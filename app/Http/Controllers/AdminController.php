<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\burgers;
use App\Models\Paiement;
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
        // Validation : on ne change que le statut
        $request->validate(['statut' => 'required|in:en_attente,en_preparation,prete',]);
        // Mise à jour du statut
        $commande->statut = $request->statut;
        $commande->save();
        //Génération du paiement uniquement si la commande est marquée "prete"
        if ($commande->statut === 'prete') {
            Paiement::create(['commande_id' => $commande->id, 'montant' => $commande->total,

                'date_paiement' => now(),]);
        }
        return redirect()->route('commandes.liste') ->with('success', 'Statut de la commande mis à jour avec succès.');
    }
}
