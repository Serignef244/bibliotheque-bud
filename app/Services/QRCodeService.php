<?php

namespace App\Services;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class QRCodeService
{
    /**
     * Génère un QR code à partir d'une chaîne de caractères.
     *
     * @param  string  $data  Les données à encoder
     * @param  int     $size  La taille du QR code en pixels
     * @return string  Le chemin relatif de l'image générée
     */
    public function generate(string $data, int $size = 200): string
    {
        $filename = 'qrcodes/' . md5($data) . '.svg';

        $svg = QrCode::format('svg')
            ->size($size)
            ->errorCorrection('H')
            ->generate($data);

        Storage::disk('public')->put($filename, $svg);

        return $filename;
    }

    /**
     * Génère un QR code pour un adhérent.
     * Le QR code encode le numéro de carte pour un scan facile.
     *
     * @param  string  $numCarte  Le numéro de carte de l'adhérent
     * @return string  Le chemin relatif de l'image générée
     */
    public function generateFromNumCarte(string $numCarte): string
    {
        return $this->generate($numCarte, 250);
    }

    /**
     * Retourne le contenu SVG brut du QR code (pour insertion dans un PDF).
     */
    public function generateSvgRaw(string $data, int $size = 200): string
    {
        return QrCode::format('svg')
            ->size($size)
            ->errorCorrection('H')
            ->generate($data);
    }
}
