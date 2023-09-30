<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{('Редактирование пользователя') }}
        </h2>
    </x-slot>


    <div class="space-y-10 divide-y divide-gray-900/10 justify-center flex ">
        <div class="grid grid-cols-1 gap-x-8 gap-y-8 max-w-xs mb-4">
            <div class="px-4 sm:px-0">
                <h2 class="text-base font-semibold leading-7 text-gray-900"></h2>
                <!--Вывод сообщения -->
                @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif
                <p class="mt-1 text-sm leading-6 text-gray-600"> </p>
                <!--Вывод ошибки валидации -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />
            </div>

            <form class="bg-gray-200 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2 items-center justify-center" method="post" action="{{ route('B24User.update', ['B24User' => $item]) }}">
                <div class="px-4 py-6 sm:p-8 justify-center">
                    <div class=" justify-center">
                        Заполните форму чтобы изменить пользователя
                    </div>
                </div>
                <div class="flex items-center justify-center border-t border-gray-900/10 px-4 py-4 sm:px-8">
                    <div>
                        @csrf
                        @method('PUT')

                        <!-- ID -->
                        <div>
                            <x-label for="ID" :value="__('ID')" />

                            <x-input id="ID" class="block mt-1 w-full" type="text" NAME="ID" value="{{$item->ID}}" required autofocus />
                        </div>

                        <!-- Name -->
                        <div>
                            <x-label for="NAME" :value="__('Имя')" />

                            <x-input id="NAME" class="block mt-1 w-full" type="text" name="NAME" value="{{$item->NAME}}" required autofocus />
                        </div>

                        <!-- LAST_NAME -->
                        <div class="mt-4">
                            <x-label for="LAST_NAME" :value="__('Фамилия')" />

                            <x-input id="LAST_NAME" class="block mt-1 w-full" type="text" name="LAST_NAME" value="{{$item->LAST_NAME}}" required />
                        </div>

                        <!-- ACTIVE -->
                        <div class="mt-4">
                            <x-label for="ACTIVE" :value="__('ACTIVE')" />

                            <x-input id="ACTIVE" class="block mt-1 w-full" type="text" name="ACTIVE" value="{{$item->ACTIVE}}" />
                        </div>


                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __   ('Confirm') }}
                            </x-button>
                            <x-button_red class="ml-4">
                                <a class="btn btn-link" href="{{ route('B24User.index') }}">
                                    {{ __('Cancel') }}</a>
                            </x-button_red>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>



</x-app-layout>