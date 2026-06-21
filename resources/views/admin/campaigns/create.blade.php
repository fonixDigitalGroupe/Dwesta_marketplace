@extends('layouts.admin')

@section('title', 'Lancer une Campagne')

@push('styles')
<style>
    .main-content { background-color: #f8f9fa !important; }
    .card-amazon {
        background: #fff;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    .form-label {
        font-weight: 700;
        font-size: 0.85rem;
        color: #111;
        margin-bottom: 6px;
    }
    .form-control-amazon {
        border: 1px solid #767676;
        border-radius: 3px;
        padding: 8px 12px;
        font-size: 0.9rem;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-control-amazon:focus {
        border-color: #e77600;
        box-shadow: 0 0 0 3px rgba(228, 121, 17, 0.5);
        outline: none;
    }
    .btn-amazon-primary {
        background: linear-gradient(180deg, #ff9900 0%, #e77600 100%);
        border: 1px solid #a88734;
        color: #111;
        padding: 10px 24px;
        border-radius: 3px;
        font-size: 0.9rem;
        font-weight: 500;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-amazon-primary:hover {
        background: linear-gradient(180deg, #f7dfa1 0%, #edbd3a 100%);
        border-color: #a88734;
    }
</style>
@endpush

@section('content')
<div style="max-width: 900px; margin: 0 auto; padding: 20px;">
    
    <div style="margin-bottom: 25px;">
        <a href="{{ route('admin.promotions.index') }}" style="color: #0066c0; text-decoration: none; font-size: 0.85rem;">
            ← Retour aux promotions
        </a>
    </div>

    <div class="card-amazon">
        <div style="padding: 20px; border-bottom: 1px solid #dee2e6; background: #f6f6f6; border-radius: 8px 8px 0 0;">
            <h1 style="font-size: 1.25rem; font-weight: 700; margin: 0;">🛠️ Nouvelle Campagne Promotionnelle</h1>
            <p style="font-size: 0.85rem; color: #555; margin-top: 5px;">Motivez vos vendeurs à baisser leurs prix en les informant d'un nouveau code promo.</p>
        </div>

        <form action="{{ route('admin.campaigns.store') }}" method="POST" style="padding: 24px;">
            @csrf

            <div class="row">
                {{-- Choix du Coupon --}}
                <div class="col-md-7 mb-4">
                    <label class="form-label">Sélectionner le code promo actif</label>
                    <select name="coupon_id" class="form-control-amazon w-100" required onchange="updateMessageTemplate(this)">
                        <option value="">-- Choisir un code --</option>
                        @foreach($coupons as $coupon)
                            @php 
                                $discount = $coupon->type === 'percent' ? $coupon->value . '%' : number_format($coupon->value, 0) . ' FCFA';
                            @endphp
                            <option value="{{ $coupon->id }}" 
                                    data-code="{{ $coupon->code }}" 
                                    data-discount="{{ $discount }}">
                                {{ $coupon->code }} ({{ $discount }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Choix de la Cible --}}
                <div class="col-md-5 mb-4">
                    <label class="form-label">Groupe de vendeurs cible</label>
                    <select name="target_type" class="form-control-amazon w-100" required>
                        <option value="all">Tous les vendeurs</option>
                        <option value="professionnel">Vendeurs Professionnels uniquement</option>
                        <option value="particulier">Vendeurs Particuliers uniquement</option>
                    </select>
                </div>
            </div>

            {{-- Objet --}}
            <div class="mb-4">
                <label class="form-label">Objet de la notification</label>
                <input type="text" name="subject" id="campaign_subject" class="form-control-amazon w-100" 
                       value="Boostez vos ventes : Nouveau code promo disponible !" required>
            </div>

            {{-- Message --}}
            <div class="mb-4">
                <label class="form-label">Message personnalisé pour les vendeurs</label>
                <textarea name="message" id="campaign_message" rows="6" class="form-control-amazon w-100" required>C'est le moment idéal pour ajuster vos prix ! Nous venons de lancer une campagne de publicité massive pour attirer les clients vers vos catégories.</textarea>
                <small style="color: #666; font-style: italic;">Note : Un bloc automatique contenant le code promo et le montant de la remise sera ajouté au message.</small>
            </div>

            <div style="background: #fff8e1; border: 1px solid #ffe082; padding: 15px; border-radius: 4px; margin-bottom: 25px;">
                <div style="display: flex; gap: 10px;">
                    <i class="fas fa-info-circle" style="color: #ffa000; margin-top: 3px;"></i>
                    <p style="font-size: 0.82rem; margin: 0; line-height: 1.4;">
                        <strong>Action immédiate :</strong> En cliquant sur "Lancer l'envoi", un email et une notification interne seront envoyés instantanément à tous les vendeurs de la cible choisie. Assurez-vous que vos informations sont correctes.
                    </p>
                </div>
            </div>

            <div style="text-align: right;">
                <button type="submit" class="btn-amazon-primary">
                    <i class="fas fa-paper-plane"></i> Lancer l'envoi de la campagne
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function updateMessageTemplate(select) {
    const option = select.options[select.selectedIndex];
    if (option.value) {
        const code = option.getAttribute('data-code');
        const discount = option.getAttribute('data-discount');
        
        document.getElementById('campaign_subject').value = `Boostez vos ventes : Profitez du code ${code} sur Karnou !`;
        document.getElementById('campaign_message').value = `Nous vous encourageons à réduire vos prix de ${discount} sur vos produits stratégiques. En combinant vos réductions avec ce code promo, vous apparaitrez en priorité sur les résultats de recherche et la page d'accueil !`;
    }
}
</script>
@endsection
