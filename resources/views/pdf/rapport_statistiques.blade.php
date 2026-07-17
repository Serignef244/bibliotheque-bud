<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport Statistiques</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333; line-height: 1.6; }
        .header { text-align: center; border-bottom: 2px solid #1E3A8A; padding-bottom: 20px; margin-bottom: 30px; }
        .logo { font-size: 24px; font-weight: bold; color: #1E3A8A; }
        .title { font-size: 20px; color: #333; margin-top: 10px; }
        .date { font-size: 14px; color: #666; }
        
        .section { margin-bottom: 40px; }
        .section-title { font-size: 18px; color: #1E3A8A; border-bottom: 1px solid #ddd; padding-bottom: 5px; margin-bottom: 15px; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #f8f9fa; font-weight: bold; color: #333; }
        
        .stats-grid { display: block; width: 100%; }
        .stat-box { display: inline-block; width: 45%; margin-bottom: 20px; padding: 15px; border: 1px solid #e2e8f0; border-radius: 8px; background: #f8fafc; margin-right: 2%; box-sizing: border-box; }
        .stat-label { font-size: 14px; color: #64748b; margin-bottom: 5px; display: block; }
        .stat-value { font-size: 24px; font-weight: bold; color: #0f172a; }
        
        .footer { position: fixed; bottom: -30px; left: 0; right: 0; text-align: center; font-size: 12px; color: #999; border-top: 1px solid #eee; padding-top: 10px; }
        .page-number:after { content: counter(page); }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">{{ \App\Models\Setting::get('biblio_nom', 'BiblioSmart') }}</div>
        <div class="title">Rapport d'Activité et Statistiques</div>
        <div class="date">Généré le {{ now()->format('d/m/Y à H:i') }}</div>
        @if($period)
        <div class="date">Période du {{ \Carbon\Carbon::parse($period['start'])->format('d/m/Y') }} au {{ \Carbon\Carbon::parse($period['end'])->format('d/m/Y') }}</div>
        @endif
    </div>

    <div class="section">
        <div class="section-title">Vue d'ensemble</div>
        <div class="stats-grid">
            <div class="stat-box">
                <span class="stat-label">Total Livres</span>
                <span class="stat-value">{{ number_format($stats['totalBooks']) }}</span>
            </div>
            <div class="stat-box">
                <span class="stat-label">Adhérents Actifs</span>
                <span class="stat-value">{{ number_format($stats['activeMembers']) }}</span>
            </div>
            <div class="stat-box">
                <span class="stat-label">Prêts en cours</span>
                <span class="stat-value">{{ number_format($stats['currentLoans']) }}</span>
            </div>
            <div class="stat-box">
                <span class="stat-label">Pénalités Impayées</span>
                <span class="stat-value">{{ number_format($stats['totalFines'], 0, ',', ' ') }} FCFA</span>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Activité du Mois ({{ now()->translatedFormat('F Y') }})</div>
        <div class="stats-grid">
            <div class="stat-box">
                <span class="stat-label">Nouveaux Prêts</span>
                <span class="stat-value">{{ number_format($stats['monthlyLoans']) }}</span>
            </div>
            <div class="stat-box">
                <span class="stat-label">Nouvelles Inscriptions</span>
                <span class="stat-value">{{ number_format($stats['monthlyRegistrations']) }}</span>
            </div>
            <div class="stat-box">
                <span class="stat-label">Prêts en retard actuels</span>
                <span class="stat-value">{{ number_format($stats['lateLoans']) }}</span>
            </div>
            <div class="stat-box">
                <span class="stat-label">Taux de fréquentation</span>
                <span class="stat-value">{{ $stats['frequentationRate'] }}%</span>
            </div>
        </div>
    </div>

    <div class="footer">
        {{ \App\Models\Setting::get('biblio_nom', 'BiblioSmart') }} - Rapport de statistiques - Page <span class="page-number"></span>
    </div>
</body>
</html>
