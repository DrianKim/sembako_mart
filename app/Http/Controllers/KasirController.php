<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return view('kasir.riwayat', $data);
    }
}
