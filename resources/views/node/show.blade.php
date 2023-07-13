<x-app-layout>
    <x-slot name="header">
        <div class="flex">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex-initial pr-2">
                {{('Node') }}
            </h2>
            <form class="flex-initial" action="{{route('node.create')}} ">
                <button class="btn-main" type="submit"> Create Node</button>

                <a class="btn-main" href="{{route('node.edit',[$node->id])}}">Edit Node</a>

                <a class="btn-main" href="{{route('catalog.show',[$node->id])}}">Watch catalog</a>
                <a class="btn-main" href="{{route('catalog.edit',[$node->id])}}">Create catalog</a>
                <a class="btn-main" href="{{route('selector.show',[$node->id])}}">Watch selectors</a>
                <a class="btn-main" href="{{route('selector.createAll',[$node->id])}}">Create selectors</a>
               <!-- <a class="btn-main" href="{{route('exp',[$node->id])}}">Create CSV</a>
                <a class="btn-main" href="{{route('NodeDownload',[$node->id])}}">Download CSV</a>-->
            </form>
            <form class="flex-initial" method="post" action="{{route('exportDataSheet',[$node->id])}}">
                {{csrf_field()}}
                         <button class="btn-main">Upload Goods</button>
            </form>
        </div>
    </x-slot>
    <div class="container mx-auto px-4 p-6 ">
        <table>
            <tbody>
                <tr>
                    <th>Id</th>
                    <td>{{$node->id}}</td>
                </tr>
                <tr>
                    <th>
                        <h2>Name</h2>
                    </th>
                    <td>
                        <h2>{{$node->name}}</h2>
                    </td>
                </tr>
                <tr>
                    <th>URL</th>
                    <td>{{$node->url}}</td>
                </tr>
                <tr>
                    <th>Pagination</th>
                    <td>{{$node->node_paginat_pattern}}</td>
                </tr>
                <tr>
                    <th>Login</th>
                    <td>{{$node->login}}</td>
                </tr>
                <tr>
                    <th>Create Time</th>
                    <td>{{$node->createdAt}}</td>
                </tr>
                <tr>
                    <th>Update Time</th>
                    <td>{{$node->updatedAt}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</x-app-layout>