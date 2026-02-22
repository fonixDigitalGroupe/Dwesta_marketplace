@extends('layouts.app')

@section('title', 'Mes Favoris - Mady Market')

@section('content')
<div class="breadcrumb">
    <a href="{{ route('home') }}">Accueil</a> > <a href="{{ route('account.index') }}">Mon Compte</a> > <span>Mes Favoris</span>
</div>

<div class="dashboard-container">
    @include('partials.profile-sidebar')

    <main class="main-content">
        <h1 style="font-size: 1.75rem; font-weight: 800; margin-bottom: 1.5rem;">Mes Favoris</h1>

        @if($favorites->count() > 0)
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1.5rem;">
                @foreach($favorites as $annonce)
                    @include('components.annonce-card', ['annonce' => $annonce])
                @endforeach
            </div>
            <div style="margin-top: 2rem;">
                {{ $favorites->links() }}
            </div>
        @else
            <div style="background: white; padding: 3rem; text-align: center; border-radius: 8px; border: 1px solid #eee;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">❤️</div>
                <h3 style="margin-bottom: 0.5rem;">Vous n'avez pas encore de favoris.</h3>
            </div>
        @endif
    </main>
</div>
@endsection