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
}
