<x-app-layout>
    <x-slot name="header">
        <div class="flex">

        </div>
    </x-slot>
    <div class="container">
        <section>
            <br>
            <form action="{{ route('GoodsPresenter.PresentGoods' )}}" method="post">
                {{csrf_field()}}
                <fieldset style="max-width: 400px; position: relative; align-content: center;text-align:right;padding-right: 50;">
                    <legend>Введите Артикулы товаров для вывода</legend>
                    <form class="flex-initial" action="{{route('GoodsPresenter.formAdd')}}" method="post">
                        {{csrf_field()}}
                        @for ($i = 1; $i <= 10; $i++) <p>
                            <label for="art">Артикул-{{$i}}</label>
                            <input class="field-main" type="text" name="art{{$i}}" style="width: 170px;" watermark="Enter Articul">
                            </p>
                            @endfor
                    </form>
                    <br>
                    <button class="btn-main" type="submit">Создать</button>
                    @isset($arts)
                    @endisset
                </fieldset>
            </form>


    </div>
</x-app-layout>