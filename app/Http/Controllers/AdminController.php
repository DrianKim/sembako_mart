<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $data = [
            'title' => 'Dashboard',
        ];

        return view('admin.dashboard', $data);
    }

    // Kategori
    public function kategoriIndex()
    {
        $data = [
            'title' => 'Kategori',
        ];

        return view('admin.kategori.index', $data);
    }

    public function kategoriCreate()
    {
        $data = [
            'title' => 'Tambah Kategori',
        ];

        return view('admin.kategori.create', $data);
    }

    public function kategoriStore(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ], [
            'nama_kategori.required' => 'Nama kategori harus diisi!',
            'nama_kategori.string' => 'Nama kategori harus berupa teks!',
            'nama_kategori.max' => 'Nama kategori tidak boleh lebih dari 255 karakter!',
        ]);

        Kategori::create([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()->route('admin.kategori')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function kategoriEdit($id)
    {
        $data = [
            'title' => 'Edit Kategori',
        ];

        return view('admin.kategori.edit', $data);
    }

    public function kategoriUpdate(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ], [
            'nama_kategori.required' => 'Nama kategori harus diisi!',
            'nama_kategori.string' => 'Nama kategori harus berupa teks!',
            'nama_kategori.max' => 'Nama kategori tidak boleh lebih dari 255 karakter!',
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()->route('admin.kategori')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function kategoriDelete($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return redirect()->route('admin.kategori')->with('success', 'Kategori berhasil dihapus!');
    }

    // Produk
    public function produkIndex()
    {
        $data = [
            'title' => 'Produk',
        ];

        return view('admin.produk.index', $data);
    }

    public function produkCreate()
    {
        $data = [
            'title' => 'Tambah Produk',
        ];

        return view('admin.produk.create', $data);
    }

    public function produkStore(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'gambar_produk' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'barcode' => 'nullable|string|max:255',
            'satuan' => 'required|enum:pcs,kg,liter',
        ], [
            'nama_produk.required' => 'Nama produk harus diisi!',
            'nama_produk.string' => 'Nama produk harus berupa teks!',
            'nama_produk.max' => 'Nama produk tidak boleh lebih dari 255 karakter!',
            'kategori_id.required' => 'Kategori harus dipilih!',
            'kategori_id.exists' => 'Kategori yang dipilih tidak valid!',
            'harga.required' => 'Harga harus diisi!',
            'harga.numeric' => 'Harga harus berupa angka!',
            'stok.required' => 'Stok harus diisi!',
            'stok.integer' => 'Stok harus berupa angka bulat!',
            'gambar_produk.image' => 'Gambar produk harus berupa file gambar!',
            'gambar_produk.mimes' => 'Gambar produk harus berformat jpeg, png, jpg, atau gif!',
            'gambar_produk.max' => 'Gambar produk tidak boleh lebih dari 2MB!',
            'barcode.string' => 'Barcode harus berupa teks!',
            'barcode.max' => 'Barcode tidak boleh lebih dari 255 karakter!',
            'satuan.required' => 'Satuan harus diisi!',
            'satuan.enum' => 'Satuan harus salah satu dari pcs, kg, atau liter!',
        ]);

        Produk::create([
            'nama_produk' => $request->nama_produk,
            'kategori_id' => $request->kategori_id,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'gambar_produk' => $request->gambar_produk ? $request->file('gambar_produk')->store('produk_images', 'public') : null,
            'barcode' => $request->barcode,
            'satuan' => $request->satuan,
        ]);

        return redirect()->route('admin.produk')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function produkEdit($id)
    {
        $data = [
            'title' => 'Edit Produk',
        ];

        return view('admin.produk.edit', $data);
    }

    public function produkUpdate(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'gambar_produk' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'barcode' => 'nullable|string|max:255',
            'satuan' => 'required|enum:pcs,kg,liter',
        ], [
            'nama_produk.required' => 'Nama produk harus diisi!',
            'nama_produk.string' => 'Nama produk harus berupa teks!',
            'nama_produk.max' => 'Nama produk tidak boleh lebih dari 255 karakter!',
            'kategori_id.required' => 'Kategori harus dipilih!',
            'kategori_id.exists' => 'Kategori yang dipilih tidak valid!',
            'harga.required' => 'Harga harus diisi!',
            'harga.numeric' => 'Harga harus berupa angka!',
            'stok.required' => 'Stok harus diisi!',
            'stok.integer' => 'Stok harus berupa angka bulat!',
            'gambar_produk.image' => 'Gambar produk harus berupa file gambar!',
            'gambar_produk.mimes' => 'Gambar produk harus berformat jpeg, png, jpg, atau gif!',
            'gambar_produk.max' => 'Gambar produk tidak boleh lebih dari 2MB!',
            'barcode.string' => 'Barcode harus berupa teks!',
            'barcode.max' => 'Barcode tidak boleh lebih dari 255 karakter!',
            'satuan.required' => 'Satuan harus diisi!',
            'satuan.enum' => 'Satuan harus salah satu dari pcs, kg, atau liter!',
        ]);

        $produk = Produk::findOrFail($id);

        $produk->update([
            'nama_produk' => $request->nama_produk,
            'kategori_id' => $request->kategori_id,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'gambar_produk' => $request->gambar_produk ? $request->file('gambar_produk')->store('produk_images', 'public') : $produk->gambar_produk,
            'barcode' => $request->barcode,
            'satuan' => $request->satuan,
        ]);

        return redirect()->route('admin.produk')->with('success', 'Produk berhasil diperbarui!');
    }

    public function produkDelete($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();

        return redirect()->route('admin.produk')->with('success', 'Produk berhasil dihapus!');
    }

    // Stok
    public function stokIndex()
    {
        $data = [
            'title' => 'Stok Produk',
        ];

        return view('admin.stok.index', $data);
    }

    public function stokCreate()
    {
        $data = [
            'title' => 'Tambah Stok Produk',
        ];

        return view('admin.stok.create', $data);
    }

    public function stokStore(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'stok' => 'required|integer',
        ], [
            'produk_id.required' => 'Produk harus dipilih!',
            'produk_id.exists' => 'Produk yang dipilih tidak valid!',
            'stok.required' => 'Stok harus diisi!',
            'stok.integer' => 'Stok harus berupa angka bulat!',
        ]);

        $produk = Produk::findOrFail($request->produk_id);
        $produk->update([
            'stok' => $produk->stok + $request->stok,
        ]);

        return redirect()->route('admin.stok')->with('success', 'Stok produk berhasil ditambahkan!');
    }

    public function stokEdit($id)
    {
        $data = [
            'title' => 'Edit Stok Produk',
        ];

        return view('admin.stok.edit', $data);
    }

    public function stokUpdate(Request $request, $id)
    {
        $request->validate([
            'stok' => 'required|integer',
        ], [
            'stok.required' => 'Stok harus diisi!',
            'stok.integer' => 'Stok harus berupa angka bulat!',
        ]);

        $produk = Produk::findOrFail($id);
        $produk->update([
            'stok' => $request->stok,
        ]);

        return redirect()->route('admin.stok')->with('success', 'Stok produk berhasil diperbarui!');
    }

    // Kasir
    public function kasirIndex()
    {
        $data = [
            'title' => 'Kasir',
        ];

        return view('admin.kasir.index', $data);
    }

    public function kasirCreate()
    {
        $data = [
            'title' => 'Tambah Transaksi',
        ];

        return view('admin.kasir.create', $data);
    }

    public function kasirStore(Request $request)
    {
        // create role kasir saja
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:8',
            'no_hp' => 'required|string|max:20',
            'role' => 'required|enum:admin,kasir',
            'status' => 'required|enum:aktif,nonaktif',
        ]);

        User::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'no_hp' => $request->no_hp,
            'role' => $request->role,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.kasir')->with('success', 'Kasir berhasil ditambahkan!');
    }

    public function kasirEdit($id)
    {
        $kasir = User::findOrFail($id);

        $data = [
            'title' => 'Edit Kasir',
            'kasir' => $kasir,
        ];

        return view('admin.kasir.edit', $data);
    }

    public function kasirUpdate(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'password' => 'nullable|string|min:8',
            'no_hp' => 'required|string|max:20',
            'role' => 'required|enum:admin,kasir',
            'status' => 'required|enum:aktif,nonaktif',
        ]);

        $kasir = User::findOrFail($id);
        $kasir->update([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => $request->password ? Hash::make($request->password) : $kasir->password,
            'no_hp' => $request->no_hp,
            'role' => $request->role,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.kasir')->with('success', 'Kasir berhasil diperbarui!');
    }

    // Riwayat Transaksi
    public function riwayatTransaksiIndex()
    {
        $data = [
            'title' => 'Riwayat Transaksi',
        ];

        return view('admin.riwayat_transaksi.index', $data);
    }

    public function riwayatTransaksiEdit($id)
    {
        $data = [
            'title' => 'Detail Transaksi',
        ];

        return view('admin.riwayat_transaksi.edit', $data);
    }

    public function riwayatTransaksiUpdate(Request $request, $id)
    {
        $request->validate([
            'nama_pelanggan' => 'nullable|string|max:255',
            'total_harga'    => 'required|numeric|min:0',
            'uang_bayar'     => 'nullable|numeric|min:0',
        ]);

        $transaksi = Transaksi::findOrFail($id);

        $uang_bayar = $request->uang_bayar ?? $transaksi->uang_bayar;
        $uang_kembali = max(0, $uang_bayar - $request->total_harga);

        $transaksi->update([
            'nama_pelanggan' => $request->nama_pelanggan ?? $transaksi->nama_pelanggan,
            'total_harga'    => $request->total_harga,
            'uang_bayar'     => $uang_bayar,
            'uang_kembali'   => $uang_kembali,
        ]);

        return redirect()->route('admin.riwayat_transaksi')->with('success', 'Transaksi berhasil diperbarui!');
    }

    public function struk($id)
    {
        $data = [
            'title' => 'Struk Transaksi',
        ];

        return view('admin.riwayat_transaksi.struk', $data);
    }

    // Log Aktivitas
    public function logIndex()
    {
        $data = [
            'title' => 'Log Aktivitas',
        ];

        return view('admin.log.log_aktivitas', $data);
    }
}
