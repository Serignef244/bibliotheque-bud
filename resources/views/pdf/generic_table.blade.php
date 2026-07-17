<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Export {{ ucfirst($type) }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #1E3A8A; padding-bottom: 10px; margin-bottom: 20px; }
        .logo { font-size: 20px; font-weight: bold; color: #1E3A8A; }
        .title { font-size: 16px; color: #333; margin-top: 5px; }
        .date { font-size: 12px; color: #666; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 6px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #f8f9fa; font-weight: bold; color: #333; }
        
        .footer { position: fixed; bottom: -30px; left: 0; right: 0; text-align: center; font-size: 10px; color: #999; border-top: 1px solid #eee; padding-top: 10px; }
        .page-number:after { content: counter(page); }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">{{ \App\Models\Setting::get('biblio_nom', 'BiblioSmart') }}</div>
        <div class="title">Export des {{ ucfirst($type) }}</div>
        <div class="date">Généré le {{ now()->format('d/m/Y à H:i') }}</div>
        @if($period && isset($period['start']) && isset($period['end']))
        <div class="date">Période : {{ \Carbon\Carbon::parse($period['start'])->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($period['end'])->format('d/m/Y') }}</div>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                @foreach($headings as $heading)
                <th>{{ $heading }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($data as $row)
            <tr>
                @foreach($row as $cell)
                <td>{{ $cell }}</td>
                @endforeach
            </tr>
            @endforeach
            
            @if(count($data) === 0)
            <tr>
                <td colspan="{{ count($headings) }}" style="text-align: center;">Aucune donnée disponible pour cette période.</td>
            </tr>
            @endif
        </tbody>
    </table>

    <div class="footer">
        {{ \App\Models\Setting::get('biblio_nom', 'BiblioSmart') }} - Export {{ ucfirst($type) }} - Page <span class="page-number"></span>
    </div>
</body>
</html>
