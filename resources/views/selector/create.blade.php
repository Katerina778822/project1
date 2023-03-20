<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Selectors') }}
        </h2>
    </x-slot>

    <section style="background-color:#e0f8ff;">
    @if(isset($selectors))
        <div class="mx-16 p-4">Заполните форму</div>
        <form action="{{ route('selector.store') }}" method="post">
            {{csrf_field()}}
            <fieldset style="max-width: 400px; position: relative; align-content: center;text-align:right;padding-right: 50;">

                <fieldset style="max-width: 350px; position: relative; align-content: center;text-align:right;padding-right: 50;">
                    <legend>Селекторы:</legend>
                    <p><label for="b1">Корневой каталог(b1):</label>
                    @if(isset($selectors->where('name', 'b1')->first()->value))
                        <input class="field-main" type="text" name="b1" id="b1" style="width: 170px;"  value="{{$selectors->where('name', 'b1')->first()->value}}">
                    @else   
                     <input class="field-main" type="text" name="b1" id="b1" style="width: 170px;"  value="">
                    @endif
                </p>
                    <p><label for="b2">Подкаталог(b2):</label>
                    @if(isset($selectors->where('name', 'b2')->first()->value))
                    <input class="field-main" type="text" name="b2" id="b2" style="width: 170px;" value="{{$selectors->where('name', 'b2')->first()->value}}">
                    @else   
                    <input class="field-main"  type="text" name="b2" id="b2" style="width: 170px;">
                    @endif                        
                    </p>
                    <p><label for="b3">Подподкаталог(b3):</label>
                    @if(isset($selectors->where('name', 'b3')->first()->value))
                    <input class="field-main" type="text" name="b3" id="b3" style="width: 170px;" value="{{$selectors->where('name', 'b3')->first()->value}}">
                    @else 
                    <input class="field-main" type="text" name="b3" id="b3" style="width: 170px;">  
                    @endif                       
                    </p>
                    <p><label for="gd">Товар(gd):</label>
                    @if(isset($selectors->where('name', 'gd')->first()->value))
                    <input class="field-main" type="text" name="gd" id="gd" style="width: 170px;" value="{{$selectors->where('name', 'gd')->first()->value}}">
                    @else 
                    <input class="field-main" name="gd" id="gd" style="width: 170px;">  
                    @endif
                  </p>
                    <p><label for="im">Картинки(im):</label>
                    @if(isset($selectors->where('name', 'im')->first()->value))
                    <input class="field-main" type="text" name="im" id="im" style="width: 170px;" value="{{$selectors->where('name', 'im')->first()->value}}">
                    @else 
                    <input class="field-main" type="text" name="im" id="im" style="width: 170px;">  
                    @endif
                 </p>
                    <p><label for="vd">Видео(vd):</label>
                    @if(isset($selectors->where('name', 'vd')->first()->value))
                    <input class="field-main" type="text" name="vd" id="vd" style="width: 170px;" value="{{$selectors->where('name', 'vd')->first()->value}}">
                    @else 
                    <input class="field-main" type="text" name="vd" id="vd" style="width: 170px;">  
                    @endif
                  </p>
                    <p><label for="ds">Описание(ds):</label>
                    @if(isset($selectors->where('name', 'ds')->first()->value))
                    <input class="field-main" type="text" name="ds" id="ds" style="width: 170px;" value="{{$selectors->where('name', 'ds')->first()->value}}">
                    @else 
                    <input class="field-main" type="text" name="ds" id="ds" style="width: 170px;">  
                    @endif
                  </p>
                    <p><label for="ch">Характеристики(ch):</label>
                    @if(isset($selectors->where('name', 'ch')->first()->value))
                    <input class="field-main" type="text" name="ch" id="ch" style="width: 170px;" value="{{$selectors->where('name', 'ch')->first()->value}}">
                    @else 
                    <input class="field-main" type="text" name="ch" id="ch" style="width: 170px;">  
                    @endif
                     </p>
                    <p><label for="cp">Комплектация(cp):</label>
                    @if(isset($selectors->where('name', 'cp')->first()->value))
                    <input class="field-main" type="text" name="cp" id="cp" style="width: 170px;" value="{{$selectors->where('name', 'cp')->first()->value}}">
                    @else 
                    <input class="field-main" type="text" name="cp" id="cp" style="width: 170px;">  
                    @endif
                     </p>
                    <p><label for="nm">Наименование(nm):</label>
                    @if(isset($selectors->where('name', 'nm')->first()->value))
                    <input class="field-main" type="text" name="nm" id="nm" style="width: 170px;" value="{{$selectors->where('name', 'nm')->first()->value}}">
                    @else 
                    <input class="field-main" type="text" name="nm" id="nm" style="width: 170px;">  
                    @endif
                     </p>
                    <p><label for="ar">Артикул(ar):</label>
                    @if(isset($selectors->where('name', 'ar')->first()->value))
                    <input class="field-main" type="text" name="ar" id="ar" style="width: 170px;" value="{{$selectors->where('name', 'ar')->first()->value}}">
                    @else 
                    <input class="field-main" type="text" name="ar" id="ar" style="width: 170px;">  
                    @endif
                     </p>
                    <p><label for="pr">Цена(pr):</label>
                    @if(isset($selectors->where('name', 'pr')->first()->value))
                    <input class="field-main" type="text" name="pr" id="pr" style="width: 170px;" value="{{$selectors->where('name', 'pr')->first()->value}}">
                    @else 
                    <input class="field-main" type="text" name="pr" id="pr" style="width: 170px;">  
                    @endif
                     </p>
                    <p><label for="st">Наличие(st):</label>
                    @if(isset($selectors->where('name', 'st')->first()->value))
                    <input class="field-main" type="text" name="st" id="st" style="width: 170px;" value="{{$selectors->where('name', 'st')->first()->value}}">
                    @else 
                    <input class="field-main" type="text" name="st" id="st" style="width: 170px;">  
                    @endif
                     </p>
                    <p><label for="f1">Фильтр1(f1):</label>
                    @if(isset($selectors->where('name', 'f1')->first()->value))
                    <input class="field-main" type="text" name="f1" id="f1" style="width: 170px;" value="{{$selectors->where('name', 'f1')->first()->value}}">
                    @else 
                    <input class="field-main" type="text" name="f1" id="f1" style="width: 170px;">  
                    @endif
                    </p>
                    <p><label for="f2">Фильтр2(f2):</label>
                    @if(isset($selectors->where('name', 'f2')->first()->value))
                    <input class="field-main" type="text" name="f2" id="f2" style="width: 170px;" value="{{$selectors->where('name', 'f2')->first()->value}}">
                    @else 
                    <input class="field-main" type="text" name="f2" id="f2" style="width: 170px;">  
                    @endif
                    </p>
                    <p><label for="f3">Фильтр3(f3):</label>
                    @if(isset($selectors->where('name', 'f3')->first()->value))
                    <input class="field-main" type="text" name="f3" id="f3" style="width: 170px;" value="{{$selectors->where('name', 'f3')->first()->value}}">
                    @else 
                    <input class="field-main" type="text" name="f3" id="f3" style="width: 170px;">  
                    @endif
                     </p>
                    <p><label for="f4">Фильтр4(f4):</label>
                    @if(isset($selectors->where('name', 'f4')->first()->value))
                    <input class="field-main" type="text" name="f4" id="f4" style="width: 170px;" value="{{$selectors->where('name', 'f4')->first()->value}}">
                    @else 
                    <input class="field-main" type="text" name="f4" id="f4" style="width: 170px;">  
                    @endif
                     </p>
                    <p><label for="f5">Фильтр5(f5):</label>
                    @if(isset($selectors->where('name', 'f5')->first()->value))
                    <input class="field-main" type="text" name="f5" id="f5" style="width: 170px;" value="{{$selectors->where('name', 'f5')->first()->value}}">
                    @else 
                    <input class="field-main" type="text" name="f5" id="f5" style="width: 170px;">  
                    @endif
                    <input class="field-main" class="field-main" type="hidden" name="node_id" id="node_id" value="{{$node_id}}">
                    </p>

                </fieldset>

                <button class="btn-main">Create</button>
            </fieldset>
        </form>
        @endif
    </section>

</x-app-layout>