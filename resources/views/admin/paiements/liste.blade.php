@extends('admin.dashboard_template')

@section('dashboard-content')
    <div class="min-h-screen py-6">
        <div class="container mx-auto px-4">
            <!-- En-tête simple -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Liste des paiements</h1>
            </div>

            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-lg mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Carte des paiements -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <!-- En-tête bleu marine -->
                <div class="bg-blue-900 px-6 py-3">
                    <h2 class="text-white font-medium">Historique des paiements</h2>
                </div>

                <!-- Tableau -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Commande</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Client</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Montant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Facture</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                        @forelse($paiements as $paiement)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-3 font-medium text-gray-900">#CMD{{ str_pad($paiement->commande_id, 4, '0', STR_PAD_LEFT) }}</td>
                                <td class="px-6 py-3 text-gray-700">{{ $paiement->commande->nom_client ?? 'N/A' }}</td>
                                <td class="px-6 py-3 font-semibold text-gray-900">{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</td>
                                <td class="px-6 py-3 text-gray-500 text-sm">
                                    {{ \Carbon\Carbon::parse($paiement->date_paiement)->format('d/m/Y à H:i') }}
                                </td>
                                <td class="px-6 py-3">
                                    @if($paiement->commande && in_array($paiement->commande->statut, ['prete', 'payee']))
                                        <a href="{{ route('commandes.facture', $paiement->commande_id) }}"
                                           target="_blank"
                                           class="inline-flex items-center space-x-1.5 bg-gray-900 hover:bg-gray-700 text-white text-xs font-medium px-3 py-1.5 rounded-lg transition">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            <span>Télécharger</span>
                                        </a>
                                    @else
                                        <span class="text-xs text-gray-400 italic">Non disponible</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    Aucun paiement enregistré
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
