<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - ISI BURGER</title>
    @vite('resources/css/app.css')
    <style>
        /* Pour s'assurer que la sidebar reste fixe */
        .fixed-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            overflow-y: auto;
        }

        .main-content {
            margin-left: 12rem; /* 64 = 16rem */
            width: calc(100% - 16rem);
            min-height: 100vh;
            overflow-y: auto;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-900">

<!-- Barre latérale fixe -->
<aside class="fixed-sidebar w-64 bg-gray-900 text-white flex flex-col">
    <div class="p-6 text-center border-b border-gray-800">
        <h2 class="text-xl font-bold">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        </h2>
    </div>
    <nav class="flex-1 px-4 py-6 space-y-2">
        <a href="{{ route('burgers.index') }}"
           class="block px-3 py-2 rounded hover:bg-gray-800 transition">
            Stock
        </a>
        <a href="{{ route('commandes.liste') }}"
           class="block px-3 py-2 rounded hover:bg-gray-800 transition">
            Commandes
        </a>
        <a href="{{ route('paiements.liste') }}"
           class="block px-3 py-2 rounded hover:bg-gray-800 transition">
            Paiements
        </a>
        <a href="#"
           class="block px-3 py-2 rounded hover:bg-gray-800 transition">
            Paramètres
        </a>
    </nav>
</aside>

<!-- Contenu principal avec défilement -->
<main class="main-content">
    @yield('dashboard-content')
</main>

</body>
</html>
