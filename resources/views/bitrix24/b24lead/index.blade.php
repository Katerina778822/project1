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
                <th>Заголовок</th>
                <th>Источник</th>
                <th>Статус</th>
                <th>Компания</th>
                <th>Контакт</th>
                <th>Ответственный</th>
                <th>К-во сделок</th>
                <th>Сумма продаж</th>
                <th>UTM_SOURCE</th>
                <th>UTM_MEDIUM</th>
                <th>UTM_CAMPAIGN</th>
                <th>UTM_CONTENT</th>
                <th>UTM_TERM</th>
            </tr>
        </thead>
        <tbody>
            @if(count($items))
            @foreach($items as $item)
            <tr>
                <td>{{$item['NAME']}}</td>
                <td>{{$item['LAST_NAME']}}</td>
                <td><a class="btn btn-link" href="{{env('B24_MAIN1_URI').'crm/lead/details/'.$item['ID'].'/'}}" target="_blank">
                                    {{$item['TITLE']}} </a></td>
                <td>{{$item['SOURCE_ID']}}</td>
                <td>{{$item['STATUS_ID']}}</td>
                <td>{{$item['COMPANY_ID']}}</td>
                <td>{{$item['CONTACT_ID']}}</td>
                <td>{{$item['USER_NAME']}}</td>
                <td>{{$item['DEALS_COUNT']}}</td>
                <td>{{$item['DEALS_SUMM']}}</td>
                <td>{{$item['UTM_SOURCE']}}</td>
                <td>{{$item['UTM_MEDIUM']}}</td>
                <td>{{$item['UTM_CAMPAIGN']}}</td>
                <td>{{$item['UTM_CONTENT']}}</td>
                <td>{{$item['UTM_TERM']}}</td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</x-app-layout>