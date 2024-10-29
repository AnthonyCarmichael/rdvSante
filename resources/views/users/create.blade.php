<x-admin-layout>
    <div class="max-w-md mx-auto p-6 bg-white dark:bg-gray-800 shadow-md rounded-md mt-40">
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6 text-center">Inviter un utilisateur</h1>

        <!-- Message de succès -->
        @if (session('success'))
            <div class="mb-4 text-green-600 dark:text-green-400">{{ session('success') }}</div>
        @endif

        <!-- Formulaire de création d'utilisateur -->
        <form action="{{ route('sendInvitation') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Champ nom -->
            <div>
                <x-input-label for="nom" :value="__('Nom')" />
                <x-text-input name="nom" id="nom" class="block mt-1 w-full" type="text" value="{{ old('nom') }}" />
                <x-input-error :messages="$errors->get('nom')" class="mt-2" />
            </div>

            <!-- Champ prénom -->
            <div>
                <x-input-label for="prenom" :value="__('Prénom')" />
                <x-text-input name="prenom" id="prenom" class="block mt-1 w-full" type="text" value="{{ old('prenom') }}" />
                <x-input-error :messages="$errors->get('prenom')" class="mt-2" />
            </div>

            <!-- Champ email -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input name="email" id="email" class="block mt-1 w-full" type="email" value="{{ old('email') }}" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Bouton de soumission -->
            <div class="mt-4">
                <x-primary-button class="w-full">
                    {{ __('Créer') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-admin-layout>
