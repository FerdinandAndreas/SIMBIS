<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penjualans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->string('no_invoice')->unique();
            $table->date('tanggal');
            $table->string('nama_barang');
            $table->integer('jumlah');
            $table->string('satuan')->default('pcs');
            $table->bigInteger('harga_jual');
            $table->bigInteger('total');
            $table->bigInteger('bayar');
            $table->bigInteger('kembalian')->default(0);
            $table->string('nama_pelanggan')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penjualans');
    }
};
