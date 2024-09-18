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
        Schema::create('clients', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // Pour pouvoir utiliser les clés étrangères et les transactions
            $table->bigIncrements('idClient'); // Clé primaire automatiquement créée avec "bigIncrements()".
            // "usigned()" nécessaire pour éventuellement pouvoir définir une clé étrangère sur cette colonne.
            $table->string('nom');
            $table->string('prenom');
            $table->string('courriel');
            $table->string('telephone');
            $table->date('ddn');
            $table->string('nomResponsable');
            $table->string('prenomResponsable');
            $table->string('lienResponsable');
            $table->string('rue');
            $table->integer('noCivique');
            $table->string('codePostal');
            $table->bigInteger('idGenre')->unsigned();
            $table->bigInteger('idVille')->unsigned();
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->foreign('idGenre')->references('idGenre')->on('genres');
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->foreign('idVille')->references('idVille')->on('villes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
