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
                    <th>Дата</th>  
                    <th>Количество</th>  
                </tr>
            </thead>
            <tbody>
                @if(count($items))
                @foreach($items as $item)
                <tr>
                    <td><a class="btn btn-link" href="{{ route('b24analitics_companies_date.show',[$item]) }}">{{$item}}</a>                  
                    <td>{{$counts[$item]}}                
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
</x-app-layout>