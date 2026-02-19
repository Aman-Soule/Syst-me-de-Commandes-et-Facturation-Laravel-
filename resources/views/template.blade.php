<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISI BURGER</title>
    @vite('resources/css/app.css') {{-- Tailwind via Vite --}}
</head>
<body class="bg-gray-100 text-gray-900">

{{-- Header --}}
<header class="bg-blue-900 text-white shadow-md">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold">ISI BURGER</h1>
        <nav class="space-x-4">
            <a href="{{ url('/') }}" class="hover:text-gray-200">Accueil</a>
            <a href="#" class="hover:text-gray-200">Catalogue</a>
            <a href="#" class="hover:text-gray-200">Commandes</a>
            <a href="{{route('burgers.index')}}" class="hover:text-gray-200">Gestion</a>
        </nav>
    </div>
</header>

{{-- Contenu principal --}}
<main class="container mx-auto px-6 py-8">
    @yield('content')
</main>

{{-- Footer --}}
<footer class="bg-blue-900 text-white mt-10">
    <div class="container mx-auto px-6 py-4 text-center">
        <p>&copy; {{ date('Y') }} ISI BURGER - AMAN SOULE - Tous droits réservés</p>
    </div>
</footer>

</body>
</html>
