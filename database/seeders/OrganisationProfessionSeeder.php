<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganisationProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('organisation_professions')->insert([
            [
                'idOrganisation' => 1,
                'idProfession' => 1,
            ],
            [
                'idOrganisation' => 1,
                'idProfession' => 2,
            ],
            [
                'idOrganisation' => 2,
                'idProfession' => 2,
            ]

        ]);
    }
}
