<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Создание страницы') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="container">

                <x-auth-validation-errors class="mb-4" :errors="$errors"/>

                <div class="border-b mb-2 border-gray-200 shadow p-4 bg-white">

                    <form action="{{ route('page.store') }}" method="post">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                                {{ __('Name') }}
                            </label>
                            <input value="{{ old('name') }}"
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                   id="name" name="name" type="text" placeholder="{{ __('Name') }}">
                        </div>

                        <div class="mb-4">
                            <label class="block text-grey-700 text-sm font-bold mb-2" for="route">
                                {{ __('Route') }}
                                <input type="text" value="{{ old('route') }}"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                       name="route" id="route" placeholder="{{ __('Route') }}">
                            </label>
                        </div>

                        <div class="mb-4">
                            <label class="block text-grey-700 text-sm font-bold mb-2" for="icon">
                                {{ __('Icon') }}
                                <input type="text" value="{{ old('icon') }}"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                       name="icon" id="icon" placeholder="{{ __('Icon') }}">
                            </label>
                        </div>

                        <div class="mb-4">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                   for="pages">
                                {{ __('Roles') }}
                            </label>
                            <div class="relative">
                                <select multiple
                                        name="roles[]"
                                        class="multi-select"
                                        id="roles">
                                    @switch(\request()->user()->role)
                                        @case(\App\Models\User::ROLES['superuser'])
                                        @case(\App\Models\User::ROLES['admin'])
                                            <option value="{{ \App\Models\User::ROLE_PAGE['pseudo_admin'] }}">{{ __('Pseudo Admin') }}</option>
                                            @break
                                    @endswitch
                                    <option value="{{ \App\Models\User::ROLE_PAGE['partner'] }}">{{ __('Partner') }}</option>
                                    <option value="{{ \App\Models\User::ROLE_PAGE['webmaster'] }}">{{ __('Webmaster') }}</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 20 20">
                                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-grey-700 text-sm font-bold mb-2" for="group">
                                {{ __('Group') }}
                            </label>
                            <select
                                    name="page_group_id"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="group">
                                <option value="">Choose group</option>
                                @foreach($groups as $group)
                                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        @push('scripts')
                            <script>
                                $(function () {
                                    $('#roles').filterMultiSelect()
                                })
                            </script>
                        @endpush

                        <div class="flex items-center mb-4">
                            <input id="is-visible" @if(old('is_visible')) checked @endif value="1" name="is_visible" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="is-visible" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('Is visible?') }}</label>
                        </div>

                        <button type="submit"
                                class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
                            {{ __('Submit') }}
                        </button>

                    </form>

                </div>

            </div>

        </div>
    </div>
</x-app-layout>
