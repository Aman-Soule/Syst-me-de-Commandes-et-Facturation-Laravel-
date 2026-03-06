@extends('template')

@section('content')

    <div class="confirmation-wrapper">
        <div class="confirmation-inner">

            <div class="confirmation-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
            </div>

            <p class="confirmation-eyebrow">Commande confirmée</p>
            <h1 class="confirmation-title">Merci pour votre commande !</h1>
            <p class="confirmation-subtitle">
                Votre commande a bien été enregistrée. Vous pouvez suivre son état en temps réel depuis votre espace de suivi.
            </p>

            <div class="confirmation-details">
                <div class="confirmation-detail-item">
                    <span class="detail-label">Client</span>
                    <span class="detail-value">{{ $commande->nom_client }}</span>
                </div>
                <div class="confirmation-detail-item">
                    <span class="detail-label">Téléphone</span>
                    <span class="detail-value">{{ $commande->telephone_client }}</span>
                </div>
                @foreach($commande->burgers as $burger)

                <div class="confirmation-detail-item">
                    <span class="detail-label">Burger</span>
                    <span class="detail-value">{{ $burger->nom }}</span>

                </div>
                <div class="confirmation-detail-item">
                    <span class="detail-label">Quantité</span>
                    <span class="detail-value">{{ $burger->pivot->quantite }}</span>
                </div>
                @endforeach

                <div class="confirmation-detail-item">
                    <span class="detail-label">Etat</span>
                    <span class="detail-value">{{ $commande->statut }}</span>
                </div>
                <div class="confirmation-detail-item">
                    <span class="detail-label">Total</span>
                    <span class="detail-value detail-price">
                    {{ number_format($commande->total, 0, ',', ' ') }} <small>FCFA</small>
                </span>
                </div>
            </div>

            <div class="confirmation-actions">
                <a href="#" class="btn-suivi">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9 17v-6h13M9 11H3m6 6H3m6-3H3"/>
                    </svg>
                    Suivre ma commande
                </a>
                <a href="{{ route('burgers.index') }}" class="btn-retour">
                    Retour au menu
                </a>
            </div>

        </div>
    </div>

    <style>
        .confirmation-wrapper {
            min-height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .confirmation-inner {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 8px 40px rgba(0,0,0,0.08);
            padding: 3rem 2.5rem;
            max-width: 520px;
            width: 100%;
            text-align: center;
        }

        .confirmation-icon {
            width: 80px;
            height: 80px;
            background: #f0fdf4;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            animation: pop .4s cubic-bezier(.36,.07,.19,.97);
        }

        .confirmation-icon svg {
            width: 40px;
            height: 40px;
            stroke: #22c55e;
            stroke-dasharray: 60;
            stroke-dashoffset: 60;
            animation: draw .6s .2s ease forwards;
        }

        @keyframes pop {
            0%   { transform: scale(0.5); opacity: 0; }
            100% { transform: scale(1);   opacity: 1; }
        }

        @keyframes draw {
            to { stroke-dashoffset: 0; }
        }

        .confirmation-eyebrow {
            font-size: .8rem;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: #22c55e;
            margin: 0 0 .5rem;
        }

        .confirmation-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: #111;
            margin: 0 0 .75rem;
            line-height: 1.2;
        }

        .confirmation-subtitle {
            color: #6b7280;
            font-size: .95rem;
            line-height: 1.6;
            margin: 0 0 2rem;
        }

        .confirmation-details {
            background: #f9fafb;
            border-radius: 12px;
            padding: 1.25rem 1.5rem;
            text-align: left;
            margin-bottom: 2rem;
            display: flex;
            flex-direction: column;
            gap: .75rem;
        }

        .confirmation-detail-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: .9rem;
        }

        .detail-label {
            color: #9ca3af;
            font-weight: 500;
        }

        .detail-value {
            color: #111;
            font-weight: 600;
        }

        .detail-price {
            color: #ef4444;
            font-size: 1rem;
        }

        .detail-price small {
            font-size: .7rem;
            font-weight: 500;
            color: #9ca3af;
            margin-left: 2px;
        }

        .confirmation-actions {
            display: flex;
            flex-direction: column;
            gap: .75rem;
        }

        .btn-suivi {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            background: #ef4444;
            color: #fff;
            font-weight: 700;
            font-size: .95rem;
            padding: .85rem 1.5rem;
            border-radius: 10px;
            text-decoration: none;
            transition: background .2s, transform .15s;
        }

        .btn-suivi:hover {
            background: #dc2626;
            transform: translateY(-1px);
        }

        .btn-retour {
            display: inline-block;
            color: #9ca3af;
            font-size: .875rem;
            font-weight: 500;
            text-decoration: none;
            padding: .5rem;
            transition: color .2s;
        }

        .btn-retour:hover {
            color: #374151;
        }
    </style>

@endsection
