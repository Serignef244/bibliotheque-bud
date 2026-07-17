<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Etiquette {{ $exemplaire->code_barre }}</title>
    <style>
        @page {
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 8px; /* Slight padding from edges */
            text-align: center;
            width: 100%;
            height: 100%;
            box-sizing: border-box;
            background-color: #ffffff;
        }
        .container {
            width: 100%;
            height: 100%;
            display: table;
        }
        .content {
            display: table-cell;
            vertical-align: middle;
        }
        .title {
            font-size: 10px;
            font-weight: bold;
            margin-bottom: 2px;
            text-transform: uppercase;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .author {
            font-size: 8px;
            margin-bottom: 5px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .barcode {
            margin: 0 auto;
            text-align: center;
        }
        .barcode img {
            width: 140px;
            height: 40px;
            margin: 0 auto;
        }
        .code {
            font-size: 11px;
            font-weight: bold;
            letter-spacing: 1px;
            margin-top: 3px;
        }
        .biblio-name {
            font-size: 7px;
            color: #555;
            margin-top: 5px;
            border-top: 1px solid #ccc;
            padding-top: 2px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="content">
            <div class="title">{{ Str::limit($ouvrage->titre, 25) }}</div>
            <div class="author">{{ Str::limit($ouvrage->auteurs, 30) }}</div>
            
            <div class="barcode">
                <img src="data:image/svg+xml;base64,{{ base64_encode($svgCodeBarre) }}" width="140" height="40" alt="Code-barres">
            </div>
            
            <div class="code">{{ $exemplaire->code_barre }}</div>
            
            <div class="biblio-name">{{ \App\Models\Setting::get('biblio_nom', 'BiblioSmart') }}</div>
        </div>
    </div>
</body>
</html>
