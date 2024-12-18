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
        Schema::create('transactions', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // Pour pouvoir utiliser les clés étrangères et les transactions
            $table->bigIncrements('id'); // Clé primaire automatiquement créée avec "bigIncrements()".
            // "usigned()" nécessaire pour éventuellement pouvoir définir une clé étrangère sur cette colonne.
            $table->decimal('montant', 5, 2);
            $table->dateTime('dateHeure');
            $table->string('paymentIntent')->nullable();
            $table->bigInteger('idRdv')->unsigned();
            $table->bigInteger('idTypeTransaction')->unsigned();
            $table->bigInteger('idMoyenPaiement')->unsigned();
            $table->bigInteger('idTransaction')->nullable()->unsigned();
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->foreign('idTypeTransaction')->references('id')->on('type_transactions');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->foreign('idMoyenPaiement')->references('id')->on('moyen_paiements');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->foreign('idRdv')->references('id')->on('rdvs');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->foreign('idTransaction')->references('id')->on('transactions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
