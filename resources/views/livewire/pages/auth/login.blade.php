<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('index', absolute: false), navigate: true);
    }
}; ?>

<div>
    <div class="text-center mb-4">
        <label class="text-3xl mt-8 font-medium text-white" for="Title">Connexion</label>
    </div>

    <x-input-error :messages="$errors->get('form.email')" class="mt-2 mb-4" />

    <div class="">
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form wire:submit="login" class="">
            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input wire:model="form.email" id="email" class="block mt-1 w-full" type="email" name="email" required autofocus autocomplete="username" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Mot de passe')" />

                <x-text-input wire:model="form.password" id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <x-primary-button class="ms-3">
                    {{ __('Se connecter') }}
                </x-primary-button>

                <label for="remember" class="inline-flex items-center ml-4">
                    <input wire:model="form.remember" id="remember" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Se souvenir ') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-center mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}" wire:navigate>
                        {{ __('Mot de passe oublié?') }}
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>
