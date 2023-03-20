<x-app-layout>
    <x-slot name="header">
    <div    class="flex">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex-initial">
            {{ __('Good Dashboard') }}
        </h2>
        <form class="flex-initial" action="{{route('catalog.show',[$id_node])}}">
            <p><button class="btn-main" type="submit">Watch catalog</button>
            </p>
        </form>
        <form class="flex-initial" action="{{route('goods.destroyAllCatalog',[$goods->first()->fid_id_catalog])}}">
            <p><button class="btn-del" type="submit">Delete All Goods</button>
            </p>
        </form>
        </div>     
    </x-slot>
    <div class="container">
       <table class="table table-hover">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Art</th>
                    <th>URL</th>
                    <th>Catalog id</th>
                    <th>Created</th>
                    <th>Updated</th>
                    <th>Q-ty:
                            @if(count($goods))
                                {{count($goods)}}
                            @endif
                    </th>
                </tr>
            </thead>
            <tbody>
                @if(count($goods))
                @foreach($goods as $good)
                <tr>
                    <td>{{$good->id}}</td>
                    <td>
                        <p class="bg-success">{{$good->art}}</p>
                    </td>
                    <td>
                        <p class="bg-success">{{$good->url}}</p>
                    </td>

                    <td>
                        <p class="bg-danger">{{$good->fid_id_catalog}}</p>
                    </td>
                    <td>
                        <p class="bg-danger">{{$good->createdAt}}</p>
                    </td>
                    <td>
                        <p class="bg-danger">{{$good->updatedAt}}</p>
                    </td>
                    <td>
                    <form class="flex-initial" action="{{route('goods.showdetails',[$good->id])}}">
                            <p><button class="btn-main p-0" type="submit">Detail good</button>
                            </p>
                        </form>
                    </td>
                    <td>
                        <form method="post" action="{{route('goods.destroy',[$good->id])}}">
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