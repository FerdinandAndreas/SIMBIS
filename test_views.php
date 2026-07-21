<?php
// Test script untuk cek semua view
Auth::loginUsingId(1);

$controllers = [
    'Dashboard' => fn() => (new \App\Http\Controllers\DashboardController())->index(),
    'Transaksi Index' => fn() => (new \App\Http\Controllers\TransactionController())->index(),
    'Modal' => fn() => (new \App\Http\Controllers\TransactionController())->modal(),
    'Pembelian' => fn() => (new \App\Http\Controllers\TransactionController())->pembelian(),
    'Penjualan' => fn() => (new \App\Http\Controllers\TransactionController())->penjualan(),
    'Prive' => fn() => (new \App\Http\Controllers\TransactionController())->prive(),
    'Produk Index' => fn() => (new \App\Http\Controllers\ProductController())->index(),
    'Produk Create' => fn() => (new \App\Http\Controllers\ProductController())->create(),
    'Laporan' => fn() => (new \App\Http\Controllers\ReportController())->index(request()),
    'Akun' => fn() => (new \App\Http\Controllers\AccountController())->index(),
];

foreach ($controllers as $name => $fn) {
    try {
        $result = $fn();
        echo "OK: $name\n";
    } catch (\Throwable $e) {
        echo "ERROR: $name -> " . $e->getMessage() . " [" . basename($e->getFile()) . ":" . $e->getLine() . "]\n";
    }
}
