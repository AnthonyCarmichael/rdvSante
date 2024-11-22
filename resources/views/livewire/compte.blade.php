<div class="flex justify-center items-center min-h-screen flex-wrap">
    <div class="w-full min-h-min max-w-2xl p-8 rounded-lg shadow-lg bg-mid-green">
        @if (session()->has('message'))
            <div class="alert alert-success text-center text-green-600">
                {{ session('message') }}
            </div>
        @endif

        <form wire:submit.prevent="save" class="space-y-6">
            <div class="mb-4">
                <label for="nom" class="block text-sm font-medium">Nom</label>
                <input type="text" id="nom" wire:model="nom"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('nom')
                    <span class="error text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="prenom" class="block text-sm font-medium">Prénom</label>
                <input type="text" id="prenom" wire:model="prenom"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('prenom')
                    <span class="error text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium">Email</label>
                <input type="email" id="email" wire:model="email"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('email')
                    <span class="error text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="telephone" class="block text-sm font-medium">Téléphone</label>
                <input placeholder="(123) 456-7890" type="text" id="telephone" wire:model.live="telephone" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('telephone')
                    <span class="error text-red-600">{{ 'Entrez un format valide' }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="lien" class="block text-sm font-medium">Lien du site</label>
                <input type="text" id="lien" wire:model="lien"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('lien')
                    <span class="error text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium">Description</label>
                <textarea wire:model="description" name="description" id="description" cols="30" rows="4" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                @error('description')
                    <span class="error text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="photoProfil" class="block text-sm font-medium">Photo de profil</label>
                <input type="file" accept=".jpg, .jpeg, .png" id="photoProfil" wire:model="photoProfil"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('photoProfil')
                    <span class="error text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="signature" class="block text-sm font-medium">Signature</label>
                <input type="file" accept=".jpg, .jpeg, .png" id="signature" wire:model="signature"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('signature')
                    <span class="error text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="numTvq" class="block text-sm font-medium">Numéro TVQ</label>
                <input type="text" id="numTvq" wire:model="numTvq"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('numTvq')
                    <span class="error text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="numTps" class="block text-sm font-medium">Numéro TPS</label>
                <input type="text" id="numTps" wire:model="numTps"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('numTps')
                    <span class="error text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="cleStripe" class="block text-sm font-medium">Clé secrète stripe</label>
                <input type="text" id="cleStripe" wire:model="cleStripe"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <button type="submit"
                class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 focus:ring-4 focus:ring-blue-300">
                Mettre à jour
            </button>
        </form>
    </div>

    <div class="w-full flex justify-center my-8">

        @if ($actif == 0)
            <button wire:click="activer()"
                class="w-1/3 bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 focus:ring-4 focus:ring-blue-300">
                Activer
            </button>
        @endif

        @if ($actif == 1)
            <button wire:click="desactiver()"
                class="w-1/3 bg-red-500 text-white py-2 rounded-lg hover:bg-red-600 focus:ring-4 focus:ring-red-300">
                Désactiver
            </button>
        @endif
    </div>

    <div class="w-full flex justify-center my-8">
        <a href="{{ route('message')}}" class="text-center w-1/3 bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 focus:ring-4 focus:ring-blue-300">Personnaliser le message du courriel de confirmation de rendez-vous</a>
    </div>
</div>
