@extends('admin/dashboard_template')

@section('dashboard-content')
    <div class="bg-gray-100 min-h-screen py-10">
        <div class="container mx-auto px-6">

            {{-- Header --}}
            <h1 class="text-3xl font-bold text-gray-900 mb-6">Ajouter un Burger</h1>

            @if(session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            {{-- Formulaire --}}
            <div class="bg-white shadow-md rounded-lg p-6">
                <form action="{{ route('burgers.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf

                    {{-- Nom --}}
                    <div class="mb-4">
                        <label for="nom" class="block text-gray-700 font-semibold mb-2">Nom du Burger</label>
                        <input type="text" name="nom" id="nom" value="{{ old('nom') }}"
                               class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-900"
                               required>
                        @error('nom')
                        <div class="text-red-700 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Prix --}}
                    <div class="mb-4">
                        <label for="prix_unitaire" class="block text-gray-700 font-semibold mb-2">Prix (FCFA)</label>
                        <input type="number" step="0.01" name="prix_unitaire" id="prix_unitaire" value="{{ old('prix_unitaire') }}"
                               class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-900"
                               required>
                        @error('prix_unitaire')
                        <div class="text-red-700 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 font-semibold mb-2">Description</label>
                        <textarea name="description" id="description" rows="3"
                                  class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-900">{{ old('description') }}</textarea>
                        @error('description')
                        <div class="text-red-700 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Stock --}}
                    <div class="mb-4">
                        <label for="quantite_stock" class="block text-gray-700 font-semibold mb-2">Quantité en stock</label>
                        <input type="number" name="quantite_stock" id="quantite_stock" value="{{ old('quantite_stock') }}"
                               class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-900"
                               required>
                        @error('quantite_stock')
                        <div class="text-red-700 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Image --}}
                    <div class="mb-6">
                        <label for="image" class="block text-gray-700 font-semibold mb-2">Image</label>
                        <input type="file" name="image" id="image"
                               class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-900"
                               required>
                        @error('image')
                        <div class="text-red-700 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Bouton --}}
                    <div class="flex justify-end">
                        <button type="submit"
                                class="bg-gray-900 text-white px-6 py-2 rounded hover:bg-blue-800 transition">
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection
