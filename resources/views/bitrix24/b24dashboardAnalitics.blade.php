<x-app-layout>
    <x-slot name="header">
    <div class="flex ">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight mx-4">
                <a href="first" class="btn-main" >First fetch</a>
            </h2>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mx-4">
                <a href="new" class="btn-main">New data</a>
            </h2>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mx-4">
                <a href="analitics" class="btn-main">Analitics</a>
            </h2>
    </div>  
    
    </x-slot>
    <div>
        <div>
            <div class="bg-blue-300 rounded-lg  p-8">

              
                <form action="{{ ('b24contact.fetchAll') }}" method="POST">
                    <button class="btn-main my-4">Fetch </button>
                    @csrf
                </form>

            </div>

        </div>
    </div>
    </div>
</x-app-layout>