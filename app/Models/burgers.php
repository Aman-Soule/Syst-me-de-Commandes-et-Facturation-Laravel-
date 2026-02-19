<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class burgers extends Model
{
    //
    protected $fillable = ['nom', 'prix_unitaire', 'image', 'description', 'quantite_stock'];
}
