@extends('layouts.admin')

@section('content')
<div style="max-width: 600px; margin: 2rem auto; padding: 0 1rem;">
    <h1 style="font-size: 1.3rem; font-weight: 800; margin-bottom: 1.5rem;">Attribuer des crédits</h1>

    @if($errors->any())
        <div style="background:#f8d7da;color:#721c24;padding:0.75rem 1rem;border-radius:6px;margin-bottom:1rem;">
            <ul style="margin:0;padding-left:1.2rem;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.credits.attribuer.store') }}">
        @csrf
        <div style="display:grid;gap:1rem;">
            <div>
                <label style="display:block;font-weight:700;font-size:0.85rem;margin-bottom:0.3rem;">Utilisateur</label>
                <select name="user_id" required style="width:100%;padding:0.6rem;border:1.5px solid #ddd;border-radius:6px;font-size:0.9rem;">
                    <option value="">-- Choisir un utilisateur --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->prenom }} {{ $user->nom }} — {{ $user->email }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label style="display:block;font-weight:700;font-size:0.85rem;margin-bottom:0.3rem;">Nombre de crédits à attribuer</label>
                <input type="number" name="montant" value="{{ old('montant') }}" min="1" required
                    style="width:100%;padding:0.6rem;border:1.5px solid #ddd;border-radius:6px;font-size:0.9rem;">
            </div>
            <div>
                <label style="display:block;font-weight:700;font-size:0.85rem;margin-bottom:0.3rem;">Raison / Note</label>
                <input type="text" name="raison" value="{{ old('raison') }}" required placeholder="Ex: Compensation, offre promotionnelle..."
                    style="width:100%;padding:0.6rem;border:1.5px solid #ddd;border-radius:6px;font-size:0.9rem;">
            </div>
            <div style="display:flex;gap:1rem;margin-top:0.5rem;">
                <button type="submit" style="background:#ff6600;color:#fff;padding:0.6rem 1.5rem;border:none;border-radius:6px;font-weight:700;cursor:pointer;">Attribuer les crédits</button>
                <a href="{{ route('admin.credits.dashboard') }}" style="padding:0.6rem 1.5rem;border:1.5px solid #ddd;border-radius:6px;font-weight:700;text-decoration:none;color:#333;">Annuler</a>
            </div>
        </div>
    </form>
</div>
@endsection
