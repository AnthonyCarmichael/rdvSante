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
        Schema::create('services', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // Pour pouvoir utiliser les clés étrangères et les transactions
            $table->bigIncrements('id'); // Clé primaire automatiquement créée avec "bigIncrements()".
            // "usigned()" nécessaire pour éventuellement pouvoir définir une clé étrangère sur cette colonne.
            $table->string('nom');
            $table->text('description')->nullable();
            $table->integer('duree');
            $table->decimal('prix', 5, 2);
            $table->boolean('taxable');
            $table->integer('minutePause');
            $table->integer('nombreHeureLimiteReservation');
            $table->boolean('droitPersonneACharge');
            $table->boolean('actif');
            $table->text('prixStripe');
            $table->text('produitStripe');
            $table->bigInteger('idProfessionService')->unsigned();
            $table->bigInteger('idProfessionnel')->unsigned();
            $table->decimal('montantPenalite', 5, 2)->default(0.00);
        });

        Schema::table('services', function (Blueprint $table) {
            $table->foreign('idProfessionService')->references('id')->on('professions');
        });

        Schema::table('services', function (Blueprint $table) {
            $table->foreign('idProfessionnel')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
