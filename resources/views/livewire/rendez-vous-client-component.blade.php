
<div x-data="{ showForm: false }" class="text-xs text-gray-700 bg-stone-200 m-10 flex flex-col items-center m-6 p-6">
    <img class="rounded w-full max-w-md" src="{{ asset('img/imgMassage.jpg') }}" alt="image massage">
    <div class="w-full max-w-md">
        <form wire:submit.prevent="rdvClient">
            @switch ($step)
                @case(0)
                    <div class="p-5 bg-white rounded shadow-md">
                        <div class="flex justify-center">
                            <button type="button" wire:click="nextStep" class="px-4 py-2 mt-2 mb-4 text-white rounded-full bg-dark-green hover:bg-darker-green">
                                Prendre rendez-vous
                        </button>
                        </div>

                    </div>
                    @break
                @case(1)
                    <!-- Section 1 -->
                    <div class="p-5 bg-white rounded shadow-md">

                        <div class="flex justify-center">
                            <button type="button" wire:click="nextStep" class="px-4 py-2 m-2 text-white rounded-full bg-dark-green hover:bg-darker-green">Nouveau client</button>
                            <button type="button" wire:click="nextStep" class="px-4 py-2 m-2 text-white rounded-full bg-dark-green hover:bg-darker-green">Ancien client</button>
                        </div>

                        <div class="flex justify-between">
                            <button type="button" wire:click="backStep" class="mt-4 px-4 py-2 bg-gray-500 text-white rounded">Précédent</button>
                        </div>
                    </div>
                    @break

                @case(2)
                    <!-- Section 2 -->
                    <div class="p-5 bg-white rounded shadow-md">
                        <h2 class="text-lg font-bold">Sélectionnez un professionnel</h2>

                        <div class="flex justify-between">
                            <button type="button" wire:click="backStep" class="mt-4 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-700">Précédent</button>
                            <button type="button" wire:click="nextStep" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">Suivant</button>
                        </div>
                    </div>
                    @break

                @case(3)
                    <!-- Section 3 -->
                    <div class="p-5 bg-white rounded shadow-md">
                        <h2 class="text-lg font-bold">Résumé</h2>
                        <p>Merci d'avoir rempli le formulaire. Cliquez sur "Confirmer" pour soumettre.</p>
                        <div class="flex justify-between">
                            <button type="button"  wire:click="backStep" class="mt-4 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-700">Précédent</button>
                            <button type="submit" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">Confirmer</button>
                        </div>

                    </div>
                    @break
            @endswitch
        </form>
    </div>
                    
</div>

