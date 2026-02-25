@extends('template')

@section('content')
    <div class="bg-gray-100 min-h-screen py-10">
        <div class="container mx-auto px-6 max-w-lg">
            <h1 class="text-3xl font-bold text-center text-gray-900 mb-8">
                Passer une commande
            </h1>

            <!-- Carte du burger choisi -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                <img src="{{ asset('storage/' . $burger->image) }}"
                     alt="{{ $burger->nom }}"
                     class="w-full h-56 object-cover">

                <div class="p-5">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-2">{{ $burger->nom }}</h2>
                    <p class="text-gray-700 mb-3">{{ $burger->description }}</p>
                    <p class="text-lg font-bold text-gray-800">{{ $burger->prix_unitaire }} FCFA</p>

                    @if($burger->quantite_stock > 0)
                        <span class="inline-block mt-2 px-3 py-1 text-sm bg-green-100 text-green-700 rounded-full">
                        Disponible
                    </span>
                    @else
                        <span class="inline-block mt-2 px-3 py-1 text-sm bg-red-100 text-red-700 rounded-full">
                        Rupture de stock
                    </span>
                    @endif
                </div>
            </div>

            <!-- Formulaire de commande -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <form method="POST" action="{{ route('commandes.store') }}">
                    @csrf
                    <input type="hidden" name="burgers[0][id]" value="{{ $burger->id }}">

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">Quantité</label>
                        <input type="number" name="burgers[0][quantite]" value="1" min="1"
                               class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">Nom du client</label>
                        <input type="text" name="nom_client" required
                               class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">Téléphone</label>
                        <input type="text" name="telephone_client" required
                               class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <button type="submit"
                            class="w-full bg-blue-900 text-white px-4 py-2 rounded hover:bg-blue-800 transition">
                        Valider la commande
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

