<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Профиль') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="container">

                <x-auth-validation-errors class="mb-4" :errors="$errors"/>

                <div class="border-b mb-2 border-gray-200 shadow p-4 bg-white">
                    <div class="flex justify-between">
                        <div class="w-full md:w-1/2">
                            <form action="{{ route('profile.update') }}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="current-password">
                                        {{ __('Текущий пароль') }}
                                    </label>
                                    <input
                                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                            id="current-password" name="old_password" type="password"
                                            placeholder="{{ __('Текущий пароль') }}">
                                </div>

                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="new-password">
                                        {{ __('Новый пароль') }}
                                    </label>
                                    <input
                                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                            id="new-password" name="password" type="password"
                                            placeholder="{{ __('Новый пароль') }}">
                                </div>

                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="repeat-password">
                                        {{ __('Повторите пароль') }}
                                    </label>
                                    <input
                                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                            id="repeat-password" name="password_confirmation" type="password"
                                            placeholder="{{ __('Повторите пароль') }}">
                                </div>

                                <button type="submit"
                                        class="inline-block bg-blue-600 px-6 py-2.5 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
                                    {{ __('Сохранить') }}
                                </button>

                            </form>
                        </div>
                    </div>
                    <br />
                    <div class="w-full md:w-1/2 p-6 max-w-sm bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ __('2-Step Authentication') }}</h5>
                        @if (is_null(request()->user()->two_factor_secret))
                            <p>{{ __('2-Step Authentication is') }} <b>{{ __('OFF') }}</b></p>
                            <a href="{{ route('tfa.index') }}"
                               class="mt-2 inline-flex items-center py-2 bg-blue-600 px-3 text-sm font-medium text-center text-white rounded-lg focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:focus:ring-blue-800">
                                {{ __('Включить') }}
                                <svg class="ml-2 -mr-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                          d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                          clip-rule="evenodd"></path>
                                </svg>
                            </a>
                        @else
                            {{ __('2-Step Authentication is') }} <b>{{ __('ON') }}</b>
                            <form method="post" action="{{ route('tfa.disable') }}">
                                @method('PUT')
                                @csrf
                                <button type="submit" style="background-color: #8B008B;"
                                        class="mt-2 inline-flex items-center py-2 px-3 text-sm font-medium text-center text-white rounded-lg focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800">
                                    {{ __('Disable') }}
                                    <svg class="ml-2 -mr-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                              d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                              clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </form>
                        @endif
                    </div>


                </div>

            </div>

        </div>
    </div>
</x-app-layout>
