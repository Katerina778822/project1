<x-app-layout>
    <x-slot name="header">
        <div class="flex ">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mx-4">
                <a href="first" class="btn-main">First fetch</a>
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
            <div class="bg-blue-300 rounded-lg  p-8 flex">
                <form action="{{ route('b24contact.analitics.companies_date') }}" method="get">
                    <button class="btn-main my-4">Компании без движения после </button>
                    <input type="date" class="field-main" id="date" name="date">
                    @csrf
                </form>
                <form action="{{ route('b24contact.analitics.companies_date_show') }}" method="get" disabled>
                    <button class="btn-main my-4">Показать </button>
                    @csrf
                </form>
            </div>
        </div>
        <div>
            <div class="bg-blue-300 rounded-lg  p-8 flex">
                <form action="{{ route('b24contact.analitics.companies_cold_date') }}" method="get">
                    <button class="btn-main my-4">Компании без движения после </button>
                    <input type="date" class="field-main" id="date" name="date">
                    @csrf
                </form>
                <form action="{{ route('b24analitics_companies_date.index') }}" method="get" disabled>
                    <button class="btn-main my-4">Показать </button>
                    <input type="date" class="field-main" id="date" name="date">
                    @csrf
                </form>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>