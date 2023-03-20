<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="container">
        <a class="btn btn-default" href="{{route('good.create')}}">Create</a>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>art</th>
                    <th>URL</th>
                    <th>fid_id_good</th>
                    <th>-----</th>

                    <th></th>
                </tr>
            </thead>
            <tbody>
                @if(count($goods))
                @foreach($good as $good)
                <tr>
                    <td>{{$good->id}}</td>
                    <td>
                        <a class="btn btn-link" href="{{route('good.show',[$good->id])}}">
                            {{$good->value}}
                        </a>
                    </td>
                    <td>
                        <p class="bg-success">{{$good->fid_id_catalog}}</p>
                    </td>
                    <td>
                        <p class="bg-danger">------</p>
                    </td>

                    <td>

                        <a class="btn btn-default" href="{{route('good.edit',[$good->id])}}">Edit</a>

                    </td>
                    <td>
                        <form method="post" action="{{route('good.destroy',[$good->id])}}">
                            {{csrf_field()}}
                            {{method_field('delete')}}
                            <input type="submit" value="Delete" class="btn btn-danger">
                        </form>


                    </td>
                    <td>
                    <form method="post" action="{{route('good.show',[$good->id])}}">
                            {{csrf_field()}}
                          <input type="submit" value="Смотреть Каталог">
                        </form>
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>

        </table>

    </div>

</x-app-layout>