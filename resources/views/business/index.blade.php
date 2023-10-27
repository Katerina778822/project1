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
                    <th>Name</th>
                    <th>Type</th>
                </tr>
            </thead>
            <tbody>
                @if(count($items))
                @foreach($items as $item)
                <tr>
                    <td>{{$item->id}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->type}}</td>
                    @if(auth()->user()->can('role.edit'))
                    <td>
                        <x-button_blue class="">
                            <a class="" href="{{ route('business.edit', ['business' => $item]) }}">
                                {{ __('Edit') }}</a>
                        </x-button_blue>
                    </td>
                    @endif
                    @if(auth()->user()->can('business.delete'))
                    <td>

                        <form action="{{ route('business.destroy', [$item->id])}} " method="post" style="display: inline-block">
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
        @if(auth()->user()->can('business.add'))
        <x-button_green class="ml-2">
            <a class="btn btn-link" href="{{ route('business.create') }}">
                {{ __('Create new business') }}</a>
        </x-button_green>
        @endif



    </div>



</x-app-layout>