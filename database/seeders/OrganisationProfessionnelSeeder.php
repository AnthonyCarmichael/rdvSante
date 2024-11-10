<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganisationProfessionnelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('organisation_professionnels')->insert([
            [
                'idOrganisation' => 1,
                'idProfessionnel' => 1,
                'idProfession' => 1,
                'numMembre' => '123546',
                'dateExpiration' => '2025-04-29',
            ]

        ]);
    }
}
