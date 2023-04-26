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
                    <th>к-во компаний с открытой сделкой</th>
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
                    <td> {{$item['ID']}}</td>
                    <td>{{$item['NAME'].' '.$item['LAST_NAME']}}</td>
                    <td><a href="{{ route('b24analitics_companies_date.showColdCompaniesInfo',[$item['COMPANY_ALL']]) }}">
                        {{$item['deals_all']}}</td>
                    <td><a href="{{ route('b24analitics_companies_date.showColdCompaniesInfo',[$item['OPEN_DEAL_COMPANY']]) }}">
                        {{$item['deal_created']}}</td>
                    <td><a href="{{ route('b24analitics_companies_date.showColdCompaniesInfo',[$item['CLOSE_DEAL_COMPANY']]) }}">
                        {{$item['deals_staige_won']}}</td>
                    <td><a href="{{ route('b24analitics_companies_date.showColdCompaniesInfo',[$item['LOOSE_DEAL_COMPANY']]) }}">
                        {{$item['deals_staige_loose']}}</td>
                    <td>
                        {{$item['deals_won_sum']}}</td>
                    <td><a href="{{ route('b24analitics_companies_date.showColdCompaniesInfo',[$item['COLD_DEAL_COMPANY']]) }}">
                        {{$item['company_cold_count']}}</td>
            
 
       
                    
                </tr>
                @endforeach
                @endif
            </tbody>

        </table>
</x-app-layout>