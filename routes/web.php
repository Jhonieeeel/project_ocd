<?php

use App\Livewire\Pages\Supply\Dashboard;
use App\Livewire\Pages\Supply\RequestList;
use App\Livewire\Pages\Supply\StockList;
use App\Livewire\Pages\Supply\SupplyList;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::middleware(['auth', 'verified'])->group(function() {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/stocks', StockList::class)->name('stocks');
    Route::get('/request-list', RequestList::class)->name('request-list');
});

// Route::middleware(['auth', 'verified', 'role:admin|super-admin'])->group(function () {
//     Route::get('/supplies', SupplyList::class)->name('supplies');
//     // edit roles on user route
//     // register some users or new admin|super-admin
// });

Route::middleware(['auth', 'verified', 'role:admin|super-admin'])->group(function () {
    Route::get('/supplies', SupplyList::class)->name('supplies');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

