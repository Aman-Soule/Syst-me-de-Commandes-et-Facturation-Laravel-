@extends('admin/dashboard_template')

@section('dashboard-content')
    <div class="space-y-6">

        <!-- En-tête -->
        <div class="bg-white rounded-xl shadow-sm p-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Modifier la commande #{{ $commande->id }}</h1>
                <p class="text-gray-500 mt-1">Mise à jour du statut et suivi de la commande</p>
            </div>
            <a href="{{ route('commandes.liste') }}"
               class="flex items-center space-x-2 text-sm text-gray-600 hover:text-gray-900 bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-lg transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Retour aux commandes</span>
            </a>
        </div>

        <!-- Erreurs -->
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-xl">
                <p class="font-semibold mb-1">Des erreurs sont survenues :</p>
                <ul class="list-disc list-inside space-y-1 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Message succès -->
        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-xl flex items-center space-x-2">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Colonne gauche : Infos commande -->
            <div class="lg:col-span-1 space-y-4">

                <!-- Infos client -->
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-4">Informations client</h2>
                    <div class="space-y-3">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400">Nom du client</p>
                                <p class="font-semibold text-gray-900">{{ $commande->nom_client }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400">Téléphone</p>
                                <p class="font-semibold text-gray-900">{{ $commande->telephone_client }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400">Total à payer</p>
                                <p class="font-semibold text-gray-900 text-lg">{{ number_format($commande->total, 0, ',', ' ') }} FCFA</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400">Date de commande</p>
                                <p class="font-semibold text-gray-900">{{ $commande->created_at->format('d/m/Y à H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statut actuel -->
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Statut actuel</h2>
                    <div class="flex items-center space-x-2">
                        @switch($commande->statut)
                            @case('en_attente')
                                <span class="inline-flex items-center space-x-1.5 px-3 py-1.5 bg-yellow-100 text-yellow-700 rounded-full text-sm font-medium">
                                    <span class="w-2 h-2 rounded-full bg-yellow-400"></span>
                                    <span>En attente</span>
                                </span>
                                @break
                            @case('en_preparation')
                                <span class="inline-flex items-center space-x-1.5 px-3 py-1.5 bg-blue-100 text-blue-700 rounded-full text-sm font-medium">
                                    <span class="w-2 h-2 rounded-full bg-blue-400"></span>
                                    <span>En préparation</span>
                                </span>
                                @break
                            @case('prete')
                                <span class="inline-flex items-center space-x-1.5 px-3 py-1.5 bg-green-100 text-green-700 rounded-full text-sm font-medium">
                                    <span class="w-2 h-2 rounded-full bg-green-400"></span>
                                    <span>Prête</span>
                                </span>
                                @break
                            @case('payee')
                                <span class="inline-flex items-center space-x-1.5 px-3 py-1.5 bg-gray-100 text-gray-700 rounded-full text-sm font-medium">
                                    <span class="w-2 h-2 rounded-full bg-gray-400"></span>
                                    <span>Payée</span>
                                </span>
                                @break
                        @endswitch
                    </div>
                </div>

                <!-- Lien facture PDF si dispo -->
                @if($commande->statut === 'prete' || $commande->statut === 'payee')
                    <div class="bg-white rounded-xl shadow-sm p-5">
                        <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Facture</h2>
                        <a href="{{ route('commandes.facture', $commande->id) }}"
                           target="_blank"
                           class="flex items-center justify-center space-x-2 w-full bg-gray-900 text-white px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-800 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <span>Télécharger la facture PDF</span>
                        </a>
                    </div>
                @endif
            </div>

            <!-- Colonne droite : Formulaire + progression -->
            <div class="lg:col-span-2 space-y-4">

                <!-- Progression des statuts -->
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-4">Progression</h2>
                    <div class="flex items-center">
                        @php
                            $etapes = ['en_attente', 'en_preparation', 'prete', 'payee'];
                            $labels = ['En attente', 'En préparation', 'Prête', 'Payée'];
                            $currentIndex = array_search($commande->statut, $etapes);
                        @endphp
                        @foreach($etapes as $i => $etape)
                            <div class="flex items-center {{ $i < count($etapes) - 1 ? 'flex-1' : '' }}">
                                <div class="flex flex-col items-center">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold
                                        {{ $i <= $currentIndex ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-400' }}">
                                        @if($i < $currentIndex)
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        @else
                                            {{ $i + 1 }}
                                        @endif
                                    </div>
                                    <span class="text-xs mt-1 text-center {{ $i <= $currentIndex ? 'text-gray-900 font-medium' : 'text-gray-400' }} w-16">
                                        {{ $labels[$i] }}
                                    </span>
                                </div>
                                @if($i < count($etapes) - 1)
                                    <div class="flex-1 h-0.5 mx-1 mb-4 {{ $i < $currentIndex ? 'bg-gray-900' : 'bg-gray-200' }}"></div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Formulaire modification statut -->
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-4">Changer le statut</h2>

                    <form action="{{ route('commandes.update', $commande->id) }}" method="POST" class="space-y-5">
                        @csrf
                        @method('PUT')

                        <!-- Sélection du statut avec cartes radio -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">

                            <!-- En attente -->
                            <label class="relative cursor-pointer">
                                <input type="radio" name="statut" value="en_attente" class="sr-only peer"
                                    {{ old('statut', $commande->statut) == 'en_attente' ? 'checked' : '' }}>
                                <div class="border-2 border-gray-200 rounded-xl p-4 peer-checked:border-yellow-400 peer-checked:bg-yellow-50 transition hover:border-gray-300">
                                    <div class="flex items-center space-x-3">
                                        <span class="w-3 h-3 rounded-full bg-yellow-400 shrink-0"></span>
                                        <div>
                                            <p class="font-semibold text-gray-900 text-sm">En attente</p>
                                            <p class="text-xs text-gray-400 mt-0.5">Commande reçue, non traitée</p>
                                        </div>
                                    </div>
                                </div>
                            </label>

                            <!-- En préparation -->
                            <label class="relative cursor-pointer">
                                <input type="radio" name="statut" value="en_preparation" class="sr-only peer"
                                    {{ old('statut', $commande->statut) == 'en_preparation' ? 'checked' : '' }}>
                                <div class="border-2 border-gray-200 rounded-xl p-4 peer-checked:border-blue-400 peer-checked:bg-blue-50 transition hover:border-gray-300">
                                    <div class="flex items-center space-x-3">
                                        <span class="w-3 h-3 rounded-full bg-blue-400 shrink-0"></span>
                                        <div>
                                            <p class="font-semibold text-gray-900 text-sm">En préparation</p>
                                            <p class="text-xs text-gray-400 mt-0.5">En cours de préparation</p>
                                        </div>
                                    </div>
                                </div>
                            </label>

                            <!-- Prête -->
                            <label class="relative cursor-pointer">
                                <input type="radio" name="statut" value="prete" class="sr-only peer"
                                    {{ old('statut', $commande->statut) == 'prete' ? 'checked' : '' }}>
                                <div class="border-2 border-gray-200 rounded-xl p-4 peer-checked:border-green-400 peer-checked:bg-green-50 transition hover:border-gray-300">
                                    <div class="flex items-center space-x-3">
                                        <span class="w-3 h-3 rounded-full bg-green-400 shrink-0"></span>
                                        <div>
                                            <p class="font-semibold text-gray-900 text-sm">Prête</p>
                                            <p class="text-xs text-gray-400 mt-0.5">Facture PDF générée auto.</p>
                                        </div>
                                    </div>
                                </div>
                            </label>

                            <!-- Payée -->
                            <label class="relative cursor-pointer">
                                <input type="radio" name="statut" value="payee" class="sr-only peer"
                                    {{ old('statut', $commande->statut) == 'payee' ? 'checked' : '' }}>
                                <div class="border-2 border-gray-200 rounded-xl p-4 peer-checked:border-gray-400 peer-checked:bg-gray-50 transition hover:border-gray-300">
                                    <div class="flex items-center space-x-3">
                                        <span class="w-3 h-3 rounded-full bg-gray-500 shrink-0"></span>
                                        <div>
                                            <p class="font-semibold text-gray-900 text-sm">Payée</p>
                                            <p class="text-xs text-gray-400 mt-0.5">Paiement enregistré</p>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <!-- Note d'info -->
                        <div class="flex items-start space-x-2 text-xs text-gray-500 bg-gray-50 rounded-lg p-3">
                            <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Passer une commande à <strong>Prête</strong> génère automatiquement la facture PDF. Passer à <strong>Payée</strong> enregistre le paiement avec la date et le montant.</span>
                        </div>

                        <!-- Boutons -->
                        <div class="flex justify-end space-x-3 pt-2">
                            <a href="{{ route('commandes.liste') }}"
                               class="px-5 py-2.5 rounded-lg text-sm font-medium bg-gray-100 text-gray-700 hover:bg-gray-200 transition">
                                Annuler
                            </a>
                            <button type="submit"
                                    class="px-6 py-2.5 rounded-lg text-sm font-medium bg-gray-900 text-white hover:bg-gray-700 transition">
                                Mettre à jour le statut
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
