
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
            <main class="container mx-auto">

                <div x-data="{ showForm: false }" class="text-xs text-gray-700 bg-stone-200 m-10 flex flex-col items-center m-6 p-6">
                    <img class="rounded w-full max-w-md" src="{{ asset('img/imgMassage.jpg') }}" alt="image massage">

                    @livewire('RendezVousClientComponent')

                    <button x-data x-show="!showForm" @click="showForm = true" class="px-4 py-2 mt-2 mb-4 text-white rounded-full bg-dark-green hover:bg-darker-green">
                        Prendre rendez-vous
                    </button>

                    <div class="w-full max-w-md">
                        <form x-show="showForm" x-data="{ currentStep: 1 }">
                            <!-- Section 1 -->
                            <div x-show="currentStep === 1" class="p-5 bg-white rounded shadow-md">

                                <div class="flex justify-center">
                                    <button @click="currentStep++" class="px-4 py-2 m-2 text-white rounded-full bg-dark-green hover:bg-darker-green">Nouveau client</button>
                                    <button @click="currentStep++" class="px-4 py-2 m-2 text-white rounded-full bg-dark-green hover:bg-darker-green">Ancien client</button>
                                </div>
                                
                               
                                <div class="flex justify-between">
                                    <button type="button" @click="showForm = false" class="mt-4 px-4 py-2 bg-gray-500 text-white rounded">Précédent</button>
                                </div>
                                
                            </div>

                            <!-- Section 2 -->
                            <div x-show="currentStep === 2" class="p-5 bg-white rounded shadow-md">
                                <h2 class="text-lg font-bold">Sélectionnez un professionnel</h2>
                                <div>
                                    <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                                    <input type="date" id="date" name="date" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required>
                                </div>
                                <div class="mt-4">
                                    <label for="time" class="block text-sm font-medium text-gray-700">Heure</label>
                                    <input type="time" id="time" name="time" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required>
                                </div>

                                <div class="flex justify-between">
                                    <button type="button" @click="currentStep--" class="mt-4 px-4 py-2 bg-gray-500 text-white rounded">Précédent</button>
                                    <button type="button" @click="currentStep++" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded">Suivant</button>
                                </div>

                            </div>

                            <!-- Section 3 -->
                            <div x-show="currentStep === 3" class="p-5 bg-white rounded shadow-md">
                                <h2 class="text-lg font-bold">Résumé</h2>
                                <p>Merci d'avoir rempli le formulaire. Cliquez sur "Confirmer" pour soumettre.</p>
                                <button type="button" @click="currentStep--" class="mt-4 px-4 py-2 bg-gray-500 text-white rounded">Précédent</button>
                                <button type="submit" class="mt-4 px-4 py-2 bg-green-500 text-white rounded">Confirmer</button>
                            </div>
                        </form>
                    </div>
                    
                </div>

            </main>

        </div>
    </body>
</html>