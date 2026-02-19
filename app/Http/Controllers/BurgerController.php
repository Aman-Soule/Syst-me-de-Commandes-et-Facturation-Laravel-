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
        return view('admin.burgers.index', compact('burgers'));
    }
// Côté client
    public function catalogue()
    {
        $burgers = burgers::where('quantite_stock', '>', 0)->get();
        return view('welcome', compact('burgers'));
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
            'quantite_stock' => 'required|integer|min:0',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('burgers', 'public');
            $burger->image = $path;
        }

        $burger->update([
            'nom' => $request->nom,
            'prix_unitaire' => $request->prix_unitaire,
            'description' => $request->description,
            'quantite_stock' => $request->quantite_stock,
            'image' => $burger->image,
        ]);

        return redirect()->route('burgers.index')->with('success', 'Burger mis à jour avec succès');
    }

// Suppression d’un burger
    public function destroy(burgers $burger)
    {
        $burger->delete();
        return redirect()->route('burgers.index')->with('success', 'Burger supprimé avec succès');
    }
}

