<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ================= CONTROLLERS =================

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RisikoController;
use App\Http\Controllers\LossController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\Api\SasaranController;
use App\Http\Controllers\Api\KomitmenController;
use App\Http\Controllers\Api\PaketController;
use App\Http\Controllers\Api\ProfilRisikoController;

// ======================================================
// AUTH
// ======================================================

// REGISTER
Route::post('/register', [
    AuthController::class,
    'register'
]);

// LOGIN
Route::post('/login', [
    AuthController::class,
    'login'
]);

// ======================================================
// PUBLIC DASHBOARD
// ======================================================

Route::get('/dashboard', [
    DashboardController::class,
    'index'
]);

Route::get('/super-dashboard', [
    DashboardController::class,
    'index'
]);

// ======================================================
// PEGAWAI PUBLIC
// ======================================================

Route::get('/pegawai', [
    PegawaiController::class,
    'index'
]);

Route::post('/pegawai', [
    PegawaiController::class,
    'store'
]);

Route::get('/pegawai/{id}', [
    PegawaiController::class,
    'show'
]);

Route::put('/pegawai/{id}', [
    PegawaiController::class,
    'update'
]);

Route::delete('/pegawai/{id}', [
    PegawaiController::class,
    'destroy'
]);

Route::get('/pegawai-dashboard', [
    PegawaiController::class,
    'dashboard'
]);

// ======================================================
// KOMITMEN PUBLIC
// ======================================================

Route::apiResource(
    'komitmen',
    KomitmenController::class
);

// ======================================================
// PAKET PUBLIC
// ======================================================

Route::apiResource(
    'paket',
    PaketController::class
);

// ======================================================
// PROFIL RISIKO PUBLIC
// ======================================================

Route::get(
    '/profil-risiko',
    [ProfilRisikoController::class, 'index']
);

Route::post(
    '/profil-risiko',
    [ProfilRisikoController::class, 'store']
);

Route::get(
    '/profil-risiko/{id}',
    [ProfilRisikoController::class, 'show']
);

Route::put(
    '/profil-risiko/{id}',
    [ProfilRisikoController::class, 'update']
);

Route::delete(
    '/profil-risiko/{id}',
    [ProfilRisikoController::class, 'destroy']
);

// ======================================================
// SASARAN PUBLIC
// ======================================================

// GET SASARAN
Route::get(
    '/sasaran/{komitmenId}',
    [SasaranController::class, 'show']
);

// STORE / UPDATE SASARAN
Route::post(
    '/sasaran',
    [SasaranController::class, 'store']
);

// DELETE SASARAN
Route::delete(
    '/sasaran/{id}',
    [SasaranController::class, 'destroy']
);

// ======================================================
// PROTECTED ROUTES
// ======================================================

Route::middleware('auth:sanctum')->group(function () {

    // USER LOGIN
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // LOGOUT
    Route::post('/logout', [
        AuthController::class,
        'logout'
    ]);

    // ==================================================
    // RISIKO
    // ==================================================

    Route::get('/risiko', [
        RisikoController::class,
        'index'
    ]);

    Route::post('/risiko', [
        RisikoController::class,
        'store'
    ]);

    Route::put('/risiko/{id}', [
        RisikoController::class,
        'update'
    ]);

    Route::delete('/risiko/{id}', [
        RisikoController::class,
        'destroy'
    ]);

    // ==================================================
    // LOSS
    // ==================================================

    Route::get('/loss', [
        LossController::class,
        'index'
    ]);

    Route::post('/loss', [
        LossController::class,
        'store'
    ]);

});