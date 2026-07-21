<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama',
        'satuan',
        'stok',
        'harga_beli',
        'harga_jual',
        'keterangan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pembelians()
    {
        return $this->hasMany(Pembelian::class);
    }

    public function penjualans()
    {
        return $this->hasMany(Penjualan::class);
    }
}
