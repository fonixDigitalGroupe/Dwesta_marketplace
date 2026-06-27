{{-- Champ d'upload de document (photo). Variables : $name, $label --}}
<label class="pt-card" style="display:flex;align-items:center;gap:12px;padding:16px;margin-top:12px;cursor:pointer;"
       x-data="{ nom: '' }">
    <span class="ic" style="font-size:18px;">📷</span>
    <span style="flex:1;color:#94A3B8;font-size:15px;">
        <span x-show="!nom">{{ $label }}</span>
        <span x-show="nom" x-text="nom" style="color:#fff;"></span>
    </span>
    <span style="color:var(--karnou-orange);font-weight:600;font-size:14px;">Choisir</span>
    <input type="file" name="{{ $name }}" accept="image/*" capture="environment" hidden
           @change="nom = $event.target.files[0]?.name || ''">
</label>
