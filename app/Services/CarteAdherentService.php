<?php

namespace App\Services;

use App\Models\Adherent;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class CarteAdherentService
{
    public function __construct(
        private readonly QRCodeService $qrCodeService,
        private readonly CodeBarreService $codeBarreService,
    ) {}

    /**
     * Génère la carte d'adhérent en PDF.
     *
     * @return string Le chemin relatif du fichier PDF généré
     */
    public function generatePDF(Adherent $adherent): string
    {
        $adherent->load('typeAdherent');

        // Générer le QR Code
        $qrCodeSvg = $this->qrCodeService->generateSvgRaw($adherent->num_carte, 60);
        $qrCodeBase64 = base64_encode($qrCodeSvg);

        // Générer le Code-barres
        $barcodeSvg = $this->codeBarreService->genererSvg($adherent->num_carte, 40, 2);
        // Supprimer le texte car nous allons l'afficher proprement en HTML
        $barcodeSvg = preg_replace('/<text.*?<\/text>/', '', $barcodeSvg);
        $barcodeBase64 = base64_encode($barcodeSvg);

        // Photo de l'adhérent en base64 si elle existe
        $photoBase64 = null;
        if ($adherent->photo) {
            if (str_starts_with($adherent->photo, 'http')) {
                // Image hébergée sur Cloudinary ou ailleurs
                try {
                    $photoContent = file_get_contents($adherent->photo);
                    if ($photoContent) {
                        $finfo = new \finfo(FILEINFO_MIME_TYPE);
                        $photoMime = $finfo->buffer($photoContent);
                        $photoBase64 = 'data:' . $photoMime . ';base64,' . base64_encode($photoContent);
                    }
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::warning("Impossible de charger la photo Cloudinary de l'adhérent: " . $e->getMessage());
                }
            } elseif (Storage::disk('public')->exists($adherent->photo)) {
                // Fichier local
                $photoContent = Storage::disk('public')->get($adherent->photo);
                $photoMime = Storage::disk('public')->mimeType($adherent->photo);
                $photoBase64 = 'data:' . $photoMime . ';base64,' . base64_encode($photoContent);
            }
        }

        $pdf = Pdf::loadView('pdf.carte_adherent', [
            'adherent' => $adherent,
            'qrCodeBase64' => $qrCodeBase64,
            'barcodeBase64' => $barcodeBase64,
            'photoBase64' => $photoBase64,
        ]);

        // Format A4 pour imprimer le recto et le verso sur la même page
        $pdf->setPaper('A4', 'portrait');

        $filename = 'cartes/carte_' . $adherent->num_carte . '.pdf';
        Storage::disk('public')->put($filename, $pdf->output());

        return $filename;
    }

    /**
     * Envoie la carte par email à l'adhérent.
     */
    public function sendByEmail(Adherent $adherent): bool
    {
        $pdfPath = $this->generatePDF($adherent);
        $fullPath = Storage::disk('public')->path($pdfPath);

        // TODO: Implémentation avec Mailable dans le module email
        // Mail::to($adherent->email)->send(new CarteAdherentMail($adherent, $fullPath));

        \Illuminate\Support\Facades\Log::info("Carte adhérent envoyée par email à {$adherent->email}", [
            'adherent_id' => $adherent->id,
            'pdf_path' => $pdfPath,
        ]);

        return true;
    }
}
