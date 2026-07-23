<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carte Adhérent</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        @page {
            margin: 0;
            size: A4 portrait;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #ffffff;
            font-size: 8pt;
            color: #4A5568;
        }

        .container {
            width: 100%;
            padding-top: 20mm;
        }
        
        .page {
            width: 85.6mm;
            height: 53.98mm;
            position: relative;
            background: #ffffff;
            overflow: hidden;
            border-radius: 4mm;
            margin: 0 auto 15mm auto;
            border: 1px solid #e2e8f0; /* Simulate cut line/shadow */
        }

        /* --- FRONT --- */
        .front-bg-shape {
            position: absolute;
            bottom: -5mm;
            right: -5mm;
            width: 50mm;
            height: 20mm;
            background-color: #0B2E59;
            border-radius: 50% 0 0 0;
            z-index: 1;
        }
        .front-bg-shape-2 {
            position: absolute;
            bottom: -2mm;
            right: 20mm;
            width: 20mm;
            height: 12mm;
            background-color: #1E88E5;
            transform: skewX(-30deg);
            z-index: 0;
        }

        .front-header {
            position: absolute;
            top: 3mm;
            left: 3mm;
            width: 80mm;
            z-index: 2;
        }

        .logo-container {
            float: left;
        }
        .logo-img {
            height: 6mm;
        }
        .slogan-top {
            font-size: 4.5pt;
            color: #4A5568;
            letter-spacing: 0.5px;
            margin-top: 1px;
            margin-left: 1mm;
        }

        .front-content {
            position: absolute;
            top: 13mm;
            left: 3mm;
            width: 80mm;
            z-index: 2;
        }

        .photo-wrapper {
            float: left;
            width: 25mm;
        }
        .photo {
            width: 25mm;
            height: 30mm;
            background-color: #F5F7FA;
            border-radius: 4mm;
            overflow: hidden;
            text-align: center;
            border: 1px solid #e2e8f0;
        }
        .photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .info-wrapper {
            float: left;
            padding-left: 3mm;
            width: 55mm;
        }

        .user-name {
            font-size: 9pt;
            font-weight: bold;
            color: #0B2E59;
            margin-bottom: 0.5mm;
            line-height: 1.2;
        }
        .user-type {
            font-size: 6pt;
            color: #1E88E5;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 2mm;
            line-height: 1;
        }

        .info-grid {
            width: 100%;
        }
        .info-col-1 {
            float: left;
            width: 55%;
        }
        .info-col-2 {
            float: left;
            width: 45%;
        }

        .info-row {
            margin-bottom: 2mm;
        }
        .info-label {
            font-size: 4pt;
            color: #4A5568;
            margin-bottom: 0.5mm;
            line-height: 1;
        }
        .info-value {
            font-size: 5pt;
            color: #0B2E59;
            font-weight: bold;
            line-height: 1;
        }

        .front-footer {
            position: absolute;
            bottom: 2mm;
            right: 3mm;
            z-index: 2;
            text-align: right;
        }
        .slogan-bottom {
            color: #ffffff;
            font-size: 5pt;
            font-style: italic;
        }

        /* --- BACK --- */
        .back-top {
            background-color: #0B2E59;
            height: 12mm;
            width: 100%;
            text-align: center;
            padding-top: 3mm;
        }
        .back-top img {
            height: 6mm;
            filter: brightness(0) invert(1);
        }

        .back-middle {
            height: 34mm;
            width: 100%;
            text-align: center;
            padding-top: 2mm;
        }
        .qr-center-box {
            display: inline-block;
            width: 28mm;
            height: 28mm;
            background: white;
            padding: 0;
            border: 1px solid #e2e8f0;
            border-radius: 1mm;
            overflow: hidden;
        }
        .qr-center-box img {
            width: 28mm;
            height: 28mm;
            display: block;
        }
        .qr-text {
            font-family: monospace;
            font-size: 8pt;
            font-weight: bold;
            color: #0B2E59;
            margin-top: 1.5mm;
            letter-spacing: 0.5px;
        }

        .back-bottom {
            background-color: #F5F7FA;
            height: 8mm;
            width: 100%;
            position: absolute;
            bottom: 0;
            padding: 0 3mm;
        }
        .contact-item {
            float: left;
            font-size: 5pt;
            color: #4A5568;
            text-align: center;
            width: 33.33%;
            line-height: 8mm;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- PAGE 1: RECTO -->
        <div class="page">
            <div class="front-bg-shape-2"></div>
            <div class="front-bg-shape"></div>
            
            <div class="front-header">
                <div class="logo-container">
                    <img src="{{ public_path('images/logo.jpeg') }}" class="logo-img" alt="BiblioSmart">
                    <div class="slogan-top">Gérez. Organisez. Valorisez.</div>
                </div>
            </div>

            <div class="front-content">
                <div class="photo-wrapper">
                    <div class="photo">
                        @if($photoBase64)
                            <img src="{{ $photoBase64 }}" alt="Photo">
                        @endif
                    </div>
                </div>
                <div class="info-wrapper">
                    <div class="user-name">{{ mb_strtoupper($adherent->nom) }} {{ $adherent->prenom }}</div>
                    <div class="user-type">ADHÉRENT</div>
                    
                    <div class="info-grid">
                        <div class="info-col-1">
                            <div class="info-row">
                                <div class="info-label">ID Adhérent</div>
                                <div class="info-value">{{ $adherent->num_carte }}</div>
                            </div>
                            
                            <div class="info-row">
                                <div class="info-label">Date d'émission</div>
                                <div class="info-value">{{ $adherent->date_inscription->format('d/m/Y') }}</div>
                            </div>
                        </div>
                        <div class="info-col-2">
                            <div class="info-row">
                                <div class="info-label">Catégorie</div>
                                <div class="info-value">{{ $adherent->typeAdherent->nom ?? 'Standard' }}</div>
                            </div>

                            <div class="info-row">
                                <div class="info-label">Date d'expiration</div>
                                <div class="info-value">{{ $adherent->date_expiration ? $adherent->date_expiration->format('d/m/Y') : 'Illimitée' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="front-footer">
                <div class="slogan-bottom">Le savoir mérite le meilleur outil.</div>
            </div>
        </div>

        <!-- PAGE 2: VERSO -->
        <div class="page">
            <div class="back-top">
                <img src="{{ public_path('images/logo.jpeg') }}" alt="BiblioSmart">
            </div>

            <div class="back-middle">
                <div class="qr-center-box">
                    <img src="data:image/svg+xml;base64,{!! $qrCodeBase64 !!}" alt="QR">
                </div>
                <div class="qr-text">{{ $adherent->num_carte }}</div>
                <div style="font-size: 5pt; color: #718096; margin-top: 2mm;">
                    Carte strictement personnelle. Présentation obligatoire lors des emprunts.
                </div>
            </div>

            <div class="back-bottom">
                <div class="contact-item" style="text-align: left;">www.bibliosmart.com</div>
                <div class="contact-item">contact@bibliosmart.com</div>
                <div class="contact-item" style="text-align: right;">+221 77 123 45 67</div>
            </div>
        </div>
    </div>
</body>
</html>
