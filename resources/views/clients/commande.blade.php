@extends('template')

@section('content')

    <div class="commande-wrapper">
        <div class="commande-inner">
            <p class="commande-eyebrow">Votre sélection</p>
            <h1 class="commande-title">Passer une commande</h1>

            <div class="burger-preview">
                <img src="{{ asset('storage/' . $burger->image) }}" alt="{{ $burger->nom }}" class="burger-preview-img">
                <div class="burger-preview-info">
                    <div class="burger-preview-name">{{ $burger->nom }}</div>
                    <div class="burger-preview-desc">{{ $burger->description }}</div>
                    <div class="burger-preview-price">
                        {{ number_format($burger->prix_unitaire, 0, ',', ' ') }}<small>FCFA</small>
                    </div>
                    @if($burger->quantite_stock > 0)
                        <span class="stock-badge badge-ok">Disponible</span>
                    @else
                        <span class="stock-badge badge-rupture">Rupture de stock</span>
                    @endif
                </div>
            </div>

            <form method="POST" action="{{ route('commandes.store') }}" novalidate>
                @csrf
                <input type="hidden" name="burgers[0][id]" value="{{ $burger->id }}">
                <div class="commande-form">

                    <p class="form-section-title">Détails de la commande</p>
                    <div class="form-group">
                        <label for="quantite">Quantité</label>
                        <input type="number" id="quantite" name="burgers[0][quantite]"
                               value="{{ old('burgers.0.quantite', 1) }}" min="1" placeholder="Ex : 2"
                               class="{{ $errors->has('burgers.0.quantite') ? 'is-invalid' : '' }}">
                        @error('burgers.0.quantite')
                        <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <hr class="form-divider">

                    <p class="form-section-title">Vos informations</p>
                    <div class="form-group">
                        <label for="nom_client">Nom du client</label>
                        <input type="text" id="nom_client" name="nom_client"
                               value="{{ old('nom_client') }}" placeholder="Ex : Moussa Diallo"
                               class="{{ $errors->has('nom_client') ? 'is-invalid' : '' }}">
                        @error('nom_client')
                        <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="telephone_client">Téléphone</label>
                        <input type="text" id="telephone_client" name="telephone_client"
                               value="{{ old('telephone_client') }}" placeholder="Ex : +221 77 000 00 00"
                               class="{{ $errors->has('telephone_client') ? 'is-invalid' : '' }}">
                        @error('telephone_client')
                        <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn-submit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        Valider la commande
                    </button>

                </div>
            </form>
        </div>
    </div>
@endsection
