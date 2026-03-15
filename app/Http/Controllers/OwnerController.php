<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        $data = [
            'title' => 'Dashboard Owner',
        ];

        return view('owner.dashboard', $data);
    }

    // Produk
    public function produkIndex()
    {
        $data = [
            'title' => 'Produk Owner',
        ];

        return view('owner.produk.index', $data);
    }

    // User
    public function userIndex()
    {
        $data =
            [
                'title' => 'User Owner',
            ];

        return view('owner.user.index', $data);
    }

    public function userCreate()
    {
        $data = [
            'title' => 'Tambah User Owner',
        ];

        return view('owner.user.create', $data);
    }

    public function userStore(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,kasir',
            'no_hp' => 'nullable|string|max:20',
        ]);

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'no_hp' => $request->no_hp,
            'status' => 'aktif',
        ]);

        return redirect()->route('owner.user')->with('success', 'User berhasil ditambahkan.');
    }

    public function userEdit($id)
    {
        $data = [
            'title' => 'Edit User Owner',
            'id' => $id,
        ];

        return view('owner.user.edit', $data);
    }

    public function userUpdate(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'role' => 'required|in:admin,kasir',
            'no_hp' => 'nullable|string|max:20',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        User::where('id', $id)->update([
            'nama' => $request->nama,
            'role' => $request->role,
            'no_hp' => $request->no_hp,
            'status' => $request->status,
        ]);

        return redirect()->route('owner.user')->with('success', 'User berhasil diperbarui.');
    }


    // Riwayat Transaksi
    public function riwayatTransaksiIndex()
    {
        $data = [
            'title' => 'Riwayat Transaksi Owner',
        ];

        return view('owner.riwayat_transaksi.index', $data);
    }

    // Struk
    public function struk($id)
    {
        $data = [
            'title' => 'Struk Transaksi',
        ];

        return view('owner.laporan_penjualan.struk', $data);
    }

    // Laporan Penjualan
    public function laporanPenjualan()
    {
        $data = [
            'title' => 'Laporan Penjualan Owner',
        ];

        return view('owner.laporan_penjualan.index', $data);
    }

    // Log Aktivitas
    public function logIndex()
    {
        $data = [
            'title' => 'Log Aktivitas Owner',
        ];

        return view('owner.log.log_aktivitas', $data);
    }
}
