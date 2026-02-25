<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\burgers;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    /**
     * Liste toutes les commandes
     */
    public function index()
    {
        $commandes = Commande::with('burgers')->latest()->get();
        return view('clients.commande', compact('commandes'));
    }

    /**
     * Affiche le formulaire de création d'une commande pour un burger donné
     */
    public function create(burgers $burger)
    {
        return view('clients.commande', compact('burger'));
    }

    /**
     * Enregistre une nouvelle commande
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom_client' => 'required|string|max:255',
            'telephone_client' => 'required|string|max:20',
            'burgers' => 'required|array',
            'burgers.*.id' => 'required|exists:burgers,id',
            'burgers.*.quantite' => 'required|integer|min:1',
        ]);

        $commande = Commande::create([
            'nom_client' => $request->nom_client,
            'telephone_client' => $request->telephone_client,
            'statut' => 'en_attente',
            'total' => 0,
        ]);

        $total = 0;

        foreach ($request->burgers as $item) {
            $burger = burgers::findOrFail($item['id']);

            if ($burger->quantite_stock < $item['quantite']) {
                return back()->withErrors("Stock insuffisant pour le burger {$burger->nom}");
            }

            $burger->quantite_stock -= $item['quantite'];
            $burger->save();

            $commande->burgers()->attach($burger->id, ['quantite' => $item['quantite']]);

            $total += $burger->prix_unitaire * $item['quantite'];
        }

        $commande->update(['total' => $total]);

        return redirect()->route('clients.catalogue', $commande->id)
            ->with('success', 'Commande créée avec succès');
    }

    /**
     * Affiche une commande spécifique
     */
    public function show(Commande $commande)
    {
        return view('clients.liste', compact('commande'));
    }

    /**
     * Formulaire d'édition d'une commande
     */
    public function edit(Commande $commande)
    {
        return view('clients.edit', compact('commande'));
    }

    /**
     * Met à jour une commande
     */
    public function update(Request $request, Commande $commande)
    {
        $request->validate([
            'nom_client' => 'required|string|max:255',
            'telephone_client' => 'required|string|max:20',
            'statut' => 'required|in:en_attente,en_preparation,prete,payee',
        ]);

        $commande->update($request->only(['nom_client', 'telephone_client', 'statut']));

        return redirect()->route('commandes.show', $commande->id)
            ->with('success', 'Commande mise à jour avec succès');
    }

    /**
     * Supprime une commande
     */
    public function destroy(Commande $commande)
    {
        $commande->delete();
        return redirect()->route('commandes.index')
            ->with('success', 'Commande supprimée avec succès');
    }
}
