<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - ISI BURGER</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-900 flex min-h-screen">

<!-- Barre latérale -->
<aside class="w-64 bg-gray-900 text-white flex flex-col">
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
        <a href="#"
           class="block px-3 py-2 rounded hover:bg-gray-800 transition">
            Clients
        </a>
        <a href="#"
           class="block px-3 py-2 rounded hover:bg-gray-800 transition">
            Paramètres
        </a>
    </nav>
</aside>

<!-- Contenu principal -->
<main class="flex-1 p-8">
    @yield('dashboard-content')
</main>

</body>
</html>
