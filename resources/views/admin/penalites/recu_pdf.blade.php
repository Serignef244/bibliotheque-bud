<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Reçu de paiement - Pénalité #{{ $penalite->id }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333; font-size: 14px; line-height: 1.5; margin: 0; padding: 20px; }
        .header { text-align: center; margin-bottom: 40px; border-bottom: 2px solid #e2e8f0; padding-bottom: 20px; }
        .logo { font-size: 24px; font-weight: bold; color: #4f46e5; margin-bottom: 5px; }
        .title { font-size: 20px; font-weight: bold; color: #1e293b; text-transform: uppercase; letter-spacing: 1px; }
        .receipt-info { display: flex; justify-content: space-between; margin-bottom: 30px; }
        .info-block { width: 48%; display: inline-block; vertical-align: top; }
        .label { font-size: 12px; color: #64748b; text-transform: uppercase; margin-bottom: 4px; }
        .value { font-size: 14px; color: #0f172a; font-weight: bold; margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th { background-color: #f8fafc; color: #475569; font-size: 12px; text-transform: uppercase; text-align: left; padding: 12px; border-bottom: 2px solid #e2e8f0; }
        td { padding: 12px; border-bottom: 1px solid #e2e8f0; color: #1e293b; }
        .total-section { width: 100%; text-align: right; }
        .total-row { display: inline-block; width: 300px; }
        .total-label { display: inline-block; width: 150px; text-align: right; padding-right: 15px; color: #64748b; }
        .total-value { display: inline-block; width: 130px; text-align: right; font-weight: bold; font-size: 16px; color: #0f172a; }
        .amount-paid { background-color: #f0fdf4; padding: 10px; margin-top: 10px; border-radius: 4px; }
        .amount-paid .total-label { color: #166534; }
        .amount-paid .total-value { color: #166534; font-size: 18px; }
        .footer { margin-top: 60px; text-align: center; color: #94a3b8; font-size: 12px; border-top: 1px solid #e2e8f0; padding-top: 20px; }
        .watermark { position: absolute; top: 30%; left: 15%; font-size: 100px; color: rgba(79, 70, 229, 0.05); transform: rotate(-45deg); z-index: -1; }
    </style>
</head>
<body>
    <div class="watermark">PAYÉ</div>

    <div class="header">
        <div class="logo">BiblioSmart</div>
        <p style="margin: 0; color: #64748b;">123 Rue de la Lecture, 75000 Paris</p>
        <p style="margin: 0; color: #64748b;">Tél: 01 23 45 67 89 • Email: contact@bibliosmart.fr</p>
        <div style="margin-top: 20px;">
            <div class="title">Reçu de paiement</div>
            <div style="color: #64748b; margin-top: 5px;">N° {{ str_pad($paiement->id, 6, '0', STR_PAD_LEFT) }}</div>
        </div>
    </div>

    <div class="receipt-info">
        <div class="info-block">
            <div class="label">Payé par</div>
            <div class="value">{{ $penalite->adherent->prenom }} {{ $penalite->adherent->nom }}</div>
            <div class="label">Numéro de carte</div>
            <div class="value">{{ $penalite->adherent->num_carte }}</div>
            <div class="label">Type d'adhérent</div>
            <div class="value">{{ $penalite->adherent->typeAdherent->nom }}</div>
        </div>
        <div class="info-block" style="text-align: right;">
            <div class="label">Date de paiement</div>
            <div class="value">{{ $paiement->date_paiement->format('d/m/Y') }}</div>
            <div class="label">Statut de la pénalité</div>
            <div class="value" style="color: {{ $penalite->montant_restant == 0 ? '#166534' : '#b45309' }};">
                {{ $penalite->montant_restant == 0 ? 'Réglée' : 'Partiellement réglée' }}
            </div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th style="text-align: right;">Montant</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div style="font-weight: bold;">Pénalité de retard</div>
                    <div style="font-size: 12px; color: #64748b; margin-top: 4px;">Ouvrage : {{ $penalite->pret->exemplaire->ouvrage->titre }}</div>
                    <div style="font-size: 12px; color: #64748b;">Retard de {{ $penalite->jours_retard }} jours (retour prévu le {{ $penalite->pret->date_retour_prevue->format('d/m/Y') }})</div>
                </td>
                <td style="text-align: right; vertical-align: top; padding-top: 15px; font-weight: bold;">
                    {{ number_format($penalite->montant, 0, ',', ' ') }} FCFA
                </td>
            </tr>
        </tbody>
    </table>

    <div class="total-section">
        <div class="total-row" style="margin-bottom: 10px;">
            <span class="total-label">Montant initial :</span>
            <span class="total-value">{{ number_format($penalite->montant, 0, ',', ' ') }} FCFA</span>
        </div>
        @if($penalite->montant != $paiement->montant + $penalite->montant_restant)
        <div class="total-row" style="margin-bottom: 10px;">
            <span class="total-label">Déjà payé :</span>
            <span class="total-value">{{ number_format($penalite->montant - $penalite->montant_restant - $paiement->montant, 0, ',', ' ') }} FCFA</span>
        </div>
        @endif
        <div class="total-row amount-paid">
            <span class="total-label">Montant payé ce jour :</span>
            <span class="total-value">{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</span>
        </div>
        @if($penalite->montant_restant > 0)
        <div class="total-row" style="margin-top: 10px;">
            <span class="total-label">Reste à payer :</span>
            <span class="total-value" style="color: #b91c1c;">{{ number_format($penalite->montant_restant, 0, ',', ' ') }} FCFA</span>
        </div>
        @endif
    </div>

    <div class="footer">
        <p>Merci de votre paiement. Ce reçu certifie le règlement du montant indiqué.</p>
        <p>Généré le {{ now()->format('d/m/Y à H:i') }}</p>
    </div>
</body>
</html>
