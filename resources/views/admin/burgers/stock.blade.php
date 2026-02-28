@extends('admin/dashboard_template')

@section('dashboard-content')
    <div class="bg-gray-100 min-h-screen py-10">
        <div class="container mx-auto px-6">

            {{-- Header avec bouton ajout --}}
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-900">Gestion des Burgers</h1>
                @if(session('success'))
                    <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif
                <a href="{{ route('burgers.create') }}"
                   class="bg-gray-900 text-white px-4 py-2 rounded hover:bg-gray-900 transition">
                    + Ajouter un Burger
                </a>
            </div>

            {{-- Table des burgers --}}
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Image</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Prix</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date d'ajout</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dernière mise à jour</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                    @forelse($burgers as $burger)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-3">
                                <img src="{{ asset('storage/' . $burger->image) }}"
                                     alt="{{ $burger->nom }}"
                                     class="w-16 h-16 object-cover rounded-lg border border-gray-200">
                            </td>
                            <td class="px-6 py-3 font-medium text-gray-900">{{ $burger->nom }}</td>
                            <td class="px-6 py-3 font-semibold text-gray-900">{{ number_format($burger->prix_unitaire, 0, ',', ' ') }} FCFA</td>
                            <td class="px-6 py-3">
                                @if($burger->quantite_stock > 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                {{ $burger->quantite_stock }}
                            </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                Rupture
                            </span>
                                @endif
                            </td>
                            <td class="px-6 py-3 text-gray-500 text-sm">
                                {{ \Carbon\Carbon::parse($burger->created_at)->format('d/m/Y à H:i') }}
                            </td>
                            <td class="px-6 py-3 text-gray-500 text-sm">
                                {{ \Carbon\Carbon::parse($burger->updated_at)->format('d/m/Y à H:i') }}
                            </td>
                            <td class="px-6 py-3">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('burgers.edit', $burger->id) }}"
                                       class="inline-flex items-center space-x-1.5 bg-gray-900 hover:bg-gray-700 text-white text-xs font-medium px-3 py-1.5 rounded-lg transition">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        <span>Éditer</span>
                                    </a>
                                    <form action="{{ route('burgers.destroy', $burger->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center space-x-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-medium px-3 py-1.5 rounded-lg transition"
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce burger ?')">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            <span>Supprimer</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">
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
