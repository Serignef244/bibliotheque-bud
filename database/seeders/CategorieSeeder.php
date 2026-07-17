<?php

namespace Database\Seeders;

use App\Models\Categorie;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorieSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            // Informatique
            'Informatique' => [
                'Programmation',
                'Base de données',
                'Réseaux',
                'Sécurité Informatique',
                'Intelligence Artificielle',
                'Développement Web',
                'Génie Logiciel',
            ],
            // Sciences
            'Sciences' => [
                'Mathématiques',
                'Physique',
                'Chimie',
                'Biologie',
                'Astronomie',
            ],
            // Littérature
            'Littérature' => [
                'Roman',
                'Poésie',
                'Théâtre',
                'Science-Fiction',
                'Fantasy',
                'Policier',
            ],
            // Sciences Humaines
            'Sciences Humaines' => [
                'Histoire',
                'Géographie',
                'Philosophie',
                'Psychologie',
                'Sociologie',
            ],
            // Arts
            'Arts' => [
                'Peinture',
                'Musique',
                'Cinéma',
                'Photographie',
                'Architecture',
            ],
            // Autres
            'Développement Personnel' => [],
            'Droit' => [],
            'Économie' => [],
            'Mangas & BD' => [],
            'Jeunesse' => [],
        ];

        $ordre = 1;
        foreach ($categories as $parentName => $children) {
            $parent = Categorie::firstOrCreate([
                'nom' => $parentName,
            ], [
                'slug' => Str::slug($parentName),
                'description' => "Catégorie principale : $parentName",
                'actif' => true,
                'ordre' => $ordre++,
            ]);

            $childOrdre = 1;
            foreach ($children as $childName) {
                Categorie::firstOrCreate([
                    'nom' => $childName,
                ], [
                    'slug' => Str::slug($childName),
                    'parent_id' => $parent->id,
                    'description' => "Sous-catégorie de $parentName",
                    'actif' => true,
                    'ordre' => $childOrdre++,
                ]);
            }
        }
    }
}
