<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Carte Adhérent - {{ $adherent->num_carte }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; margin: 0; padding: 0; }
        .card { 
            width: 85.6mm; 
            height: 53.98mm; 
            background: linear-gradient(135deg, #1E3A8A, #0f172a); 
            border-radius: 8px; 
            color: white; 
            position: relative; 
            padding: 15px; 
            box-sizing: border-box;
            overflow: hidden;
            margin: 20px auto;
        }
        .header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px; }
        .title { font-family: 'Georgia', serif; font-size: 16px; font-weight: bold; margin: 0; }
        .subtitle { font-size: 8px; text-transform: uppercase; letter-spacing: 1px; color: rgba(255,255,255,0.7); margin: 2px 0 0 0; }
        .name { font-family: 'Georgia', serif; font-size: 14px; margin: 0 0 2px 0; }
        .number { font-family: monospace; font-size: 12px; color: rgba(255,255,255,0.9); margin: 0; letter-spacing: 1px; }
        .footer { position: absolute; bottom: 15px; left: 15px; right: 15px; display: flex; justify-content: space-between; }
        .label { font-size: 7px; text-transform: uppercase; color: rgba(255,255,255,0.6); margin: 0 0 2px 0; }
        .value { font-size: 10px; font-weight: bold; margin: 0; }
        .barcode-area { background: white; padding: 5px; border-radius: 4px; display: inline-block; }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <div>
                <p class="title">BiblioNum</p>
                <p class="subtitle">Carte d'adhérent</p>
            </div>
        </div>
        
        <div>
            <p class="name">{{ $adherent->prenom }} {{ $adherent->nom }}</p>
            <p class="number">{{ $adherent->num_carte }}</p>
        </div>

        <div class="footer">
            <div>
                <p class="label">Type</p>
                <p class="value">{{ $adherent->typeAdherent->nom ?? 'Standard' }}</p>
            </div>
            <div style="text-align: right;">
                <p class="label">Valable jusqu'au</p>
                <p class="value">{{ $adherent->date_expiration ? $adherent->date_expiration->format('d/m/Y') : 'N/A' }}</p>
            </div>
        </div>
    </div>
</body>
</html>
