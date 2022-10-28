<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Страницы') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($pages->isNotEmpty())
                <div class="container">

                    <form class="flex mb-2 gap-2" method="get" action="">

                        <div>
                            <label for="" class="hidden text-gray-700 text-sm font-bold mb-2">Hidden</label>
                            <a href="{{ route('page.create') }}">
                                <x-button type="button">
                                {{ __('Создать страницу') }}
                                </x-button>
                            </a>
                        </div>

                    </form>
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
                                    {{ __('Route') }}
                                </th>
                                <th scope="col" class="px-6 py-2 text-xs">
                                    {{ __('Видимость') }}
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
                            @foreach($pages as $page)
                                <tr class="whitespace-nowrap">
                                    <td aria-label="ID" class="px-6 py-4 text-sm text-gray-500">
                                        {{ $page->id }}
                                    </td>
                                    <td aria-label="Имя" class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            {{ $page->name }}
                                        </div>
                                    </td>
                                    <td aria-label="Route" class="px-6 py-4">
                                        <div class="text-sm text-gray-500">
                                            {{ $page->route }}
                                        </div>
                                    </td>
                                    <td aria-label="Видимость" class="px-6 py-4 text-sm text-gray-500">
                                        {{ $page->is_visible ? 'True' : 'False' }}
                                    </td>
                                    <td aria-label="Редактировать" class="px-6 py-4">
                                        <a href="{{ route('page.edit', ['id' => $page->id]) }}">
                                            <x-button class="bg-green-600" type="button">{{ __('Edit') }}</x-button>
                                        </a>
                                    </td>
                                    <td aria-label="Удалить" class="px-6 py-4">
                                        <form action="{{ route('page.delete', ['id' => $page->id]) }}" method="post">
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
                    {{ $pages->links("pagination::tailwind") }}
                </div>

            @else
            {{ __('Not pages yet...') }}
            @endif
        </div>
    </div>
</x-app-layout>
