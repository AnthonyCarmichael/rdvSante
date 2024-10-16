<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ProfileController;
use App\Livewire\Agenda;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PdfController;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->middleware('auth')->name('index');

Route::get('/agenda', function () {
    return view('agenda');
})->middleware('auth')->name('agenda');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->middleware('auth')->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->middleware('auth')->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->middleware('auth')->name('profile.destroy');
});

Route::controller(ClientController::class)->group(function() {
    Route::get('/Clients', 'index')->middleware('auth')->name('clients');
});

Route::controller(TransactionController::class)->group(function() {
    Route::get('/Transactions', 'index')->middleware('auth')->name('transactions');
});


//Routes pour les services
Route::controller(ServiceController::class)->group(function () {
    Route::post('/service/ajouterService','store')->middleware('auth')->name('ajouterService');
});

Route::get('pdf', [PdfController::class, 'index'])->name('pdf');

Route::view('profile', 'profile')
    ->middleware(['auth'])->name('profile');

Route::view('/welcome', 'welcome');

/*
Route::get('/profil', function () {
    return view('profil');
})->middleware('auth')->name('profil');
*/
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');


Route::get('/profil/profil', function () {
    return view('profil/profil');
})->middleware('auth')->name('profil');

Route::get('/profil/services', function () {
    return view('profil/services');
})->middleware('auth')->name('services');

Route::get('/clinique', function () {
    return view('clinique');
})->middleware('auth')->name('clinique');

Route::get('/profil/disponibilites', function () {
    return view('profil/disponibilites');
})->middleware('auth')->name('disponibilites');


Route::get('/rendezVous', function () {
    return view('rendezVous');
})->middleware('auth')->name('rendezVous');

require __DIR__.'/auth.php';
