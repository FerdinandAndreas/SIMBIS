<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Modal;
use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\Prive;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Default User requested by user
        $user = User::create([
            'name' => 'Septian Deva Baskara',
            'email' => 'septiandevabaskara@gmail.com',
            'password' => Hash::make('12345'),
            'nama_toko' => 'UD PADI SAMUDRA',
        ]);

        // 2. Create Sample Products
        $p1 = Product::create([
            'user_id' => $user->id,
            'nama' => 'Beras Premium 25kg',
            'satuan' => 'Karung',
            'stok' => 45,
            'harga_beli' => 250000,
            'harga_jual' => 320000,
            'keterangan' => 'Stok beras kualitas super',
        ]);

        $p2 = Product::create([
            'user_id' => $user->id,
            'nama' => 'Minyak Goreng 2L',
            'satuan' => 'Pouch',
            'stok' => 30,
            'harga_beli' => 28000,
            'harga_jual' => 35000,
            'keterangan' => 'Minyak kemasan pouch 2 liter',
        ]);

        $p3 = Product::create([
            'user_id' => $user->id,
            'nama' => 'Gula Pasir 1kg',
            'satuan' => 'Bungkus',
            'stok' => 50,
            'harga_beli' => 14000,
            'harga_jual' => 17500,
            'keterangan' => 'Gula kristal putih',
        ]);

        // 3. Create Sample Initial Capital (Modal)
        Modal::create([
            'user_id' => $user->id,
            'tanggal' => Carbon::now()->startOfMonth(),
            'nominal' => 20000000,
            'keterangan' => 'Modal awal usaha',
        ]);

        // 4. Create Sample Purchases (Pembelian)
        Pembelian::create([
            'user_id' => $user->id,
            'product_id' => $p1->id,
            'tanggal' => Carbon::now()->subDays(10),
            'supplier' => 'UD Maju Jaya',
            'nama_barang' => $p1->nama,
            'jumlah' => 10,
            'satuan' => $p1->satuan,
            'harga_beli' => 250000,
            'total' => 2500000,
            'keterangan' => 'Stok tambahan bulan ini',
        ]);

        // 5. Create Sample Sales (Penjualan)
        Penjualan::create([
            'user_id' => $user->id,
            'product_id' => $p1->id,
            'no_invoice' => 'INV/' . Carbon::now()->format('Y/m') . '/020',
            'tanggal' => Carbon::now(),
            'nama_barang' => $p1->nama,
            'jumlah' => 5,
            'satuan' => $p1->satuan,
            'harga_jual' => 320000,
            'total' => 1600000,
            'bayar' => 2000000,
            'kembalian' => 400000,
            'nama_pelanggan' => 'Pelanggan Setia',
            'keterangan' => 'Penjualan tunai kasir',
        ]);

        // 6. Create Sample Prive (Pengeluaran)
        Prive::create([
            'user_id' => $user->id,
            'tanggal' => Carbon::now()->subDays(2),
            'kategori' => 'Makan',
            'nominal' => 150000,
            'keterangan' => 'Makan siang operasional toko',
        ]);
    }
}
