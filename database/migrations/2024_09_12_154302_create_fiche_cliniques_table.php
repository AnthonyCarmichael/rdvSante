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
            $table->bigIncrements('id'); // Clé primaire automatiquement créée avec "bigIncrements()".
            // "usigned()" nécessaire pour éventuellement pouvoir définir une clé étrangère sur cette colonne.
            $table->dateTime('dateHeure');
            $table->bigInteger('idTypeFiche')->unsigned();
            $table->bigInteger('idDossier')->unsigned();

            $table->string('nom')->nullable();
            $table->text('analyse')->nullable();
            $table->text('conseilsPrevention')->nullable();
            // Zone anamnèse
            $table->text('occupation')->nullable();
            $table->text('loisirs')->nullable();
            $table->text('lateralite')->nullable();
            $table->text('diagnostic')->nullable();
            $table->text('medic')->nullable();
            $table->text('contreIndication')->nullable();
            $table->text('rced')->nullable();
            $table->text('localIrr')->nullable();
            $table->text('douleur')->nullable();
            $table->text('fa')->nullable();
            $table->text('fd')->nullable();
            $table->text('nuit')->nullable();
            $table->text('sa')->nullable();
            $table->text('investigation')->nullable();
            $table->text('trauma')->nullable();
            $table->text('chx')->nullable();
            $table->text('familiaux')->nullable();
            $table->text('cardioVasculaire')->nullable();
            $table->text('pulmonaire')->nullable();
            $table->text('snc')->nullable();
            $table->text('orl')->nullable();
            $table->text('digestif')->nullable();
            $table->text('gynecoAndrologie')->nullable();
            $table->text('urinaire')->nullable();
            $table->text('hs')->nullable();
            $table->text('psychologique')->nullable();
            $table->text('msk')->nullable();
            $table->text('dermato')->nullable();
            $table->text('autre')->nullable();
            $table->text('observation')->nullable();
            $table->text('commentaire')->nullable();
            // Zone nourrisson
            #$table->text('ddn')->nullable(); Déjà dans la bd client
            $table->integer('nbreSemGestation')->nullable();
            $table->text('apgar')->nullable();
            $table->text('poid')->nullable();
            $table->text('taille')->nullable();
            $table->text('perCranien')->nullable();
            $table->text('maladieALaNaissance')->nullable();
            $table->text('medicaments')->nullable();
            $table->text('nomsParent')->nullable();
            $table->text('historiqueGrossesse')->nullable();
            $table->text('historiqueAccouchement')->nullable();
            $table->boolean('cesarienne')->nullable();
            $table->boolean('forceps')->nullable();
            $table->boolean('ventouse')->nullable();
            $table->boolean('episiotomie')->nullable();
            $table->text('alimentation')->nullable();
            $table->text('digestion')->nullable();
            $table->text('pleurs')->nullable();
            $table->text('motricite')->nullable();
            $table->text('neuro')->nullable();
            $table->text('motifConsultation')->nullable();
            $table->text('techniques')->nullable();
            $table->text('age')->nullable(); # text pour permettre au user de mettre 2 semaine ou 2 mois
        });

        Schema::table('fiche_cliniques', function (Blueprint $table) {
            $table->foreign('idTypeFiche')->references('id')->on('type_fiches');
        });

        Schema::table('fiche_cliniques', function (Blueprint $table) {
            $table->foreign('idDossier')->references('id')->on('dossiers');
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
