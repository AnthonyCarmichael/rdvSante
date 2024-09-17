<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('genres')->insert([
            ['nom' => 'Homme'],
            ['nom' => 'Femme'],
            ['nom' => 'Autre'],
            ['nom' => 'Préfère ne pas répondre']
        ]);

    }
}
