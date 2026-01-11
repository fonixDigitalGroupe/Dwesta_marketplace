@extends('layouts.app')

@section('title', $pagePro->vendeur->user->name . ' - Boutique Officielle')

@section('content')
<style>
    .boutique-primary-bg { background-color: {{ $pagePro->couleur_primaire }}; }
    .boutique-primary-text { color: {{ $pagePro->couleur_primaire }}; }
    .boutique-border { border-color: {{ $pagePro->couleur_primaire }}; }
    .hover-boutique-bg:hover { background-color: {{ $pagePro->couleur_primaire }}; color: white; }
</style>

<!-- Bannière & Header -->
<div class="relative bg-gray-100">
    @if($pagePro->banniere)
        <div class="h-64 md:h-80 w-full bg-cover bg-center" style="background-image: url('{{ Storage::url($pagePro->banniere) }}');">
            <div class="w-full h-full bg-black bg-opacity-30"></div>
        </div>
    @else
        <div class="h-64 md:h-80 w-full boutique-primary-bg opacity-90"></div>
    @endif

    <div class="container mx-auto px-4 relative -mt-32 z-10">
        <div class="bg-white rounded-xl shadow-xl p-6 md:p-8 flex flex-col md:flex-row items-center md:items-start text-center md:text-left">
            <div class="relative -mt-20 md:-mt-24 mb-4 md:mb-0 md:mr-8 flex-shrink-0">
                @if($pagePro->logo)
                    <img src="{{ Storage::url($pagePro->logo) }}" class="w-32 h-32 md:w-40 md:h-40 rounded-full border-4 border-white shadow-lg object-cover bg-white">
                @else
                    <div class="w-32 h-32 md:w-40 md:h-40 rounded-full border-4 border-white shadow-lg bg-gray-100 flex items-center justify-center text-4xl font-bold text-gray-400">
                        {{ substr($pagePro->vendeur->identite, 0, 1) }}
                    </div>
                @endif
            </div>
            
            <div class="flex-1 w-full">
                <div class="flex flex-col md:flex-row justify-between items-center mb-4">
                    <h1 class="text-3xl font-bold text-gray-900">{{ $pagePro->vendeur->identite }}</h1>
                    <div class="flex items-center space-x-2 mt-2 md:mt-0">
                        @if($pagePro->vendeur->estVendeurVerifie())
                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                Vendeur Vérifié
                            </span>
                        @endif
                        @if($pagePro->vendeur->estProfessionnel())
                            <span class="bg-purple-100 text-purple-800 text-xs font-semibold px-2.5 py-0.5 rounded">PRO</span>
                        @endif
                    </div>
                </div>

                <p class="text-gray-600 mb-6 text-sm md:text-base leading-relaxed max-w-2xl">
                    {{ $pagePro->description ?? "Bienvenue sur notre boutique officielle. Découvrez nos produits !" }}
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 text-sm border-t pt-4">
                    @if($pagePro->telephone_contact)
                    <div class="flex items-center justify-center md:justify-start text-gray-600">
                        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        {{ $pagePro->telephone_contact }}
                    </div>
                    @endif
                    @if($pagePro->email_contact)
                    <div class="flex items-center justify-center md:justify-start text-gray-600">
                        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        {{ $pagePro->email_contact }}
                    </div>
                    @endif
                    @if($pagePro->site_web)
                    <div class="flex items-center justify-center md:justify-start">
                        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                        <a href="{{ $pagePro->site_web }}" target="_blank" class="boutique-primary-text hover:underline truncate">Site Web</a>
                    </div>
                    @endif
                </div>

                <div class="mt-6 flex space-x-3">
                    <a href="{{ route('conversations.create', ['recipient_id' => $pagePro->vendeur->user->id]) }}" class="flex-1 md:flex-none boutique-primary-bg text-white font-bold py-2 px-6 rounded-lg shadow hover:opacity-90 flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        Contacter
                    </a>
                    @if(Auth::check() && Auth::id() !== $pagePro->vendeur->user->id)
                        <button class="flex-1 md:flex-none bg-white border boutique-border boutique-primary-text font-bold py-2 px-6 rounded-lg hover:bg-gray-50 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            S'abonner
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Contenu Principal -->
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        
        <!-- Sidebar Filtres (Desktop) -->
        <div class="hidden lg:block w-1/4">
            <div class="bg-white rounded-lg shadow p-6 sticky top-24">
                <h3 class="font-bold text-lg mb-4">Catégories</h3>
                <ul class="space-y-2">
                    <li><a href="?category=" class="block text-gray-700 hover:boutique-primary-text font-medium {{ !request('category') ? 'boutique-primary-text' : '' }}">Toutes les catégories</a></li>
                    <!-- Les catégories seraient dynamiques ici basées sur les produits du vendeur -->
                    @foreach($annonces->pluck('categorie')->unique('id') as $cat)
                        @if($cat)
                        <li><a href="?category={{ $cat->id }}" class="block text-gray-600 hover:boutique-primary-text text-sm ml-2">{{ $cat->nom }}</a></li>
                        @endif
                    @endforeach
                </ul>

                <hr class="my-6">
                
                <h3 class="font-bold text-lg mb-4">Avis Clients</h3>
                <div class="flex items-center mb-2">
                    <span class="text-3xl font-bold text-gray-900 mr-2">4.8</span>
                    <div class="flex text-yellow-400">★★★★★</div>
                </div>
                <p class="text-sm text-gray-500 mb-4">{{ $avis->count() }} avis vérifiés</p>
                
                <div class="space-y-4">
                    @foreach($avis->take(3) as $a)
                        <div class="bg-gray-50 p-3 rounded text-sm">
                            <div class="flex items-center justify-between mb-1">
                                <span class="font-bold">{{ $a->user->name }}</span>
                                <span class="text-yellow-400 text-xs">{{ str_repeat('★', $a->note) }}</span>
                            </div>
                            <p class="text-gray-600 italic">"{{ Str::limit($a->commentaire, 60) }}"</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Grille Produits -->
        <div class="flex-1">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Catalogue Produits</h2>
                <div class="flex items-center">
                    <span class="mr-2 text-gray-600">Trier par:</span>
                    <select onchange="window.location.href=this.value" class="border-gray-300 rounded-md shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="?sort=latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Nouveautés</option>
                        <option value="?sort=price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Prix croissant</option>
                        <option value="?sort=price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Prix décroissant</option>
                    </select>
                </div>
            </div>

            @if($annonces->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                    @foreach($annonces as $annonce)
                        <a href="{{ route('annonces.show', $annonce->slug) }}" class="bg-white rounded-lg shadow hover:shadow-lg transition group">
                            <div class="aspect-w-1 aspect-h-1 w-full bg-gray-200 rounded-t-lg overflow-hidden relative">
                                @if($annonce->photoPrincipale())
                                    <img src="{{ Storage::url($annonce->photoPrincipale()->chemin) }}" class="w-full h-48 object-cover group-hover:scale-105 transition duration-300">
                                @else
                                    <div class="w-full h-48 bg-gray-100 flex items-center justify-center text-gray-400">Sans image</div>
                                @endif
                                
                                <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition">
                                    <button class="bg-white p-1.5 rounded-full shadow text-gray-600 hover:text-red-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                    </button>
                                </div>
                            </div>
                            <div class="p-4">
                                <h3 class="font-medium text-gray-900 group-hover:text-blue-600 truncate">{{ $annonce->titre }}</h3>
                                <div class="flex items-end justify-between mt-2">
                                    <span class="text-lg font-bold boutique-primary-text">{{ number_format($annonce->prix, 0, ',', ' ') }} CFA</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="mt-8">
                    {{ $annonces->links() }}
                </div>
            @else
                <div class="text-center py-12 bg-white rounded-lg shadow">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                    <h3 class="text-lg font-medium text-gray-900">Aucun produit trouvé</h3>
                    <p class="text-gray-500 mt-1">Les produits de cette boutique apparaîtront ici.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
