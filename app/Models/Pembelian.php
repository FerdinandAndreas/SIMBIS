<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'tanggal',
        'supplier',
        'nama_barang',
        'jumlah',
        'satuan',
        'harga_beli',
        'total',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'harga_beli' => 'integer',
        'total' => 'integer',
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
