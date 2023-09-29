<x-app-layout>
    <x-slot name="header">
        <div class="flex">

        <x-button_blue class="ml-4">
                <a class="btn btn-link" href="{{ route('B24User.index') }}">
                    {{ __('CRM user') }}</a>
            </x-button_blue>
            <x-button_green class="ml-4">
                <a class="btn btn-link" href="{{ route('user.create') }}">
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
                    <th>Имя</th>
                    <th>Почта</th>
                    <th>Бизнес</th>
                </tr>
            </thead>
            <tbody>
                @if(count($items))
                @foreach($items as $item)
                <tr>
                    <td>{{$item->name}}</td>
                    <td>{{$item['email']}}</td>
                    <td>{{$item['crm_user']}}</td>
                    <td> <a class="btn btn-link" href="{{ route('user.edit', ['user' => $item]) }}">
                            Edit </a></td>
                    <td>
                        <form action="{{ route('user.delete', ['id' => $item['id']]) " method="post" style="display: inline-block">
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