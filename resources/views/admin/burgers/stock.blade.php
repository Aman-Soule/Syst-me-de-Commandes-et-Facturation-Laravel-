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
                            <td class="px-6 py-4">
                                <div class="flex space-x-2">
                                    <a href="{{ route('burgers.edit', $burger->id) }}"
                                       class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 p-2 rounded-lg transition duration-200"
                                       title="Modifier">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('burgers.destroy', $burger->id) }}" method="POST"
                                          onsubmit="return confirm('Voulez-vous vraiment supprimer ce Burger ?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition duration-200"
                                                title="Supprimer">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
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
