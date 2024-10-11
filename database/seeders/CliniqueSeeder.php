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
                'nom' => 'Ma Clinqiue Générale',
                'rue' => 'St-Hubert',
                'noCivique' => '6050',
                'codePostal' => 'H2S 2L7',
                'idVille' => 1
            ],

        ]);
    }
}
