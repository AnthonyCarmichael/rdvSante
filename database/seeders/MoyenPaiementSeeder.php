<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class MoyenPaiementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('moyen_paiements')->insert([
            ['nom' => 'Par carte'],
            ['nom' => 'Comptant'],
            ['nom' => 'Virement interac']
        ]);
    }
}
