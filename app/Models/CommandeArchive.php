<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommandeArchive extends Model
{
    protected $table = 'commande_archives';

    protected $fillable = [
        'commande_id_original',
        'nom_client',
        'telephone_client',
        'statut',
        'total',
        'burgers_snapshot',
        'supprime_par',
        'supprime_le',
    ];

    protected $casts = [
        'burgers_snapshot' => 'array',
        'supprime_le'      => 'datetime',
    ];

    /**
     * Restaure l'archive en recréant la commande d'origine.
     */
    public function restaurer(): Commande
    {
        $commande = Commande::create([
            'nom_client'       => $this->nom_client,
            'telephone_client' => $this->telephone_client,
            'statut'           => $this->statut,
            'total'            => $this->total,
        ]);

        // Restaure les liaisons burger via le snapshot
        foreach ($this->burgers_snapshot as $item) {
            $commande->burgers()->attach($item['burger_id'], [
                'quantite' => $item['quantite'],
            ]);
        }

        $this->delete();

        return $commande;
    }
}
