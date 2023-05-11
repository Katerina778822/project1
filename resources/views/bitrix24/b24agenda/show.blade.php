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
    <table class="table table-hover ">
        <thead >
            <tr >
                <th>N</th>
                <th>Id</th>
                <th>Название</th>
                <th>Дата</th>
            </tr>
        </thead>
        <tbody >
            @if(count($items))
            @foreach($items as $item)
            @if($item['STATUS']==0)
            <tr class="bg-indigo-300">
                <td>{{$loop->iteration}}</td>
                <td>{{$item['ID']}}</td>
                <td><a class="btn btn-link" href="{{env('B24_MAIN1_URI').'crm/'.($item['URL']?'lead':'company').'/details/'.$item['ID'].'/'}}">
                        {{$item['TITLE']}} </a>
                </td>
                <td>{{$item['AGENDA_DATE']??0}}</td>
            </tr>
            @endif
            @if($item['STATUS']==1)
            <tr class="bg-green-200">
                <td>{{$loop->iteration}}</td>
                <td>{{$item['ID']}}</td>
                <td><a class="btn btn-link" href="{{env('B24_MAIN1_URI').'crm/'.($item['URL']?'lead':'company').'/details/'.$item['ID'].'/'}}">
                         {{$item['TITLE']}} </a>
                </td>
                <td>{{$item['AGENDA_DATE']??0}}</td>
            </tr>
            @endif
            @if($item['STATUS']==2)
            <tr class="bg-red-200">
                <td>{{$loop->iteration}}</td>
                <td>{{$item['ID']}}</td>
                <td><a class="btn btn-link" href="{{env('B24_MAIN1_URI').'crm/company/details/'.$item['ID'].'/'}}">
                        {{$item['TITLE']}} </a>
                </td>
                <td>{{$item['AGENDA_DATE']??0}}</td>
            </tr>
            @endif
            @if($item['STATUS']==3)
            <tr class="bg-red-400">
                <td>{{$loop->iteration}}</td>
                <td>{{$item['ID']}}</td>
                <td><a class="btn btn-link" href="{{env('B24_MAIN1_URI').'crm/company/details/'.$item['ID'].'/'}}">
                        {{$item['TITLE']}} </a>
                </td>
                <td>{{$item['AGENDA_DATE']??0}}</td>
            </tr>
            @endif
            @if($item['STATUS']==4)
            <tr class="bg-red-600">
                <td>{{$loop->iteration}}</td>
                <td>{{$item['ID']}}</td>
                <td><a class="btn btn-link" href="{{env('B24_MAIN1_URI').'crm/company/details/'.$item['ID'].'/'}}">
                        {{$item['TITLE']}} </a>
                </td>
                <td>{{$item['AGENDA_DATE']??0}}</td>
            </tr>
            @endif

            @endforeach
            @endif
        </tbody>

    </table>
</x-app-layout>