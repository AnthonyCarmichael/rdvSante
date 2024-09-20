<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProfileController;
use App\Livewire\Agenda;
use App\Http\Controllers\ServiceController;
use App\Models\Service;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');
Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/agenda', function () {
    return view('agenda');
})->name('agenda');

//Route::get('/agenda', Agenda::class)->name('agenda');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
