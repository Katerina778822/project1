<x-app-layout>
    <x-slot name="header">
        <div>



        </div>
    </x-slot>

    <x-slot name="slot">

        <div class="container w-12/12 flex justify-center m-2 ">
            <div class=" w-11/12  ">
                <div>cron:{{$cronTime}} /Raport:{{$agendaTime}}</div>
                <div>{{$user}}</div>
                <!-- Main Raport -->
                @if(!empty($mainRaports))
               
                <table class="table table-hover w-full">
                    <thead>
                        <tr>
                            <th>Тип Клиента</th>
                            <th>Суммма</th>
                            <th>Сделки</th>
                            <th>ЛИД(попытки)</th>
                            <th>Конверсия</th>
                            <th>Чек</th>
                            <th></th>

                        </tr>
                    </thead>
                    <tbody>
                    @foreach($mainRaports as $mainRaport)
                        <tr class="bg-indigo-400">
                            <td>{{$mainRaport->DEAL_TYPE}}</td>
                            <td>{{$mainRaport->TOTAL}}</td>
                            <td>{{$mainRaport->DEALS}}</td>
                            <td>{{$mainRaport->LEAD}}</td>
                            <td>{{round($mainRaport->CONVERSION,2)*100}}</td>
                            <td>{{round($mainRaport->CHECK,0)}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
                <!-- Raport -->
                <table class="table table-hover w-full">
                    <thead>
                        <tr>
                            <th>N</th>
                            <th>Компания</th>
                            <th>Сумма</th>
                            <th>Сделка</th>
                            <th>Дело</th>
                            <th>Тип клиента</th>
                            <th>Дата</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($items))
                        @foreach($items as $item)
                        <tr class="bg-indigo-400">
                            <td>{{$loop->iteration}}</td>
                            <td><a class="btn btn-link" href="{{env('B24_MAIN1_URI').'crm/'.($item['URL_TYPE']?'lead':'company').'/details/'.$item['ID'].'/'}}">
                                    {{$item['TITLE']}} </a>
                            </td>
                            <td>{{$item['SUMM']}}</td>
                            <td>{{$item['DEAL_STATUS']}}</td>
                            <td>{{$item['BUSINESS']??0}}</td>
                            <td>{{$item['DEAL_TYPE']??0}}</td>
                            <td>{{$item['DATE']??0}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif


            </div>
        </div>
    </x-slot>
</x-app-layout>