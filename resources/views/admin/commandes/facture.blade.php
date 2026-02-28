<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 13px;
            color: #1a1a1a;
            background: #fff;
            padding: 40px;
        }

        /* ---- En-tête ---- */
        .header {
            display: table;
            width: 100%;
            margin-bottom: 40px;
            border-bottom: 3px solid #111;
            padding-bottom: 20px;
        }
        .header-left {
            display: table-cell;
            vertical-align: top;
            width: 50%;
        }
        .header-right {
            display: table-cell;
            vertical-align: top;
            text-align: right;
            width: 50%;
        }

        .logo-text {
            font-size: 26px;
            font-weight: bold;
            color: #111;
            letter-spacing: 1px;
        }
        .logo-sub {
            font-size: 11px;
            color: #666;
            margin-top: 2px;
        }

        .facture-title {
            font-size: 22px;
            font-weight: bold;
            color: #111;
        }
        .facture-num {
            font-size: 12px;
            color: #555;
            margin-top: 4px;
        }
        .facture-date {
            font-size: 11px;
            color: #888;
            margin-top: 2px;
        }

        /* ---- Bloc infos ---- */
        .infos {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }
        .infos-col {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }
        .infos-box {
            background: #f8f8f8;
            border-left: 4px solid #111;
            padding: 14px 18px;
            border-radius: 2px;
            margin-right: 15px;
        }
        .infos-box h3 {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #888;
            margin-bottom: 8px;
        }
        .infos-box p {
            font-size: 13px;
            color: #111;
            margin-bottom: 3px;
        }
        .infos-box .label {
            font-size: 11px;
            color: #888;
        }

        /* ---- Badge statut ---- */
        .statut-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
        }
        .statut-prete  { background: #dcfce7; color: #166534; }
        .statut-payee  { background: #e5e7eb; color: #374151; }

        /* ---- Tableau articles ---- */
        .articles-title {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #888;
            margin-bottom: 10px;
        }

        table.articles {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }
        table.articles thead tr {
            background: #111;
            color: #fff;
        }
        table.articles thead th {
            padding: 10px 14px;
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }
        table.articles tbody tr:nth-child(even) {
            background: #f9f9f9;
        }
        table.articles tbody td {
            padding: 10px 14px;
            font-size: 13px;
            border-bottom: 1px solid #eeeeee;
        }
        table.articles tfoot td {
            padding: 10px 14px;
            font-size: 13px;
        }

        /* ---- Total ---- */
        .total-block {
            text-align: right;
            margin-bottom: 36px;
        }
        .total-line {
            display: table;
            width: 260px;
            margin-left: auto;
            margin-bottom: 6px;
        }
        .total-line-label, .total-line-value {
            display: table-cell;
            font-size: 12px;
            color: #555;
        }
        .total-line-value {
            text-align: right;
        }
        .total-final {
            display: table;
            width: 260px;
            margin-left: auto;
            background: #111;
            color: #fff;
            padding: 10px 14px;
            border-radius: 4px;
            margin-top: 8px;
        }
        .total-final-label, .total-final-value {
            display: table-cell;
            font-size: 14px;
            font-weight: bold;
        }
        .total-final-value {
            text-align: right;
        }

        /* ---- Message de remerciement ---- */
        .thanks {
            text-align: center;
            color: #888;
            font-size: 12px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        .thanks strong {
            color: #111;
            font-size: 13px;
        }

        /* ---- Pied de page ---- */
        .footer {
            text-align: center;
            font-size: 10px;
            color: #bbb;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<!-- En-tête -->
<div class="header">
    <div class="header-left">
        <div class="logo-text">ISI BURGER</div>
        <div class="logo-sub">Restaurant – Fast Food</div>
    </div>
    <div class="header-right">
        <div class="facture-title">FACTURE</div>
        <div class="facture-num">N° {{ str_pad($commande->id, 6, '0', STR_PAD_LEFT) }}</div>
        <div class="facture-date">Émise le {{ now()->format('d/m/Y à H:i') }}</div>
    </div>
</div>

<!-- Infos client + commande -->
<div class="infos">
    <div class="infos-col">
        <div class="infos-box">
            <h3>Client</h3>
            <p><strong>{{ $commande->nom_client }}</strong></p>
            <p class="label">Téléphone</p>
            <p>{{ $commande->telephone_client }}</p>
        </div>
    </div>
    <div class="infos-col">
        <div class="infos-box" style="margin-right: 0; margin-left: 15px;">
            <h3>Détails commande</h3>
            @foreach($commande->burgers as $burger)
            <p class="label">Burger</p>
            <p>{{ $burger->nom }}</p>

            <p class="label">Quantité</p>
            <p>{{ $burger->pivot->quantite }}</p>
            @endforeach

            <p class="label">Date de commande</p>
            <p>{{ $commande->created_at->format('d/m/Y à H:i') }}</p>
            <p class="label" style="margin-top: 6px;">Statut</p>
            <p>
                    <span class="statut-badge {{ $commande->statut === 'payee' ? 'statut-payee' : 'statut-prete' }}">
                        {{ $commande->statut === 'payee' ? 'Payée' : 'Prête' }}
                    </span>
            </p>
        </div>
    </div>
</div>

<!-- Articles commandés -->
<p class="articles-title">Articles commandés</p>
<table class="articles">
    <thead>
    <tr>
        <th>#</th>
        <th>Désignation</th>
        <th>Qté</th>
        <th>Prix unitaire</th>
        <th>Sous-total</th>
    </tr>
    </thead>
    <tbody>
     <tr>
            <td>Commande #{{ str_pad($commande->id, 6, '0', STR_PAD_LEFT) }}</td>
            @foreach($commande->burgers as $burger)
            <td>{{ $burger->nom }}</td>
            <td>{{ $burger->pivot->quantite }}</td>
            <td>{{ $burger->prix_unitaire }} FCFA</td>
            @endforeach
            <td>{{ number_format($commande->total, 0, ',', ' ') }} FCFA</td>
        </tr>
    </tbody>
</table>

<!-- Total -->
<div class="total-block">
    <div class="total-line">
        <div class="total-line-label">Sous-total HT</div>
        <div class="total-line-value">{{ number_format($commande->total, 0, ',', ' ') }} FCFA</div>
    </div>
    <div class="total-line">
        <div class="total-line-label">TVA (0%)</div>
        <div class="total-line-value">0 FCFA</div>
    </div>
    <div class="total-final">
        <div class="total-final-label">TOTAL À PAYER</div>
        <div class="total-final-value">{{ number_format($commande->total, 0, ',', ' ') }} FCFA</div>
    </div>
</div>

<!-- Message -->
<div class="thanks">
    <strong>Merci pour votre commande !</strong><br>
    ISI BURGER vous souhaite un excellent repas. À très bientôt 🍔
</div>

<!-- Pied de page -->
<div class="footer">
    Document généré automatiquement le {{ now()->format('d/m/Y à H:i') }} — ISI BURGER
</div>

</body>
</html>
