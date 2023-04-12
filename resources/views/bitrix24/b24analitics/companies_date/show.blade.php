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
      
                    <th>Название</th>
                    <th>Ответственный</th>
                    <th>Звонок компании</th>
                    <th>Звонок контакту</th>
                    <th>Дедлайн задачи</th>
                    <th>Закрытие задачи</th>


     
                </tr>
            </thead>
            <tbody>
                @if(count($items))
                @foreach($items as $item)
                <tr>
       
                    <td><a class="btn btn-link" href="{{env('B24_MAIN1_URI').'crm/company/details/'.$item['company_id'].'/'}}">
                        {{$item->companyName}} </a>
                    </td>
                    <td>{{$item['user']}}</td>
                    <td>{{$item['ring']}}</td>
                    <td>{{$item['ringContact']}}</td>
                    <td>{{$item['deadline']}}</td>
                    <td>{{$item['taskCLose']}}</td>                    
                </tr>
                @endforeach
                @endif
            </tbody>

        </table>
</x-app-layout>