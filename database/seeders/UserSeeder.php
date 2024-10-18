<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            ['nom' => 'Carmichael',
            'prenom' => 'Daphné',
            'email' => 'admin@admin.com',
            'telephone' => '(123) 456-7890',
            'password' => Hash::make('admin'),
            'idRole' => '1'],

            ['nom' => 'Maheu-Guay',
            'prenom' => 'Olivier ',
            'email' => 'olivier@test.com',
            'telephone' => '(123) 456-7890',
            'password' => Hash::make('test'),
            'idRole' => '2'],

            ['nom' => 'Yale',
            'prenom' => 'Catherine',
            'email' => 'catherine@test.com',
            'telephone' => '(123) 456-7890',
            'password' => Hash::make('test'),
            'idRole' => '2']
        ]);

    }
}
