<button {{ $attributes->merge(['type' => 'submit', 'class' => 'h-[48px] w-full inline-flex items-center justify-center px-6 py-3 bg-[#FF6B00] border border-transparent rounded-2xl font-outfit font-extrabold text-sm text-white tracking-wide hover:bg-[#E65A00] hover:shadow-lg hover:shadow-orange-500/10 focus:outline-none focus:ring-4 focus:ring-[#FF6B00]/20 transition-all duration-200']) }}>
    {{ $slot }}
</button>
