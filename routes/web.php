<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProfileController;
use App\Livewire\Agenda;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/agenda', Agenda::class)->name('agenda');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::controller(ClientController::class)->group(function() {
    Route::get('/Clients', 'index')->name('clients');
});


require __DIR__.'/auth.php';
