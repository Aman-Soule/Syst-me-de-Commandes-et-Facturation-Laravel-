<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('burger_archives', function (Blueprint $table) {
            $table->dropColumn('raison_suppression');
        });
    }

    public function down(): void
    {
        Schema::table('burger_archives', function (Blueprint $table) {
            $table->string('raison_suppression')->nullable()->after('supprime_par');
        });
    }
};
