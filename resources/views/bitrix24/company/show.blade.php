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

    <div class="flex justify-between items-center w-full">
        <div>
            Название {{$company->TITLE}}
        </div>
        <div class="ml-auto">
            <x-button_blue>
                <a class="btn btn-link" href="{{ route('agenda.show', ['agenda'=>$company->ASSIGNED_BY_ID]) }}">
                    {{ __('Agenda') }}
                </a>
            </x-button_blue>
        </div>


        <div>
            @if(auth()->user()->can('deal.add'))
            <!-- x-button_green class="ml-2">
        <a class="btn btn-link" href="{{ route('dashboard') }}">
            {{ __('Create new deal') }}</a>
    </x-button_green -->
            @endif
        </div>
    </div>


    @foreach($activeDeals as $activeDeal)
    <x-jame.deal :active-deal="$activeDeal" />

    <!-- Вывод задачи -->

    <div>
    <form class="bg-gray-200 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2" method="post" action="{{$activeDeal->task?route('task.update', ['task' => $activeDeal->task->id]):route('task.store') }}">
        <div class="flex items-center border-t border-gray-900/10 py-2 px-4">
            @csrf
            @if($activeDeal->task)
            @method('PUT')
            @endif

            <!-- description -->
            <textarea id="description" class="flex-grow" name="description" required autofocus>{{ $activeDeal->task->description ?? '' }}</textarea>

            <!-- deadline -->
            <x-input id="deadline" class="ml-2" type="datetime-local" name="deadline" value="{{$activeDeal->task?(\Carbon\Carbon::parse($activeDeal->task->deadline)->format('Y-m-d\TH:i')):'' }}" />

            <!-- deal_id -->
            <x-input id="deal_id" type="hidden" name="deal_id" value="{{$activeDeal->id1??''}}" />

            <!-- typeTask -->
            <div class="form-group mx-2">
                <label for="typeTask"></label>
                <select class="form-control" id="typeTask" name="typeTask">
                    @foreach($typeTasks as $typeTask)
                    <option value="{{ (integer) $typeTask->id }}" {{  !empty($activeDeal->task) && $activeDeal->task->typeTask == $typeTask->id ? 'selected' : '' }}>
                        {{ $typeTask->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <x-button class="ml-auto">
                {{ __('Confirm') }}
            </x-button>
        </div>
    </form>
</div>


    @endforeach
    <x-alert />
</x-company>