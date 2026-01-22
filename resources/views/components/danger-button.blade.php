<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-5 py-2.5 bg-gradient-to-r from-red-500 to-pink-500 border border-transparent rounded-xl font-semibold text-sm text-white hover:from-red-600 hover:to-pink-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-[#1e1b2e] shadow-lg shadow-red-500/25 hover:shadow-red-500/40 transition-all duration-300']) }}>
    {{ $slot }}
</button>
