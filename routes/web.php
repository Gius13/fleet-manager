<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\DashboardController; // <--- AGGIUNTO
use Illuminate\Support\Facades\Route;

/**
 * 🟢 ROTTE PUBBLICHE (Accessibili a tutti)
 */

// Rotta per il QR Code (URL breve /v/ per facilitare la scansione)
Route::get('/v/{vehicle}', [VehicleController::class, 'showPublic'])->name('vehicles.public.show');

// Reindirizzamento della homepage alla Dashboard o alla Flotta
Route::get('/', function () {
    return redirect()->route('dashboard');
});

/**
 * 🔴 ROTTE PROTETTE (Richiedono Login e Verifica)
 */
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard Principale (Ora gestita dal Controller per mostrare i dati reali)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Gestione Flotta (CRUD Veicoli)
    Route::resource('vehicles', VehicleController::class);
    
    // Download PDF, QR ed Etichette
    Route::get('/vehicles/{vehicle}/qr-download', [VehicleController::class, 'downloadQr'])->name('vehicles.qr.download');
    Route::get('/vehicles/{vehicle}/card-download', [VehicleController::class, 'downloadCard'])->name('vehicles.card.download');
    Route::get('/vehicles/{vehicle}/label', [VehicleController::class, 'printLabel'])->name('vehicles.label');

    // Gestione Manutenzioni
    Route::prefix('vehicles/{vehicle}')->name('vehicles.')->group(function () {
        Route::get('/maintenances', [MaintenanceController::class, 'index'])->name('maintenances.index');
        Route::get('/maintenances/create', [MaintenanceController::class, 'create'])->name('maintenances.create');
        Route::post('/maintenances', [MaintenanceController::class, 'store'])->name('maintenances.store');
    });
    Route::delete('/maintenances/{maintenance}', [MaintenanceController::class, 'destroy'])->name('maintenances.destroy');

    // Impostazioni Sistema (Email Notifiche e SMTP)
    Route::controller(SettingController::class)->group(function () {
        Route::get('/settings', 'index')->name('settings.index');
        Route::post('/settings', 'update')->name('settings.update');
        Route::post('/settings/test-email', 'testEmail')->name('settings.test-email');
    });

    // Profilo Utente (Breeze)
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });
});

require __DIR__.'/auth.php';