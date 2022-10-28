<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Пользователи') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($users->isNotEmpty())
                <div class="container">
                    <form class="flex mb-2 gap-2" method="get" action="">
                        <div>
                            <x-input value="{{ \request()->get('email') }}" id="email" name="email" type="text" placeholder="Email"></x-input>
                        </div>
                        <div>
                            <x-label for="" class="hidden">Hidden</x-label>
                            <x-button class="bg-green-600">
                                {{ __('Поиск') }}
                            </x-button>
                        </div>

                        <div>
                            <x-label for="" class="hidden">Hidden</x-label>
                            <a href="{{ route('user.create') }}">
                                <x-button type="button">
                                    {{ __('Создать пользователя') }}
                                </x-button>
                            </a>
                        </div>

                    </form>

                    <div class="border-b mb-2 border-gray-200 shadow">
                        <table class="table-apps">
                            <thead class="bg-gray-50">
                            <tr style='background:#9400D3;color:#fff;font-weight: bold;'>
                                <th scope="col" class="px-6 py-2 text-xs">
                                    {{ __('ID') }}
                                </th>
                                <th scope="col" class="px-6 py-2 text-xs">
                                    {{ __('Имя') }}
                                </th>
                                <th scope="col" class="px-6 py-2 text-xs">
                                    {{ __('Email') }}
                                </th>
                                <th scope="col" class="px-6 py-2 text-xs">
                                    {{ __('Role') }}
                                </th>
                                <th scope="col" class="px-6 py-2 text-xs">
                                    {{ __('Telegram') }}
                                </th>
                                <th scope="col" class="px-6 py-2 text-xs">
                                    {{ __('Создан') }}
                                </th>
                                <th scope="col" class="px-6 py-2 text-xs">
                                    {{ __('Редактировать') }}
                                </th>
                                <th scope="col" class="px-6 py-2 text-xs">
                                    {{ __('Удалить') }}
                                </th>
                                <th scope="col" class="px-6 py-2 text-xs">
                                    {{ __('Login') }}
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white">
                            @foreach($users as $user)
                                <tr class="whitespace-nowrap">
                                    <td aria-label="ID" class="px-6 py-4 text-sm text-gray-500">
                                        {{ $user->id }}
                                    </td>
                                    <td aria-label="Имя" class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            {{ $user->name }}
                                        </div>
                                    </td>
                                    <td aria-label="Email" class="px-6 py-4">
                                        <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                    </td>
                                    <td aria-label="Role" class="px-6 py-4">
                                        <div class="text-sm text-gray-500">{{ $user->role }}</div>
                                    </td>
                                    <td aria-label="Telegram" class="px-6 py-4">
                                        <div class="text-sm text-gray-500">{{ $user->telegram }}</div>
                                    </td>
                                    <td aria-label="Создан" class="px-6 py-4 text-sm text-gray-500">
                                        {{ $user->created_at }}
                                    </td>
                                    <td aria-label="Редактировать" class="px-6 py-4">
                                        <a href="{{ route('user.edit', ['id' => $user->id]) }}">
                                            <x-button class="bg-green-600" type="button">{{ __('Edit') }}</x-button>
                                        </a>
                                    </td>
                                    <td aria-label="Удалить" class="px-6 py-4">
                                        <form action="{{ route('user.delete', ['id' => $user->id]) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <x-button class="bg-red-600" type="submit">{{ __('Delete') }}</x-button>
                                        </form>
                                    </td>
                                    <td aria-label="Login" class="px-6 py-4">
                                        <a href="{{ route('user.loginAsAdmin', ['id' => $user->id]) }}">
                                            <x-button class="bg-green-600" type="button">{{ __('Login') }}</x-button>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $users->links("pagination::tailwind") }}
                </div>
            @else
                {{ __('Not users yet...') }}
            @endif
        </div>
    </div>
</x-app-layout>
