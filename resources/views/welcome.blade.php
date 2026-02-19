@extends('template')

@section('content')
    <div class="bg-gray-100 min-h-screen py-10">
        <div class="container mx-auto px-6">
            <h1 class="text-4xl font-bold text-center text-blue-900 mb-10">
                🍔 Bienvenue chez ISI BURGER
            </h1>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($burgers as $burger)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                        {{-- Image depuis storage --}}
                        <img src="{{ asset('storage/' . $burger->image) }}"
                             alt="{{ $burger->nom }}"
                             class="w-full h-48 object-cover">

                        <div class="p-5">
                            <h2 class="text-xl font-semibold text-blue-900 mb-2">
                                {{ $burger->nom }}
                            </h2>
                            <p class="text-gray-700 mb-3">{{ $burger->description }}</p>
                            <p class="text-lg font-bold text-blue-800">
                                {{ $burger->prix_unitaire }} FCFA
                            </p>

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

                        <div class="p-4 border-t text-center">
                            @if($burger->quantite_stock > 0)
                                <a href="#"
                                   class="bg-blue-900 text-white px-4 py-2 rounded hover:bg-blue-800 transition">
                                    Commander
                                </a>
                            @else
                                <button class="bg-gray-300 text-gray-600 px-4 py-2 rounded cursor-not-allowed">
                                    Indisponible
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
