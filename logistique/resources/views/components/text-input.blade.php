@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'h-[48px] border-slate-200 focus:border-[#004AAD] focus:ring-4 focus:ring-[#004AAD]/5 rounded-2xl shadow-sm transition-all']) }}>
