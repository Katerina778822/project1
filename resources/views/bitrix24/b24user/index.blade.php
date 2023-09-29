<x-app-layout>
    <x-slot name="header">
        <div class="flex">

            <x-button_green class="ml-4">
                <a class="btn btn-link" href="{{ route('B24User.create') }}">
                    {{ __('Create') }}</a>
            </x-button_green>
            <x-button_red class="ml-4">

                {{ __('Register') }}

            </x-button_red>
        </div>

    </x-slot>


    <div class="space-y-10 divide-y divide-gray-900/10">
        <!--Вывод сообщения -->
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Фамилия</th>
                    <th>Активен</th>
                  
                </tr>
            </thead>
            <tbody>
                @if(count($items))
                @foreach($items as $item)
                <tr>
                    <td>{{$item->ID}}</td>
                    <td>{{$item->NAME}}</td>
                    <td>{{$item->LAST_NAME}}</td>
                    <td>{{$item->ACTIVE}}</td>
                    <td> <a class="btn btn-link" href="{{ route('B24User.edit', ['B24User' => $item]) }}">
                            Edit </a></td>
                    <td>
                        <form action="{{ route('B24User.delete', ['id' => $item['id']]) " method="post" style="display: inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                   </td>  
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>




    </div>



</x-app-layout>