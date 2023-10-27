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
                    @if(auth()->user()->can('B24User.edit'))
                    <td>
                        <x-button_blue class="">
                            <a class="" href="{{ route('B24User.edit', ['B24User' => $item]) }}">
                                {{ __('Edit') }}</a>
                        </x-button_blue>
                    </td>
                    @endif
                    @if(auth()->user()->can('B24User.delete'))
                    <td>
                        <form action="{{ route('B24User.destroy', [$item->ID])}} " method="post" style="display: inline-block">
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
        @if(auth()->user()->can('B24User.add'))
        <x-button_green class="ml-2">
            <a class="btn btn-link" href="{{ route('B24User.create') }}">
                {{ __('Create new crm user') }}</a>
        </x-button_green>
        @endif



    </div>



</x-app-layout>