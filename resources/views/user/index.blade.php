<x-app-layout>
    <x-slot name="header">
        <x-userMenu />

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
                    <th>id</th>
                    <th>Имя</th>
                    <th>Почта</th>
                    <th>Роли</th>
                    <th>Бизнес</th>
                    <th>CRM user</th>
                </tr>
            </thead>
            <tbody>
                @if(count($items))
                @foreach($items as $item)
                <tr>
                    <td>{{$item->id}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item['email']}}</td>
                    <td>
                        @foreach($item->roles as $role)
                        {{$role->name}}
                        @if($item->roles->count()>1)
                        |
                        @endif
                        @endforeach
                    </td>
                    <td>{{$item['business_id']}}</td>
                    <td>{{$item->crmUser->NAME??''}}


                    </td>
                    @if(auth()->user()->can('user.edit'))
                    <td>
                        <x-button_blue class="">
                            <a class="" href="{{ route('user.edit', ['user' => $item]) }}">
                                {{ __('Edit') }}</a>
                        </x-button_blue>
                    </td>
                    @endif
                    @if(auth()->user()->can('user.delete'))
                    <td>
                        <form action="{{ route('user.destroy', ['user' => $item['id']]) }}" method="post" style="display: inline-block">
                            @csrf
                            @method('DELETE')

                            <x-button_red class="">
                                {{ __('Delete') }}
                            </x-button_red>
                        </form>
                    </td>
                    @endif
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
        @if(auth()->user()->can('user.add'))
        <x-button_green class="ml-2">
            <a class="btn btn-link" href="{{ route('user.create') }}">
                {{ __('Create new user') }}</a>
        </x-button_green>
        @endif




    </div>



</x-app-layout>