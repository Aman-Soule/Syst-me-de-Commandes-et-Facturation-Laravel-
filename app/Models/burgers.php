<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class burgers extends Model
{
    //
    protected $fillable = ['nom', 'prix_unitaire', 'image', 'description', 'quantite_stock'];

    public function commandes()
    {
        return $this->belongsToMany(Commande::class, 'commande_burger', 'burger_id', 'commande_id')
            ->withPivot('quantite')
            ->withTimestamps();
    }

}
