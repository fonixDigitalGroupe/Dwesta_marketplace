@extends('layouts.app')

@section('title', 'Modifier ma Page Pro')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-8">Personnaliser ma Boutique</h1>

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <form action="{{ route('page-pro.update') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-8">
                @csrf
                @method('PUT')

                <!-- Section Design -->
                <div>
                    <h2 class="text-xl font-semibold mb-4 border-b pb-2">Identité Visuelle</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Logo</label>
                            @if($pagePro->logo)
                                <img src="{{ Storage::url($pagePro->logo) }}" class="h-20 w-20 object-cover rounded-full mb-3 border">
                            @endif
                            <input type="file" name="logo" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Bannière</label>
                            @if($pagePro->banniere)
                                <img src="{{ Storage::url($pagePro->banniere) }}" class="h-24 w-full object-cover rounded mb-3 border">
                            @endif
                            <input type="file" name="banniere" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Couleur Principale</label>
                            <div class="flex items-center space-x-3">
                                <input type="color" name="couleur_primaire" value="{{ $pagePro->couleur_primaire ?? '#3b82f6' }}" class="h-10 w-20 p-1 rounded border">
                                <span class="text-gray-500 text-sm">Choisir la couleur de votre marque</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section Infos -->
                <div>
                    <h2 class="text-xl font-semibold mb-4 border-b pb-2">Informations</h2>
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea name="description" rows="5" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">{{ old('description', $pagePro->description) }}</textarea>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email Contact</label>
                                <input type="email" name="email_contact" value="{{ old('email_contact', $pagePro->email_contact) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                                <input type="text" name="telephone_contact" value="{{ old('telephone_contact', $pagePro->telephone_contact) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Site Web</label>
                                <input type="url" name="site_web" value="{{ old('site_web', $pagePro->site_web) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t flex justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg transform transition hover:scale-105">
                        Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
        
        <div class="mt-6 text-center">
            <a href="{{ route('page-pro.show', $pagePro->slug) }}" target="_blank" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                Voir ma boutique en ligne
            </a>
        </div>
    </div>
</div>
@endsection
