<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class VilleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('villes')->insert([
            [
                'nom' => 'Montréal',
                'idProvince' => '1',
            ],
            [
                'nom' => 'Otawa',
                'idProvince' => '2',
            ],
            [
                'nom' => 'Douala',
                'idProvince' => '3',
            ],
            [
                'nom' => 'Québec',
                'idProvince' => '1',
            ]
        ]);
    }
}
