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
        Schema::create('fiche_cliniques', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // Pour pouvoir utiliser les clés étrangères et les transactions
            $table->bigIncrements('idFiche'); // Clé primaire automatiquement créée avec "bigIncrements()".
            // "usigned()" nécessaire pour éventuellement pouvoir définir une clé étrangère sur cette colonne.
            $table->dateTime('dateHeure');
            $table->bigInteger('idTypeFiche')->unsigned();
            $table->bigInteger('idDossier')->unsigned();
        });

        Schema::table('fiche_cliniques', function (Blueprint $table) {
            $table->foreign('idTypeFiche')->references('idTypeFiche')->on('type_fiches');
        });

        Schema::table('fiche_cliniques', function (Blueprint $table) {
            $table->foreign('idDossier')->references('idDossier')->on('dossiers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fiche_cliniques');
    }
};
