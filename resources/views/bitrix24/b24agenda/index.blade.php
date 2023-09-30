<x-app-layout>
    <x-slot name="header">
        <div class="flex ">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mx-4">
                <a href="{{ route('raport.index') }}" class="btn-main">Создать отчет</a>
            </h2>
        </div>
    </x-slot>
    <table class="table table-hover ">
        <thead>
            <tr>
                <th>Имя</th>
                <th>Фамилия</th>
                <th>Создать Расписание</th>
                <th>Смотреть Расписание</th>
                <th>Смотреть Отчет</th>
                <th>Смотреть</th>
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
                <td>
                    <form action="{{ route('raport.show', ['raport' => $item['ID']]) }}" method="GET">
                    <button class="btn-link">Смотреть</button>
                    <input type="date" class="w-18 h-2 text-xs" id="date" name="date">
                    <input type="date" class="w-18 h-2 text-xs" id="dateEnd" name="dateEnd">
                </form>
                        <td>
                            <a href="{{ route('company.show', ['company' => $item['ID']]) }}">
                                <x-button>
                                    Компания
                                </x-button>
                            </a>
                        </td>
                </td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</x-app-layout>
