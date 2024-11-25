<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('clients')->insert([
            [
                'nom' => 'Dupont',
                'prenom' => 'Jean',
                'courriel' => 'jean.dupont@example.com',
                'telephone' => '(514) 555-1234',
                'ddn' => '1990-05-15',
                'nomResponsable' => null,
                'prenomResponsable' => null,
                'lienResponsable' => null,
                'rue' => 'Rue Principale',
                'noCivique' => 123,
                'codePostal' => 'H2X3L2',
                'actif' => true,
                'idGenre' => 1,
                'idVille' => 1,
            ],
            [
                'nom' => 'Martin',
                'prenom' => 'Sophie',
                'courriel' => 'sophie.martin@example.com',
                'telephone' => '(438) 555-5678',
                'ddn' => '1985-10-20',
                'nomResponsable' => 'Lemoine',
                'prenomResponsable' => 'Marie',
                'lienResponsable' => 'Mère',
                'rue' => 'Boulevard Saint-Laurent',
                'noCivique' => 456,
                'codePostal' => 'H3C4N5',
                'actif' => true,
                'idGenre' => 2,
                'idVille' => 2,
            ],
            [
                'nom' => 'Nguyen',
                'prenom' => 'Thierry',
                'courriel' => 'thierry.nguyen@example.com',
                'telephone' => '(514) 555-9876',
                'ddn' => '2000-02-10',
                'nomResponsable' => null,
                'prenomResponsable' => null,
                'lienResponsable' => null,
                'rue' => 'Avenue Mont-Royal',
                'noCivique' => 789,
                'codePostal' => 'H4A5K6',
                'actif' => false,
                'idGenre' => 1,
                'idVille' => 1,
            ],
        ]);
    }
}
