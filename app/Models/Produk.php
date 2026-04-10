<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produk extends Model
{
    use SoftDeletes;

    protected $table = 'produk';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'kategori_id',
        'nama_produk',
        'harga_jual',
        'foto',
        'barcode',
        'satuan',
    ];

    public function batchProduks()
    {
        return $this->hasMany(BatchProduk::class, 'produk_id');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'produk_id');
    }

    public function getTotalStokAttribute()
    {
        return $this->batchProduks()->whereNull('deleted_at')->sum('stok');
    }

    public function getHargaBeliAttribute()
    {
        return $this->batchProduks()->whereNull('deleted_at')->latest()->value('harga_beli') ?? 0;
    }

    public function getLatestHargaBeliAttribute()
    {
        return $this->batchProduks()
            ->whereNull('deleted_at')
            ->latest('id')
            ->value('harga_beli') ?? 0;
    }
}
