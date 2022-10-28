<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Группы страниц') }}
        </h2>
    </x-slot>

    <x-modal modalId="create-group" :title="__('Create Group Page')">
        <form action="{{ route('page-groups.store') }}" method="post">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                    {{ __('Name') }}
                </label>
                <input value="{{ old('name') }}"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       id="name" name="name" type="text" placeholder="{{ __('Name') }}">
            </div>
            <button type="submit"
                    class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
                {{ __('Submit') }}
            </button>
        </form>
    </x-modal>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="container">
                    <x-auth-validation-errors class="mb-4" :errors="$errors"/>

                    <form class="flex mb-2 gap-2" method="get" action="">
                        <div>
                            <x-label class="hidden">Hidden</x-label>
                            <x-button type="button" onclick="toggleModal('create-group')">
                                {{ __('Создать группу') }}
                            </x-button>
                        </div>

                    </form>
                    @if($groups->isNotEmpty())

                    <div class="border-b mb-2 border-gray-200 ">
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
                                    {{ __('Количество страниц') }}
                                </th>
                                <th scope="col" class="px-6 py-2 text-xs">
                                    {{ __('Редактировать') }}
                                </th>
                                <th scope="col" class="px-6 py-2 text-xs">
                                    {{ __('Удалить') }}
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white">
                            @foreach($groups as $group)
                                <tr class="whitespace-nowrap">
                                    <td aria-label="ID" class="px-6 py-4 text-sm text-gray-500">
                                        {{ $group->id }}
                                    </td>
                                    <td aria-label="Имя" class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            {{ $group->name }}
                                        </div>
                                    </td>
                                    <td aria-label="Route" class="px-6 py-4">
                                        <div class="text-sm text-gray-500">
                                            {{ $group->pages_count }}
                                        </div>
                                    </td>
                                    <td aria-label="Редактировать" class="px-6 py-4">
                                        <a href="{{ route('page-groups.edit', ['page_group' => $group->id]) }}">
                                            <x-button class="bg-green-600" type="submit">
                                                {{ __('Edit') }}
                                            </x-button>
                                        </a>
                                    </td>
                                    <td aria-label="Удалить" class="px-6 py-4">
                                        <form action="{{ route('page-groups.destroy', ['page_group' => $group->id]) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <x-button class="bg-red-600" type="submit">{{ __('Delete') }}</x-button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                    {{ $groups->links("pagination::tailwind") }}
                    @else
                        {{ __('No groups yet...') }}
                    @endif
                </div>


        </div>
    </div>
</x-app-layout>
