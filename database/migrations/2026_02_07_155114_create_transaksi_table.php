<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kasir_id')->constrained('users')->onDelete('restrict');
            $table->dateTime('tanggal_transaksi');
            $table->string('nama_pelanggan')->default('Umum');
            $table->string('nomor_unik')->unique();
            $table->decimal('total_harga', 12, 2);
            $table->decimal('uang_bayar', 12, 2);
            $table->decimal('uang_kembali', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
