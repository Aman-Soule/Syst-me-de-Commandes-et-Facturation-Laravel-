<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = ['nom_client', 'telephone_client', 'statut', 'total'];

    public function burgers()
    {
        return $this->belongsToMany(burgers::class, 'commande_burger', 'commande_id', 'burger_id')
            ->withPivot('quantite')
            ->withTimestamps();
    }

}
