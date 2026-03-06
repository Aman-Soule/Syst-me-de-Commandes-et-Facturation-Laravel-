@extends('admin.dashboard_template')

@section('dashboard-content')
    <div class="min-h-screen py-8">
        <div class="container mx-auto px-4">

            {{-- En-tête --}}
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Archives</h1>
                <span class="text-sm text-gray-500">Éléments supprimés — restaurables ou à supprimer définitivement</span>
            </div>

            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center justify-between shadow-sm">
                    <span>{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            @endif

            {{-- ── BURGERS ARCHIVÉS ────────────────────────────────────────── --}}
            <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-10">
                <div class="bg-gray-900 px-6 py-4 flex justify-between items-center">
                    <h2 class="text-white font-semibold text-lg">Burgers archivés</h2>
                    <span class="bg-gray-700 text-gray-300 text-xs font-semibold px-3 py-1 rounded-full">
                    {{ $burgerArchives->count() }} élément(s)
                </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Image</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nom</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Prix</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Stock</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Supprimé le</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                        @forelse($burgerArchives as $archive)
                            <tr class="hover:bg-gray-50 transition duration-200">
                                <td class="px-6 py-4">
                                    @if($archive->image)
                                        <img src="{{ asset('storage/' . $archive->image) }}"
                                             alt="{{ $archive->nom }}"
                                             class="h-12 w-12 object-cover rounded-lg">
                                    @else
                                        <div class="h-12 w-12 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400 text-xs">—</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $archive->nom }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ number_format($archive->prix_unitaire, 0, ',', ' ') }} FCFA</td>
                                <td class="px-6 py-4 text-gray-600">{{ $archive->quantite_stock }}</td>
                                <td class="px-6 py-4 text-gray-500 text-sm whitespace-nowrap">{{ $archive->supprime_le->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-2">
                                        {{-- Restaurer --}}
                                        <form method="POST" action="{{ route('archives.burgers.restaurer', $archive->id) }}">
                                            @csrf
                                            <button type="submit"
                                                    class="text-blue-600 hover:text-blue-900 bg-blue-500 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition duration-200 text-xs font-semibold"
                                                    title="Restaurer">
                                                 Restaurer
                                            </button>
                                        </form>
                                        {{-- Supprimer définitivement --}}
                                        <form method="POST" action="{{ route('archives.burgers.supprimer', $archive->id) }}"
                                              onsubmit="return confirm('Supprimer définitivement cette archive ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition duration-200 text-xs font-semibold"
                                                    title="Supprimer définitivement">
                                                 Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <p class="text-lg font-medium">Aucun burger archivé</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ── COMMANDES ARCHIVÉES ─────────────────────────────────────── --}}
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gray-900 px-6 py-4 flex justify-between items-center">
                    <h2 class="text-white font-semibold text-lg">Commandes archivées</h2>
                    <span class="bg-gray-700 text-gray-300 text-xs font-semibold px-3 py-1 rounded-full">
                    {{ $commandeArchives->count() }} élément(s)
                </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Client</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Téléphone</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Burgers</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Supprimé le</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                        @forelse($commandeArchives as $archive)
                            <tr class="hover:bg-gray-50 transition duration-200">
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $archive->nom_client }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $archive->telephone_client }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($archive->burgers_snapshot as $item)
                                            <span class="px-2 py-0.5 bg-gray-100 text-gray-700 text-xs font-medium rounded-full whitespace-nowrap">
                                                {{ $item['nom'] }} × {{ $item['quantite'] }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if($archive->statut == 'en_attente') bg-yellow-100 text-yellow-800
                                        @elseif($archive->statut == 'en_preparation') bg-blue-100 text-blue-800
                                        @elseif($archive->statut == 'prete') bg-green-100 text-green-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        @switch($archive->statut)
                                            @case('en_attente') En attente @break
                                            @case('en_preparation') En préparation @break
                                            @case('prete') Prête @break
                                            @default {{ ucfirst($archive->statut) }}
                                        @endswitch
                                    </span>
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900">{{ number_format($archive->total, 0, ',', ' ') }} FCFA</td>
                                <td class="px-6 py-4 text-gray-500 text-sm whitespace-nowrap">{{ $archive->supprime_le->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-2">
                                        {{-- Restaurer --}}
                                        <form method="POST" action="{{ route('archives.commandes.restaurer', $archive->id) }}">
                                            @csrf
                                            <button type="submit"
                                                    class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition duration-200 text-xs font-semibold">
                                                 Restaurer
                                            </button>
                                        </form>
                                        {{-- Supprimer définitivement --}}
                                        <form method="POST" action="{{ route('archives.commandes.supprimer', $archive->id) }}"
                                              onsubmit="return confirm('Supprimer définitivement cette archive ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition duration-200 text-xs font-semibold">
                                                 Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <p class="text-lg font-medium">Aucune commande archivée</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection
