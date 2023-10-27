<button {{ $attributes->merge([
    'type' => 'submit', 
    'class' =>' mx-1 mt-1  py-1   border border-transparent rounded-md 
      text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none 
      focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 '. $class,   
      ]) }}>
    {{ $slot }}
</button>
