@extends('template')

@section('content')
    <div class="bg-gray-100 min-h-screen py-10">
        <div class="container mx-auto px-6">

            <h1 class="text-4xl font-bold text-center text-gray-900 mb-10">Notre Catalogue</h1>

            <form method="GET" action="{{ route('clients.catalogue') }}"
                  class="bg-white rounded-xl shadow-sm p-5 mb-10">
                <div class="flex flex-col md:flex-row gap-4 items-end">

                    <div class="flex flex-col gap-1 flex-1">
                        <label class="text-xs font-medium text-gray-500 uppercase tracking-wide">Recherche</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Rechercher un burger..."
                               class="px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-300 text-sm w-full">
                    </div>

                    <div class="flex flex-col gap-1 w-full md:w-32">
                        <label class="text-xs font-medium text-gray-500 uppercase tracking-wide">Disponibilité</label>
                        <select name="disponibilite"
                                class="px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-300 text-sm bg-white">
                            <option value="">Toutes</option>
                            <option value="disponible" {{ request('disponibilite') == 'disponible' ? 'selected' : '' }}>Disponible</option>
                            <option value="rupture"    {{ request('disponibilite') == 'rupture'    ? 'selected' : '' }}>Rupture de stock</option>
                        </select>
                    </div>

                    <div class="flex flex-col gap-1 w-full md:w-32">
                        <label class="text-xs font-medium text-gray-500 uppercase tracking-wide">Prix</label>
                        <select name="prix"
                                class="px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-300 text-sm bg-white">
                            <option value="">Trier par prix</option>
                            <option value="asc"  {{ request('prix') == 'asc'  ? 'selected' : '' }}>Prix croissant</option>
                            <option value="desc" {{ request('prix') == 'desc' ? 'selected' : '' }}>Prix décroissant</option>
                        </select>
                    </div>

                    <div class="flex gap-2 w-full md:w-auto">
                        <button type="submit"
                                class="flex-1 md:flex-none bg-gray-900 text-white px-6 py-2.5 rounded-lg hover:bg-gray-700 transition text-sm font-medium">
                            Filtrer
                        </button>
                        @if(request()->hasAny(['search','disponibilite','prix']))
                            <a href="{{ route('clients.catalogue') }}"
                               class="flex-1 md:flex-none text-center bg-gray-100 text-gray-600 px-4 py-2.5 rounded-lg hover:bg-gray-200 transition text-sm font-medium border border-gray-200">
                                Réinitialiser
                            </a>
                        @endif
                    </div>
                </div>
            </form>

            {{-- ══════════════════════════════════════════
                 GRILLE BURGERS
            ══════════════════════════════════════════ --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($burgers as $burger)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition flex flex-col">

                        <img src="{{ asset('storage/' . $burger->image) }}"
                             alt="{{ $burger->nom }}"
                             class="w-full h-48 object-cover">

                        <div class="p-5 flex-1">
                            <h2 class="text-xl font-semibold text-gray-900 mb-1">{{ $burger->nom }}</h2>
{{--                            <p class="text-gray-500 text-sm mb-3 line-clamp-2">{{ $burger->description }}</p>--}}
                            <p class="text-lg font-bold text-gray-800">{{ number_format($burger->prix_unitaire, 0, ',', ' ') }} FCFA</p>

                            @if($burger->quantite_stock > 0)
                                <span class="inline-block mt-2 px-3 py-1 text-xs bg-green-100 text-green-700 rounded-full font-medium">
                            Disponible
                        </span>
                            @else
                                <span class="inline-block mt-2 px-3 py-1 text-xs bg-red-100 text-red-600 rounded-full font-medium">
                            Rupture de stock
                        </span>
                            @endif
                        </div>

                        {{-- Boutons --}}
                        <div class="p-4 border-t flex items-center gap-2">

                            {{-- Bouton Infos --}}
                            <button type="button"
                                    onclick="openModal({{ $burger->id }})"
                                    class="flex items-center gap-1.5 border border-gray-200 text-gray-600 px-3 py-2 rounded-lg hover:bg-gray-50 transition text-sm font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Infos
                            </button>

                            {{-- Bouton Commander / Indisponible --}}
                            @if($burger->quantite_stock > 0)
                                <a href="{{ route('commandes.create', $burger->id) }}"
                                   class="flex-1 text-center bg-gray-900 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition text-sm font-medium">
                                    Commander
                                </a>
                            @else
                                <button type="button" disabled
                                        class="flex-1 bg-gray-100 text-gray-400 px-4 py-2 rounded-lg cursor-not-allowed text-sm font-medium">
                                    Indisponible
                                </button>
                            @endif
                        </div>
                    </div>

                    {{-- ── Modal Infos pour ce burger ─────────────────── --}}
                    <div id="modal-{{ $burger->id }}"
                         class="fixed inset-0 z-50 hidden items-center justify-center p-4"
                         onclick="closeModalOnBackdrop(event, {{ $burger->id }})">

                        {{-- Fond sombre --}}
                        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>

                        {{-- Contenu --}}
                        <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-sm overflow-hidden animate-fade-in">

                            {{-- Header : image miniature + titre + fermer --}}
                            <div class="flex items-center gap-4 p-4 border-b border-gray-100">
                                <img src="{{ asset('storage/' . $burger->image) }}"
                                     alt="{{ $burger->nom }}"
                                     class="w-16 h-16 object-cover rounded-xl shrink-0">
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-base font-bold text-gray-900 truncate">{{ $burger->nom }}</h3>
                                    <p class="text-sm font-semibold text-gray-700 mt-0.5">{{ number_format($burger->prix_unitaire, 0, ',', ' ') }} FCFA</p>
                                </div>
                                <button onclick="closeModal({{ $burger->id }})"
                                        class="shrink-0 text-gray-400 hover:text-gray-700 hover:bg-gray-100 rounded-full p-1.5 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>

                            {{-- Corps --}}
                            <div class="p-4">

                                {{-- Description --}}
                                <p class="text-gray-500 text-sm leading-relaxed mb-4">
                                    {{ $burger->description ?? 'Aucune description disponible.' }}
                                </p>

                                {{-- Badge stock --}}
                                <div class="flex items-center justify-between mb-4 py-2 border-t border-b border-gray-50">
                                    <span class="text-xs text-gray-400 uppercase tracking-wide">Stock disponible</span>
                                    @if($burger->quantite_stock > 0)
                                        <span class="text-xs font-semibold text-green-700 bg-green-100 px-2.5 py-1 rounded-full">
                                    {{ $burger->quantite_stock }} unités
                                </span>
                                    @else
                                        <span class="text-xs font-semibold text-red-600 bg-red-100 px-2.5 py-1 rounded-full">
                                    Rupture
                                </span>
                                    @endif
                                </div>

                                {{-- Actions --}}
                                <div class="flex gap-2">
                                    <button onclick="closeModal({{ $burger->id }})"
                                            class="flex-1 border border-gray-200 text-gray-600 px-3 py-2 rounded-lg hover:bg-gray-50 transition text-sm font-medium">
                                        Fermer
                                    </button>
                                    @if($burger->quantite_stock > 0)
                                        <a href="{{ route('commandes.create', $burger->id) }}"
                                           class="flex-1 text-center bg-gray-900 text-white px-3 py-2 rounded-lg hover:bg-gray-700 transition text-sm font-medium">
                                            Commander
                                        </a>
                                    @else
                                        <button disabled
                                                class="flex-1 bg-gray-100 text-gray-400 px-3 py-2 rounded-lg cursor-not-allowed text-sm font-medium">
                                            Indisponible
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- ── Fin modal ───────────────────────────────────── --}}

                @endforeach
            </div>

            @if($burgers->isEmpty())
                <div class="text-center py-20 text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-3 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-lg font-medium">Aucun burger trouvé.</p>
                    <p class="text-sm mt-1">Essayez de modifier vos filtres.</p>
                </div>
            @endif

        </div>
    </div>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        @keyframes fade-in {
            from { opacity: 0; transform: scale(0.95); }
            to   { opacity: 1; transform: scale(1); }
        }
        .animate-fade-in { animation: fade-in 0.2s ease-out; }
    </style>

    <script>
        function openModal(id) {
            const modal = document.getElementById('modal-' + id);
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(id) {
            const modal = document.getElementById('modal-' + id);
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }

        function closeModalOnBackdrop(event, id) {
            // Ferme uniquement si on clique sur le fond, pas sur la card
            if (event.target === document.getElementById('modal-' + id)) {
                closeModal(id);
            }
        }

        // Fermeture
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('[id^="modal-"]').forEach(function(modal) {
                    if (!modal.classList.contains('hidden')) {
                        const id = modal.id.replace('modal-', '');
                        closeModal(id);
                    }
                });
            }
        });
    </script>
@endsection
