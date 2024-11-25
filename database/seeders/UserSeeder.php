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
            [
                'nom' => 'Carmichael',
                'prenom' => 'Daphné',
                'email' => 'admin@admin.com',
                'telephone' => '(123) 456-7890',
                'password' => Hash::make('admin'),
                'idRole' => '1',
                'description' =>
                    "Daphné prend en considération l’individu, dans sa réalité actuelle physique,
                psychologique et émotionnelle avec ses besoins et ses objectifs. Elle
                offre ainsi un traitement personnalisé et adapté aux besoins de chacun.e
                en combinant les différentes pratiques ostéopathiques, et ce, avec une
                habileté pour les techniques fasciales et tissulaires.

                Elle
                est aussi particulièrement intéressée par tout ce qui englobe la sphère
                viscérale digestive ainsi que la sphère gynécologique.

                Par
                son approche attentive et en douceur, Daphné aide au retour ainsi qu’au
                soutien de l’équilibre des divers systèmes et structures du corps.",
                'actif' => true,
                'lien' => 'https://www.macliniquegenerale.com/daphne-carmichael',
                'photoProfil' => '',
                'signature' => '',
                'cleStripe' => 'sk_test_51QLRk0G8MNDQfBDwRqTNqHUZSEmqRHPJJwWOb90PfAnEVd6Vrr3S857Z3boV4kv0ZBdwQHQEbFuRw1IbRyIiYUDa005h9SywCD'
            ],
            [
                'nom' => 'Maheu-Guay',
                'prenom' => 'Olivier ',
                'email' => 'olivier@test.com',
                'telephone' => '(123) 456-7890',
                'password' => Hash::make('test'),
                'idRole' => '2',
                'description' =>
                    "Olivier est un passionné de la thérapie manuelle depuis de nombreuses années.
                Membre de la Fédération des Massothérapeutes du Québec et diplômé de
                l’Institut KinéConcept, Olivier est massothérapeute depuis 2018 et a
                également approfondi ses compétences en complétant une formation en
                kinésithérapie.

                Son approche
                vise une libération des tensions et un renforcement des faiblesses
                musculaires dans le but d’augmenter la qualité du mouvement et de
                soulager les symptômes dérangeants. En plus du soin prodigué,  Olivier
                cherche par ses recommandations à offrir des outils que vous pourrez
                utiliser dans votre quotidien pour un soulagement et une prise en charge
                plus autonome.

                Selon vos
                objectifs, les séances avec lui peuvent comporter un volet d’analyse
                posturale et de bilan de mobilité afin de cibler les causes potentielles
                des symptômes pour agir à la source de ceux-ci.",
                'actif' => true,
                'lien' => 'https://www.macliniquegenerale.com/olivier-maheux-guay',
                'photoProfil' => '',
                'signature' => '',
                'cleStripe' => 'sk_test_51QLRk0G8MNDQfBDwRqTNqHUZSEmqRHPJJwWOb90PfAnEVd6Vrr3S857Z3boV4kv0ZBdwQHQEbFuRw1IbRyIiYUDa005h9SywCD'
            ],

            [
                'nom' => 'Yale',
                'prenom' => 'Catherine',
                'email' => 'catherine@test.com',
                'telephone' => '(123) 456-7890',
                'password' => Hash::make('test'),
                'idRole' => '2',
                'description' =>
                    "** Présentement en congé de maternité

                Catherine détient un diplôme en ostéopathie et une certification de massothérapeute praticienne. Ayant dansé toute sa vie, la biomécanique et la santé musculosquelettique ont toujours eu un rôle central dans son quotidien. Interpellée
                par la prévention et l’autonomie du patient, la vulgarisation tient une
                grande place dans son approche thérapeutique.

                Catherine est une thérapeute attentive, généreuse et minutieuse qui vous accueillera avec plaisir.

                **Tarifs
                flexibles: Catherine souhaite contribuer à l'accessibilité aux soins,
                c'est pourquoi le client est libre de choisir le montant qu'il est
                confortable de donner entre un prix minimum et maximum (indiqués lorsque
                vous sélectionnez un service).",
                'actif' => false,
                'lien' => 'https://www.macliniquegenerale.com/catherine-yale',
                'photoProfil' => '',
                'signature' => '',
                'cleStripe' => 'sk_test_51QLRk0G8MNDQfBDwRqTNqHUZSEmqRHPJJwWOb90PfAnEVd6Vrr3S857Z3boV4kv0ZBdwQHQEbFuRw1IbRyIiYUDa005h9SywCD'
            ]
        ]);

    }
}
