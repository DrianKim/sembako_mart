<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BatchProduk extends Model
{
    use SoftDeletes;

    protected $table = 'batch_produk';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'produk_id',
        'nomor_batch',
        'tanggal_kadaluarsa',
        'stok',
        'harga_beli',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }

    // Cek apakah batch sudah kadaluarsa
    public function getIsKadaluarsaAttribute()
    {
        return $this->tanggal_kadaluarsa && now()->gt($this->tanggal_kadaluarsa);
    }

    // Cek batch mendekati kadaluarsa (dalam 30 hari)
    public function getMendekatiKadaluarsaAttribute()
    {
        if (!$this->tanggal_kadaluarsa || $this->is_kadaluarsa) return false;

        $diff = now()->diffInDays($this->tanggal_kadaluarsa, false);
        return $diff >= 0 && $diff <= 30;
    }
}
