<x-app-layout>
<x-slot name="header">
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{('Bitrix24') }}
        </h2>
    </x-slot>
    <div>
        <div>           
            <div class="bg-blue-300 rounded-lg  p-8">
                <form action="{{ route('bitrix24.company.index') }}">
                    <button class="btn-main my-4">Создать новый узелq</button>
                </form>
                <form action="{{ route('node.index') }}">
                    <button class="btn-main">Смотреть сохраненные узлы</button>
                </form>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>