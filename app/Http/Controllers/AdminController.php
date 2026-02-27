<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\burgers;
use App\Models\Paiement;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\Facade\Pdf as PDFFacade;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Dashboard principal — route /admin
     */
    public function index()
    {
        $today = Carbon::today();

        $totalCommandes         = Commande::count();
        $commandesEnAttente     = Commande::where('statut', 'en_attente')->count();
        $commandesEnPreparation = Commande::where('statut', 'en_preparation')->count();
        $commandesPretes        = Commande::where('statut', 'prete')->count();
        $commandesPayees        = Commande::where('statut', 'payee')->count();
        $chiffreAffaires        = Commande::where('statut', 'payee')->sum('total');

        // Commandes en cours aujourd'hui (en_attente ou en_preparation)
        $commandesEnCoursAujourdhui = Commande::whereDate('created_at', $today)
            ->whereIn('statut', ['en_attente', 'en_preparation'])
            ->count();

        // Commandes validées aujourd'hui (prete ou payee)
        $commandesValideesAujourdhui = Commande::whereDate('updated_at', $today)
            ->whereIn('statut', ['prete', 'payee'])
            ->count();

        // Recettes journalières
        $recettesJournalieres = Commande::whereDate('updated_at', $today)
            ->where('statut', 'payee')
            ->sum('total');

        //Stats burgers
        $totalBurgers     = burgers::count();
        $burgersEnRupture = burgers::where('quantite_stock', 0)->count();
        $stockTotal       = burgers::sum('quantite_stock');
        $burgers          = burgers::all();

        //stats commandes

        $commandes = commande::all();

        // ── Données graphiques ────────────────────────────────────────────────

        // 1. Commandes & recettes par mois sur les 12 derniers mois
        $moisLabels      = [];
        $chartCommandesMois = [];
        $chartRecettesMois  = [];

        for ($i = 11; $i >= 0; $i--) {
            $mois = Carbon::now()->subMonths($i);
            $moisLabels[] = $mois->translatedFormat('M Y');

            $chartCommandesMois[] = Commande::whereYear('created_at', $mois->year)
                ->whereMonth('created_at', $mois->month)
                ->count();

            $chartRecettesMois[] = (int) Commande::whereYear('updated_at', $mois->year)
                ->whereMonth('updated_at', $mois->month)
                ->where('statut', 'payee')
                ->sum('total');
        }

        // 2. Quantités vendues par burger ce mois-ci
        $moisCourant = Carbon::now();
        $ventesParBurger = DB::table('commande_burger')
            ->join('commandes', 'commande_burger.commande_id', '=', 'commandes.id')
            ->join('burgers', 'commande_burger.burger_id', '=', 'burgers.id')
            ->whereYear('commandes.created_at', $moisCourant->year)
            ->whereMonth('commandes.created_at', $moisCourant->month)
            ->select('burgers.nom', DB::raw('SUM(commande_burger.quantite) as total_vendu'))
            ->groupBy('burgers.nom')
            ->orderByDesc('total_vendu')
            ->get();

        $chartBurgerLabels = $ventesParBurger->pluck('nom')->toArray();
        $chartBurgerVendus = $ventesParBurger->pluck('total_vendu')->map(fn($v) => (int)$v)->toArray();

        return view('admin.index', compact(
            'burgers',
            // Globaux
            'totalCommandes',
            'commandesEnAttente',
            'commandesEnPreparation',
            'commandesPretes',
            'commandesPayees',
            'chiffreAffaires',
            // Stocks
            'totalBurgers',
            'burgersEnRupture',
            'stockTotal',
            //commande
            'commandes',
            // Journaliers
            'commandesEnCoursAujourdhui',
            'commandesValideesAujourdhui',
            'recettesJournalieres',
            // Graphiques
            'moisLabels',
            'chartCommandesMois',
            'chartRecettesMois',
            'chartBurgerLabels',
            'chartBurgerVendus'
        ));
    }

    /**
     * Liste des commandes — route /admin/commandes
     */
    public function commandes()
    {
        $commandes = Commande::with('burgers')->latest()->get();
        return view('admin.commandes.liste', compact('commandes'));
    }

    public function edit(Commande $commande)
    {
        return view('admin.commandes.edit', compact('commande'));
    }

    public function update(Request $request, Commande $commande)
    {
        //Validation
        $request->validate([
            'statut' => 'required|in:en_attente,en_preparation,prete,payee',
        ]);

        $ancienStatut  = $commande->statut;
        $nouveauStatut = $request->statut;


        $commande->statut = $nouveauStatut;
        $commande->save();

        // 3. Passage à pret génération  de la facture PDF
        if ($nouveauStatut === 'prete' && $ancienStatut !== 'prete') {
            $this->genererFacturePdf($commande);
        }

        // 4. Passage à "payee" → enregistrement du paiement (sans doublon)
        if ($nouveauStatut === 'payee' && $ancienStatut !== 'payee') {
            // Vérifie qu'aucun paiement n'existe déjà pour cette commande
            $paiementExistant = Paiement::where('commande_id', $commande->id)->first();

            if (! $paiementExistant) {
                Paiement::create([
                    'commande_id'    => $commande->id,
                    'montant'        => $commande->total,
                    'date_paiement'  => now(),
                ]);
            }
        }

        return back()->with('success', 'Statut de la commande mis à jour avec succès.');
    }

    /**
     * Télécharge la facture PDF d'une commande.
     * Accessible via : GET /admin/commandes/{commande}/facture
     * Route nommée  : commandes.facture
     */
    public function telechargerFacture(Commande $commande)
    {
        // Vérifie que la commande est au moins "prête"
        if (! in_array($commande->statut, ['prete', 'payee'])) {
            return redirect()
                ->route('commandes.liste')
                ->with('error', 'La facture n\'est disponible que pour les commandes prêtes ou payées.');
        }

        $pdf = Pdf::loadView('admin.commandes.facture', compact('commande'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('facture-commande-' . $commande->id . '.pdf');
    }


    // Méthode privée : génère et stocke le PDF de facture
    private function genererFacturePdf(Commande $commande): void
    {
        $pdf = Pdf::loadView('admin.commandes.facture', compact('commande'))
            ->setPaper('a4', 'portrait');

        // Stockage dans storage/app/factures/
        $dossier = storage_path('app/factures');
        if (! is_dir($dossier)) {
            mkdir($dossier, 0755, true);
        }

        $pdf->save($dossier . '/facture-commande-' . $commande->id . '.pdf');
    }

    public function destroy(Commande $commande)
    {
        $commande->delete();
        return redirect()->route('commandes.liste')
            ->with('success', 'Commande supprimée avec succès');
    }
}
