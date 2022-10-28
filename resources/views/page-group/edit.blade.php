<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Редактирование групп страниц') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="container">

                <x-auth-validation-errors class="mb-4" :errors="$errors"/>

                <div class="border-b mb-2 border-gray-200 shadow p-4 bg-white">

                    <form action="{{ route('page-groups.update', ['page_group' => $pageGroup->id]) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                                {{ __('Name') }}
                            </label>
                            <input value="{{ old('name', $pageGroup->name) }}"
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                   id="name" name="name" type="text" placeholder="{{ __('Name') }}">
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
