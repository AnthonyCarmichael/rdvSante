<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeFicheSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('type_fiches')->insert([
            [
                'nom' => 'Anamnèse',
                'description' => null,
                'idLangue' => 1
            ],
            [
                'nom' => 'Éval Nourrisson / Enfant 3 ans et moins',
                'description' => 'De 0 à 3 mois : Alimentation, poids, sommeil, tétée; De 3 à 6 mois: On ajoute l\'éveil, psycho moteur, sourire; De 6 à 9 mois: moteur, retournement, parole, contact aux autres, diversification, allergie; De 9 à 18 mois : motricité fine, marche, parole',
                'idLangue' => 1
            ],
            [
                'nom' => 'Suivi-SOAPIE',
                'description' => null,
                'idLangue' => 1
            ],
        ]);
    }
}
