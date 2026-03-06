<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('commande_archives', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('commande_id_original');
            $table->string('nom_client');
            $table->string('telephone_client');
            $table->string('statut');
            $table->decimal('total', 10, 2);
            // Snapshot des burgers commandés (JSON)
            $table->json('burgers_snapshot');
            $table->string('supprime_par')->nullable();
            $table->string('raison_suppression')->nullable();
            $table->timestamp('supprime_le')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commande_archives');
    }
};
