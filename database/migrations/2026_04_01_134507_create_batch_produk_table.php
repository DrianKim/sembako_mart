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
        Schema::create('batch_produk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id')->constrained('produk')->cascadeOnDelete();
            $table->string('nomor_batch')->nullable();
            $table->date('tanggal_kadaluarsa')->nullable();
            $table->integer('stok')->default(0);
            $table->decimal('harga_beli', 10, 2);
            $table->softDeletes('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batch_produk');
    }
};
