<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class OrganisationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('organisations')->insert([
            [
                'nom' => 'Organisation de ostéo et masso',
            ],
            [
                'nom' => 'Organisation des masso',
            ]

        ]);
    }
}
