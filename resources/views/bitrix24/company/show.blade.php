<x-company>
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
    @endforeach
    <x-alert />
</x-company>