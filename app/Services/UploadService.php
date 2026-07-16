<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadService
{
    private const DISK = 'public';

    public function uploadCouverture(UploadedFile $fichier): string
    {
        $nom = Str::uuid() . '.' . $fichier->getClientOriginalExtension();
        return $fichier->storeAs('couvertures', $nom, self::DISK);
    }

    public function supprimer(?string $chemin): void
    {
        if ($chemin && Storage::disk(self::DISK)->exists($chemin)) {
            Storage::disk(self::DISK)->delete($chemin);
        }
    }
}
