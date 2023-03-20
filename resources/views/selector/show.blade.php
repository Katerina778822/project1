<x-app-layout>
    <x-slot name="header">
        <div class="flex">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex-initial pr-2">
                {{ __('Selector') }}
            </h2>
            @if(count($selectors))
            <a class="btn-main" href="{{route('selector.createAll',[$selectors->first()->fid_id_node])}}">Create selectors</a>
            <a class="btn-main" href="{{route('node.show',[$selectors->first()->fid_id_node])}}">Watch Node</a>
            @endif
        </div>
    </x-slot>
    <div class="container mx-auto p-4 ">
        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Value</th>
                    <th>Node Id</th>
                    <th>Create time</th>
                    <th>Update time</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @if(count($selectors))
                @foreach($selectors as $selector)
                <tr>
                    <td>{{$selector->id??0}}</td>
                    <td>
                        <p class="bg-success">{{$selector->name}}</p>
                    </td>
                    <td>
                        <p class="bg-success">{{$selector->value}}</p>
                    </td>
                    <td>
                        <p class="bg-danger">{{$selector->fid_id_node}}</p>
                    </td>

                    <td>
                        <p class="bg-danger">{{$selector->createdAt}}</p>
                    </td>
                    <td>
                        <p class="bg-danger">{{$selector->updatedAt}}</p>
                    <td>@isset($selector->id)
                        <form  action="{{route('selector.edit',[$selector->id])}}">
                        
                            <input type="submit" value="Edit selector" class="btn-main">
                        </form>
                        @endisset
                    </td>
                    <td>
                        <form method="post" action="{{route('selector.destroy',[$selector->id])}}">
                            {{csrf_field()}}
                            {{method_field('delete')}}
                            <input type="submit" value="Delete" class="btn-del">
                        </form>
                    </td>

                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>



</x-app-layout>