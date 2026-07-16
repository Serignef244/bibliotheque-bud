<?php

namespace App\Services;

use App\Models\Adherent;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class CarteAdherentService
{
    public function __construct(
        private readonly QRCodeService $qrCodeService,
    ) {}

    /**
     * Génère la carte d'adhérent en PDF.
     *
     * @return string Le chemin relatif du fichier PDF généré
     */
    public function generatePDF(Adherent $adherent): string
    {
        $adherent->load('typeAdherent');

        // Générer le QR Code (contenu SVG brut pour l'intégrer dans le PDF)
        $qrCodeSvg = $this->qrCodeService->generateSvgRaw($adherent->num_carte, 120);
        $qrCodeBase64 = base64_encode($qrCodeSvg);

        // Photo de l'adhérent en base64 si elle existe
        $photoBase64 = null;
        if ($adherent->photo && Storage::disk('public')->exists($adherent->photo)) {
            $photoContent = Storage::disk('public')->get($adherent->photo);
            $photoMime = Storage::disk('public')->mimeType($adherent->photo);
            $photoBase64 = 'data:' . $photoMime . ';base64,' . base64_encode($photoContent);
        }

        $pdf = Pdf::loadView('pdf.carte_adherent', [
            'adherent' => $adherent,
            'qrCodeBase64' => $qrCodeBase64,
            'photoBase64' => $photoBase64,
        ]);

        // Format carte de crédit : 85.6mm x 53.98mm
        $pdf->setPaper([0, 0, 242.65, 153.07], 'landscape');

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
