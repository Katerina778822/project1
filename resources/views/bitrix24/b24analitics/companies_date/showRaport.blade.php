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
    <table class="table table-hover">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Ответственный1</th>
                    <th>к-во компаний </th>
                    <th>к-во закрытых успешно сделок</th>
                    <th>к-во отказов и</th>
                    <th>сумма продаж</th>
                    <th>остаток необработанных компаний</th>
     
                </tr>
            </thead>
            <tbody>
                @if(count($items))
                @foreach($items as $item)
                <tr>
                    <td>{{$item->ID}}</td>
                    <td>{{$item->TITLE}}</td>
                    <td>{{$item->NAME}}</td>
                    <td><a class="btn btn-link" href="{{env('B24_MAIN1_URI').'crm/company/details/'.$item->id_item.'/'}}">
                        {{$item->LAST_NAME}} </a>
                    </td>
       
                    
                </tr>
                @endforeach
                @endif
            </tbody>

        </table>
</x-app-layout>