<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaxeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('taxes')->insert([
            [
                'nom' => 'TPS',
                'valeur' => '5',
            ],
            [
                'nom' => 'TVQ',
                'valeur' => '9.975',
            ]
        ]);
    }
}
