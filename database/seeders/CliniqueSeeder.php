<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CliniqueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cliniques')->insert([
            [
                'nom' => 'Ma Clinique Générale',
                'rue' => 'St-Hubert',
                'noCivique' => '6050',
                'codePostal' => 'H2S 2L7',
                'idVille' => 1
            ],
            [
                'nom' => 'Clinique St-hyacynthe',
                'rue' => 'St-hyacynthe',
                'noCivique' => '8060',
                'codePostal' => 'J2Y 7H9',
                'idVille' => 2
            ],
            [
                'nom' => 'Clinique du grand nord',
                'rue' => 'Vincent',
                'noCivique' => '8547',
                'codePostal' => 'P2L 4G7',
                'idVille' => 3
            ],
            [
                'nom' => 'Clinique des jeunes',
                'rue' => 'Du conseil',
                'noCivique' => '4569',
                'codePostal' => 'G4R 7V3',
                'idVille' => 4
            ]
        ]);
    }
}
