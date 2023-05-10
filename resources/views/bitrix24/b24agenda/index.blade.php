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
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Имя</th>
                <th>Фамилия</th>
                <th>Создать Расписание</th>
                <th>Смотреть Расписание</th>



            </tr>
        </thead>
        <tbody>
            @if(count($items))
            @foreach($items as $item)
            <tr>
                <td>{{$item['NAME']}}</td>
                <td>{{$item['LAST_NAME']}}</td>
                <td> <a class="btn btn-link" href="{{ route('agenda.edit', ['agenda' => $item['ID']]) }}">
                        Создать </a></td>
                <td> <a class="btn btn-link" href="{{ route('agenda.show', ['agenda' => $item['ID']]) }}">
                        Смотреть
                    </a></td>


            </tr>
            @endforeach
            @endif
        </tbody>

    </table>
</x-app-layout>