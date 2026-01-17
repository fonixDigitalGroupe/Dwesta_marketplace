@extends('layouts.app')

@section('title', 'Commande Confirmée - Mady Market')

@section('content')
    <div style="max-width: 800px; margin: 4rem auto; padding: 0 1rem; text-align: center;">
        <div
            style="background: white; border: 1px solid #e0e0e0; border-radius: 12px; padding: 3rem; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
            <div style="font-size: 5rem; color: #28a745; margin-bottom: 2rem;">✅</div>

            <h1 style="font-size: 2rem; font-weight: bold; margin-bottom: 1rem; color: #333;">Merci pour votre commande !
            </h1>
            <p style="font-size: 1.1rem; color: #666; margin-bottom: 2.5rem;">Votre paiement a été traité avec succès et vos
                commandes ont été transmises aux vendeurs.</p>

            @if(session('orders'))
                <div style="background: #f9f9f9; border-radius: 8px; padding: 1.5rem; text-align: left; margin-bottom: 2.5rem;">
                    <h3 style="font-size: 1rem; font-weight: bold; margin-bottom: 1rem; color: #333;">Références de vos
                        commandes :</h3>
                    @foreach(session('orders') as $order)
                        <div
                            style="display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid #eee;">
                            <span>Commande #{{ $order->reference }}</span>
                            <span style="font-weight: bold;">{{ number_format($order->total_final, 0, ',', ' ') }} FCFA</span>
                        </div>
                    @endforeach
                </div>
            @endif

            <div style="display: flex; gap: 1rem; justify-content: center;">
                <a href="{{ route('profile.show') }}"
                    style="background: #bf0000; color: white; padding: 1rem 2rem; border-radius: 6px; font-weight: bold; text-decoration: none;">Suivre
                    mes achats</a>
                <a href="{{ route('home') }}"
                    style="background: white; color: #333; padding: 1rem 2rem; border-radius: 6px; font-weight: bold; text-decoration: none; border: 1px solid #ccc;">Continuer
                    mes achats</a>
            </div>

            <p style="margin-top: 2rem; font-size: 0.9rem; color: #999;">
                Un e-mail de confirmation vous a été envoyé.
            </p>
        </div>
    </div>
@endsection