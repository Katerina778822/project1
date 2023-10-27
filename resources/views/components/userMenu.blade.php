<div class="flex">
    @if(auth()->user()->can('user.read.list'))
    <x-button_blue class="ml-2">
        <a class="btn btn-link" href="{{ route('user.index') }}">
            {{ __('Users') }}</a>
    </x-button_blue>
    @endif
    @if(auth()->user()->can('B24User.read.list'))
    <x-button_blue class="ml-2">
        <a class="btn btn-link" href="{{ route('B24User.index') }}">
            {{ __('CRM users') }}</a>
    </x-button_blue>
    @endif
    @if(auth()->user()->can('role.read.list'))
    <x-button_blue class="ml-2">
        <a class="btn btn-link" href="{{ route('role.index') }}">
            {{ __('Roles') }}</a>
    </x-button_blue>
    @endif
    @if(auth()->user()->can('business.read.list'))
    <x-button_blue class="ml-2">
        <a class="btn btn-link" href="{{ route('business.index') }}">
            {{ __('Businesses') }}</a>
    </x-button_blue>
    @endif
    @if(auth()->user()->can('branch.read.list'))
    <x-button_blue class="ml-2">
        <a class="btn btn-link" href="{{ route('branch.index') }}">
            {{ __('Branches') }}</a>
    </x-button_blue>
    @endif
    <!--x-button_red class="ml-4">

    {{ __('Register') }}

</x-button_red -->
</div>