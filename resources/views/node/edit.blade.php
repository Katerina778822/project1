<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="container mx-auto px-4 p-6 ">
        <form method="post" action="{{ route('node.update',[ $node->id]) }}">
            {{csrf_field()}}
            {{ method_field('put')}}
            @include('partial.error')
            <div>
                <table>
                    <tbody>
                        @if(!empty($node))
                        <tr>
                            <th>Name</th>
                            <td>
                                <input type="text" class="field-main" id="name" name="name" value="{{$node->name}}">
                            </td>
                        </tr>
                        <tr >
                            <th>URL</th>
                            <td>
                                <input type="text" class="field-main" id="url" name="url" value="{{$node->url}}">
                            </td>
                        </tr>
                        <tr>
                            <th>Pagination</th>
                            <td>
                                <input type="text" class="field-main" id="page" name="node_paginat_pattern" value="{{$node->node_paginat_pattern}}">
                            </td>
                            <th>Login</th>
                            <td>
                                <input type="text" class="field-main" id="login" name="login" value="{{$node->login}}">
                            </td>
                            <th>Password</th>
                            <td>
                                <input type="password" class="field-main" id="pass" name="pass" value="{{$node->pass}}">
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <input type="submit" class="btn-main" value="Submit">
        </form>
    </div>

</x-app-layout>