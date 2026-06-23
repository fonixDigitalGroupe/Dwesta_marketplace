@extends('layouts.admin')

@section('title', 'Lancer une Campagne')

@push('styles')
    <style>
        input[type="text"],
        input[type="number"],
        input[type="date"],
        textarea,
        select {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            font-size: 0.82rem;
            outline: none;
            background: #fff;
            color: #475569;
            transition: all 0.2s;
        }

        input:focus, textarea:focus, select:focus {
            border-color: #ff9900 !important;
        }

        .amazon-card {
            background: #fff;
            border: 1px solid #eff3f6;
            border-radius: 8px;
            padding: 24px;
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 0.75rem;
            font-weight: 700;
            color: #475569;
            margin-bottom: 16px;
            padding-bottom: 10px;
            border-bottom: 1px solid #f1f5f9;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .field-label {
            display: block;
            font-size: 0.72rem;
            font-weight: 600;
            color: #94a3b8;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .btn-amazon-primary {
            background: linear-gradient(180deg, #3b82f6 0%, #2563eb 100%);
            border: none;
            color: #fff;
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 0.78rem;
            font-weight: 600;
            letter-spacing: 0.03em;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s;
            cursor: pointer;
            width: 100%;
        }

        .btn-amazon-primary:hover {
            background: linear-gradient(180deg, #2563eb 0%, #1d4ed8 100%);
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            color: #fff;
        }

        .btn-amazon-secondary {
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            color: #475569;
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 0.78rem;
            font-weight: 500;
            letter-spacing: 0.03em;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s;
            cursor: pointer;
            width: 100%;
        }

        .btn-amazon-secondary:hover {
            background: #f8fafc;
            border-color: #dee2e6;
            color: #1e293b;
        }

        .info-box {
            background: #fff8e1;
            border: 1px solid #ffe082;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 25px;
        }
    </style>
@endpush

@section('content')
<div style="max-width: 1200px; margin: -30px auto 0;">
    <div style="background: #fff; border: 1px solid #eff3f6; border-top: none; border-radius: 0 0 8px 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.02); padding: 24px;">

        {{-- Card Header --}}
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eff3f6; padding-bottom: 15px; margin-bottom: 24px;">
            <div style="display: flex; align-items: center; gap: 8px; color: #475569; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; height: 28px;">
                <i class="fas fa-bullhorn" style="font-size: 0.8rem;"></i>
                <span>Nouvelle Campagne Promotionnelle</span>
            </div>
            <a href="{{ route('admin.promotions.index') }}" class="btn-amazon-secondary" style="width: auto !important; height: 32px !important; padding: 0 16px !important; font-size: 0.8rem;">
                <i class="fas fa-arrow-left" style="color: #ff9900;"></i> Retour aux promotions
            </a>
        </div>

        <form action="{{ route('admin.campaigns.store') }}" method="POST">
            @csrf

            <div style="display: grid; grid-template-columns: 1fr 380px; gap: 20px; align-items: start;">

                {{-- Left Column --}}
                <div style="display: flex; flex-direction: column; gap: 20px;">

                    {{-- Configuration de la campagne --}}
                    <div class="amazon-card" style="margin: 0;">
                        <h3 class="section-title">Configuration</h3>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                            <div>
                                <label class="field-label">Code Promo Actif <span style="color: red;">*</span></label>
                                <select name="coupon_id" required onchange="updateMessageTemplate(this)">
                                    <option value="">-- Choisir un code --</option>
                                    @foreach($coupons as $coupon)
                                        @php 
                                            $discount = $coupon->type === 'percent' ? $coupon->value . '%' : number_format($coupon->value, 0) . ' FCFA';
                                            $catName = $coupon->category->nom ?? $coupon->categoryN1->nom ?? 'votre boutique';
                                        @endphp
                                        <option value="{{ $coupon->id }}" 
                                                data-code="{{ $coupon->code }}" 
                                                data-discount="{{ $discount }}"
                                                data-category="{{ $catName }}">
                                            {{ $coupon->code }} ({{ $discount }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="field-label">Cible vendeurs <span style="color: red;">*</span></label>
                                <select name="target_type" required>
                                    <option value="all">Tous les vendeurs</option>
                                    <option value="professionnel">Vendeurs Professionnels (Pro)</option>
                                    <option value="particulier">Vendeurs Particuliers</option>
                                </select>
                            </div>
                        </div>

                        <div style="margin-bottom: 20px;">
                            <label class="field-label">Titre de la campagne <span style="color: red;">*</span></label>
                            <input type="text" name="title" value="{{ old('title') }}" required>
                        </div>

                        <div style="margin-bottom: 20px;">
                            <label class="field-label">Objet du message <span style="color: red;">*</span></label>
                            <input type="text" name="subject" id="campaign_subject" value="Boostez vos ventes : Nouveau code promo disponible !" required placeholder="Sujet de l'email et de la notification">
                        </div>

                        <div>
                            <label class="field-label">Message aux vendeurs <span style="color: red;">*</span></label>
                            <textarea name="message" id="campaign_message" rows="6" required placeholder="Expliquez aux vendeurs pourquoi ils doivent baisser leurs prix...">C'est le moment idéal pour ajuster vos prix ! Nous venons de lancer une campagne de publicité massive pour attirer les clients vers vos catégories.</textarea>

                        </div>
                    </div>



                </div>

                {{-- Right Column --}}
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    <div class="amazon-card" style="margin: 0;">
                        <h3 class="section-title">Validation & Envoi</h3>

                        <p style="font-size: 0.8rem; color: #64748b; line-height: 1.5; margin-bottom: 20px;">
                            L'envoi est immédiat et ne peut pas être annulé une fois lancé. Veuillez vérifier le contenu de votre message.
                        </p>

                        <div style="margin-bottom: 20px;">
                            <div style="margin-bottom: 15px;">
                                <label class="field-label">Date de début</label>
                                <input type="date" name="starts_at" value="{{ old('starts_at') }}" style="width: 100%; padding: 10px; border: 1px solid #dee2e6; border-radius: 4px; font-size: 0.85rem; color: #475569;">
                            </div>
                            <div style="margin-bottom: 15px;">
                                <label class="field-label">Date de fin</label>
                                <input type="date" name="ends_at" value="{{ old('ends_at') }}" style="width: 100%; padding: 10px; border: 1px solid #dee2e6; border-radius: 4px; font-size: 0.85rem; color: #475569;">
                            </div>
                        </div>

                        <div style="display: flex; flex-direction: column; gap: 10px;">
                            <button type="submit" class="btn-amazon-primary">
                                <i class="fas fa-paper-plane"></i> LANCER L'ENVOI
                            </button>
                            <a href="{{ route('admin.promotions.index') }}" class="btn-amazon-secondary">
                                ANNULER
                            </a>
                        </div>
                    </div>
                </div>

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
        const category = option.getAttribute('data-category');
        
        document.getElementById('campaign_subject').value = `Boostez vos ventes : Profitez du code ${code} sur Karnou !`;
        document.getElementById('campaign_message').value = `Nous vous encourageons à réduire vos prix de ${discount} sur vos produits de la catégorie ${category}. En combinant vos réductions avec ce code promo, vous apparaitrez en priorité sur les résultats de recherche et la page d'accueil !`;
    }
}
</script>
@endsection
