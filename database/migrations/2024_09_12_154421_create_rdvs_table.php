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
            $table->bigIncrements('id'); // Clé primaire automatiquement créée avec "bigIncrements()".
            // "usigned()" nécessaire pour éventuellement pouvoir définir une clé étrangère sur cette colonne.
            $table->dateTime('dateHeureDebut');
            $table->bigInteger('idDossier')->unsigned();
            $table->bigInteger('idService')->unsigned();
            $table->bigInteger('idClinique')->unsigned();
            $table->text('raison')->nullable();
            $table->boolean('actif');
            $table->string('token')->nullable(); // Enlever le nullable apres avoir gèrer au complet la fonctionnalité
        });

        Schema::table('rdvs', function (Blueprint $table) {
            $table->foreign('idDossier')->references('id')->on('dossiers');
        });

        Schema::table('rdvs', function (Blueprint $table) {
            $table->foreign('idService')->references('id')->on('services');
        });

        Schema::table('rdvs', function (Blueprint $table) {
            $table->foreign('idClinique')->references('id')->on('cliniques');
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
