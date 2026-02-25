<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index() {
        // On récupère toutes les commandes avec leurs burgers associés
        $commandes = Commande::with('burgers')->latest()->get();
        // On envoie les données à la vue admin/commandes.blade.php
        return view('admin.commandes.commandes', compact('commandes'));
    }
}
