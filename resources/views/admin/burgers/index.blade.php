@extends('template')

@section('content')
    <div class="bg-gray-100 min-h-screen py-10">
        <div class="container mx-auto px-6">

            {{-- Header avec bouton ajout --}}
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-blue-900">Gestion des Burgers</h1>
                <a href="{{ route('burgers.create') }}"
                   class="bg-blue-900 text-white px-4 py-2 rounded hover:bg-blue-800 transition">
                    + Ajouter un Burger
                </a>
            </div>

            {{-- Table des burgers --}}
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <table class="min-w-full border-collapse">
                    <thead class="bg-blue-900 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left">Image</th>
                        <th class="px-6 py-3 text-left">Nom</th>
                        <th class="px-6 py-3 text-left">Prix</th>
                        <th class="px-6 py-3 text-left">Stock</th>
                        <th class="px-6 py-3 text-left">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($burgers as $burger)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-3">
                                <img src="{{ asset('storage/' . $burger->image) }}"
                                     alt="{{ $burger->nom }}"
                                     class="w-16 h-16 object-cover rounded">
                            </td>
                            <td class="px-6 py-3">{{ $burger->nom }}</td>
                            <td class="px-6 py-3">{{ $burger->prix_unitaire }} FCFA</td>
                            <td class="px-6 py-3">
                                @if($burger->quantite_stock > 0)
                                    <span class="text-green-700 font-semibold">{{ $burger->quantite_stock }}</span>
                                @else
                                    <span class="text-red-700 font-semibold">Rupture</span>
                                @endif
                            </td>
                            <td class="px-6 py-3 flex space-x-2">
                                <a href="{{ route('burgers.edit', $burger->id) }}"
                                   class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 transition">
                                    Éditer
                                </a>
                                <form action="{{ route('burgers.destroy', $burger->id) }}" method="POST" onsubmit="return confirm('Supprimer ce burger ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition">
                                        Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                Aucun burger disponible.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
