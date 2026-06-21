@extends('layouts.admin')

@section('title', 'Modifier la Campagne')

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

        .badge-status {
            font-size: 0.7rem;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 12px;
            text-transform: uppercase;
        }
    </style>
@endpush

@section('content')
<div style="max-width: 1200px; margin: -30px auto 0;">
    <div style="background: #fff; border: 1px solid #eff3f6; border-top: none; border-radius: 0 0 8px 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.02); padding: 24px;">

        {{-- Card Header --}}
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eff3f6; padding-bottom: 15px; margin-bottom: 24px;">
            <div style="display: flex; align-items: center; gap: 8px; color: #475569; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; height: 28px;">
                <i class="fas fa-edit" style="font-size: 0.8rem;"></i>
                <span>Modifier la Campagne</span>
                
                @php
                    $status = 'Active';
                    $statusColor = '#569b00';
                    $statusBg = '#f7fff0';

                    if ($campaign->ends_at && $campaign->ends_at->isPast()) {
                        $status = 'Terminée';
                        $statusColor = '#c40000';
                        $statusBg = '#fff5f5';
                    } elseif ($campaign->starts_at && $campaign->starts_at->isFuture()) {
                        $status = 'À venir';
                        $statusColor = '#0066c0';
                        $statusBg = '#f0f7ff';
                    }
                @endphp
                <span class="badge-status" style="background: {{ $statusBg }}; color: {{ $statusColor }}; margin-left: 10px;">
                    {{ $status }}
                </span>
            </div>
            <a href="{{ route('admin.promotions.index') }}" class="btn-amazon-secondary" style="width: auto !important; height: 32px !important; padding: 0 16px !important; font-size: 0.8rem;">
                <i class="fas fa-arrow-left" style="color: #ff9900;"></i> Retour aux promotions
            </a>
        </div>

        <form action="{{ route('admin.campaigns.update', $campaign) }}" method="POST">
            @csrf
            @method('PUT')

            <div style="display: grid; grid-template-columns: 1fr 380px; gap: 20px; align-items: start;">

                {{-- Left Column --}}
                <div style="display: flex; flex-direction: column; gap: 20px;">

                    {{-- Configuration de la campagne --}}
                    <div class="amazon-card" style="margin: 0;">
                        <h3 class="section-title">Configuration</h3>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                            <div>
                                <label class="field-label">Code Promo Associé <span style="color: red;">*</span></label>
                                <select name="coupon_id" required>
                                    @foreach($coupons as $coupon)
                                        <option value="{{ $coupon->id }}" {{ old('coupon_id', $campaign->coupon_id) == $coupon->id ? 'selected' : '' }}>
                                            {{ $coupon->code }} ({{ $coupon->type == 'percent' ? $coupon->value.'%' : number_format($coupon->value, 0).' F' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="field-label">Cible vendeurs <span style="color: red;">*</span></label>
                                <select name="target_type" required>
                                    <option value="all" {{ old('target_type', $campaign->target_type) == 'all' ? 'selected' : '' }}>Tous les vendeurs</option>
                                    <option value="professionnel" {{ old('target_type', $campaign->target_type) == 'professionnel' ? 'selected' : '' }}>Vendeurs Professionnels (Pro)</option>
                                    <option value="particulier" {{ old('target_type', $campaign->target_type) == 'particulier' ? 'selected' : '' }}>Vendeurs Particuliers</option>
                                </select>
                            </div>
                        </div>

                        <div style="margin-bottom: 20px;">
                            <label class="field-label">Objet du message <span style="color: red;">*</span></label>
                            <input type="text" name="subject" value="{{ old('subject', $campaign->subject) }}" required placeholder="Sujet de l'email et de la notification">
                            @error('subject') <p style="color: #dc2626; font-size: 0.75rem; margin-top: 5px;">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="field-label">Message aux vendeurs <span style="color: red;">*</span></label>
                            <textarea name="message" rows="10" required placeholder="Contenu du message...">{{ old('message', $campaign->message) }}</textarea>
                            @error('message') <p style="color: #dc2626; font-size: 0.75rem; margin-top: 5px;">{{ $message }}</p> @enderror
                            <p style="font-size: 0.75rem; color: #64748b; margin-top: 12px; line-height: 1.4;">
                                <i class="fas fa-info-circle"></i> Note : La modification de ce message ne renverra pas la campagne. Cela met uniquement à jour l'historique de consultation.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Right Column --}}
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    <div class="amazon-card" style="margin: 0;">
                        <h3 class="section-title">Validation & Mise à jour</h3>

                        <div style="margin-bottom: 20px;">
                            <div style="margin-bottom: 15px;">
                                <label class="field-label">Date de début</label>
                                <input type="date" name="starts_at" value="{{ old('starts_at', $campaign->starts_at ? $campaign->starts_at->format('Y-m-d') : '') }}" style="width: 100%;">
                            </div>
                            
                            <div style="margin-bottom: 15px;">
                                <label class="field-label">Date de fin</label>
                                <input type="date" name="ends_at" value="{{ old('ends_at', $campaign->ends_at ? $campaign->ends_at->format('Y-m-d') : '') }}" style="width: 100%;">
                            </div>
                        </div>

                        <div style="display: flex; flex-direction: column; gap: 10px;">
                            <button type="submit" class="btn-amazon-primary">
                                <i class="fas fa-save"></i> METTRE À JOUR
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
@endsection
