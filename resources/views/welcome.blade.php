@extends('template')

@section('content')

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@400;500;600&display=swap');

        :root {
            --gold:       #eab308;
            --gold-light: #fde68a;
            --dark:       #0f1117;
            --dark-card:  #1a1d27;
            --soft:       #9ca3af;
        }

        /* Annule le padding/container du layout pour prendre toute la largeur */
        .home-wrapper {
            font-family: 'DM Sans', sans-serif;
            background: var(--dark);
            color: #fff;
            margin: 0;
            padding: 0;
        }

        /* ===== HERO ===== */
        .hero {
            position: relative;
            min-height: 90vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 7rem 1.5rem 5rem;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(234,179,8,.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(234,179,8,.05) 1px, transparent 1px);
            background-size: 64px 64px;
            pointer-events: none;
        }

        .hero::after {
            content: '';
            position: absolute;
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 800px;
            height: 800px;
            background: radial-gradient(circle, rgba(234,179,8,.11) 0%, transparent 65%);
            pointer-events: none;
        }

        .hero-inner { position: relative; z-index: 1; max-width: 700px; margin: 0 auto; }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            background: rgba(234,179,8,.1);
            border: 1px solid rgba(234,179,8,.28);
            color: var(--gold);
            font-size: .75rem;
            font-weight: 600;
            letter-spacing: .14em;
            text-transform: uppercase;
            padding: .35rem 1rem;
            border-radius: 100px;
            margin-bottom: 1.8rem;
            animation: fadeUp .55s ease both;
        }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(3.2rem, 10vw, 7.5rem);
            font-weight: 900;
            line-height: .95;
            color: #fff;
            margin-bottom: 1.5rem;
            animation: fadeUp .6s .1s ease both;
        }
        .hero-title em {
            font-style: normal;
            color: var(--gold);
        }

        .hero-sub {
            font-size: clamp(.95rem, 2vw, 1.1rem);
            color: var(--soft);
            line-height: 1.75;
            margin-bottom: 2.8rem;
            animation: fadeUp .6s .2s ease both;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: .55rem;
            background: var(--gold);
            color: #0f1117;
            font-weight: 700;
            font-size: 1rem;
            padding: .9rem 2.2rem;
            border-radius: 100px;
            text-decoration: none;
            transition: transform .22s, box-shadow .22s, background .22s;
            animation: fadeUp .6s .3s ease both;
        }
        .btn-primary:hover {
            transform: translateY(-3px);
            background: var(--gold-light);
            box-shadow: 0 14px 40px rgba(234,179,8,.35);
        }
        .btn-primary:hover svg { transform: translateX(4px); }
        .btn-primary svg { transition: transform .2s; }

        .hero-stats {
            display: flex;
            justify-content: center;
            gap: 3.5rem;
            margin-top: 4rem;
            padding-top: 2.5rem;
            border-top: 1px solid rgba(255,255,255,.07);
            flex-wrap: wrap;
            animation: fadeUp .6s .45s ease both;
        }
        .stat-num {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 900;
            color: var(--gold);
        }
        .stat-label {
            font-size: .72rem;
            color: var(--soft);
            letter-spacing: .1em;
            text-transform: uppercase;
            margin-top: .2rem;
        }

        /* ===== SECTION BURGERS ===== */
        .section-burgers {
            padding: 5rem 2rem 6rem;
            max-width: 1280px;
            margin: 0 auto;
        }

        .section-eyebrow {
            text-align: center;
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .22em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: .7rem;
        }
        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 5vw, 3rem);
            font-weight: 900;
            text-align: center;
            color: #fff;
            margin-bottom: .6rem;
        }
        .section-sub {
            text-align: center;
            color: var(--soft);
            font-size: .92rem;
            margin-bottom: 3.5rem;
            line-height: 1.7;
        }

        /* Grille responsive */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 1.6rem;
        }

        /* Carte */
        .burger-card {
            background: var(--dark-card);
            border: 1px solid rgba(255,255,255,.07);
            border-radius: 1.25rem;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: transform .3s, border-color .3s, box-shadow .3s;
            animation: fadeUp .55s ease both;
        }
        .burger-card:nth-child(1) { animation-delay: .08s; }
        .burger-card:nth-child(2) { animation-delay: .16s; }
        .burger-card:nth-child(3) { animation-delay: .24s; }
        .burger-card:nth-child(4) { animation-delay: .32s; }
        .burger-card:nth-child(n+5) { animation-delay: .38s; }

        .burger-card:hover {
            transform: translateY(-7px);
            border-color: rgba(234,179,8,.45);
            box-shadow: 0 24px 55px rgba(0,0,0,.45), 0 0 0 1px rgba(234,179,8,.12);
        }

        .card-img {
            position: relative;
            width: 100%;
            padding-top: 62%;
            background: #13151f;
            overflow: hidden;
        }
        .card-img img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .4s ease;
        }
        .burger-card:hover .card-img img { transform: scale(1.07); }

        /* Fallback quand pas d'image */
        .card-img-placeholder {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3.5rem;
        }

        /* Badge stock */
        .stock-badge {
            position: absolute;
            top: .75rem;
            right: .75rem;
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            padding: .28rem .7rem;
            border-radius: 100px;
        }
        .stock-ok      { background: rgba(34,197,94,.15);  color: #4ade80; border: 1px solid rgba(34,197,94,.3); }
        .stock-rupture { background: rgba(239,68,68,.12);  color: #f87171; border: 1px solid rgba(239,68,68,.3); }

        .card-body {
            padding: 1.25rem 1.4rem 1.5rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .card-name {
            font-family: 'Playfair Display', serif;
            font-size: 1.15rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: .45rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .card-desc {
            font-size: .82rem;
            color: var(--soft);
            line-height: 1.65;
            flex: 1;
            margin-bottom: 1.1rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .card-price {
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem;
            font-weight: 900;
            color: var(--gold);
        }
        .card-price small {
            font-family: 'DM Sans', sans-serif;
            font-size: .7rem;
            font-weight: 500;
            color: var(--soft);
            margin-left: .2rem;
        }
        .card-qty {
            font-size: .72rem;
            color: var(--soft);
            background: rgba(255,255,255,.05);
            padding: .25rem .6rem;
            border-radius: 100px;
        }

        /* État vide */
        .empty-state {
            text-align: center;
            padding: 4rem 1rem;
            color: var(--soft);
        }
        .empty-state p { font-size: 1rem; margin-top: .5rem; }

        /* ===== CTA FINAL ===== */
        .cta-band {
            margin: 0 2rem 0;
            padding: 4rem 2rem;
            background: linear-gradient(135deg, #1c1f2e, #13151f);
            border-top: 1px solid rgba(234,179,8,.15);
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .cta-band::before {
            content: '';
            position: absolute;
            bottom: -80px; right: -80px;
            width: 320px; height: 320px;
            background: radial-gradient(circle, rgba(234,179,8,.09) 0%, transparent 70%);
            pointer-events: none;
        }
        .cta-band-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.7rem, 4vw, 2.6rem);
            font-weight: 900;
            color: #fff;
            margin-bottom: .7rem;
        }
        .cta-band-sub {
            color: var(--soft);
            font-size: .95rem;
            margin-bottom: 2rem;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 640px) {
            .hero-stats { gap: 2rem; }
            .cards-grid { grid-template-columns: 1fr 1fr; gap: 1rem; }
            .card-body { padding: 1rem; }
            .card-name { font-size: 1rem; }
        }
        @media (max-width: 380px) {
            .cards-grid { grid-template-columns: 1fr; }
        }
    </style>

    <div class="home-wrapper">

        <section class="hero">
            <div class="hero-inner">
                <div class="hero-badge">Fait maison · Dakar</div>

                <h1 class="hero-title">
                    Goûtez<br><em>l'exception.</em>
                </h1>

                <p class="hero-sub">
                    Des burgers généreux, préparés avec des ingrédients frais,
                    pour une expérience unique à chaque bouchée.
                </p>

                <a href="{{ route('clients.catalogue') }}" class="btn-primary">
                    Voir le catalogue
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>

                <div class="hero-stats">
                    <div>
                        <div class="stat-num">100%</div>
                        <div class="stat-label">Frais</div>
                    </div>
                    <div>
                        <div class="stat-num">{{ $burgers->count() }}+</div>
                        <div class="stat-label">Recettes</div>
                    </div>
                    <div>
                        <div class="stat-num">5★</div>
                        <div class="stat-label">Qualité</div>
                    </div>
                    <div>
                        <div class="stat-num">7j/7</div>
                        <div class="stat-label">Ouvert</div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ===== BURGERS ===== --}}
        <section class="section-burgers">
            <p class="section-eyebrow">Notre sélection</p>
            <h2 class="section-title">Les incontournables</h2>
            <p class="section-sub">Découvrez nos burgers du moment, préparés avec passion.</p>

            @if($burgers->isEmpty())
                <div class="empty-state">
                    <p>Aucun burger disponible pour le moment.</p>
                </div>
            @else
                <div class="cards-grid">
                    @foreach($burgers->take(4) as $burger)
                        <div class="burger-card">

                            <div class="card-img">
                                @if($burger->image)
                                    <img
                                        src="{{ asset('storage/' . $burger->image) }}"
                                        alt="{{ $burger->nom }}"
                                        onerror="this.style.display='none';this.nextElementSibling.style.display='flex';"
                                    >
                                    <div class="card-img-placeholder" style="display:none;">🍔</div>
                                @else
                                    <div class="card-img-placeholder">🍔</div>
                                @endif

                                @if($burger->quantite_stock > 0)
                                    <span class="stock-badge stock-ok">Disponible</span>
                                @else
                                    <span class="stock-badge stock-rupture">Rupture</span>
                                @endif
                            </div>

                            <div class="card-body">
                                <div class="card-name" title="{{ $burger->nom }}">{{ $burger->nom }}</div>
                                <div class="card-desc">
                                    {{ $burger->description ?: 'Un burger savoureux préparé avec des ingrédients frais de qualité.' }}
                                </div>
                                <div class="card-footer">
                                    <div class="card-price">
                                        {{ number_format($burger->prix_unitaire, 0, ',', ' ') }}<small>FCFA</small>
                                    </div>
                                    <div class="card-qty">{{ $burger->quantite_stock }} en stock</div>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            @endif
        </section>

        {{-- ===== CTA ===== --}}
        <div class="cta-band">
            <h2 class="cta-band-title">Prêt à commander ?</h2>
            <p class="cta-band-sub">Explorez notre catalogue complet et composez votre repas idéal.</p>
            <a href="{{ route('clients.catalogue') }}" class="btn-primary" style="display:inline-flex;">
                Accéder au catalogue
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>

    </div>

@endsection
