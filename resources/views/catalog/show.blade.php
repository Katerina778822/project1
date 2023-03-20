<x-app-layout>
    <x-slot name="header">
        <div class="flex">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex-initial  ">
                {{ __('Dashboard') }}
                @if(!empty($id_node))
            </h2>
            <a class="btn-main" href="{{route('catalog.edit',[$id_node])}}" class="flex-initial pl-2">Create catalog</a>
            <form class="flex-initial" action="{{route('catalog.destroy',[$id_node])}}" method="post">
                @method('DELETE')
                {{csrf_field()}}
                <button class="btn-del" type="submit">Delete All Catalogs</button>
            </form>
            <form class="flex-initial" action="{{route('catalog.destroyAllNode',[$id_node])}}">
                <button class="btn-del" type="submit">Delete All Goods</button>
            </form>
            @endif
        </div>


    </x-slot>
    <div class="container p-4 ">
        <form method="post" action="{{route('catalog.update',[$id_node])}}">
            @method('PUT')
            {{csrf_field()}}
            <table>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Value</th>
                        <th>URL</th>
                        <th>Progress</th>
                        <th>Disable</th>
                        <th>Node id</th>
                        <th>Created</th>
                        <th>Updated</th>
                        <th>Q-ty:
                            @if(count($catalogs))
                                {{count($catalogs)}}
                            @endif
                        </th>
                        <th><form></form></th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($catalogs))
                    @foreach($catalogs as $catalog)
                    <tr>
                        <td>{{$catalog->id}}</td>
                        <td>
                            <p class="bg-success">{{$catalog->value}}</p>
                        </td>
                        <td>
                            <a href="{{$catalog->url}}" target="_blank">{{$catalog->url}}</a>
                        </td>
                        <td>
                            <p class="bg-danger">{{$catalog->branch_progress_good}}</p>
                        </td>
                        <td>
                            <input class="btn-main p-0" type="checkbox" name="{{$catalog->id}}" @if($catalog->branch_progress_good==-1) checked @endif
                            ></input>
                        </td>
                        <td>
                            <p class="bg-danger">{{$catalog->fid_id_node}}</p>
                        </td>
                        <td>
                            <p class="bg-danger">{{$catalog->createdAt}}</p>
                        </td>
                        <td>
                            <p class="bg-danger ">{{$catalog->updatedAt}}</p>
                        <td>@if(!empty($catalog->id))
                            <form class="flex-initial" action="{{route('goods.edit',[$catalog->id])}} ">
                                <p><button class="btn-main p-0" type="submit">Create goods</button>
                                </p>
                            </form>
                        </td>
                        <td>
                            @if(count(App\Models\Goods::where('fid_id_catalog',$catalog->id)->get()))
                            <form class="flex-initial" action="{{route('goods.show',[$catalog->id])}} ">
                                <p><button class="btn-main p-0" type="submit">Show goods</button>
                                </p>
                                @endif
                            </form>
                            @endif
                        </td>

                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
            <p><button class="btn-main" type="submit">Submit</button>
            </p>
        </form>
    </div>
</x-app-layout>