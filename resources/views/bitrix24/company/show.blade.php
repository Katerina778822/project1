<x-company>
<div class="flex justify-center">
    <!-- Centered block -->
    <div class="w-full max-w-md">
        <!-- Displaying the session message -->
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <p class="mt-1 text-sm leading-6 text-gray-600"> </p>

        <!-- Displaying validation errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />
    </div>
</div>

    <div>
        Компания {{$company->ID}} Название {{$company->TITLE}}
    </div>
    <form method="POST" action="{{ route('dashboard') }}" class="flex  basis-11/12  justify-end">
        @csrf
        <input type="hidden" name="stage_button_id" value="{{ -1}}">
        @if(auth()->user()->can('deal.add'))
        <x-button_green class="ml-2">
            <a class="btn btn-link" href="{{ route('dashboard') }}">
                {{ __('Create new deal') }}</a>
        </x-button_green>
        @endif
    </form>
    @foreach($activeDeals as $activeDeal)
    <x-jame.deal :active-deal="$activeDeal" />

    <!-- Вывод задачи -->
    @if($activeDeal->task)
    <div>
        <form class="bg-gray-200 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2 items-center justify-center" method="post" action="{{ route('task.update', ['task' => $activeDeal->task->id]) }}" style="display: flex; flex-wrap: nowrap; align-items: center;">

            <div class="items-center justify-center border-t border-gray-900/10 " style="display: flex;">
                <div class="flex" style="flex-grow: 1;">
                    @csrf
                    @method('PUT')
                    <!-- description -->
                    <x-input id="description"  class="w-full max-w-none" type="text" name="description" value="{{$activeDeal->task->description}}" required autofocus style="flex-grow: 1;" />

                    <!-- deadline -->
                   <x-input id="deadline" class="" type="datetime-local" name="deadline" value="{{ \Carbon\Carbon::parse($activeDeal->task->deadline)->format('Y-m-d\TH:i') }}" />

                    <!-- deal_id -->
                    <x-input id="deal_id" class="" type="hidden" name="deal_id" value="{{$activeDeal->id1}}" />

                    <!-- typeTask -->
                    <div class="form-group" style="margin-left: 10px;">
                        <label for="typeTask"></label>
                        <select class="form-control" id="typeTask" name="typeTask">
                            @foreach($typeTasks as $typeTask)
                            <option value="{{ (integer) $typeTask->id }}"{{ $activeDeal->task->typeTask == $typeTask->id ? 'selected' : '' }}>
                                {{ $typeTask->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <x-button class="ml-4" style="margin-left: 10px;">
                        {{ __('Confirm') }}
                    </x-button>
                </div>
            </div>
        </form>
    </div>
    @endif

    @endforeach
    <x-alert />
</x-company>