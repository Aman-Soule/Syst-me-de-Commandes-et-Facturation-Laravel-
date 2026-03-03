@extends('template')

@section('content')

{{--    <style>--}}
{{--        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@400;500;600&display=swap');--}}
{{--    </style>--}}

    <div class="catalogue-wrapper">
        <div class="catalogue-inner">

            <p class="catalogue-eyebrow">Découvrez</p>
            <h1 class="catalogue-title">Notre Catalogue</h1>

            <form method="GET" action="{{ route('clients.catalogue') }}" class="filter-form">

                {{-- Recherche --}}
                <div class="filter-group filter-search">
                    <label>Recherche</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Rechercher un burger...">
                </div>

                {{-- Disponibilité --}}
                <div class="filter-group filter-select">
                    <label>Disponibilité</label>
                    <select name="disponibilite">
                        <option value="">Toutes</option>
                        <option value="disponible" {{ request('disponibilite') == 'disponible' ? 'selected' : '' }}>Disponible</option>
                        <option value="rupture"    {{ request('disponibilite') == 'rupture'    ? 'selected' : '' }}>Rupture</option>
                    </select>
                </div>

                {{-- Prix --}}
                <div class="filter-group filter-select">
                    <label>Prix</label>
                    <select name="prix">
                        <option value="">Trier par prix</option>
                        <option value="asc"  {{ request('prix') == 'asc'  ? 'selected' : '' }}>Croissant</option>
                        <option value="desc" {{ request('prix') == 'desc' ? 'selected' : '' }}>Décroissant</option>
                    </select>
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn-filter">Filtrer</button>
                    @if(request()->hasAny(['search','disponibilite','prix']))
                        <a href="{{ route('clients.catalogue') }}" class="btn-reset">Réinitialiser</a>
                    @endif
                </div>

            </form>

            @if($burgers->isEmpty())
                <div class="empty-state">
                    <svg class="w-12 h-12 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p style="font-size:1rem;font-weight:600;">Aucun burger trouvé.</p>
                    <p style="font-size:.85rem;margin-top:.4rem;">Essayez de modifier vos filtres.</p>
                </div>
            @else
                <div class="burgers-grid">
                    @foreach($burgers as $burger)
                        <div class="burger-card">

                            {{-- Image --}}
                            <div class="card-img-wrap">
                                <img src="{{ asset('storage/' . $burger->image) }}" alt="{{ $burger->nom }}">
                                @if($burger->quantite_stock > 0)
                                    <span class="card-stock-badge badge-ok">Disponible</span>
                                @else
                                    <span class="card-stock-badge badge-rupture">Rupture</span>
                                @endif
                            </div>

                            <div class="card-body">
                                <div class="card-name" title="{{ $burger->nom }}">{{ $burger->nom }}</div>
                                <div class="card-price">
                                    {{ number_format($burger->prix_unitaire, 0, ',', ' ') }}<small>FCFA</small>
                                </div>
                            </div>

                            <div class="card-actions">
                                <button type="button" onclick="openModal({{ $burger->id }})" class="btn-info">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Infos
                                </button>

                                @if($burger->quantite_stock > 0)
                                    <a href="{{ route('commandes.create', $burger->id) }}" class="btn-commander">
                                        Commander
                                    </a>
                                @else
                                    <button type="button" disabled class="btn-indisponible">Indisponible</button>
                                @endif
                            </div>
                        </div>

                        {{-- Boite modal --}}
                        <div id="modal-{{ $burger->id }}"
                             class="burger-modal"
                             onclick="closeModalOnBackdrop(event, {{ $burger->id }})">

                            <div class="modal-backdrop"></div>

                            <div class="modal-box">
                                <div class="modal-header">
                                    <img src="{{ asset('storage/' . $burger->image) }}" alt="{{ $burger->nom }}">
                                    <div class="modal-header-info">
                                        <div class="modal-name">{{ $burger->nom }}</div>
                                        <div class="modal-price">{{ number_format($burger->prix_unitaire, 0, ',', ' ') }} FCFA</div>
                                    </div>
                                    <button onclick="closeModal({{ $burger->id }})" class="modal-close">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>

                                <div class="modal-body">
                                    <p class="modal-desc">{{ $burger->description ?? 'Aucune description disponible.' }}</p>

                                    <div class="modal-stock-row">
                                        <span class="modal-stock-label">Stock disponible</span>
                                        @if($burger->quantite_stock > 0)
                                            <span class="card-stock-badge badge-ok" style="position:static;">{{ $burger->quantite_stock }} unités</span>
                                        @else
                                            <span class="card-stock-badge badge-rupture" style="position:static;">Rupture</span>
                                        @endif
                                    </div>

                                    <div class="modal-actions">
                                        <button onclick="closeModal({{ $burger->id }})" class="btn-info" style="flex:1;justify-content:center;">
                                            Fermer
                                        </button>
                                        @if($burger->quantite_stock > 0)
                                            <a href="{{ route('commandes.create', $burger->id) }}" class="btn-commander">Commander</a>
                                        @else
                                            <button disabled class="btn-indisponible">Indisponible</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endforeach
                </div>
            @endif

        </div>
    </div>

    <script>
        function openModal(id) {
            const modal = document.getElementById('modal-' + id);
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }
        function closeModal(id) {
            const modal = document.getElementById('modal-' + id);
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }
        function closeModalOnBackdrop(event, id) {
            if (event.target === document.getElementById('modal-' + id)) {
                closeModal(id);
            }
        }
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('.burger-modal.flex').forEach(function(modal) {
                    modal.classList.remove('flex');
                });
                document.body.style.overflow = '';
            }
        });
    </script>

@endsection
