<div>
    <form action="{{ route('user.store') }}" method="post">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                {{ __('Name') }}
            </label>
            <input value="{{ old('name') }}"
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                   id="name" name="name" type="text" placeholder="Name">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                {{ __('Email') }}
            </label>
            <input value="{{ old('email') }}"
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                   id="email" type="email" name="email" placeholder="Email">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                {{ __('Telegram') }}
            </label>
            <input value="{{ old('telegram') }}"
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                   id="telegram" type="text" name="telegram" placeholder="Telegram">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                {{ __('Password') }}
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                   id="password" type="password" name="password" placeholder="******************">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="role">
                {{ __('Role') }}
            </label>
            <select class="form-select appearance-none block w-full px-3 py-1.5 text-base font-normal
                             text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded transition ease-in-out m-0
                                focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                    wire:model="state.role"
                    id="role"
                    name="role">
                <option selected>{{ __('Select role...') }}</option>
                @switch(\request()->user()->role)
                    @case(\App\Models\User::ROLES['superuser'])
                    @case(\App\Models\User::ROLES['admin'])
                        <option value="{{ \App\Models\User::ROLES['admin'] }}">{{ __('Admin') }}</option>
                        <option value="{{ \App\Models\User::ROLES['pseudo_admin'] }}">{{ __('Pseudo Admin') }}</option>
                        @break
                    @case(\App\Models\User::ROLES['pseudo_admin'])
                        <option value="{{ \App\Models\User::ROLES['pseudo_admin'] }}">{{ __('Admin') }}</option>
                        @break
                @endswitch
                <option value="{{ \App\Models\User::ROLES['partner'] }}">{{ __('Partner') }}</option>
                <option value="{{ \App\Models\User::ROLES['webmaster'] }}">{{ __('Webmaster') }}</option>
            </select>
        </div>

        @if($state['role'] === \App\Models\User::ROLES['pseudo_admin'])

            <div id="pseudo-container" class="@if(!$state['all_users']) flex @endif flex-wrap -mx-3 mb-4">
                <div id="pages-container" class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                           for="pages">
                        {{ __('Pages') }}
                    </label>
                    <div class="relative">
                        <select multiple
                                name="pages[]"
                                class="multi-select"
                                id="pages">
                            @foreach($pages as $page)
                                <option value="{{ $page->id }}">{{ $page->name }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                @if(!$state['all_users'])
                <div id="users-container" class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                           for="users">
                        {{ __('Users') }}
                    </label>
                    <div class="relative">
                        <select multiple
                                name="users[]"
                                class="multi-select"
                                id="users">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->email }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            <div id="all-users-container" class="mb-4 flex gap-2">
                <x-label class="uppercase inline-block"
                       for="all-users">All Users?</x-label>
                <input type="checkbox"
                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                       wire:model="state.all_users" name="all_users" id="all-users" />
            </div>
        @endif

        <button id="smt-button" type="submit"
                class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
            {{ __('Submit') }}
        </button>

    </form>
</div>
