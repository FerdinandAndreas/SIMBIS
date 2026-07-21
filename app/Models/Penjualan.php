<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'no_invoice',
        'tanggal',
        'nama_barang',
        'jumlah',
        'satuan',
        'harga_jual',
        'total',
        'bayar',
        'kembalian',
        'nama_pelanggan',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'harga_jual' => 'integer',
        'total' => 'integer',
        'bayar' => 'integer',
        'kembalian' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
