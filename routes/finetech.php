<?php

use App\Http\Controllers\Finetech\AuthenticationController;
use App\Http\Controllers\Finetech\AuthorizationController;
use App\Http\Controllers\Finetech\DashboardController;
use App\Http\Controllers\Finetech\ProfileController;
use App\Http\Controllers\Finetech\SettingController;
use App\Http\Controllers\Finetech\ThemeController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'finetech', 'as' => 'finetech.'], function () {

    // guest route
    Route::group(['middleware' => 'finetech:guest'], function () {
        Route::get('/', fn() => redirect()->route('finetech.login'));
        Route::get('login', [AuthenticationController::class, 'create'])->name('login');
        Route::post('login', [AuthenticationController::class, 'store']);

    });

    // auth Route
    Route::group(['middleware' => 'finetech:auth'], function () {

        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('themes/toggle', [ThemeController::class, 'toggle'])->name('themes.toggle');
        Route::group(['prefix' => "settings", 'as' => 'settings.'], function () {
            Route::get('/edit', [SettingController::class, 'edit'])->name('edit');
            Route::put('/edit', [SettingController::class, 'update'])->name('update');
        });

        Route::resource('authorization', AuthorizationController::class)
            ->parameters(['authorization' => 'role']);

        Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
            Route::get('/', [ProfileController::class, 'index'])->name('index');
            Route::get('update', [ProfileController::class, 'profile'])->name('update');
            Route::put('/update', [ProfileController::class, 'profileUpdate']);
            Route::get('/password', [ProfileController::class, 'password'])->name('password');
            Route::patch('/password', [ProfileController::class, 'passwordUpdate']);
        });

        Route::post('logout', [AuthenticationController::class, 'destroy'])->name('logout');

    });

});
