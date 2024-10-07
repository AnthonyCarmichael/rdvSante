<div class="flex justify-center items-center min-h-screen">
    <div class="w-full min-h-min max-w-2xl p-8 rounded-lg shadow-lg bg-mid-green">
        @if (session()->has('message'))
            <div class="alert alert-success text-center text-green-600">
                {{ session('message') }}
            </div>
        @endif

        <form wire:submit.prevent="save" class="space-y-6">
            <div class="mb-4">
                <label for="nom" class="block text-sm font-medium">Nom</label>
                <input type="text" id="nom" wire:model="nom" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('nom') <span class="error text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="prenom" class="block text-sm font-medium">Prénom</label>
                <input type="text" id="prenom" wire:model="prenom" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('prenom') <span class="error text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium">Email</label>
                <input type="email" id="email" wire:model="email" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('email') <span class="error text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="telephone" class="block text-sm font-medium">Téléphone</label>
                <input type="text" id="telephone" wire:model="telephone" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('telephone') <span class="error text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="$selectedIdProfession" class="block text-sm font-medium">Sélectionnez vos professions</label>
                <select required id="$selectedIdProfession" wire:model="selectedIdProfession" multiple class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @foreach (\App\Models\Profession::all() as $profession)
                        <option value="{{ $profession->id }}">{{ $profession->nom }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <p class="font-bold">Professions</p>
                <ul class="ml-6">
                    @foreach ($idProfession as $profession )
                        <li>-{{$profession->nom}}</li>
                    @endforeach
                    
                </ul>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 focus:ring-4 focus:ring-blue-300">
                Mettre à jour
            </button>
        </form>
    </div>
</div>
