<?php

namespace App\Http\Controllers;

use App\Models\burgers;
use Illuminate\Http\Request;

class BurgerController extends Controller
{
// Liste des burgers
    public function index()
    {
        $burgers = burgers::all();
        return view('admin.burgers.stock', compact('burgers'));
    }
    public function accueil()
    {
        $burgers = burgers::where('quantite_stock', '>', 0)->get();
        return view('welcome', compact('burgers'));
    }

    public function catalogue(Request $request)
    {
        $query = burgers::query();

        //recherche par nom
        if ($request->filled('search')) {
            $search = strtolower($request->search); //Met en majuscule la saisie de l'utilisateur
            $query->whereRaw('LOWER(nom) LIKE ?', ["%{$search}%"]);
        }

        //Tri disponibilité
        if ($request->filled('disponibilite')) {
            if ($request->disponibilite === 'disponible') {
                $query->where('quantite_stock', '>', 0);
            } elseif ($request->disponibilite === 'rupture') {
                $query->where('quantite_stock', '=', 0);
            }
        }
        //Trie prix
        if ($request->filled('prix')) {
            $query->orderBy('prix_unitaire', $request->prix);
        }

        //Récupération des burgers filtrés
        $burgers = $query->get();

        return view('clients.catalogue', compact('burgers'));
    }


// Formulaire de création
    public function create()
    {
        return view('admin.burgers.create');
    }

// Enregistrement d’un nouveau burger
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prix_unitaire' => 'required|numeric',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'description' => 'nullable|string',
            'quantite_stock' => 'required|integer|min:0',
        ]);

        // Sauvegarde de l’image dans storage/app/public/images
        $path = $request->file('image')->store('images', 'public');
        burgers::create([
            'nom' => $request->nom,
            'prix_unitaire' => $request->prix_unitaire,
            'image' => $path, // on stocke juste le chemin relatif
            'description' => $request->description,
            'quantite_stock' => $request->quantite_stock,
        ]);

        return redirect()->route('burgers.index')->with('success', 'Burger ajouté avec succès');
    }

// Formulaire d’édition
    public function edit(burgers $burger)
    {
        return view('admin.burgers.edit', compact('burger'));
    }

// Mise à jour d’un burger
    public function update(Request $request, burgers $burger)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prix_unitaire' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'description' => 'nullable|string',
            'ajout_stock' => 'nullable|integer|min:0',
        ]);

        $data = $request->only(['nom', 'prix_unitaire', 'description']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('burgers', 'public');
        }
        $burger->update($data);

        if ($request->filled('ajout_stock')) {
            $burger->quantite_stock += $request->ajout_stock;
            $burger->save();
        }

        return redirect()->route('burgers.index')->with('success', 'Burger mis à jour avec succès');
    }



// Suppression d’un burger
    public function destroy(burgers $burger)
    {
        $burger->delete();
        return redirect()->route('burgers.index');
    }
}

