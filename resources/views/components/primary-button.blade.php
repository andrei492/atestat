<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-purple-500 to-fuchsia-500 border border-transparent rounded-xl font-semibold text-sm text-white uppercase tracking-wide hover:from-purple-600 hover:to-fuchsia-600 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 focus:ring-offset-[#1e1b2e] shadow-lg shadow-purple-500/25 hover:shadow-purple-500/40 hover:scale-105 transition-all duration-300']) }}>
    {{ $slot }}
</button>
