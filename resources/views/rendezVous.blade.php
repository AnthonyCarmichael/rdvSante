
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Rendez-vous santé') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-stone-300">

        <header>
            
        </header>

        <div class="">
            <!-- Main content -->
            <main class="flex justify-center">

                <div class="text-xs text-gray-700 bg-stone-200 w-1/2 flex flex-col items-center m-10">
                    <img class="m-4" src="{{ asset('img/imgMassage2.webp') }}" alt="image massage">
                    
                    <button type="button" @click="editable = !editable" x-show="!editable" 
                        class="px-4 py-2 mt-2 mb-4 text-white rounded-full bg-dark-green hover:bg-darker-green">
                        Prendre rendez-vous
                    </button>
                </div>

            </main>

        </div>
    </body>
</html>