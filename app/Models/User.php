<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'nama_toko',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function modals()
    {
        return $this->hasMany(Modal::class);
    }

    public function pembelians()
    {
        return $this->hasMany(Pembelian::class);
    }

    public function penjualans()
    {
        return $this->hasMany(Penjualan::class);
    }

    public function prives()
    {
        return $this->hasMany(Prive::class);
    }
}
