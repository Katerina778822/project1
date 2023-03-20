<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Selector Dashboard') }}
        </h2>
    </x-slot>
    <div class="container">
        <form method="post" action="{{ route('selector.update',[ $selector->id]) }}">
            {{csrf_field()}}
            {{ method_field('put')}}
            @include('partial.error')
            <div class="container mx-auto px-4 p-6 ">
                <table>
                    <tbody>
                        @if(!empty($selector))
                        <tr>
                            <th>Name</th>
                            <td>
                                <input type="text" class="field-main" id="name" name="name" value="{{$selector->name}}">
                            </td>
                        </tr>
                        <tr>
                            <th>Value</th>
                            <td>
                                <input type="text" class="field-main" id="value" name="value" value="{{$selector->value}}">
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
                <button class="btn-main">Submit</button>
            </div>
 
        </form>
</x-app-layout>