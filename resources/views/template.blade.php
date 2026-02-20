<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISI BURGER</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-900 flex flex-col min-h-screen">

{{-- Header avec bleu très foncé (gray-900) --}}
<header class="bg-gray-900 text-white shadow-lg border-b border-gray-800">
    <div class="container mx-auto px-6 py-4">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <img src="{{ asset('storage/logos/burger-logo.png') }}"class="img-fluid" style="height: 60px; width: auto;">
                <h1 class="text-3xl font-extrabold tracking-tight text-white">ISI BURGER</h1>
            </div>
            <nav class="space-x-6">
                <a href="{{ url('/') }}" class="text-gray-300 hover:text-yellow-500 transition duration-300 font-medium">Accueil</a>
                <a href="{{route('clients.catalogue')}}" class="text-gray-300 hover:text-yellow-500 transition duration-300 font-medium">Catalogue</a>
                <a href="#" class="text-gray-300 hover:text-yellow-500 transition duration-300 font-medium">Commandes</a>
                <a href="{{route('burgers.index')}}" class="text-gray-300 hover:text-yellow-500 transition duration-300 font-medium">Gestion</a>
            </nav>
        </div>
    </div>
</header>

<main class="container mx-auto px-6 py-8 flex-grow">
    @yield('content')
</main>

{{-- Footer --}}
<footer class="bg-gray-900 text-white mt-auto border-t border-gray-800">
    {{-- Section principale --}}
    <div class="container mx-auto px-6 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

            {{-- Colonne 1 : Logo et description --}}
            <div class="space-y-4">
                <div class="flex items-center space-x-2">
                    <img src="{{ asset('storage/logos/burger-logo.png') }}"class="img-fluid" style="height: 60px; width: auto;">
                    <h2 class="text-2xl font-bold text-white">ISI BURGER</h2>
                </div>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Découvrez les meilleurs burgers de la ville, préparés avec des ingrédients frais et de qualité.
                    Une expérience gustative unique à chaque bouchée.
                </p>
                <div class="flex space-x-4 pt-2">
                    <a href="#" class="text-gray-500 hover:text-yellow-500 transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-yellow-500 transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.336 3.608 1.311.975.975 1.249 2.242 1.311 3.608.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.062 1.366-.336 2.633-1.311 3.608-.975.975-2.242 1.249-3.608 1.311-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.366-.062-2.633-.336-3.608-1.311-.975-.975-1.249-2.242-1.311-3.608-.058-1.266-.07-1.646-.07-4.85s.012-3.584.07-4.85c.062-1.366.336-2.633 1.311-3.608.975-.975 2.242-1.249 3.608-1.311 1.266-.058 1.646-.07 4.85-.07zm0-2.163c-3.259 0-3.667.014-4.947.072-1.427.064-2.799.39-3.899 1.49-1.09 1.09-1.416 2.462-1.48 3.889-.058 1.28-.072 1.688-.072 4.947s.014 3.667.072 4.947c.064 1.427.39 2.799 1.49 3.899 1.09 1.09 2.462 1.416 3.889 1.48 1.28.058 1.688.072 4.947.072s3.667-.014 4.947-.072c1.427-.064 2.799-.39 3.899-1.49 1.09-1.09 1.416-2.462 1.48-3.889.058-1.28.072-1.688.072-4.947s-.014-3.667-.072-4.947c-.064-1.427-.39-2.799-1.49-3.899-1.09-1.09-2.462-1.416-3.889-1.48-1.28-.058-1.688-.072-4.947-.072z"/><path d="M12 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zm0 10.162a4 4 0 110-8 4 4 0 010 8z"/><circle cx="18.406" cy="5.594" r="1.44"/></svg>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-yellow-500 transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.937 4.937 0 004.604 3.417 9.868 9.868 0 01-6.102 2.104c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 0021.775-4.758 13.94 13.94 0 001.543-6.325c0-.21-.005-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                    </a>
                </div>
            </div>

            {{-- Colonne 2 : Horaires --}}
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-yellow-500 uppercase tracking-wider text-sm">Horaires</h3>
                <ul class="space-y-3 text-gray-400 text-sm">
                    <li class="flex justify-between border-b border-gray-800 pb-2">
                        <span>Lundi - Jeudi</span>
                        <span class="font-medium text-white">11h - 23h</span>
                    </li>
                    <li class="flex justify-between border-b border-gray-800 pb-2">
                        <span>Vendredi - Samedi</span>
                        <span class="font-medium text-white">11h - 00h</span>
                    </li>
                    <li class="flex justify-between border-b border-gray-800 pb-2">
                        <span>Dimanche</span>
                        <span class="font-medium text-white">12h - 22h</span>
                    </li>
                </ul>
                <p class="text-gray-600 text-xs pt-2">
                    <span class="text-yellow-500 font-medium">⟡</span> Service continu
                </p>
            </div>

            {{-- Colonne 3 : Contact --}}
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-yellow-500 uppercase tracking-wider text-sm">Contact</h3>
                <div class="space-y-4 text-gray-400 text-sm">
                    <div class="flex items-start space-x-3">
                        <svg class="w-4 h-4 text-yellow-500 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="leading-relaxed">Avenue Cheikh Anta Diop<br>75000 Dakar</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <svg class="w-4 h-4 text-yellow-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <span>+221 78 753 76 88</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <svg class="w-4 h-4 text-yellow-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span>burgur@isi.com</span>
                    </div>
                </div>
            </div>

            {{-- Colonne 4 : Liens --}}
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-yellow-500 uppercase tracking-wider text-sm">Infos</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="text-gray-400 hover:text-yellow-500 transition block py-1">Mentions légales</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-yellow-500 transition block py-1">Politique de confidentialité</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-yellow-500 transition block py-1">CGV</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-yellow-500 transition block py-1">Plan du site</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-yellow-500 transition block py-1">Recrutement</a></li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Barre de copyright --}}
    <div class="bg-gray-950 border-t border-gray-800">
        <div class="container mx-auto px-6 py-4">
            <div class="flex flex-col md:flex-row justify-between items-center text-xs text-gray-600">
                <p>&copy; {{ date('Y') }} ISI BURGER - AMAN SOULE - Tous droits réservés</p>
                <p class="mt-2 md:mt-0 flex items-center">
                    <span class="mr-1">Développé avec ISI</span>
                    <span class="ml-1">par Aman Soule</span>
                </p>
            </div>
        </div>
    </div>
</footer>

{{-- Style pour le footer collé --}}
<style>
    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }
    main {
        flex: 1 0 auto;
    }
    footer {
        flex-shrink: 0;
    }
    .bg-gray-950 {
        background-color: #0a0c10;
    }
</style>

</body>
</html>
