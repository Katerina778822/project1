        <x-app-layout>
            <x-slot name="header">
                <div class="font-sans text-2xl">
                    Geleon<span style="vertical-align:30%"> &reg </span>   presentation technology 2023   
                </div>
            </x-slot>

            <div>
                @foreach($goods as $good)
                <div>
                    @if(!empty($good->name))


                    <h1 class="text-2xl font-bold m-2">{{$good->name}}</h1>

                    @endif
                    @if(!empty($good->fotos))
                    <?php
                    $imgs = explode(',', $good->fotos);
                    $iterator = 1;
                    ?>
                    <div class="flex items-stretch border-sky-400 ">


                        @foreach($imgs as $img)
                        @if(!empty($img))

                        @if($iterator==1)
                        <div class="flex-none m-2 border-sky-200 border-2 shadow-xl rounded ">
                            <img src="{{ $img ?? '' }} " width="300">
                            @else
                            <div class="flex-initial self-end m-2 border-sky-400 border-2 shadow-xl rounded ">
                                <img src="{{ $img ?? '' }}" width="300">
                                @endif
                            </div>

                            <?php
                            $iterator++;
                            ?>
                            @endif
                            @endforeach
                        </div>
                        @endif

                        @if(!empty($good->descripttxt))

                        <div contenteditable="true" class="bg-white border p-2 text-blue-900 font-sans m-2 shadow-xl">
                            {{$good->descripttxt}}
                        </div>
                        @endif

                        @if(!empty($good->charact))

                        <div contenteditable="true" class="bg-white border p-2 text-blue-900 font-sans m-2 shadow-xl">
                            {!!$good->charact!!}
                        </div>
                        @endif


                        <p class="text-green-400 m-2">
                        
                            <br>
                            <input class="bg-gray-100 border-none" type="text" value=" {{$good->price??''}}"  style="width: 170px;" watermark="Enter Articul">
                        
                            @if(!empty($good->store))
                        <h3 class="m-2 text-blue-500">{{$good->store}}</h3>
                        @endif
                        </p>
                        <br>
                        <hr>
                    </div>
                    @endforeach

                </div>
        </x-app-layout>