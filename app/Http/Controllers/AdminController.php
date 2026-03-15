<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Supabase\SupabaseClient;

class AdminController extends Controller
{

    //supabase upload
    private function uploadToSupabase($file)
    {
        $bucket = 'produk_images';
        $fileName = 'produk_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => env('SUPABASE_URL') . "/storage/v1/object/{$bucket}/{$fileName}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_POSTFIELDS => file_get_contents($file->getRealPath()),
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer " . env('SUPABASE_SERVICE_KEY'),
                "Content-Type: " . $file->getMimeType(),
            ],
        ]);

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($httpCode === 200) {
            return "{$bucket}/{$fileName}";
        }
        return null;
    }

    private function deleteFromSupabase($filePath)
    {
        $fileName = basename($filePath);
        $bucket = 'produk_images';

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => env('SUPABASE_URL') . "/storage/v1/object/{$bucket}/{$fileName}",
            CURLOPT_CUSTOMREQUEST => "DELETE",
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer " . env('SUPABASE_SERVICE_KEY'),
            ],
        ]);
        curl_exec($curl);
        curl_close($curl);
    }



    // dashboard
    public function dashboard()
    {
        $data = [
            'title' => 'Dashboard',
        ];

        return view('admin.dashboard', $data);
    }

    // Kategori
    public function kategoriIndex(Request $request)
    {
        $search = $request->query('search', '');

        $query = Kategori::query();

        if ($search !== '') {
            $query->where('nama_kategori', 'like', "%{$search}%");
        }

        $kategoris = $query->latest('id')->paginate(3);

        $data = [
            'title'     => 'Kategori Produk',
            'kategoris' => $kategoris,
            'search'    => $search,
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
            'nama_kategori' => 'required|string|max:255|unique:kategori,nama_kategori',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi!',
            'nama_kategori.unique'   => 'Nama kategori ini sudah ada, gunakan nama lain.',
            'nama_kategori.max'      => 'Maksimal 255 karakter.',
        ]);

        Kategori::create([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()->route('admin.kategori')
            ->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function kategoriEdit($id)
    {
        $kategori = Kategori::findOrFail($id);

        $data = [
            'title'    => 'Edit Kategori',
            'kategori' => $kategori,
        ];

        return view('admin.kategori.edit', $data);
    }

    public function kategoriUpdate(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $request->validate([
            'nama_kategori' => "required|string|max:255|unique:kategori,nama_kategori,{$id}",
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi!',
            'nama_kategori.unique'   => 'Nama kategori ini sudah dipakai.',
        ]);

        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()->route('admin.kategori')
            ->with('success', 'Kategori berhasil diperbarui!');
    }

    public function kategoriDelete($id)
    {
        $kategori = Kategori::findOrFail($id);

        if ($kategori->produk()->exists()) {
            return redirect()->back()
                ->with('error', 'Kategori ini masih digunakan oleh produk, tidak bisa dihapus!');
        }

        $kategori->delete();

        return redirect()->route('admin.kategori')
            ->with('success', 'Kategori berhasil dihapus!');
    }

    // Produk
    public function produkIndex(Request $request)
    {
        $search = $request->query('search', '');
        $produks = Produk::with('kategori')
            ->when($search, function ($query, $search) {
                $query->where('nama_produk', 'like', "%{$search}%")
                    ->orWhere('barcode', 'like', "%{$search}%")
                    ->orWhereHas('kategori', fn($q) => $q->where('nama_kategori', 'like', "%{$search}%"));
            })
            ->latest()
            ->paginate(3)
            ->appends(['search' => $search]);

        $data = [
            'title' => 'Produk',
            'produks' => $produks,
            'search' => $search,
        ];

        return view('admin.produk.index', $data);
    }

    public function produkCreate()
    {
        $data = [
            'title' => 'Tambah Produk',
            'kategoris' => Kategori::all(),
        ];
        return view('admin.produk.create', $data);
    }

    public function produkStore(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|gt:harga_beli',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'barcode' => 'nullable|string|max:255|unique:produk,barcode',
            'satuan' => 'required|in:kg,pcs,liter',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $this->uploadToSupabase($request->file('foto'));
        }

        Produk::create([
            'kategori_id' => $request->kategori_id,
            'nama_produk' => $request->nama_produk,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'foto' => $fotoPath,
            'barcode' => $request->barcode,
            'satuan' => $request->satuan,
        ]);

        return redirect()->route('admin.produk')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function produkEdit($id)
    {
        $produk = Produk::with('kategori')->findOrFail($id);
        $data = [
            'title' => 'Edit Produk',
            'produk' => $produk,
            'kategoris' => Kategori::all(),
        ];
        return view('admin.produk.edit', $data);
    }

    public function produkUpdate(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|gt:harga_beli',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'barcode' => 'nullable|string|max:255|unique:produk,barcode,' . $id,
            'satuan' => 'required|in:kg,pcs,liter',
        ]);

        $fotoPath = $produk->foto;
        if ($request->hasFile('foto')) {
            // Hapus foto lama dari Supabase (optional)
            if ($produk->foto) {
                $this->deleteFromSupabase($produk->foto);
            }
            $fotoPath = $this->uploadToSupabase($request->file('foto'));
        }

        $produk->update([
            'kategori_id' => $request->kategori_id,
            'nama_produk' => $request->nama_produk,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'foto' => $fotoPath,
            'barcode' => $request->barcode,
            'satuan' => $request->satuan,
        ]);

        return redirect()->route('admin.produk')->with('success', 'Produk berhasil diperbarui!');
    }

    public function produkDelete($id)
    {
        $produk = Produk::findOrFail($id);

        // Hapus foto dari Supabase jika ada
        if ($produk->foto) {
            $this->deleteFromSupabase($produk->foto);
        }

        $produk->delete();

        return redirect()->route('admin.produk')->with('success', 'Produk berhasil dihapus!');
    }

    // Stok
    public function stokIndex(Request $request)
    {
        $search = $request->get('search');
        $stokFilter = $request->get('stok_filter');

        $query = Produk::with('kategori')
            ->when($search, function ($q) use ($search) {
                $q->where('nama_produk', 'like', "%{$search}%")
                    ->orWhere('barcode', 'like', "%{$search}%");
            })
            ->when($stokFilter, function ($q) use ($stokFilter) {
                if ($stokFilter == 'aman') {
                    $q->where('stok', '>', 15);
                } elseif ($stokFilter == 'peringatan') {
                    $q->whereBetween('stok', [6, 15]);
                } elseif ($stokFilter == 'kritis') {
                    $q->where('stok', '<=', 5);
                }
            })
            ->orderBy('nama_produk');

        $produks = $query->paginate(3);

        $data = [
            'title' => 'Stok Produk',
            'produks' => $produks,
            'search' => $search,
            'stok_filter' => $stokFilter
        ];

        return view('admin.stok.index', $data);
    }

    public function stokCreate($id)
    {
        $produk = Produk::with('kategori')->findOrFail($id);

        $data = [
            'title' => 'Tambah Stok: ' . $produk->nama_produk,
            'produk' => $produk
        ];

        return view('admin.stok.create', $data);
    }

    public function stokStore(Request $request, $id)
    {
        $request->validate([
            'stok' => 'required|integer|min:1',
        ], [
            'stok.required' => 'Stok harus diisi!',
            'stok.integer' => 'Stok harus berupa angka bulat!',
            'stok.min' => 'Stok minimal 1!',
        ]);

        $produk = Produk::findOrFail($id);
        $stokLama = $produk->stok;

        $produk->update([
            'stok' => $produk->stok + $request->stok,
        ]);

        return redirect()->route('admin.stok')->with(
            'success',
            "Stok produk berhasil diperbarui! Stok lama: {$stokLama}, Stok ditambahkan: {$request->stok}, Total stok sekarang: {$produk->stok}"
        );
    }

    public function stokEdit($id)
    {
        $produk = Produk::with('kategori')->findOrFail($id);

        $data = [
            'title' => 'Edit Stok: ' . $produk->nama_produk,
            'produk' => $produk
        ];

        return view('admin.stok.edit', $data);
    }

    public function stokUpdate(Request $request, $id)
    {
        $request->validate([
            'stok' => 'required|integer|min:0',
        ], [
            'stok.required' => 'Stok harus diisi!',
            'stok.integer' => 'Stok harus berupa angka bulat!',
            'stok.min' => 'Stok tidak boleh negatif!',
        ]);

        $produk = Produk::findOrFail($id);
        $stokLama = $produk->stok;

        $produk->update([
            'stok' => $request->stok,
        ]);

        return redirect()->route('admin.stok')->with(
            'success',
            "Stok {$produk->nama_produk} berhasil diupdate! {$stokLama} → " .
                number_format($produk->stok)
        );
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
