<x-app-layout>
    <x-slot name="header">
    <x-userMenu />

    </x-slot>

    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{('Редактирование пользователя') }}
        </h2>
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

            <form class="bg-gray-200 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2 items-center justify-center" method="post" action="{{ route('user.update', ['user' => $item]) }}">
                <div class="px-4 py-6 sm:p-8 justify-center">
                    <div class=" justify-center">
                        Заполните форму чтобы изменить пользователя
                    </div>
                </div>
                <div class="flex items-center justify-center border-t border-gray-900/10 px-4 py-4 sm:px-8">
                    <div>
                        @csrf
                        @method('PUT')
                        <!-- Name -->
                        <div>
                            <x-label for="name" :value="__('Name')" />

                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{$item->name}}" required autofocus />
                        </div>

                        <!-- Email Address -->
                        <div class="mt-4">
                            <x-label for="email" :value="__('Email')" />

                            <x-input id="email" class="block mt-1 w-full" type="email" name="email" value="{{$item->email}}" required />
                        </div>

                        <!-- Business -->
                        <div class="mt-4">
                            <x-label for="business_id" :value="__('*Business')" />

                            <x-input id="business_id" class="block mt-1 w-full" type="text" name="business_id" value="{{$item->business_id}}" />
                        </div>

                        <!-- Password -->
                        <div class="mt-4">
                            <x-label for="password" :value="__('Password')" />

                            <x-input id="password" class="block mt-1 w-full" type="password" name="password" autocomplete="new-password" />
                        </div>

                        <!-- Confirm Password -->
                        <div class="mt-4">
                            <x-label for="password_confirmation" :value="__('Confirm Password')" />

                            <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" />
                        </div>

                        <hr>
                        <fieldset class="mt-4 ">
                            <legend> Выберите роли: </legend>
                            @foreach($roles as $role)
                            <div class="form-group form-check m-2">
                                <input type="checkbox" value="{{$role->id}}" name="roles[]" class="form-check-input" id="exampleCheck{{$role->id}}" @if ($currentRoles->contains($role->id)) checked @endif>
                                <label class="form-check-label" for="exampleCheck{{$role->id}}">{{$role->name}}</label>
                            </div>
                            @endforeach
                        </fieldset>

                        <div class="form-group">
                            <label for="crmUsersSelect">Выберите CRM user:</label>
                            <select class="form-control" id="crmUsersSelect" name="crmuser_id">
                                <option value="">{{ $item->crmUser->NAME??'Без CRM user'}}</option>
                                @foreach($crmUsers as $crmUser)
                                <option value="{{ $crmUser->ID }}">
                                    {{ $crmUser->NAME }} {{ $crmUser->LAST_NAME }}
                                </option>
                                @endforeach
                            </select>
                        </div>


                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __   ('Confirm') }}
                            </x-button>
                            <x-button_red class="ml-4">
                                <a class="btn btn-link" href="{{ route('user.index') }}">
                                    {{ __('Cancel') }}</a>
                            </x-button_red>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>



</x-app-layout>