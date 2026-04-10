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

    protected $casts = [
        'tanggal_transaksi' => 'datetime',
        'total_harga'       => 'decimal:2',
        'uang_bayar'        => 'decimal:2',
        'uang_kembali'      => 'decimal:2',
    ];

    public function kasir()
    {
        return $this->belongsTo(User::class, 'kasir_id');
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'transaksi_id');
    }
}
