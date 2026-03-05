<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KasirController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        $data = [
            'title' => 'Dashboard Kasir',
        ];
        return view('kasir.dashboard', $data);
    }

    // Transaksi
    public function transaksiIndex()
    {
        $data = [
            'title' => 'Transaksi',
        ];
        return view('kasir.transaksi', $data);
    }

    // Riwayat Transaksi
    public function riwayatTransaksi()
    {
        $data = [
            'title' => 'Riwayat Transaksi',
        ];
        return view('kasir.riwayat_transaksi', $data);
    }

    // Struk
    public function struk($id)
    {
        // Dummy data sementara
        $transaksi = (object) [
            'nomor_unik' => 'TRX-20260226-' . str_pad($id, 3, '0', STR_PAD_LEFT),
            'tanggal' => now()->format('d M Y H:i') . ' WIB',
            'kasir' => Auth::user()->nama ?? 'Kasir',
            'pelanggan' => 'Umum',
            'total' => 198500,
            'uang_bayar' => 200000,
            'kembalian' => 1500,
            'items' => [
                ['nama' => 'Beras Pandan Premium 5kg', 'qty' => 2, 'harga' => 78000, 'subtotal' => 156000],
                ['nama' => 'Minyak Goreng Sania 2L', 'qty' => 1, 'harga' => 42500, 'subtotal' => 42500],
            ],
        ];

        return view('kasir.struk', compact('transaksi'));
    }

    // Log Aktivitas
    public function logIndex()
    {
        $data = [
            'title' => 'Log Aktivitas',
        ];

        return view('kasir.log_aktivitas', $data);
    }
}
