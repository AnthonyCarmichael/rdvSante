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
    <body class="font-sans antialiased bg-pale-green">

        <header>
            <!-- Logo -->
            <nav class="bg-dark-green p-2">
                <div class="flex text-white items-center">
                    <img class="w-[5rem]" src="{{ asset('img/logoRdvSante.png') }}" alt="Logo">
                    <h1 class="ml-4 text-2xl font-extrabold">Rendez-vous santé</h1>
                </div>
            </nav>
        </header>

        <div class="relative min-h-screen md:flex">

            <!-- Sidebar -->
            <!-- Ajouter -translate-x-full en JS pour fermer le Sidebar -->
            <aside class="bg-mid-green z-10 text-darker-green px-4 py-4 absolute inset-y-0 left-0 md:relative transform md:translate-x-0 
                overflow-y-auto transition ease-in-out duration-200 shadow-lg">

                <div class="flex justify-end">
                    <button type="button" class="md:hidden inline-flex justify-center items-center rounded-md absolute">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="block size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- nav links -->
                <nav>
                    <ul>
                        <li><a href="">Profil</a></li>
                        <li><a href="">Client</a></li>
                        <li><a href="">dossier</a></li>
                        <li><a href="">Agenda</a></li>
                        <li><a href="">Factures</a></li>
                        <li><a href="">Clinique</a></li>
                        <li><a href="">Collaborer</a></li>
                    </ul>
                </nav>
            </aside>

            <!-- Main content -->
            <main class="">
                <nav>
                    <div>
                        {{ $slot}}
                    </div>
                </nav>
            </main>

        </div>
    </body>
</html>
