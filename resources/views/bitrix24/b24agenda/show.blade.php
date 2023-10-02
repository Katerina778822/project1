<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="flex " x-data="{  Tomorrow_cargo: false  }">

                <h2 class="font-semibold text-xl text-gray-800 leading-tight mx-4">
                    <button x-on:click="Tomorrow_cargo = !Tomorrow_cargo; $dispatch('toggle-content', Tomorrow_cargo)" class="btn-main">С делом/Развоз</button>
                </h2>

            </div>
    </x-slot>

    <x-slot name="slot">
        <div class="container w-12/12 flex justify-center m-2 ">
            <div class=" w-11/12  ">
            <div>cron:{{$cronTime}} /Agenda:{{$agendaTime}}</div>
                <!-- Tomorrow  -->
                @if(!empty($itemsTomorrow))
                <table x-data="{ Tomorrow: false }" x-show="Tomorrow" x-on:toggle-content.window="Tomorrow = $event.detail"  class="table table-hover w-full">
                    <thead>
                        <tr>
                            <th>N</th>
                            <th>Id</th>
                            <th>Название</th>
                            <th>Дата</th>
                            <th>Статус сделки</th>
                            <th>Статус клиента</th>
                            <th>Смотреть</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($itemsTomorrow as $item)
                        <tr class="bg-indigo-300">
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item['ID']}}</td>
                            <td><a class="btn btn-link" href="{{env('B24_MAIN1_URI').'crm/'.($item['URL_TYPE']?'lead':'company').'/details/'.$item['ID'].'/'}}">
                                    {{$item['TITLE']}} </a>
                            </td>
                            <td>{{$item['AGENDA_DATE']??0}}</td>
                            <td>{{$item['STATUS']??0}}</td>
                            <td>{{$item['UF_CRM_1540465145514']??0}}</td>
                            <td>
                                <x-button>
                                    <a href="{{ route('company.details', ['company' => $item['ID']]) }}">
                                        Смотреть
                                    </a>
                                </x-button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif

                <!-- Tomorrow РАЗВОЗ -->
                @if(!empty($items28Days))
                <table x-data="{ Tomorrow_cargo: false }" x-show="Tomorrow_cargo" x-on:toggle-content.window="Tomorrow_cargo = $event.detail"  class="table table-hover w-full">
                    <thead>
                        <tr>
                            <th>N</th>
                            <th>Id</th>
                            <th>Название</th>
                            <th>Дата</th>
                            <th>Статус сделки</th>
                            <th>Статус клиента</th>
                            <th>Смотреть</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items28Days as $item)
                        <tr class="bg-indigo-400">
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item['ID']}}</td>
                            <td><a class="btn btn-link" href="{{env('B24_MAIN1_URI').'crm/'.($item['URL_TYPE']?'lead':'company').'/details/'.$item['ID'].'/'}}" target="_blank">
                                    {{$item['TITLE']}} </a>
                            </td>
                            <td>{{$item['AGENDA_DATE']??0}}</td>
                            <td>{{$item['STATUS']??0}}</td>
                            <td>{{$item['UF_CRM_1540465145514']??0}}</td>
                            <td>
                                <x-button>
                                    <a href="{{ route('company.details', ['company' => $item['ID']]) }}">
                                        Смотреть
                                    </a>
                                </x-button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif

                <!-- Today -->
                @if(!empty($itemsToday))
                <table class="table table-hover w-full">
                    <thead>
                        <tr>
                            <th>N</th>
                            <th>Id</th>
                            <th>Название</th>
                            <th>Дата</th>
                            <th>Статус сделки</th>
                            <th>Статус клиента</th>
                            <th>Смотреть</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($itemsToday as $item)
                        <tr class="bg-green-200">
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item['ID']}}</td>
                            <td><a class="btn btn-link" href="{{env('B24_MAIN1_URI').'crm/'.($item['URL_TYPE']?'lead':'company').'/details/'.$item['ID'].'/'}}" target="_blank">
                                    {{$item['TITLE']}} </a>
                            </td>
                            <td>{{$item['AGENDA_DATE']??0}}</td>
                            <td>{{$item['STATUS']??0}}</td>
                            <td>{{$item['UF_CRM_1540465145514']??0}}</td>
                            <td>
                                <x-button>
                                    <a href="{{ route('company.details', ['company' => $item['ID']]) }}">
                                        Смотреть
                                    </a>
                                </x-button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
                <!-- 60 days deal -->
                @if(!empty($items60Days))
                <table class="table table-hover w-full">
                    <thead>
                        <tr>
                            <th>N</th>
                            <th>Id</th>
                            <th>Название</th>
                            <th>Дата</th>
                            <th>Статус сделки</th>
                            <th>Статус клиента</th>
                            <th>Смотреть</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items60Days as $item)
                        <tr class="bg-red-200">
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item['ID']}}</td>
                            <td><a class="btn btn-link" href="{{env('B24_MAIN1_URI').'crm/'.($item['URL_TYPE']?'lead':'company').'/details/'.$item['ID'].'/'}}" target="_blank">
                                    {{$item['TITLE']}} </a>
                            </td>
                            <td>{{$item['AGENDA_DATE']??0}}</td>
                            <td>{{$item['STATUS']??0}}</td>
                            <td>{{$item['UF_CRM_1540465145514']??0}}</td>
                            <td>
                                <x-button>
                                    <a href="{{ route('company.details', ['company' => $item['ID']]) }}">
                                        Смотреть
                                    </a>
                                </x-button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif

                <!-- itemsYesterday -->
                @if(!empty($itemsYesterday))
                <table class="table table-hover w-full">
                    <thead>
                        <tr>
                            <th>N</th>
                            <th>Id</th>
                            <th>Название</th>
                            <th>Дата</th>
                            <th>Статус сделки</th>
                            <th>Статус клиента</th>
                            <th>Смотреть</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($itemsYesterday as $item)
                        <tr class="bg-red-400">
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item['ID']}}</td>
                            <td><a class="btn btn-link" href="{{env('B24_MAIN1_URI').'crm/'.($item['URL_TYPE']?'lead':'company').'/details/'.$item['ID'].'/'}}" target="_blank">
                                    {{$item['TITLE']}} </a>
                            </td>
                            <td>{{$item['AGENDA_DATE']??0}}</td>
                            <td>{{$item['STATUS']??0}}</td>
                            <td>{{$item['UF_CRM_1540465145514']??0}}</td>
                            <td>
                                <x-button>
                                    <a href="{{ route('company.details', ['company' => $item['ID']]) }}">
                                        Смотреть
                                    </a>
                                </x-button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
                <!-- itemsCold -->
                @if(!empty($itemsCold))
                <table class="table table-hover w-full">
                    <thead>
                        <tr>
                            <th>N</th>
                            <th>Id</th>
                            <th>Название</th>
                            <th>Дата</th>
                            <th>Статус сделки</th>
                            <th>Статус клиента</th>
                            <th>Смотреть</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($itemsCold as $item)
                        <tr class="bg-red-600">
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item['ID']}}</td>
                            <td><a class="btn btn-link" href="{{env('B24_MAIN1_URI').'crm/'.($item['URL_TYPE']?'lead':'company').'/details/'.$item['ID'].'/'}}" target="_blank">
                                    {{$item['TITLE']}} </a>
                            </td>
                            <td>{{$item['AGENDA_DATE']??0}}</td>
                            <td>{{$item['STATUS']??0}}</td>
                            <td>{{$item['UF_CRM_1540465145514']??0}}</td>
                            <td>
                                <x-button>
                                    <a href="{{ route('company.details', ['company' => $item['ID']]) }}">
                                        Смотреть
                                    </a>
                                </x-button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </x-slot>
</x-app-layout>
