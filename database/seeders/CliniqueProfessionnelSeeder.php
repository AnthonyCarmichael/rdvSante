<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CliniqueProfessionnelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('clinique_professionnels')->insert([
            [
                'idClinique' => 1,
                'idProfessionnel' => 1,
            ]

        ]);
    }
}
