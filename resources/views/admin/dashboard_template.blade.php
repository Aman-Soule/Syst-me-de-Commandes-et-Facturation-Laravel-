<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - ISI BURGER</title>
    @vite('resources/css/app.css')
    <style>
        /* ===== LAYOUT DE BASE ===== */
        body {
            margin: 0;
            background: #f3f4f6;
        }

        /* ===== SIDEBAR ===== */
        #sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 16rem;           /* 256px */
            background: #111827;   /* gray-900 */
            color: #fff;
            display: flex;
            flex-direction: column;
            z-index: 200;
            transition: transform 0.3s ease;
            overflow-y: auto;
        }

        /* Sur desktop : sidebar toujours visible */
        @media (min-width: 768px) {
            #sidebar {
                transform: translateX(0) !important;
            }
            #sidebar-backdrop {
                display: none !important;
            }
        }

        /* Sur mobile : sidebar cachée par défaut, revealed via classe .open */
        @media (max-width: 767px) {
            #sidebar {
                transform: translateX(-100%);
            }
            #sidebar.open {
                transform: translateX(0);
            }
        }

        /* ===== BACKDROP (mobile seulement) ===== */
        #sidebar-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.55);
            z-index: 199;
            backdrop-filter: blur(2px);
        }
        #sidebar-backdrop.open {
            display: block;
        }

        /* ===== TOPBAR MOBILE ===== */
        #mobile-topbar {
            display: none;
            position: sticky;
            top: 0;
            z-index: 100;
            background: #111827;
            color: #fff;
            padding: 0.9rem 1.25rem;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #1f2937;
        }
        @media (max-width: 767px) {
            #mobile-topbar {
                display: flex;
            }
        }

        /* ===== CONTENU PRINCIPAL ===== */
        #main-content {
            margin-left: 16rem;   /* correspond à la largeur de la sidebar */
            min-height: 100vh;
            padding: 1.5rem;
        }

        /* Sur mobile : plus de marge, contenu pleine largeur */
        @media (max-width: 767px) {
            #main-content {
                margin-left: 0;
                padding: 1rem;
            }
        }

        /* ===== LIENS SIDEBAR ===== */
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.6rem 0.9rem;
            border-radius: 0.5rem;
            color: #d1d5db;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: background 0.18s, color 0.18s;
        }
        .sidebar-link:hover,
        .sidebar-link.active {
            background: #1f2937;
            color: #fbbf24;
        }
        .sidebar-link svg {
            flex-shrink: 0;
            width: 1.1rem;
            height: 1.1rem;
        }
    </style>
</head>
<body>

<div id="mobile-topbar">
    <div class="flex items-center gap-3">
        <img src="{{ asset('storage/logos/burger-logo.png') }}" style="height:36px;width:auto;" alt="Logo">
        <span style="font-weight:800;font-size:1.1rem;letter-spacing:.03em;">ISI BURGER</span>
    </div>
    <button onclick="openSidebar()" style="background:none;border:none;color:#fff;cursor:pointer;display:flex;align-items:center;gap:.4rem;font-size:.85rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;">
        MENU
        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>
</div>

<div id="sidebar-backdrop" onclick="closeSidebar()"></div>

<aside id="sidebar">

    {{-- Logo --}}
    <div style="padding:1.5rem 1.25rem 1.25rem;border-bottom:1px solid #1f2937;display:flex;align-items:center;justify-content:space-between;">
        <a href="{{ route('admin.dashboard') }}" style="display:flex;align-items:center;gap:.6rem;text-decoration:none;">
            <img src="{{ asset('storage/logos/burger-logo.png') }}" style="height:40px;width:auto;" alt="Logo">
            <span style="color:#fff;font-weight:800;font-size:1.05rem;letter-spacing:.03em;">ISI BURGER</span>
        </a>
        {{-- Bouton fermer (mobile seulement) --}}
        <button onclick="closeSidebar()" style="background:none;border:none;color:#9ca3af;cursor:pointer;font-size:1.6rem;line-height:1;padding:0;" class="md-hidden">
            &times;
        </button>
    </div>

    {{-- Label section --}}
    <div style="padding:.9rem 1.25rem .3rem;font-size:.65rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:#6b7280;">
        Navigation
    </div>

    {{-- Navigation --}}
    <nav style="padding:.25rem .75rem;display:flex;flex-direction:column;gap:.2rem;flex:1;">

        <a href="{{ route('admin.dashboard') }}" class="sidebar-link">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Tableau de bord
        </a>

        <a href="{{ route('burgers.index') }}" class="sidebar-link">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
            </svg>
            Stock Burgers
        </a>

        <a href="{{ route('commandes.liste') }}" class="sidebar-link">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
            Commandes
        </a>

        <a href="{{ route('paiements.liste') }}" class="sidebar-link">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            Paiements
        </a>

        <a href="#" class="sidebar-link">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Paramètres
        </a>
        <a href="{{ route('welcome') }}" class="sidebar-link">
{{--            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>--}}
{{--                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>--}}
{{--            </svg>--}}
            Accueil
        </a>
    </nav>

    {{-- Footer sidebar --}}
    <div style="padding:1rem 1.25rem;border-top:1px solid #1f2937;font-size:.75rem;color:#6b7280;text-align:center;">
        ISI BURGER &copy; {{ date('Y') }}
    </div>

</aside>

{{--Menu principale--}}
<main id="main-content">
    @yield('dashboard-content')
</main>

{{-- SCRIPT SIDEBAR MOBILE --}}
<script>
    function openSidebar() {
        document.getElementById('sidebar').classList.add('open');
        document.getElementById('sidebar-backdrop').classList.add('open');
        document.body.style.overflow = 'hidden';
    }
    function closeSidebar() {
        document.getElementById('sidebar').classList.remove('open');
        document.getElementById('sidebar-backdrop').classList.remove('open');
        document.body.style.overflow = '';
    }
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeSidebar();
    });

    // Marquer le lien actif selon l'URL courante
    document.addEventListener('DOMContentLoaded', function() {
        const links = document.querySelectorAll('.sidebar-link');
        links.forEach(link => {
            if (link.href && window.location.href.startsWith(link.href) && link.href !== window.location.origin + '/') {
                link.classList.add('active');
            } else if (link.href === window.location.href) {
                link.classList.add('active');
            }
        });
    });
</script>

</body>
</html>
