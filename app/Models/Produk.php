<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produks';

    protected $fillable = [
        'nama_produk',
        'kategori_id',
        'harga',
        'stok',
        'gambar_produk',
        'barcode',
        'satuan',
    ];
}
