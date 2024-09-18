<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            ['nom' => 'Admin',
            'prenom' => 'Admin',
            'email' => 'admin@admin.com',
            'telephone' => '123-456-7890',
            'mdp' => 'admin',
            'idProfession' => '1',
            'idRole' => '1']
            ]);

    }
}
