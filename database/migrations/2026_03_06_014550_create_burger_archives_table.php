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
        Schema::create('burger_archives', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('burger_id_original'); // ID d'origine pour restauration
            $table->string('nom');
            $table->decimal('prix_unitaire', 10, 2);
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->integer('quantite_stock')->default(0);
            $table->string('supprime_par')->nullable(); // nom admin
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
        Schema::dropIfExists('burger_archives');
    }
};
