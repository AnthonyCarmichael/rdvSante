<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class JourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jours')->insert([
            ['nom' => 'Lundi'],
            ['nom' => 'Mardi'],
            ['nom' => 'Mercredi'],
            ['nom' => 'Jeudi'],
            ['nom' => 'Vendredi'],
            ['nom' => 'Samedi'],
            ['nom' => 'Dimanche']
        ]);
    }
}
