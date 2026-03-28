<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

// 🟢 ROTTA PUBBLICA (QR Code): Accessibile a TUTTI senza login
// Usiamo /v/ per brevità nel QR Code
Route::get('/v/{vehicle}', [VehicleController::class, 'showPublic'])->name('vehicles.public.show');

// Reindirizzamento Homepage
Route::get('/', function () {
    return redirect()->route('vehicles.index');
});

// 🔴 ROTTE PROTETTE: Richiedono login e verifica email
Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Gestione Flotta (Privata)
    Route::resource('vehicles', VehicleController::class);
    
    // Download PDF e QR (Privati)
    Route::get('/vehicles/{vehicle}/qr-download', [VehicleController::class, 'downloadQr'])->name('vehicles.qr.download');
    Route::get('/vehicles/{vehicle}/card-download', [VehicleController::class, 'downloadCard'])->name('vehicles.card.download');
    Route::get('/vehicles/{vehicle}/label', [VehicleController::class, 'printLabel'])->name('vehicles.label');

    // Manutenzioni
    Route::get('/vehicles/{vehicle}/maintenances', [MaintenanceController::class, 'index'])->name('vehicles.maintenances.index');
    Route::post('/vehicles/{vehicle}/maintenances', [MaintenanceController::class, 'store'])->name('vehicles.maintenances.store');
    Route::delete('/maintenances/{maintenance}', [MaintenanceController::class, 'destroy'])->name('maintenances.destroy');
    Route::get('/vehicles/{vehicle}/maintenances/create', [MaintenanceController::class, 'create'])->name('vehicles.maintenances.create');

    // Impostazioni Email Notifiche
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
    Route::post('/settings/test-email', [SettingController::class, 'testEmail'])->name('settings.test-email');
    // Profilo Utente
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';