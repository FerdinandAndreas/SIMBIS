<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;

// Grup route yang membutuhkan autentikasi
Route::middleware(['auth'])->group(function () {

    // Dashboard / Beranda
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Profile (Breeze compatibility alias)
    Route::get('/profile', [AccountController::class, 'index'])->name('profile.edit');
    Route::patch('/profile', [AccountController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Master Produk
    Route::prefix('produk')->name('produk.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/tambah', [ProductController::class, 'create'])->name('create');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::get('/{produk}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{produk}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{produk}', [ProductController::class, 'destroy'])->name('destroy');
    });

    // Transaksi
    Route::prefix('transaksi')->name('transaksi.')->group(function () {
        Route::get('/', [TransactionController::class, 'index'])->name('index');

        Route::get('/modal', [TransactionController::class, 'modal'])->name('modal');
        Route::post('/modal', [TransactionController::class, 'storeModal'])->name('modal.store');

        Route::get('/pembelian', [TransactionController::class, 'pembelian'])->name('pembelian');
        Route::post('/pembelian', [TransactionController::class, 'storePembelian'])->name('pembelian.store');

        Route::get('/penjualan', [TransactionController::class, 'penjualan'])->name('penjualan');
        Route::post('/penjualan', [TransactionController::class, 'storePenjualan'])->name('penjualan.store');

        Route::get('/prive', [TransactionController::class, 'prive'])->name('prive');
        Route::post('/prive', [TransactionController::class, 'storePrive'])->name('prive.store');

        Route::get('/struk/{id}', [TransactionController::class, 'struk'])->name('struk');
        // Batch print multiple receipts
        Route::post('/struk/batch', [TransactionController::class, 'batchStruk'])->name('struk.batch');
        // Delete routes for transaction types
        Route::delete('/pembelian/{id}', [TransactionController::class, 'destroyPembelian'])->name('pembelian.destroy');
        Route::delete('/penjualan/{id}', [TransactionController::class, 'destroyPenjualan'])->name('penjualan.destroy');
        Route::delete('/modal/{id}', [TransactionController::class, 'destroyModal'])->name('modal.destroy');
        Route::delete('/prive/{id}', [TransactionController::class, 'destroyPrive'])->name('prive.destroy');
    });

    // Laporan
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/export/pdf', [ReportController::class, 'exportPdf'])->name('pdf');
        Route::get('/export/excel', [ReportController::class, 'exportExcel'])->name('excel');
    });

    // Akun
    Route::get('/akun', [AccountController::class, 'index'])->name('akun.index');
    Route::put('/akun', [AccountController::class, 'update'])->name('akun.update');
    Route::put('/akun/password', [AccountController::class, 'updatePassword'])->name('akun.password');
});

require __DIR__ . '/auth.php';
