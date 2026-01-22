<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-5 py-2.5 bg-[#221f2e] border border-purple-500/20 rounded-xl font-semibold text-sm text-gray-300 hover:bg-[#2a2640] hover:text-white focus:outline-none focus:ring-2 focus:ring-purple-500/50 disabled:opacity-25 transition-all duration-300']) }}>
    {{ $slot }}
</button>
