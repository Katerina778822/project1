<x-app-layout>
    <x-slot  name="header">
        <div    class="flex">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex-initial">
            {{ __('Token') }}
        </h2>

        </div>        
    </x-slot>
    <div class="container mx-auto px-4 p-6 ">
        
    <a class="btn-main" href="{{ $authUrl}}">Watch catalog</a>

    </div>

</x-app-layout>