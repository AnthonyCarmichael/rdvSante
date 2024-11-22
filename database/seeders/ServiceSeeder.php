<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('services')->insert([
            [
                'nom' => 'Consultation initiale',
                'description' => 'Première rencontre pour évaluation complète.',
                'duree' => 60,
                'prix' => 50.00,
                'taxable' => true,
                'minutePause' => 10,
                'nombreHeureLimiteReservation' => 48,
                'droitPersonneACharge' => false,
                'actif' => true,
                'prixStripe' => 'price_12345',
                'produitStripe' => 'prod_12345',
                'idProfessionService' => 1, // ID de la profession associée
                'idProfessionnel' => 1, // ID du professionnel associé
                'montantPenalite' => 5.00,
            ],
            [
                'nom' => 'Suivi mensuel',
                'description' => 'Rencontre de suivi pour évaluer les progrès.',
                'duree' => 45,
                'prix' => 30.00,
                'taxable' => true,
                'minutePause' => 5,
                'nombreHeureLimiteReservation' => 24,
                'droitPersonneACharge' => true,
                'actif' => true,
                'prixStripe' => 'price_67890',
                'produitStripe' => 'prod_67890',
                'idProfessionService' => 2, // ID de la profession associée
                'idProfessionnel' => 1, // ID du professionnel associé
                'montantPenalite' => 10.00,
            ],
            [
                'nom' => 'Service d\'urgence',
                'description' => 'Consultation urgente, hors des heures normales.',
                'duree' => 30,
                'prix' => 100.00,
                'taxable' => true,
                'minutePause' => 0,
                'nombreHeureLimiteReservation' => 1,
                'droitPersonneACharge' => false,
                'actif' => true,
                'prixStripe' => 'price_abcde',
                'produitStripe' => 'prod_abcde',
                'idProfessionService' => 3, // ID de la profession associée
                'idProfessionnel' => 2, // ID du professionnel associé
                'montantPenalite' => 25.00,
            ],
        ]);
    }
}
