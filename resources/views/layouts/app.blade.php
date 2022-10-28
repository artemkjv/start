<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Excelsior') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/table.css') }}">
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        @livewireStyles

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            <header class="shadow bg-white">
                <div style="max-width: 100%;" class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
            @if(Auth::user()->role === "SUPERUSER" || Auth::user()->role === "ADMIN" || Auth::user()->role === "PSEUDO_ADMIN")
            @else
                @if(Auth::user()->balance < 0)
                    <div style="margin-top:10px;padding:10px;text-align: center;" class="shadow bg-white">
                        <b style="color: red;">
                            ❗❗❗ ВНИМАНИЕ, у Вас отрицательный баланс ❗❗❗ <br />
                            ❗Если в течении 7 дней Вы не погасите задолженность - Ваш аккаунт будет ЗАБЛОКИРОВАН❗ <br />
                            ❗Все потоки внутри приложений будут отключены, что не даст возможность пользователям, уже сделавшим депозит или регистрацию, попасть в продукт❗ <br />
                            ❗❗❗ Бан происходит полностью автоматически ❗ ❗ ❗
                        </b>
                    </div>
                @endif
            @endif
            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        @livewireScripts
        <script src="{{ asset('js/excel.js') }}"></script>
        @stack('scripts')
    </body>
</html>
