<?php

namespace App\Http\Controllers;

use App\Models\BurgerArchive;
use App\Models\burgers;
use App\Models\Commande;
use App\Models\CommandeArchive;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{

    public function index()
    {
        $burgerArchives  = BurgerArchive::latest('supprime_le')->get();
        $commandeArchives = CommandeArchive::latest('supprime_le')->get();

        return view('admin.archives.index', compact('burgerArchives', 'commandeArchives'));
    }

    public function archiverBurger(Request $request, $id)
    {
        $burger = burgers::findOrFail($id);

        BurgerArchive::create([
            'burger_id_original' => $burger->id,
            'nom'                => $burger->nom,
            'prix_unitaire'      => $burger->prix_unitaire,
            'image'              => $burger->image,
            'description'        => $burger->description,
            'quantite_stock'     => $burger->quantite_stock,
            'supprime_par'       => auth()->check() ? auth()->user()->name : 'Admin',
            'supprime_le'        => now(),
        ]);

        $burger->delete();

        return redirect()->route('burgers.index')
            ->with('success', "Le burger « {$burger->nom} » a été archivé.");
    }

    public function archiverCommande(Request $request, $id)
    {
        $commande = Commande::with('burgers')->findOrFail($id);

        $snapshot = $commande->burgers->map(fn($b) => [
            'burger_id' => $b->id,
            'nom'       => $b->nom,
            'quantite'  => $b->pivot->quantite,
            'prix'      => $b->prix_unitaire,
        ])->toArray();

        CommandeArchive::create([
            'commande_id_original' => $commande->id,
            'nom_client'           => $commande->nom_client,
            'telephone_client'     => $commande->telephone_client,
            'statut'               => $commande->statut,
            'total'                => $commande->total,
            'burgers_snapshot'     => $snapshot,
            'supprime_par'         => auth()->check() ? auth()->user()->name : 'Admin',
            'supprime_le'          => now(),
        ]);

        $commande->burgers()->detach();
        $commande->delete();

        return redirect()->route('commandes.liste')
            ->with('success', "La commande #{$id} a été archivée.");
    }

    public function restaurerBurger(BurgerArchive $archive)
    {
        $burger = $archive->restaurer();

        return redirect()->route('archives.index')
            ->with('success', "Le burger « {$burger->nom} » a été restauré.");
    }


    public function restaurerCommande(CommandeArchive $archive)
    {
        $commande = $archive->restaurer();

        return redirect()->route('archives.index')
            ->with('success', "La commande de {$commande->nom_client} a été restaurée.");
    }

    public function supprimerBurgerArchive(BurgerArchive $archive)
    {
        $nom = $archive->nom;
        $archive->delete();

        return redirect()->route('archives.index')
            ->with('success', "Archive du burger « $nom » supprimée définitivement.");
    }

    public function supprimerCommandeArchive(CommandeArchive $archive)
    {
        $archive->delete();

        return redirect()->route('archives.index')
            ->with('success', 'Archive de commande supprimée définitivement.');
    }
}
