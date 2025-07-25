<?php

use App\Livewire\Pages\Supply\Dashboard;
use App\Livewire\Pages\Supply\MyRequestList;
use App\Livewire\Pages\Supply\RequestList;
use App\Livewire\Pages\Supply\StockList;
use App\Livewire\Pages\Supply\SupplyList;
use App\Livewire\Pages\Supply\UserList;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/stocks', StockList::class)->name('stocks');
    Route::get('/request-list', RequestList::class)->name('request-list');
    Route::get('/my-request-list', MyRequestList::class)->name('my-request-list');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get("/users", UserList::class)->name('user-list');
});

Route::middleware(['auth', 'verified', 'role:admin|super-admin'])->group(function () {
    Route::get('/supplies', SupplyList::class)->name('supplies');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
