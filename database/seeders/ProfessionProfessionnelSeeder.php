<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ProfessionProfessionnelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('profession_professionnels')->insert([
            [
                'idProfession' => 1,
                'user_id' => 1,
            ],
            [
                'idProfession' => 1,
                'user_id' => 2,
            ],
            [
                'idProfession' => 2,
                'user_id' => 2,
            ],
            [
                'idProfession' => 1,
                'user_id' => 3,
            ],
            [
                'idProfession' => 2,
                'user_id' => 3,
            ],
            [
                'idProfession' => 3,
                'user_id' => 3,
            ],

        ]);
    }
}
