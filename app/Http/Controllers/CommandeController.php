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
            'telephone_client' => [
                'required',
                'regex:/^(77|78|76|75|70)[0-9]{7}$/'
            ],
            'burgers' => 'required|array',
            'burgers.*.id' => 'required|exists:burgers,id',
            'burgers.*.quantite' => 'required|integer|min:1',
        ], [
            'nom_client.required' => 'Le nom du client est obligatoire.',
            'telephone_client.required' => 'Le numéro de téléphone est obligatoire.',
            'telephone_client.regex' => 'Le numéro doit être un numéro sénégalais valide (ex: 77XXXXXXX).',
            'burgers.required' => 'Vous devez sélectionner au moins un burger.',
            'burgers.*.id.exists' => 'Le burger sélectionné n’existe pas.',
            'burgers.*.quantite.required' => 'La quantité est obligatoire.',
            'burgers.*.quantite.min' => 'La quantité doit être au minimum 1.',
            'burgers.*.quantite.integer' => 'La quantité doit être un nombre entier.',
        ]);

        $total = 0;

        foreach ($request->burgers as $index => $item) {
            $burger = burgers::findOrFail($item['id']);

            if ($burger->quantite_stock < $item['quantite']) {
                // On rattache l'erreur au champ exact
                return back()->withErrors([
                    "burgers.$index.quantite" => "Stock insuffisant pour le burger {$burger->nom}"
                ])->withInput();
            }

            $burger->quantite_stock -= $item['quantite'];
            $burger->save();

            // Création de la commande seulement si tout est valide
            if (!isset($commande)) {
                $commande = Commande::create([
                    'nom_client' => $request->nom_client,
                    'telephone_client' => $request->telephone_client,
                    'statut' => 'en_attente',
                    'total' => 0,
                ]);
            }

            $commande->burgers()->attach($burger->id, ['quantite' => $item['quantite']]);
            $total += $burger->prix_unitaire * $item['quantite'];
        }

        if (isset($commande)) {
            $commande->update(['total' => $total]);

            return redirect()->route('clients.catalogue', $commande->id)
                ->with('success', 'Commande créée avec succès');
        }

        return back()->withErrors("Impossible de créer la commande.")->withInput();
    }


    public function show(Commande $commande)
    {
        return view('clients.liste', compact('commande'));
    }

    public function edit(Commande $commande)
    {
        return view('clients.edit', compact('commande'));
    }

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
