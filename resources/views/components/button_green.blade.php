<button {{ $attributes->merge(['type' => 'submit', 'class' => 'block rounded-md bg-lime-500 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-lime-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-lime-600']) }}>
    {{ $slot }}
</button>