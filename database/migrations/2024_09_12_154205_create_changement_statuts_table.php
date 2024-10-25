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
        Schema::create('changement_statuts', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // Pour pouvoir utiliser les clés étrangères et les transactions
            $table->bigIncrements('id'); // Clé primaire automatiquement créée avec "bigIncrements()".
            // "usigned()" nécessaire pour éventuellement pouvoir définir une clé étrangère sur cette colonne.
            $table->date('dateChangement');
            $table->bigInteger('idProfessionnel')->unsigned();
            $table->bigInteger('idStatut')->unsigned();
        });

        Schema::table('changement_statuts', function (Blueprint $table) {
            $table->foreign('idProfessionnel')->references('id')->on('users');
        });

        Schema::table('changement_statuts', function (Blueprint $table) {
            $table->foreign('idStatut')->references('id')->on('statuts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('changement_statuts');
    }
};
