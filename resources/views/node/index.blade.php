<x-app-layout>
    <x-slot  name="header">
        <div    class="flex">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex-initial">
            {{ __('Node Dashboard') }}
        </h2>
        <form class="flex-initial" action="{{route('node.create')}} ">
            <p><button class="btn-main" type="submit"> Create Node</button>
            </p>
        </form>
        </div>        
    </x-slot>
    <div class="container mx-auto px-4 p-6 ">
        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>URL</th>
                    <th>Pagination</th>
                    <th>Login</th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="border-separate">
                @if(count($nodes))
                @foreach($nodes as $node)
                <tr class="border-separate">
                    <td>{{$node->id}}</td>
                    <td>
                        <a class="text-blue-600" style="text-decoration:underline;" href="{{route('node.show',[$node->id])}}">
                            {{$node->name}}
                        </a>
                    </td>
                    <td>
                        <p >{{$node->url}}</p>
                    </td>
                    <td>
                        <p class="bg-danger">{{$node->node_paginat_pattern}}</p>
                    </td>
                    <td>
                        <p class="bg-danger">{{$node->login}}</p>
                    </td>



                </tr>
                @endforeach
                @endif
            </tbody>

        </table>

    </div>

</x-app-layout>