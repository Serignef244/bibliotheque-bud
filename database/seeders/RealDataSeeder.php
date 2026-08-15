<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categorie;
use App\Models\Ouvrage;
use App\Models\Exemplaire;
use Illuminate\Support\Str;

class RealDataSeeder extends Seeder
{
    public function run()
    {
        // 1. Catégories et sous-catégories
        $categories = [
            ['nom' => 'Romans', 'slug' => 'romans', 'parent_id' => null],
            ['nom' => 'Policier', 'slug' => 'policier', 'parent_id' => null],
            ['nom' => 'Science-Fiction', 'slug' => 'science-fiction', 'parent_id' => null],
            ['nom' => 'Sciences', 'slug' => 'sciences', 'parent_id' => null],
            ['nom' => 'Histoire', 'slug' => 'histoire', 'parent_id' => null],
            ['nom' => 'Jeunesse', 'slug' => 'jeunesse', 'parent_id' => null],
            ['nom' => 'Informatique', 'slug' => 'informatique', 'parent_id' => null],
            ['nom' => 'Philosophie', 'slug' => 'philosophie', 'parent_id' => null],
            // Sous-catégories
            ['nom' => 'Thriller', 'slug' => 'thriller', 'parent_id' => 1], // Romans (l'ID sera retrouvé)
            ['nom' => 'Roman noir', 'slug' => 'roman-noir', 'parent_id' => 1], // Romans
            ['nom' => 'Romance', 'slug' => 'romance', 'parent_id' => 1],
            ['nom' => 'Enquête', 'slug' => 'enquete', 'parent_id' => 2], // Policier
            ['nom' => 'Polar', 'slug' => 'polar', 'parent_id' => 2],
            ['nom' => 'Suspense', 'slug' => 'suspense', 'parent_id' => 2],
            ['nom' => 'Dystopie', 'slug' => 'dystopie', 'parent_id' => 3], // SF
            ['nom' => 'Space opera', 'slug' => 'space-opera', 'parent_id' => 3],
            ['nom' => 'Cyberpunk', 'slug' => 'cyberpunk', 'parent_id' => 3],
            ['nom' => 'Physique', 'slug' => 'physique', 'parent_id' => 4], // Sciences
            ['nom' => 'Biologie', 'slug' => 'biologie', 'parent_id' => 4],
            ['nom' => 'Mathématiques', 'slug' => 'mathematiques', 'parent_id' => 4],
            ['nom' => 'Antiquité', 'slug' => 'antiquite', 'parent_id' => 5], // Histoire
            ['nom' => 'Médiévale', 'slug' => 'medievale', 'parent_id' => 5],
            ['nom' => 'Moderne', 'slug' => 'moderne', 'parent_id' => 5],
            ['nom' => 'Albums', 'slug' => 'albums', 'parent_id' => 6], // Jeunesse
            ['nom' => 'Contes', 'slug' => 'contes', 'parent_id' => 6],
            ['nom' => 'Premières lectures', 'slug' => 'premieres-lectures', 'parent_id' => 6],
            ['nom' => 'Programmation', 'slug' => 'programmation', 'parent_id' => 7], // Informatique
            ['nom' => 'Réseaux', 'slug' => 'reseaux', 'parent_id' => 7],
            ['nom' => 'IA', 'slug' => 'ia', 'parent_id' => 7],
            ['nom' => 'Métaphysique', 'slug' => 'metaphysique', 'parent_id' => 8], // Philosophie
            ['nom' => 'Éthique', 'slug' => 'ethique', 'parent_id' => 8],
            ['nom' => 'Logique', 'slug' => 'logique', 'parent_id' => 8],
        ];

        // Créer les catégories parentes d'abord
        $parentMap = [];
        foreach ($categories as $cat) {
            if ($cat['parent_id'] === null) {
                $created = Categorie::firstOrCreate(['slug' => $cat['slug']], $cat);
                $parentMap[$created->id] = $created->id; // En l'occurrence, parent_id dans le tableau réfère à la position, mais on va gérer proprement
            }
        }

        // Création plus robuste (en se basant sur le nom du parent)
        $categoriesToCreate = [
            'Romans' => ['Thriller', 'Roman noir', 'Romance'],
            'Policier' => ['Enquête', 'Polar', 'Suspense'],
            'Science-Fiction' => ['Dystopie', 'Space opera', 'Cyberpunk'],
            'Sciences' => ['Physique', 'Biologie', 'Mathématiques'],
            'Histoire' => ['Antiquité', 'Médiévale', 'Moderne'],
            'Jeunesse' => ['Albums', 'Contes', 'Premières lectures'],
            'Informatique' => ['Programmation', 'Réseaux', 'IA'],
            'Philosophie' => ['Métaphysique', 'Éthique', 'Logique'],
        ];

        foreach ($categoriesToCreate as $parentName => $subcats) {
            $parent = Categorie::firstOrCreate(['nom' => $parentName], ['slug' => Str::slug($parentName)]);
            foreach ($subcats as $subName) {
                Categorie::firstOrCreate(
                    ['nom' => $subName],
                    ['slug' => Str::slug($subName), 'parent_id' => $parent->id]
                );
            }
        }

        // 2. Ouvrages réels
        $ouvrages = [
            [
                'titre' => 'Le Petit Prince',
                'auteurs' => 'Antoine de Saint-Exupéry',
                'isbn' => '9782070408504',
                'editeur' => 'Gallimard',
                'annee_publication' => 1943,
                'description' => 'Le célèbre conte philosophique de Saint-Exupéry.',
                'categories' => ['Romans', 'Jeunesse'],
                'exemplaires' => 3,
            ],
            [
                'titre' => '1984',
                'auteurs' => 'George Orwell',
                'isbn' => '9782070368228',
                'editeur' => 'Gallimard',
                'annee_publication' => 1949,
                'description' => 'Un classique intemporel de la dystopie.',
                'categories' => ['Romans', 'Science-Fiction'],
                'exemplaires' => 2,
            ],
            [
                'titre' => 'L\'Étranger',
                'auteurs' => 'Albert Camus',
                'isbn' => '9782070360024',
                'editeur' => 'Gallimard',
                'annee_publication' => 1942,
                'description' => 'Le roman existentialiste de Camus qui marque la littérature.',
                'categories' => ['Romans', 'Philosophie'],
                'exemplaires' => 2,
            ],
            [
                'titre' => 'Fondation',
                'auteurs' => 'Isaac Asimov',
                'isbn' => '9782070418480',
                'editeur' => 'Gallimard',
                'annee_publication' => 1951,
                'description' => 'Le chef-d\'œuvre fondateur de la science-fiction moderne.',
                'categories' => ['Science-Fiction'],
                'exemplaires' => 3,
            ],
            [
                'titre' => 'Le Meurtre de Roger Ackroyd',
                'auteurs' => 'Agatha Christie',
                'isbn' => '9782702430103',
                'editeur' => 'Librairie des Champs-Élysées',
                'annee_publication' => 1926,
                'description' => 'Un classique révolutionnaire du roman policier.',
                'categories' => ['Policier', 'Thriller'],
                'exemplaires' => 2,
            ],
            [
                'titre' => 'La Peste',
                'auteurs' => 'Albert Camus',
                'isbn' => '9782070360468',
                'editeur' => 'Gallimard',
                'annee_publication' => 1947,
                'description' => 'Chronique de la vie d\'une ville frappée par une épidémie.',
                'categories' => ['Romans'],
                'exemplaires' => 2,
            ],
            [
                'titre' => 'Dune',
                'auteurs' => 'Frank Herbert',
                'isbn' => '9782266228702',
                'editeur' => 'Robert Laffont',
                'annee_publication' => 1965,
                'description' => 'Le mythe planétaire et écologique de la science-fiction.',
                'categories' => ['Science-Fiction'],
                'exemplaires' => 2,
            ],
            [
                'titre' => 'L\'Alchimiste',
                'auteurs' => 'Paulo Coelho',
                'isbn' => '9782290352786',
                'editeur' => 'J\'ai lu',
                'annee_publication' => 1988,
                'description' => 'Un conte philosophique sur la quête de sa légende personnelle.',
                'categories' => ['Romans'],
                'exemplaires' => 2,
            ],
            [
                'titre' => 'Le Nom de la Rose',
                'auteurs' => 'Umberto Eco',
                'isbn' => '9782253154662',
                'editeur' => 'Grasset',
                'annee_publication' => 1980,
                'description' => 'Un meurtre mystérieux dans une abbaye au Moyen Âge.',
                'categories' => ['Policier', 'Histoire'],
                'exemplaires' => 2,
            ],
            [
                'titre' => 'La Guerre des Mondes',
                'auteurs' => 'H.G. Wells',
                'isbn' => '9782070355426',
                'editeur' => 'Gallimard',
                'annee_publication' => 1898,
                'description' => 'La première invasion martienne de la littérature.',
                'categories' => ['Science-Fiction'],
                'exemplaires' => 2,
            ],
        ];

        foreach ($ouvrages as $ouvrageData) {
            // Créer l'ouvrage de façon idempotente
            $ouvrage = Ouvrage::firstOrCreate(
                ['isbn' => $ouvrageData['isbn']],
                [
                    'titre' => $ouvrageData['titre'],
                    'slug' => Str::slug($ouvrageData['titre']) . '-' . uniqid(),
                    'auteurs' => $ouvrageData['auteurs'],
                    'editeur' => $ouvrageData['editeur'],
                    'annee_publication' => $ouvrageData['annee_publication'],
                    'description' => $ouvrageData['description'],
                    'nombre_exemplaires_total' => $ouvrageData['exemplaires'],
                    'nombre_exemplaires_disponibles' => $ouvrageData['exemplaires'],
                ]
            );

            // Attacher les catégories
            $categoriesIds = Categorie::whereIn('nom', $ouvrageData['categories'])->pluck('id');
            $ouvrage->categories()->syncWithoutDetaching($categoriesIds);

            // Si l'ouvrage vient d'être créé, créer ses exemplaires
            if ($ouvrage->wasRecentlyCreated) {
                for ($i = 1; $i <= $ouvrageData['exemplaires']; $i++) {
                    $code_barre = 'LIV-' . str_pad($ouvrage->id, 3, '0', STR_PAD_LEFT) . '-' . str_pad($i, 3, '0', STR_PAD_LEFT);
                    Exemplaire::create([
                        'ouvrage_id' => $ouvrage->id,
                        'code_barre' => $code_barre,
                        'cote' => 'A' . rand(1, 5) . '-' . rand(1, 10),
                        'statut' => 'disponible',
                    ]);
                }
            }
        }

        $this->command->info('✅ Données réelles importées avec succès !');
    }
}
