<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadService
{
    private const DISK = 'public';

    public function uploadCouverture(UploadedFile $fichier): ?string
    {
        $cloudName = env('CLOUDINARY_CLOUD_NAME');
        $apiKey = env('CLOUDINARY_API_KEY');
        $apiSecret = env('CLOUDINARY_API_SECRET');

        if (!$cloudName || !$apiKey || !$apiSecret) {
            // Fallback au stockage local si Cloudinary n'est pas configuré
            $nom = Str::uuid() . '.' . $fichier->getClientOriginalExtension();
            return $fichier->storeAs('couvertures', $nom, self::DISK);
        }

        try {
            $timestamp = time();
            // Signature require 'folder' as well if it's passed, so let's pass it in alphabetical order
            // Actually, we can just use an "unsigned upload preset" or construct signature properly.
            // Let's use the simplest signature: timestamp + apiSecret
            $signature = sha1("timestamp={$timestamp}{$apiSecret}");

            $response = \Illuminate\Support\Facades\Http::attach(
                'file',
                file_get_contents($fichier->getRealPath()),
                $fichier->getClientOriginalName()
            )->post("https://api.cloudinary.com/v1_1/{$cloudName}/image/upload", [
                'api_key' => $apiKey,
                'timestamp' => $timestamp,
                'signature' => $signature,
            ]);

            if ($response->successful()) {
                return $response->json('secure_url');
            }

            \Illuminate\Support\Facades\Log::error('Cloudinary Upload Failed: ' . $response->body());
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Cloudinary Exception: ' . $e->getMessage());
        }

        // Fallback local en cas d'erreur
        $nom = Str::uuid() . '.' . $fichier->getClientOriginalExtension();
        return $fichier->storeAs('couvertures', $nom, self::DISK);
    }

    public function supprimer(?string $chemin): void
    {
        if ($chemin && !str_starts_with($chemin, 'http') && Storage::disk(self::DISK)->exists($chemin)) {
            Storage::disk(self::DISK)->delete($chemin);
        }
    }
}
