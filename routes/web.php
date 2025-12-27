<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MaintenanceRecordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AlatBermasalahController;
use App\Http\Controllers\MasterAsetController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Homepage (Welcome)
Route::get('/', function () {
    return view('welcome');
});

// Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
    Route::get('/dashboard/riwayat', [DashboardController::class, 'riwayat'])->name('dashboard.riwayat');

// Routes yang membutuhkan autentikasi
Route::middleware('auth')->group(function () {

    // ================= PROFILE =================
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ================= ITEMS / ASET =================
    Route::resource('items', ItemController::class);
    Route::get('items/export', [ItemController::class, 'export'])->name('items.export');
    Route::post('items/import', [ItemController::class, 'import'])->name('items.import');

    // ================= MAINTENANCE =================
    Route::get('/items/{item}/maintenance', [MaintenanceRecordController::class, 'index'])
        ->name('maintenance.index');
    Route::post('/items/{item}/maintenance', [MaintenanceRecordController::class, 'store'])
        ->name('maintenance.store');
    Route::get('/maintenance/{record}/edit', [MaintenanceRecordController::class, 'edit'])
        ->name('maintenance.edit');
    Route::put('/maintenance/{record}', [MaintenanceRecordController::class, 'update'])
        ->name('maintenance.update');
    Route::put('/maintenance/{record}/finish', [MaintenanceRecordController::class, 'finish'])
        ->name('maintenance.finish');

    // ================= ALAT BERMASALAH =================
    Route::resource('alat-bermasalah', AlatBermasalahController::class);

    // ================= TEST SESSION (opsional) =================
    Route::get('/test-session', function () {
        session(['test' => 'ok']);
        return session('test');
    });

});

// ================= AUTH ROUTES =================
require __DIR__.'/auth.php';
