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
            $table->bigIncrements('id'); // Clé primaire automatiquement créée avec "bigIncrements()".
            // "usigned()" nécessaire pour éventuellement pouvoir définir une clé étrangère sur cette colonne.
            $table->string('nom');
            $table->string('prenom');
            $table->string('courriel');
            $table->string('telephone');
            $table->date('ddn')->nullable();
            $table->string('nomResponsable')->nullable();
            $table->string('prenomResponsable')->nullable();
            $table->string('lienResponsable')->nullable();
            $table->string('rue')->nullable();
            $table->integer('noCivique')->nullable();
            $table->string('codePostal')->nullable();
            $table->boolean('actif');
            $table->bigInteger('idGenre')->unsigned();
            $table->bigInteger('idVille')->nullable()->unsigned();
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->foreign('idGenre')->references('id')->on('genres');
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->foreign('idVille')->references('id')->on('villes');
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
