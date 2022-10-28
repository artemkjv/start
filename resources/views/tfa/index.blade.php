<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="container">

                <x-auth-validation-errors class="mb-4" :errors="$errors"/>

                <div class="p-6 bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                        {{ __('Step 1: Open an authenticator app on your mobile device and scan this QR code or enter the secret key.') }}</h5>
                    <div class="flex items-center">
                        {!! $qrImage !!}
                        <span style="margin-left: 40px;">
                            Secret Key: {{ $secretKey }}
                        </span>
                    </div>
                </div>

                <div class="mt-4 p-6 bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ __('Step 2: Enter the 6-digit code from the authenticator app.') }}</h5>
                    <form method="post" action="{{ route('tfa.enable') }}">
                        @method('PUT')
                        @csrf
                        <input type="hidden" value="{{ $secretKey }}" name="secret_key">
                        <div class="my-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="auth-code">
                                {{ __('Authentication Code') }}
                            </label>
                            <input
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                   id="auth-code" name="auth_code" type="text">
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
