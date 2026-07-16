<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ISBNService
{
    /**
     * Recherche un ouvrage par son ISBN via Google Books puis OpenLibrary.
     */
    public function search(string $isbn, ?string $ip = null): ?array
    {
        $cleanIsbn = $this->cleanIsbn($isbn);

        if (empty($cleanIsbn)) {
            return null;
        }

        // Rate limiting basique basé sur l'IP si fournie
        if ($ip) {
            $rateLimitKey = 'isbn_search_limit_' . $ip;
            if (Cache::get($rateLimitKey, 0) > 10) {
                throw new \Exception("Trop de requêtes. Veuillez patienter.");
            }
            Cache::increment($rateLimitKey);
            // Si la clé vient d'être créée, on lui met une durée de vie d'une minute
            if (Cache::get($rateLimitKey) == 1) {
                Cache::put($rateLimitKey, 1, now()->addMinute());
            }
        }

        $cacheKey = 'isbn_search_' . $cleanIsbn;

        return Cache::remember($cacheKey, now()->addDays(7), function () use ($cleanIsbn) {
            $data = $this->searchGoogleBooks($cleanIsbn);
            
            if (!$data) {
                $data = $this->searchOpenLibrary($cleanIsbn);
            }

            if ($data && !empty($data['couverture_url'])) {
                $data['couverture'] = $this->downloadCover($data['couverture_url'], $cleanIsbn);
                unset($data['couverture_url']);
            }

            if ($data) {
                $data['isbn'] = $cleanIsbn;
            }

            return $data;
        });
    }

    /**
     * Nettoie l'ISBN (enlève tirets, espaces).
     */
    private function cleanIsbn(string $isbn): string
    {
        return preg_replace('/[^0-9X]/i', '', strtoupper($isbn));
    }

    /**
     * Recherche via Google Books API.
     */
    private function searchGoogleBooks(string $isbn): ?array
    {
        $apiKey = config('services.google_books.key');
        $url = "https://www.googleapis.com/books/v1/volumes?q=isbn:" . $isbn;
        
        if ($apiKey) {
            $url .= "&key=" . $apiKey;
        }

        try {
            $response = Http::timeout(5)->get($url);

            if ($response->successful() && $response->json('totalItems') > 0) {
                $item = $response->json('items.0.volumeInfo');

                return [
                    'titre' => $item['title'] ?? null,
                    'auteur' => isset($item['authors']) ? implode(', ', $item['authors']) : null,
                    'editeur' => $item['publisher'] ?? null,
                    'annee_publication' => isset($item['publishedDate']) ? substr($item['publishedDate'], 0, 4) : null,
                    'description' => $item['description'] ?? null,
                    'couverture_url' => $item['imageLinks']['thumbnail'] ?? null,
                    'categorie' => isset($item['categories']) ? $item['categories'][0] : null,
                    'nombre_pages' => $item['pageCount'] ?? null,
                    'source' => 'Google Books',
                ];
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning("Erreur API Google Books pour ISBN $isbn: " . $e->getMessage());
        }

        return null;
    }

    /**
     * Recherche via OpenLibrary API (Fallback).
     */
    private function searchOpenLibrary(string $isbn): ?array
    {
        $url = "https://openlibrary.org/api/books?bibkeys=ISBN:" . $isbn . "&format=json&jscmd=data";

        try {
            $response = Http::timeout(5)->get($url);

            if ($response->successful()) {
                $data = $response->json("ISBN:" . $isbn);

                if ($data) {
                    $authors = [];
                    if (isset($data['authors'])) {
                        foreach ($data['authors'] as $author) {
                            $authors[] = $author['name'];
                        }
                    }

                    return [
                        'titre' => $data['title'] ?? null,
                        'auteur' => implode(', ', $authors),
                        'editeur' => isset($data['publishers']) ? $data['publishers'][0]['name'] : null,
                        'annee_publication' => isset($data['publish_date']) ? substr($data['publish_date'], -4) : null, // ex: "1943" ou "October 1943"
                        'description' => $data['notes'] ?? null,
                        'couverture_url' => $data['cover']['large'] ?? $data['cover']['medium'] ?? null,
                        'categorie' => isset($data['subjects']) ? $data['subjects'][0]['name'] : null,
                        'nombre_pages' => $data['number_of_pages'] ?? null,
                        'source' => 'OpenLibrary',
                    ];
                }
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning("Erreur API OpenLibrary pour ISBN $isbn: " . $e->getMessage());
        }

        return null;
    }

    /**
     * Télécharge l'image de couverture localement.
     */
    private function downloadCover(string $url, string $isbn): ?string
    {
        // Remplacer http par https si nécessaire
        $url = str_replace('http://', 'https://', $url);
        
        try {
            $imageContent = file_get_contents($url);
            
            if ($imageContent !== false) {
                $extension = 'jpg';
                $filename = "couvertures/isbn_{$isbn}.{$extension}";
                
                Storage::disk('public')->put($filename, $imageContent);
                
                return $filename;
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning("Impossible de télécharger la couverture pour ISBN $isbn: " . $e->getMessage());
        }

        return null;
    }
}
