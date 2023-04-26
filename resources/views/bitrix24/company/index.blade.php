
<x-app-layout>
    <x-slot name="header">
        <div class="flex">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex-initial">
                {{ __('Bitrix24 Dashboard') }}
            </h2>
            <form class="flex-initial" >
                <p><button class="btn-main" type="submit"> Companies</button>
                </p>
            </form>
        </div>
    </x-slot>
    <div class="container mx-auto px-4 p-6 ">
        <table>
            <thead>
                <tr>
                    <th>N</th>
                    <th>ID</th>
                    <th>TITLE</th>
                    <th>COMMENTS</th>
                    <th>DATE_CREATE</th>
                    <th>DATE_MODIFY</th>

                    <th></th>
                </tr>
            </thead>
            <tbody class="border-separate">
                @if(isset   ($companies))
                @foreach($companies as $companie)
                <tr class="border-separate">
                    <td>{{$loop->iteration}}</td>
                    <td>{{$companie->ID}}</td>
                    <td>
                    <a class="btn btn-link" href="{{env('B24_MAIN1_URI').'crm/company/details/'.$companie->ID.'/'}}">
                        {{$companie->TITLE}}
                    </a>
                    </td>
                    <td>
                        <p>{{$companie->COMMENTS}}</p>
                    </td>
                    <td>
                        <p class="bg-danger">{{$companie->DATE_CREATE}}</p>
                    </td>
                    <td>
                        <p class="bg-danger">{{$companie->DATE_MODIFY}}</p>
                    </td>


                </tr>
                @endforeach
               
                @endif
               
            </tbody>

        </table>
     


    </div>

</x-app-layout>