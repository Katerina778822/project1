<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New node') }}
        </h2>
    </x-slot>

    <section style="background-color:#e0f8ff;">
        <div>Заполните форму</div>
        <form action="{{ route('node.store') }}" method="post">
            {{csrf_field()}}
            <fieldset style="max-width: 400px; position: relative; align-content: center;text-align:right;padding-right: 50;">
                <legend>Введите данные для сохранения узла</legend>
                <p><label for="nodename">Имя Узла:</label>
                    <input class="field-main" type="text" name="nodename" id="nodename" style="width: 170px;" watermark="Enter Node name">
                </p>
                <p><label for="url">Адрес (начиная с htpps):</label>
                    <input class="field-main" type="text" name="url" id="url" style="width: 170px;" watermark="Enter Node name">
                </p>
                <p><label for="paginat">Шаблон страниц (node_paginat_pattern):</label>
                    <input class="field-main" type="text" name="node_paginat_pattern" id="node_paginat_pattern" style="width: 170px;" watermark="Enter Node name">
                </p>
                <fieldset style="max-width: 350px; position: relative; align-content: center;text-align:right;padding-right: 50;">
                    <legend>Селекторы:</legend>
                    <p><label for="b1">Корневой каталог(b1):</label>
                        <input class="field-main" type="text" name="b1" id="b1" style="width: 170px;" watermark="Enter Node name">
                    </p>
                    <p><label for="b2">Подкаталог(b2):</label>
                        <input class="field-main" type="text" name="b2" id="b2" style="width: 170px;" watermark="Enter Node name">
                    </p>
                    <p><label for="b3">Подподкаталог(b3):</label>
                        <input class="field-main" type="text" name="b3" id="b3" style="width: 170px;" watermark="Enter Node name">
                    </p>
                    <p><label for="gd">Товар(gd):</label>
                        <input class="field-main" type="text" name="gd" id="gd" style="width: 170px;" watermark="Enter Node name">
                    </p>
                    <p><label for="im">Картинки(im):</label>
                        <input class="field-main" type="text" name="im" id="im" style="width: 170px;" watermark="Enter Node name">
                    </p>
                    <p><label for="vd">Видео(vd):</label>
                        <input class="field-main" type="text" name="vd" id="vd" style="width: 170px;" watermark="Enter Node name">
                    </p>
                    <p><label for="ds">Описание(ds):</label>
                        <input class="field-main" type="text" name="ds" id="ds" style="width: 170px;" watermark="Enter Node name">
                    </p>
                    <p><label for="ch">Характеристики(ch):</label>
                        <input class="field-main" type="text" name="ch" id="ch" style="width: 170px;" watermark="Enter Node name">
                    </p>
                    <p><label for="cp">Комплектация(cp):</label>
                        <input class="field-main" type="text" name="cp" id="cp" style="width: 170px;" watermark="Enter Node name">
                    </p>
                    <p><label for="nm">Наименование(nm):</label>
                        <input class="field-main" type="text" name="nm" id="nm" style="width: 170px;" watermark="Enter Node name">
                    </p>
                    <p><label for="ar">Артикул(ar):</label>
                        <input class="field-main" type="text" name="ar" id="ar" style="width: 170px;" watermark="Enter Node name">
                    </p>
                    <p><label for="pr">Цена(pr):</label>
                        <input class="field-main" type="text" name="pr" id="pr" style="width: 170px;" watermark="Enter Node name">
                    </p>
                    <p><label for="st">Наличие(st):</label>
                        <input class="field-main" type="text" name="st" id="st" style="width: 170px;" watermark="Enter Node name">
                    </p>
                    <p><label for="f1">Фильтр1(f1):</label>
                        <input class="field-main" type="text" name="f1" id="f1" style="width: 170px;" watermark="Enter Node name">
                    </p>
                    <p><label for="f2">Фильтр2(f2):</label>
                        <input class="field-main" type="text" name="f2" id="f2" style="width: 170px;" watermark="Enter Node name">
                    </p>
                    <p><label for="f3">Фильтр3(f3):</label>
                        <input class="field-main" type="text" name="f3" id="f3" style="width: 170px;" watermark="Enter Node name">
                    </p>
                    <p><label for="f4">Фильтр4(f4):</label>
                        <input class="field-main" type="text" name="f4" id="f4" style="width: 170px;" watermark="Enter Node name">
                    </p>
                    <p><label for="f5">Фильтр5(f5):</label>
                        <input class="field-main" type="text" name="f5" id="f5" style="width: 170px;" watermark="Enter Node name">
                    </p>

                </fieldset>

                <button class="btn-main">Создать</button>
            </fieldset>
        </form>
    </section>

</x-app-layout>