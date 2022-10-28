<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Редактирование пользователя') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="container">

                <x-auth-validation-errors class="mb-4" :errors="$errors"/>

                <div class="border-b mb-2 border-gray-200 shadow p-4 bg-white">

                    @livewire('user.edit-component', compact('user'))
                    @push('scripts')
                        <script>
                            $(function () {
                                @if($user->role === \App\Models\User::ROLES['pseudo_admin'])
                                    @if(!$user->all_users)
                                        $('#users').filterMultiSelect()
                                    @endif
                                    $('#pages').filterMultiSelect()
                                @endif

                                Livewire.on('updatedState', state => {
                                    if (state.role === '{{ \App\Models\User::ROLES['pseudo_admin'] }}') {
                                        if(!state.all_users) {
                                            $('#users').filterMultiSelect()
                                        }
                                        $('#pages').filterMultiSelect()
                                    } else {
                                        $.fn.filterMultiSelect.applied = []
                                    }
                                })
                            })
                        </script>
                    @endpush
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
