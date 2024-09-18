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
        Schema::create('rdvs', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // Pour pouvoir utiliser les clés étrangères et les transactions
            $table->bigIncrements('idRdv'); // Clé primaire automatiquement créée avec "bigIncrements()".
            // "usigned()" nécessaire pour éventuellement pouvoir définir une clé étrangère sur cette colonne.
            $table->dateTime('dateHeureDebut');
            $table->bigInteger('idDossier')->unsigned();
            $table->bigInteger('idService')->unsigned();
            $table->bigInteger('idClinique')->unsigned();
        });

        Schema::table('rdvs', function (Blueprint $table) {
            $table->foreign('idDossier')->references('idDossier')->on('dossiers');
        });

        Schema::table('rdvs', function (Blueprint $table) {
            $table->foreign('idService')->references('idService')->on('services');
        });

        Schema::table('rdvs', function (Blueprint $table) {
            $table->foreign('idClinique')->references('idClinique')->on('cliniques');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rdvs');
    }
};
