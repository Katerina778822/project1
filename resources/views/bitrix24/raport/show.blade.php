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
                
                <!-- errorUpdateData  -->
                @if(!empty($errorUpdateData))
                <div class="text-xl text-red-500">
                    <p>  {{$errorUpdateData->string1}} </p>
                    <p>  {{$errorUpdateData->text1}} </p>
                    <p> {{$errorUpdateData->date1}} </p>
                </div>
                @endif
                <!-- error raport Contact withowt Company  -->
                @if(!empty($errorContact))
                <div class="text-xl text-red-500">
                    ЛИД без компании!
                    <p>ID {{$errorContact->string1}} </p>
                    <p>Имя {{$errorContact->string2}} </p>
                    <p>Дата {{$errorContact->date1}} </p>
                </div>
                @endif
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
                <!--All Users Main Raport -->
                @if(!empty($allUsersmainRaports))
                @foreach($allUsersmainRaports as $allUsersmainRaport)
                <table class="table table-hover w-full">
                    <thead>
                        <tr>
                            <th>ФИО</th>
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
                        @foreach($allUsersmainRaport as $mainRaport)
                        <tr class="bg-indigo-400">
                            <td>{{$mainRaport->USER}}</td>
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
                @endforeach
                @endif

            </div>
        </div>
    </x-slot>
</x-app-layout>