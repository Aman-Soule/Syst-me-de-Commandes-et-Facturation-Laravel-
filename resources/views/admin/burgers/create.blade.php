@extends('admin/dashboard_template')

@section('dashboard-content')
    <div class="bg-gray-100 min-h-screen py-10">
        <div class="container mx-auto px-6">

            {{-- Header --}}
            <h1 class="text-3xl font-bold text-blue-900 mb-6">Ajouter un Burger</h1>

            {{-- Formulaire --}}
            <div class="bg-white shadow-md rounded-lg p-6">
                <form action="{{ route('burgers.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Nom --}}
                    <div class="mb-4">
                        <label for="nom" class="block text-gray-700 font-semibold mb-2">Nom du Burger</label>
                        <input type="text" name="nom" id="nom"
                               class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-900"
                               required>
                    </div>

                    {{-- Prix --}}
                    <div class="mb-4">
                        <label for="prix_unitaire" class="block text-gray-700 font-semibold mb-2">Prix (FCFA)</label>
                        <input type="number" step="0.01" name="prix_unitaire" id="prix_unitaire"
                               class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-900"
                               required>
                    </div>

                    {{-- Description --}}
                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 font-semibold mb-2">Description</label>
                        <textarea name="description" id="description" rows="3"
                                  class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-900"></textarea>
                    </div>

                    {{-- Stock --}}
                    <div class="mb-4">
                        <label for="quantite_stock" class="block text-gray-700 font-semibold mb-2">Quantité en stock</label>
                        <input type="number" name="quantite_stock" id="quantite_stock"
                               class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-900"
                               required>
                    </div>

                    {{-- Image --}}
                    <div class="mb-6">
                        <label for="image" class="block text-gray-700 font-semibold mb-2">Image</label>
                        <input type="file" name="image" id="image"
                               class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-900"
                               required>
                    </div>

                    {{-- Bouton --}}
                    <div class="flex justify-end">
                        <button type="submit"
                                class="bg-blue-900 text-white px-6 py-2 rounded hover:bg-blue-800 transition">
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
