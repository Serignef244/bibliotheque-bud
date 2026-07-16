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
        
        body {
            font-family: Arial, sans-serif;
            background: #f0f0f0;
        }
        
        .carte {
            width: 85.6mm;
            height: 53.98mm;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
            padding: 8mm;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .carte::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 3mm;
        }
        
        .logo {
            font-size: 8pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .type {
            font-size: 6pt;
            background: rgba(255, 255, 255, 0.2);
            padding: 1mm 2mm;
            border-radius: 3px;
        }
        
        .content {
            display: flex;
            gap: 5mm;
        }
        
        .photo {
            width: 20mm;
            height: 25mm;
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.3);
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .photo-placeholder {
            font-size: 20pt;
            color: rgba(255, 255, 255, 0.5);
        }
        
        .infos {
            flex: 1;
        }
        
        .nom {
            font-size: 10pt;
            font-weight: bold;
            margin-bottom: 1mm;
            line-height: 1.2;
        }
        
        .num-carte {
            font-size: 7pt;
            opacity: 0.9;
            margin-bottom: 1mm;
            letter-spacing: 0.5px;
        }
        
        .validite {
            font-size: 6pt;
            opacity: 0.8;
        }
        
        .footer {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 3mm;
        }
        
        .qr-code {
            width: 15mm;
            height: 15mm;
        }
        
        .qr-code svg {
            width: 100%;
            height: 100%;
        }
        
        .date {
            font-size: 6pt;
            opacity: 0.7;
        }
    </style>
</head>
<body>
    <div class="carte">
        <div class="header">
            <div class="logo">Bibliothèque</div>
            <div class="type">{{ $adherent->typeAdherent->nom }}</div>
        </div>
        
        <div class="content">
            <div class="photo">
                @if($photoBase64)
                    <img src="{{ $photoBase64 }}" alt="Photo">
                @else
                    <span class="photo-placeholder">👤</span>
                @endif
            </div>
            
            <div class="infos">
                <div class="nom">{{ $adherent->prenom }} {{ $adherent->nom }}</div>
                <div class="num-carte">{{ $adherent->num_carte }}</div>
                <div class="validite">
                    Valide jusqu'au: {{ $adherent->date_expiration ? $adherent->date_expiration->format('d/m/Y') : 'N/A' }}
                </div>
            </div>
        </div>
        
        <div class="footer">
            <div class="qr-code">
                {!! $qrCodeBase64 !!}
            </div>
            <div class="date">
                Émis le: {{ $adherent->date_inscription->format('d/m/Y') }}
            </div>
        </div>
    </div>
</body>
</html>
