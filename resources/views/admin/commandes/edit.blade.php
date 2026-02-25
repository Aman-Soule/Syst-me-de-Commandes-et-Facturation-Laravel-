@extends('admin/dashboard_template')

@section('dashboard-content')
    <div class="bg-gray-100 min-h-screen py-10">
        <div class="container mx-auto px-6 max-w-3xl">
            <h1 class="text-3xl font-bold text-gray-900 mb-6">Modifier le statut de la commande</h1>

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow rounded-lg p-6 space-y-6">
                <!-- Infos de la commande -->
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500">Client</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $commande->nom_client }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Téléphone</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $commande->telephone_client }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $commande->total }} FCFA</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Date</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $commande->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                <!-- Formulaire de modification du statut -->
                <form action="{{ route('commandes.update', $commande->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="statut" class="block text-sm font-medium text-gray-700 mb-2">Statut de la commande</label>
                        <select id="statut" name="statut"
                                class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-lg py-3">
                            <option value="en_attente" {{ old('statut', $commande->statut) == 'en_attente' ? 'selected' : '' }}>En attente</option>
                            <option value="en_preparation" {{ old('statut', $commande->statut) == 'en_preparation' ? 'selected' : '' }}>En préparation</option>
                            <option value="prete" {{ old('statut', $commande->statut) == 'prete' ? 'selected' : '' }}>Prête</option>
                        </select>
                    </div>

                    <!-- Boutons -->
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('commandes.liste') }}"
                           class="bg-gray-300 text-gray-800 px-5 py-2 rounded hover:bg-gray-400 transition">
                            Annuler
                        </a>
                        <button type="submit"
                                class="bg-blue-600 text-white px-5 py-2 rounded transition hover:bg-blue-700">
                            Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
