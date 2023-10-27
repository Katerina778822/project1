<x-app-layout>
    <x-slot name="header">
    <x-userMenu />

    </x-slot>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{('Создание роли') }}
        </h2>

    <div class="space-y-10 divide-y divide-gray-900/10 justify-center flex ">

        <div class="grid grid-cols-1 gap-x-8 gap-y-8 max-w-xs mb-4">
            <div class="px-4 sm:px-0">
                <h2 class="text-base font-semibold leading-7 text-gray-900"></h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">
                    <!--Вывод сообщения -->
                    @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif
                <!--Вывод ошибки валидации -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />
            </div>

            <form class="bg-gray-200 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2 items-center justify-center" method="POST" action="{{ route('role.store') }}">
                <div class="px-4 py-6 sm:p-8 justify-center">
                    <div class=" justify-center">
                        Заполните форму чтобы создать новую роль
                    </div>
                </div>
                <div class="flex items-center justify-center border-t border-gray-900/10 px-4 py-4 sm:px-8">
                    <div>
                        @csrf
                        <!-- Name -->
                        <div>
                            <x-label for="name" :value="__('Имя')" />

                            <x-input id="name" class="block mt-1 w-full" type="text" NAME="name" :value="old('name')" required autofocus />
                        </div>
                        @foreach ($permissions as $groupName => $groupPermissions)
                        {{ $groupName }}:
                        @foreach($groupPermissions as $permission)
                        <div class="form-group form-check">
                            <input type="checkbox" value="{{$permission->id}}" name="permissions[]" class="form-check-input" id="exampleCheck{{$permission->id}}">
                            <label class="form-check-label" for="exampleCheck{{$permission->id}}">{{$permission->name}}</label>
                        </div>
                        @endforeach
                        @endforeach


                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __   ('Register') }}
                            </x-button>
                            <x-button_red class="ml-4">
                                <a class="btn btn-link" href="{{ route('role.index') }}">
                                    {{ __('Cancel') }}</a>
                            </x-button_red>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>



</x-app-layout>