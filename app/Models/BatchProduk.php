<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class BatchProduk extends Model
{
    use SoftDeletes;

    protected $table = 'batch_produk';

    protected $fillable = [
        'produk_id',
        'nomor_batch',
        'tanggal_kadaluarsa',
        'stok',
        'harga_beli',
    ];

    protected $casts = [
        'tanggal_kadaluarsa' => 'date',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }

    // public function getIsKadaluarsaAttribute(): bool
    // {
    //     if (!$this->tanggal_kadaluarsa) {
    //         return false;
    //     }

    //     return now()->gt($this->tanggal_kadaluarsa);
    // }

    // public function getMendekatiKadaluarsaAttribute(): bool
    // {
    //     if (!$this->tanggal_kadaluarsa || $this->is_kadaluarsa) {
    //         return false;
    //     }

    //     return $this->tanggal_kadaluarsa->between(
    //         now(),
    //         now()->addDays(30)
    //     );
    // }

    // public function scopeKadaluarsa($query)
    // {
    //     return $query->whereNotNull('tanggal_kadaluarsa')
    //         ->where('tanggal_kadaluarsa', '<', now());
    // }

    // public function scopeMendekatiKadaluarsa($query)
    // {
    //     return $query->whereNotNull('tanggal_kadaluarsa')
    //         ->whereBetween('tanggal_kadaluarsa', [now(), now()->addDays(30)]);
    // }
}
