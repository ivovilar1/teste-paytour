<?php

use App\Livewire\Auth;
use App\Livewire\Dashboard;
use Illuminate\Support\Facades\Route;

Route::get('/login', Auth\Login::class)->name('login');


Route::middleware('auth')->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');
});
