{{$activeDeal->TITLE }}
<div>
    Тип сделки {{$activeDeal->getTypeDeal()->name}}
</div>
<div class=" border-gray-700 border-2 w-full p-2 bg-gray-100">
    <div class="grid grid-cols-4 gap-4" loop={{$loop=1}}>
        @for($i=$activeDeal->type; $i<20+$activeDeal->type; $i=$i+5) <div class="flex flex-col">
            <div class="flex flex-row  justify-center basis-11/12">
                <form method="POST" action="{{ route('event.store') }}" class="flex  basis-11/12  justify-end">
                    @csrf
                    <input type="hidden" name="typeEvent" value="{{ $i+5 }}">
                    <input type="hidden" name="deal_id" value="{{ $activeDeal->id1 }}">
                    <x-jame.stage-button :design=5  :stage="$i+5 <= $activeDeal->event ? 1 : 0"> 
                 
                        @if($loop ==1)
                         Просчет
                         @elseif ($loop == 2)
                          КП
                        @elseif ($loop == 3) 
                        Заказ
                        @else
                        Деньги
                         @endif
                    </x-jame.stage-button>
                </form>
                <form method="POST" action="{{ route('dashboard') }}">
                    @csrf
                    <input type="hidden" name="scrypt_button_id" value="{{ $i+5 }}">
                    <x-jame.stage-button :design=6>
                        C
                    </x-jame.stage-button>
                </form>
            </div>
            <div class="flex flex-row  justify-center basis-10/12">
                <form method="POST" action="{{ route('event.store') }}" class="flex  basis-10/12  justify-end">
                    @csrf
                    <input type="hidden" name="typeEvent" value="{{ $i+4 }}">
                    <input type="hidden" name="deal_id" value="{{ $activeDeal->id1 }}">
                    <x-jame.stage-button :design=4  :stage="$i+4 <= $activeDeal->event ? 1 : 0"> 
                        Закрытие
                    </x-jame.stage-button>
                </form>
                <form method="POST" action="{{ route('dashboard') }}">
                    @csrf
                    <input type="hidden" name="scrypt_button_id" value="{{ $i+4 }}">
                    <x-jame.stage-button :design=6>
                        C
                    </x-jame.stage-button>
                </form>
            </div>
            <div class="flex flex-row  justify-center basis-9/12">
                <form method="POST" action="{{  route('event.store') }}" class="flex  basis-9/12  justify-end">
                    @csrf
                    <input type="hidden" name="typeEvent" value="{{ $i+3 }}">
                    <input type="hidden" name="deal_id" value="{{ $activeDeal->id1 }}">
                    <x-jame.stage-button :design=3  :stage="$i+3 <= $activeDeal->event ? 1 : 0"> 
                        Презентация
                    </x-jame.stage-button>
                </form>
                <form method="POST" action="{{ route('dashboard') }}">
                    @csrf
                    <input type="hidden" name="scrypt_button_id" value="{{ $i+3 }}">
                    <x-jame.stage-button :design=6>
                        C
                    </x-jame.stage-button>
                </form>
            </div>
            <div class="flex flex-row  justify-center basis-8/12">
                <form method="POST" action="{{  route('event.store') }}" class="flex  basis-8/12  justify-end">
                    @csrf
                    <input type="hidden" name="typeEvent" value="{{ $i+2 }}">
                    <input type="hidden" name="deal_id" value="{{ $activeDeal->id1 }}">
                    <x-jame.stage-button :design=2  :stage="$i+2 <= $activeDeal->event ? 1 : 0"> 
                        Потребности
                    </x-jame.stage-button>
                </form>
                <form method="POST" action="{{ route('dashboard') }}">
                    @csrf
                    <input type="hidden" name="scrypt_button_id" value="{{ $i+2 }}">
                    <x-jame.stage-button :design=6>
                        C
                    </x-jame.stage-button>
                </form>
            </div>
            <div class="flex flex-row  justify-center basis-7/12">
                <form method="POST" action="{{  route('event.store') }}" class="flex  basis-7/12  justify-end">
                    @csrf
                    <input type="hidden" name="typeEvent" value="{{ $i+1 }}">
                    <input type="hidden" name="deal_id" value="{{ $activeDeal->id1 }}">
                    <x-jame.stage-button :design=1  :stage="$i+1 <= $activeDeal->event ? 1 : 0"> 
                        Открытие
                    </x-jame.stage-button>
                </form>
                <form method="POST" action="{{ route('dashboard') }}">
                    @csrf
                    <input type="hidden" name="scrypt_button_id" value="{{ $i+1 }}">
                    <x-jame.stage-button :design=6>
                        C
                    </x-jame.stage-button>
                </form>
            </div>
    </div loop={{$loop++}}>
    @endfor
</div>
</div>