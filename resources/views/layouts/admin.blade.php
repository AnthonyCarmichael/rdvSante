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

        <div class="relative min-h-screen md:flex" x-data="{ open: true}">

            <!-- Sidebar -->
            <!-- Ajouter -translate-x-full en JS pour fermer le Sidebar -->
            <aside :class="{ '-translate-x-full': !open }" class="bg-mid-green z-10 text-darker-green px-4 py-4 absolute inset-y-0 left-0 md:relative transform md:translate-x-0 
                overflow-y-auto transition ease-in-out duration-200 shadow-lg">

                <div class="flex justify-end">
                    <button type="button" @click="open = !open" class="md:hidden inline-flex justify-center items-center rounded-md absolute bg-pale-green hover:bg-white 
                        focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="block size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- nav links -->
                <nav>
                    <ul>
                        <li><a class="hover:text-white" href="">Profil</a></li>
                        <li><a class="hover:text-white" href="">Client</a></li>
                        <li><a class="hover:text-white" href="">dossier</a></li>
                        <li><a class="hover:text-white" href="">Agenda</a></li>
                        <li><a class="hover:text-white" href="">Factures</a></li>
                        <li><a class="hover:text-white" href="">Clinique</a></li>
                        <li><a class="hover:text-white" href="">Collaborer</a></li>
                    </ul>
                </nav>
            </aside>

            <nav class ="">
                    <div class="">
                        <div class="relative flex items-center justify-between">
                            <div :class="{ 'hidden': open, 'ml-0': !open }" class="absolute inset-y-0 left-0 flex item-center md:hiden transition-all duration-300">
                                <button type="button" @click="open = !open" @click.away="open = false" class="inline-flex rounded-md md:hidden bg-mid-green m-4 p-1 absolute text-darker-green hover:text-white focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="block size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                                    </svg>

                                </button>
                            </div>
                        </div>
                    </div>
                </nav>
            <!-- Main content -->
            <main :class="{ 'ml-32 md:ml-0': open, 'ml-10 md:ml-0': !open }" class="transition-all duration-300">
                <div>
                    {{ $slot}}
                </div>
            </main>

        </div>
    </body>
</html>
