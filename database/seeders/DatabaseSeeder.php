<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // Vous pouvez ajouter d’autres "seeders" en les séparant par des virgules.
            GenreSeeder::class, JourSeeder::class, LangueSeeder::class, MoyenPaiementSeeder::class, StatutSeeder::class, TypeTransactionSeeder::class, ProfessionSeeder::class, RoleSeeder::class, UserSeeder::class, PaysSeeder::class, ProvinceSeeder::class
            ]);
    }
}
