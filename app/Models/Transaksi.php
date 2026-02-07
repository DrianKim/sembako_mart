<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';

    protected $fillable = [
        'kasir_id',
        'tanggal_transaksi',
        'nama_pelanggan',
        'nomor_unik',
        'total_harga',
        'uang_bayar',
        'uang_kembali',
    ];
}
