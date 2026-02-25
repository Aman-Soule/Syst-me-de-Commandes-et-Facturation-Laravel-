
@extends('template')

@section('content')
    <div class="bg-gray-100 min-h-screen py-10">
        <div class="container mx-auto px-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-6">Liste des commandes</h1>

            @if(session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-lg p-6">
                <table class="w-full border-collapse">
                    <thead>
                    <tr class="bg-gray-200 text-left">
                        <th class="px-4 py-2">Client</th>
                        <th class="px-4 py-2">Téléphone</th>
                        <th class="px-4 py-2">Statut</th>
                        <th class="px-4 py-2">Total</th>
                        <th class="px-4 py-2">Date</th>
                        <th class="px-4 py-2">Actions</th>
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
@endsection
