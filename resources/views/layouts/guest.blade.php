<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <header>
            <!-- Logo -->
            <nav class="bg-dark-green p-2">
                <div class="flex justify-between items-center">
                    <div class="flex text-white items-center ml-0">
                        <img class="w-[4rem]" src="{{ asset('img/logoRdvSante.png') }}" alt="Logo">
                        <h1 class="ml-6 text-2xl font-extrabold">Rendez-vous santé</h1>
                    </div>

                    @auth
                        <!-- Bouton de déconnexion -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-white bg-mid-green hover:bg-red-700 px-4 py-2 rounded-md">
                                Déconnexion
                            </button>
                        </form>
                    @endauth
                </div>
            </nav>
        </header>
        <div class="min-h-screen flex flex-col items-center pt-16 bg-darker-green">
            <div class="bg-green w-full sm:max-w-md mt-6 px-6 py-4 shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
