@extends('admin/dashboard_template')

@section('dashboard-content')
    <div class="space-y-6">
        <!-- En-tête -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h1 class="text-2xl font-bold text-gray-900">Tableau de bord</h1>
            <p class="text-gray-500 mt-1">Vue d'ensemble du restaurant — {{ now()->translatedFormat('l d F Y') }}</p>
        </div>

        <!-- Bloc 1: Indicateurs clés -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Total commandes -->
            <div class="bg-white rounded-xl shadow-sm p-5 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total commandes</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalCommandes }}</p>
                    </div>
                    <div class="bg-blue-100 text-blue-600 rounded-xl p-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Chiffre d'affaires -->
            <div class="bg-white rounded-xl shadow-sm p-5 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Chiffre d'affaires</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($chiffreAffaires, 0, ',', ' ') }} FCFA</p>
                    </div>
                    <div class="bg-green-100 text-green-600 rounded-xl p-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Burgers au menu -->
            <div class="bg-white rounded-xl shadow-sm p-5 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Burgers au menu</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalBurgers }}</p>
                    </div>
                    <div class="bg-yellow-100 text-yellow-600 rounded-xl p-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Ruptures -->
            <div class="bg-white rounded-xl shadow-sm p-5 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Ruptures de stock</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $burgersEnRupture }}</p>
                    </div>
                    <div class="bg-red-100 text-red-600 rounded-xl p-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bloc 2: Aujourd'hui -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl shadow-sm p-5">
                <p class="text-sm text-yellow-700 font-medium">Commandes en cours</p>
                <p class="text-3xl font-bold text-yellow-600 mt-2">{{ $commandesEnCoursAujourdhui }}</p>
                <p class="text-xs text-yellow-600/70 mt-2">En attente + En préparation</p>
            </div>

            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl shadow-sm p-5">
                <p class="text-sm text-green-700 font-medium">Commandes validées</p>
                <p class="text-3xl font-bold text-green-600 mt-2">{{ $commandesValideesAujourdhui }}</p>
                <p class="text-xs text-green-600/70 mt-2">Prêtes ou payées ce jour</p>
            </div>

            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl shadow-sm p-5">
                <p class="text-sm text-blue-700 font-medium">Recettes du jour</p>
                <p class="text-3xl font-bold text-blue-600 mt-2">{{ number_format($recettesJournalieres, 0, ',', ' ') }} FCFA</p>
                <p class="text-xs text-blue-600/70 mt-2">Paiements reçus aujourd'hui</p>
            </div>
        </div>

        <!-- Bloc 3: Graphiques - Première ligne -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <!-- Commandes par mois -->
            <div class="bg-white rounded-xl shadow-sm p-4">
                <h3 class="text-sm font-semibold text-gray-700 mb-3">Commandes par mois</h3>
                <div class="h-48">
                    <canvas id="chartCommandesMois"></canvas>
                </div>
            </div>

            <!-- Recettes par mois -->
            <div class="bg-white rounded-xl shadow-sm p-4">
                <h3 class="text-sm font-semibold text-gray-700 mb-3">Recettes mensuelles</h3>
                <div class="h-48">
                    <canvas id="chartRecettesMois"></canvas>
                </div>
            </div>
        </div>

        <!-- Bloc 4: Graphiques - Deuxième ligne -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <!-- Produits vendus -->
            <div class="bg-white rounded-xl shadow-sm p-4">
                <h3 class="text-sm font-semibold text-gray-700 mb-3">Ventes par burger (ce mois)</h3>
                <div class="h-48">
                    <canvas id="chartProduitsVendus"></canvas>
                </div>
            </div>

            <!-- Répartition statuts -->
            <div class="bg-white rounded-xl shadow-sm p-4">
                <h3 class="text-sm font-semibold text-gray-700 mb-3">Répartition des commandes</h3>
                <div class="h-48 flex items-center justify-center">
                    <canvas id="chartDonutStatuts"></canvas>
                </div>
            </div>
        </div>

        <!-- Bloc 5: Statuts et Stock -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <!-- Statuts détaillés -->
            <div class="bg-white rounded-xl shadow-sm p-5">
                <h3 class="text-sm font-semibold text-gray-700 mb-4">📌 Statuts des commandes</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-2">
                            <span class="w-2 h-2 rounded-full bg-yellow-400"></span>
                            <span class="text-sm text-gray-600">En attente</span>
                        </div>
                        <span class="font-semibold text-gray-800">{{ $commandesEnAttente }}</span>
                    </div>
                    <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-2">
                            <span class="w-2 h-2 rounded-full bg-blue-400"></span>
                            <span class="text-sm text-gray-600">En préparation</span>
                        </div>
                        <span class="font-semibold text-gray-800">{{ $commandesEnPreparation }}</span>
                    </div>
                    <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-2">
                            <span class="w-2 h-2 rounded-full bg-green-400"></span>
                            <span class="text-sm text-gray-600">Prêtes</span>
                        </div>
                        <span class="font-semibold text-gray-800">{{ $commandesPretes }}</span>
                    </div>
                    <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-2">
                            <span class="w-2 h-2 rounded-full bg-gray-400"></span>
                            <span class="text-sm text-gray-600">Payées</span>
                        </div>
                        <span class="font-semibold text-gray-800">{{ $commandesPayees }}</span>
                    </div>
                </div>
            </div>

            <!-- Aperçu stock -->
            <div class="bg-white rounded-xl shadow-sm p-5">
                <h3 class="text-sm font-semibold text-gray-700 mb-4">📦 Aperçu du stock</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg">
                        <span class="text-sm text-gray-600">Total unités</span>
                        <span class="font-semibold text-gray-800">{{ $stockTotal }}</span>
                    </div>
                    <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg">
                        <span class="text-sm text-gray-600">Disponibles</span>
                        <span class="font-semibold text-green-600">{{ $totalBurgers - $burgersEnRupture }}</span>
                    </div>
                    <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg">
                        <span class="text-sm text-gray-600">En rupture</span>
                        <span class="font-semibold text-red-600">{{ $burgersEnRupture }}</span>
                    </div>
                </div>
                <div class="mt-4 flex space-x-3">
                    <a href="{{ route('burgers.index') }}" class="flex-1 text-center bg-gray-900 text-white px-3 py-2 rounded-lg text-sm hover:bg-gray-800 transition">
                        Gérer le stock
                    </a>
                    <a href="{{ route('commandes.liste') }}" class="flex-1 text-center bg-blue-600 text-white px-3 py-2 rounded-lg text-sm hover:bg-blue-700 transition">
                        Voir commandes
                    </a>
                </div>
            </div>
        </div>

        <!-- Bloc 6: Tableau des burgers -->
        <div class="bg-white rounded-xl shadow-sm p-5">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-900">Commandes</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                    <tr class="border-b">
                        <th class="text-left py-3 px-4 text-gray-600 font-medium">Id</th>
                        <th class="text-left py-3 px-4 text-gray-600 font-medium">Nom du client</th>
                        <th class="text-left py-3 px-4 text-gray-600 font-medium">Tel</th>
                        <th class="text-left py-3 px-4 text-gray-600 font-medium">Total a payée</th>
                        <th class="text-left py-3 px-4 text-gray-600 font-medium">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($commandes as $commande)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $commande->nom_client }}</td>
                            <td class="px-4 py-2">{{ $commande->telephone_client }}</td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 rounded text-sm
                                    @if($commande->statut == 'en_attente') bg-yellow-100 text-yellow-700
                                    @elseif($commande->statut == 'en_preparation') bg-blue-100 text-blue-700
                                    @elseif($commande->statut == 'prete') bg-green-100 text-green-700
                                    @else bg-gray-100 text-gray-700 @endif">
                                    {{ ucfirst($commande->statut) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">{{ $commande->total }} FCFA</td>
                            <td class="px-4 py-2">{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-2 flex space-x-2">
                                <!-- Bouton Edit -->
                                <a href="{{ route('commandes.edit', $commande->id) }}"
                                   class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-500">
                                    Edit
                                </a>

                                <!-- Bouton Delete -->
                                <form action="{{ route('commandes.destroy', $commande->id) }}" method="POST"
                                      onsubmit="return confirm('Voulez-vous vraiment supprimer cette commande ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-500">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-2 text-center text-gray-500">
                                Aucune commande trouvée.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const moisLabels = @json($moisLabels);
        const commandesMois = @json($chartCommandesMois);
        const recettesMois = @json($chartRecettesMois);
        const burgerLabels = @json($chartBurgerLabels);
        const burgerVendus = @json($chartBurgerVendus);
        const statutData = [{{ $commandesEnAttente }}, {{ $commandesEnPreparation }}, {{ $commandesPretes }}, {{ $commandesPayees }}];

        const chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } }
        };

        // Commandes par mois
        new Chart(document.getElementById('chartCommandesMois'), {
            type: 'line',
            data: {
                labels: moisLabels,
                datasets: [{
                    data: commandesMois,
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59,130,246,0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: chartOptions
        });

        // Recettes par mois
        new Chart(document.getElementById('chartRecettesMois'), {
            type: 'bar',
            data: {
                labels: moisLabels,
                datasets: [{
                    data: recettesMois,
                    backgroundColor: '#10b981'
                }]
            },
            options: chartOptions
        });

        // Produits vendus
        new Chart(document.getElementById('chartProduitsVendus'), {
            type: 'bar',
            data: {
                labels: burgerLabels,
                datasets: [{
                    data: burgerVendus,
                    backgroundColor: '#f59e0b'
                }]
            },
            options: {
                ...chartOptions,
                indexAxis: 'y'
            }
        });

        // Donut statuts
        new Chart(document.getElementById('chartDonutStatuts'), {
            type: 'doughnut',
            data: {
                labels: ['En attente', 'Préparation', 'Prêtes', 'Payées'],
                datasets: [{
                    data: statutData,
                    backgroundColor: ['#fbbf24', '#3b82f6', '#22c55e', '#6b7280'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { boxWidth: 8, padding: 8 } }
                },
                cutout: '70%'
            }
        });
    </script>
@endsection
