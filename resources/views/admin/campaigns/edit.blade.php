@extends('layouts.admin')

@section('content')
<div style="max-width: 1000px; margin: 0 auto; padding: 20px;">
    {{-- Header --}}
    <div style="background: linear-gradient(135deg, #1e293b 0%, #334155 100%); padding: 30px; border-radius: 8px 8px 0 0; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
        <h2 style="color: #ffffff; font-size: 1.5rem; font-weight: 700; margin: 0; display: flex; align-items: center; gap: 12px;">
            <i class="fas fa-edit"></i> Modifier la Campagne
        </h2>
        <p style="color: #cbd5e1; margin: 8px 0 0 0; font-size: 0.9rem;">
            Mise à jour des détails de la campagne dans l'historique.
        </p>
    </div>

    <div style="background: #ffffff; border: 1px solid #eff3f6; border-top: none; border-radius: 0 0 8px 8px; padding: 30px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);">
        
        <form action="{{ route('admin.campaigns.update', $campaign) }}" method="POST">
            @csrf
            @method('PUT')

            <div style="display: grid; grid-template-columns: 1fr 350px; gap: 30px;">
                
                {{-- Left Content --}}
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    
                    <div>
                        <label for="subject" style="display: block; font-size: 0.75rem; font-weight: 700; color: #475569; text-transform: uppercase; margin-bottom: 8px;">Objet de l'email <span style="color: red;">*</span></label>
                        <input type="text" name="subject" id="subject" value="{{ old('subject', $campaign->subject) }}" 
                               style="width: 100%; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.9rem;" required>
                        @error('subject') <p style="color: #dc2626; font-size: 0.75rem; margin-top: 5px;">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="message" style="display: block; font-size: 0.75rem; font-weight: 700; color: #475569; text-transform: uppercase; margin-bottom: 8px;">Message de la campagne <span style="color: red;">*</span></label>
                        <textarea name="message" id="message" rows="10" 
                                  style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.9rem; resize: vertical;" required>{{ old('message', $campaign->message) }}</textarea>
                        @error('message') <p style="color: #dc2626; font-size: 0.75rem; margin-top: 5px;">{{ $message }}</p> @enderror
                        <p style="font-size: 0.75rem; color: #64748b; margin-top: 8px;">
                            <i class="fas fa-info-circle"></i> Note: La modification de ce message ne renverra pas la campagne. Cela met uniquement à jour l'historique.
                        </p>
                    </div>

                </div>

                {{-- Right Sidebar --}}
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px;">
                        <h4 style="font-size: 0.75rem; font-weight: 700; color: #475569; text-transform: uppercase; margin: 0 0 15px 0; padding-bottom: 10px; border-bottom: 1px solid #e2e8f0;">Paramètres</h4>
                        
                        <div style="margin-bottom: 15px;">
                            <label for="coupon_id" style="display: block; font-size: 0.7rem; font-weight: 600; color: #64748b; margin-bottom: 5px;">Code Promo Associé</label>
                            <select name="coupon_id" id="coupon_id" style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px; font-size: 0.85rem;" required>
                                @foreach($coupons as $coupon)
                                    <option value="{{ $coupon->id }}" {{ old('coupon_id', $campaign->coupon_id) == $coupon->id ? 'selected' : '' }}>
                                        {{ $coupon->code }} ({{ $coupon->type == 'percent' ? $coupon->value.'%' : number_format($coupon->value, 0).' F' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div style="margin-bottom: 15px;">
                            <div style="margin-bottom: 15px;">
                                <label for="starts_at" style="display: block; font-size: 0.7rem; font-weight: 600; color: #64748b; margin-bottom: 5px;">Date de début</label>
                                <input type="date" name="starts_at" id="starts_at" value="{{ old('starts_at', $campaign->starts_at ? $campaign->starts_at->format('Y-m-d') : '') }}" 
                                       style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 4px; font-size: 0.85rem; color: #475569;">
                            </div>
                            <div style="margin-bottom: 15px;">
                                <label for="ends_at" style="display: block; font-size: 0.7rem; font-weight: 600; color: #64748b; margin-bottom: 5px;">Date de fin</label>
                                <input type="date" name="ends_at" id="ends_at" value="{{ old('ends_at', $campaign->ends_at ? $campaign->ends_at->format('Y-m-d') : '') }}" 
                                       style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 4px; font-size: 0.85rem; color: #475569;">
                            </div>
                        </div>

                        <div>
                            <p style="font-size: 0.7rem; color: #64748b; margin-bottom: 5px;">Cible : <strong>{{ strtoupper($campaign->target_type) }}</strong></p>
                            <p style="font-size: 0.7rem; color: #64748b; margin-bottom: 0;">Envoyé à : <strong>{{ $campaign->sent_count }}</strong> destinataires</p>
                            <p style="font-size: 0.7rem; color: #64748b; margin-top: 5px;">Le : <strong>{{ $campaign->created_at->format('d/m/Y H:i') }}</strong></p>
                        </div>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <button type="submit" style="width: 100%; background: #ff9900; color: #ffffff; border: none; padding: 12px; border-radius: 6px; font-weight: 700; cursor: pointer; transition: background 0.2s;"
                                onmouseover="this.style.background='#e68a00'" onmouseout="this.style.background='#ff9900'">
                            METTRE À JOUR
                        </button>
                        <a href="{{ route('admin.promotions.index') }}" 
                           style="width: 100%; display: block; text-align: center; background: #ffffff; color: #475569; border: 1px solid #cbd5e1; padding: 12px; border-radius: 6px; font-weight: 700; text-decoration: none; font-size: 0.9rem;"
                           onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#ffffff'">
                            ANNULER
                        </a>
                    </div>

                </div>

            </div>
        </form>

    </div>
</div>
@endsection
