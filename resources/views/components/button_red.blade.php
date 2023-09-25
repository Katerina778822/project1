<button {{ $attributes->merge(['type' => 'submit', 'class' => 'rounded-md bg-red-50 px-3 py-2 text-sm font-semibold text-red-600 shadow-sm hover:bg-red-300']) }}>
    {{ $slot }}
</button>

