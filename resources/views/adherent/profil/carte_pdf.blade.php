<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Carte Adhérent - {{ $adherent->num_carte }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background: #f0f0f0; }
        .card { 
            width: 85.6mm; 
            height: 53.98mm; 
            background-color: #1E3A8A; 
            border-radius: 12px; 
            padding: 6mm; 
            color: white; 
            position: relative; 
            overflow: hidden;
            margin: 20px auto;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        .card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }
        .header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 3mm; position: relative; z-index: 10; }
        .title { font-size: 11pt; font-weight: 800; letter-spacing: -0.5px; margin: 0; }
        .title span { color: #93C5FD; }
        .subtitle { font-size: 6pt; text-transform: uppercase; letter-spacing: 1px; color: rgba(255,255,255,0.7); margin: 2px 0 0 0; }
        .type { font-size: 6pt; background: rgba(255, 255, 255, 0.2); padding: 1mm 2mm; border-radius: 3px; }
        
        .name { font-size: 10pt; font-weight: bold; margin: 10mm 0 1mm 0; line-height: 1.2; position: relative; z-index: 10;}
        .number { font-size: 7pt; color: rgba(255,255,255,0.9); margin: 0; letter-spacing: 0.5px; position: relative; z-index: 10;}
        
        .footer { position: absolute; bottom: 6mm; left: 6mm; right: 6mm; display: flex; justify-content: space-between; align-items: flex-end; z-index: 10;}
        .label { font-size: 6pt; text-transform: uppercase; color: rgba(255,255,255,0.6); margin: 0 0 2px 0; }
        .value { font-size: 8pt; font-weight: bold; margin: 0; }
        
        /* QR Code Simulation - as generating real base64 qr in blade needs controller data, we rely on the controller logic */
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <div>
                <p class="title">Biblio<span>Smart</span></p>
                <p class="subtitle">Carte d'adhérent</p>
            </div>
            <div class="type">{{ $adherent->typeAdherent->nom ?? 'Standard' }}</div>
        </div>
        
        <div>
            <p class="name">{{ $adherent->prenom }} {{ $adherent->nom }}</p>
            <p class="number">{{ $adherent->num_carte }}</p>
        </div>

        <div class="footer">
            <div>
                <p class="label">Émis le</p>
                <p class="value">{{ $adherent->date_inscription->format('d/m/Y') }}</p>
            </div>
            <div style="text-align: right;">
                <p class="label">Valable jusqu'au</p>
                <p class="value">{{ $adherent->date_expiration ? $adherent->date_expiration->format('d/m/Y') : 'N/A' }}</p>
            </div>
        </div>
    </div>
</body>
</html>
