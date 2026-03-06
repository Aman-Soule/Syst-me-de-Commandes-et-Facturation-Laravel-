<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BurgerArchive extends Model
{
    protected $table = 'burger_archives';

    protected $fillable = [
        'burger_id_original',
        'nom',
        'prix_unitaire',
        'image',
        'description',
        'quantite_stock',
        'supprime_par',
        'supprime_le',
    ];

    protected $casts = [
        'supprime_le' => 'datetime',
    ];

    /**
     * Restaure l'archive en recréant le burger d'origine.
     */
    public function restaurer(): burgers
    {
        $burger = burgers::create([
            'nom'            => $this->nom,
            'prix_unitaire'  => $this->prix_unitaire,
            'image'          => $this->image,
            'description'    => $this->description,
            'quantite_stock' => $this->quantite_stock,
        ]);

        $this->delete(); // supprime l'archive après restauration

        return $burger;
    }
}
