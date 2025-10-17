<?php

use Illuminate\Support\Facades\Route;
use Filament\Facades\Filament;

// routes/web.php

Route::get('/login', function () {
    return redirect(Filament::getLoginUrl());
})->name('login');

Route::get('/', function () {
    return redirect()->route('login');
});