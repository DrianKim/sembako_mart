<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Log;
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

        $kategoris = Kategori::query()
            ->when($search, function ($query, $search) {
                $lower = strtolower($search);
                $query->whereRaw('LOWER(nama_kategori) LIKE ?', ["%{$lower}%"]);
            })
            ->latest('id')
            ->paginate(3)
            ->appends(['search' => $search]);

        if ($request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'html'       => view('admin.kategori._table', compact('kategoris'))->render(),
                'pagination' => view('admin.kategori._pagination', compact('kategoris'))->render(),
                'total'      => $kategoris->total(),
                'from'       => $kategoris->firstItem() ?? 0,
                'to'         => $kategoris->lastItem() ?? 0,
            ]);
        }

        $data = [
            'title' => 'Produk',
            'kategoris' => $kategoris,
            'search' => $search,
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

        Log::create([
            'id_user'   => auth()->id(),
            'aktivitas' => "User " . auth()->user()->nama . " Menambahkan kategori baru: '{$request->nama_kategori}'",
            'waktu'     => now(),
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

        Log::create([
            'id_user'   => auth()->id(),
            'aktivitas' => "User " . auth()->user()->nama . " Memperbarui kategori: '{$request->nama_kategori}'",
            'waktu'     => now(),
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

        Log::create([
            'id_user'   => auth()->id(),
            'aktivitas' => "User " . auth()->user()->nama . " Menghapus kategori: '{$kategori->nama_kategori}'",
            'waktu'     => now(),
        ]);

        return redirect()->route('admin.kategori')
            ->with('success', 'Kategori berhasil dihapus!');
    }

    // Produk
    public function produkIndex(Request $request)
    {
        $search = $request->query('search', '');

        $produks = Produk::with('kategori')
            ->when($search, function ($query, $search) {
                $lower = strtolower($search);
                $query->whereRaw('LOWER(nama_produk) LIKE ?', ["%{$lower}%"])
                    ->orWhereRaw('LOWER(barcode) LIKE ?', ["%{$lower}%"])
                    ->orWhereHas(
                        'kategori',
                        fn($q) =>
                        $q->whereRaw('LOWER(nama_kategori) LIKE ?', ["%{$lower}%"])
                    );
            })
            ->latest()
            ->paginate(3)
            ->appends(['search' => $search]);

        if ($request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'html'       => view('admin.produk._table', compact('produks'))->render(),
                'pagination' => view('admin.produk._pagination', compact('produks'))->render(),
                'total'      => $produks->total(),
                'from'       => $produks->firstItem() ?? 0,
                'to'         => $produks->lastItem() ?? 0,
            ]);
        }

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

        Log::create([
            'id_user'   => auth()->id(),
            'aktivitas' => "User " . auth()->user()->nama . " Menambahkan produk baru: '{$request->nama_produk}'",
            'waktu'     => now(),
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

        Log::create([
            'id_user'   => auth()->id(),
            'aktivitas' => "User " . auth()->user()->nama . " Memperbarui produk: '{$request->nama_produk}'",
            'waktu'     => now(),
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

        Log::create([
            'id_user'   => auth()->id(),
            'aktivitas' => "User " . auth()->user()->nama . " Menghapus produk: '{$produk->nama_produk}'",
            'waktu'     => now(),
        ]);

        return redirect()->route('admin.produk')->with('success', 'Produk berhasil dihapus!');
    }

    // Stok
    public function stokIndex(Request $request)
    {
        $search = $request->get('search');
        $stokFilter = $request->get('stok_filter');

        $query = Produk::with('kategori')
            ->when($search, function ($q) use ($search) {
                $lower = strtolower($search);
                $q->whereRaw('LOWER(nama_produk) LIKE ?', ["%{$lower}%"])
                    ->orWhereRaw('LOWER(barcode) LIKE ?', ["%{$lower}%"])
                    ->orWhereHas(
                        'kategori',
                        fn($q) =>
                        $q->whereRaw('LOWER(nama_kategori) LIKE ?', ["%{$lower}%"])
                    );
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

        if ($request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'html'       => view('admin.stok._table', compact('produks'))->render(),
                'pagination' => view('admin.stok._pagination', compact('produks'))->render(),
                'total'      => $produks->total(),
                'from'       => $produks->firstItem() ?? 0,
                'to'         => $produks->lastItem() ?? 0,
            ]);
        }

        $data = [
            'title' => 'Stok',
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

        Log::create([
            'id_user'   => auth()->id(),
            'aktivitas' => "User " . auth()->user()->nama . " Menambahkan stok untuk produk '{$produk->nama_produk}': Stok lama: {$stokLama}, Stok ditambahkan: {$request->stok}, Total stok sekarang: {$produk->stok}",
            'waktu'     => now(),
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

        Log::create([
            'id_user'   => auth()->id(),
            'aktivitas' => "User " . auth()->user()->nama . " Memperbarui stok untuk produk '{$produk->nama_produk}': Stok lama: {$stokLama}, Stok baru: {$request->stok}",
            'waktu'     => now(),
        ]);

        return redirect()->route('admin.stok')->with(
            'success',
            "Stok {$produk->nama_produk} berhasil diupdate! {$stokLama} → " .
                number_format($produk->stok)
        );
    }

    // Kasir
    public function kasirIndex(Request $request)
    {
        $search = $request->get('search');
        $statusFilter = $request->get('status');

        $query = User::where('role', 'kasir')
            ->when($search, function ($q) use ($search) {
                $lower = strtolower($search);
                $q->where(function ($sub) use ($lower) {
                    $sub->whereRaw('LOWER(nama) LIKE ?', ["%{$lower}%"])
                        ->orWhereRaw('LOWER(username) LIKE ?', ["%{$lower}%"])
                        ->orWhereRaw('LOWER(no_hp) LIKE ?', ["%{$lower}%"]);
                });
            })
            ->when($statusFilter, function ($q) use ($statusFilter) {
                $q->where('status', $statusFilter);
            })
            ->orderBy('nama');

        $kasirs = $query->paginate(2);

        if ($request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'html'       => view('admin.kasir._table', compact('kasirs'))->render(),
                'pagination' => view('admin.kasir._pagination', compact('kasirs'))->render(),
                'total'      => $kasirs->total(),
                'from'       => $kasirs->firstItem() ?? 0,
                'to'         => $kasirs->lastItem() ?? 0,
            ]);
        }

        $data = [
            'title'  => 'Data Kasir',
            'kasirs' => $kasirs,
            'search' => $search,
            'status' => $statusFilter
        ];

        return view('admin.kasir.index', $data);
    }

    public function kasirCreate()
    {
        return view('admin.kasir.create');
    }

    public function kasirStore(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:8',
            'no_hp' => 'required|string|max:20|regex:/^08[0-9]{8,12}$/',
        ]);

        User::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'no_hp' => $request->no_hp,
            'role' => 'kasir',
            'status' => 'aktif',
        ]);

        Log::create([
            'id_user'   => auth()->id(),
            'aktivitas' => "User " . auth()->user()->nama . " Menambahkan kasir baru: '{$request->nama}'",
            'waktu'     => now(),
        ]);

        return redirect()->route('admin.kasir')->with('success', "Kasir {$request->nama} berhasil ditambahkan!");
    }

    public function kasirEdit($id)
    {
        $kasir = User::where('role', 'kasir')->findOrFail($id);

        return view('admin.kasir.edit', compact('kasir'));
    }

    public function kasirUpdate(Request $request, $id)
    {
        $kasir = User::where('role', 'kasir')->findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20|regex:/^08[0-9]{8,12}$/',
            'password' => 'nullable|string|min:8',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
        ]);

        $updateData = [
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $kasir->update($updateData);

        Log::create([
            'id_user'   => auth()->id(),
            'aktivitas' => "User " . auth()->user()->nama . " Memperbarui kasir: '{$request->nama}'",
            'waktu'     => now(),
        ]);

        return redirect()->route('admin.kasir')
            ->with('success', "Kasir {$kasir->nama} berhasil diperbarui!");
    }

    public function kasirToggleStatus($id)
    {
        $kasir = User::where('role', 'kasir')->findOrFail($id);

        $kasir->status = $kasir->status == 'aktif' ? 'nonaktif' : 'aktif';
        $kasir->save();

        $oldStatus = $kasir->status == 'aktif' ? 'nonaktif' : 'aktif';
        Log::create([
            'id_user'   => auth()->id(),
            'aktivitas' => "User " . auth()->user()->nama . " Mengubah status kasir (Kasir: {$kasir->nama}): {$oldStatus} -> {$kasir->status}",
            'waktu'     => now(),
        ]);

        return redirect()->route('admin.kasir')
            ->with('success', "Status kasir {$kasir->nama} berhasil diubah menjadi {$kasir->status}");
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
    public function logIndex(Request $request)
    {
        $search = $request->get('search');

        $logs = Log::with('user:id,nama,role')
            ->where('id_user', auth()->id())
            ->when($search, function ($query) use ($search) {
                $lower = strtolower($search);

                $query->where(function ($q) use ($lower) {
                    $q->whereRaw('LOWER(aktivitas) LIKE ?', ["%{$lower}%"]);
                });
            })
            ->orderBy('waktu', 'desc')
            ->paginate(10);

        if ($request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'html'       => view('admin.log._table', compact('logs'))->render(),
                'pagination' => view('admin.log._pagination', compact('logs'))->render(),
                'total'      => $logs->total(),
                'from'       => $logs->firstItem() ?? 0,
                'to'         => $logs->lastItem() ?? 0,
            ]);
        }

        $data = [
            'title'  => 'Log Aktivitas',
            'logs'   => $logs,
            'search' => $search,
        ];

        return view('admin.log.log_aktivitas', $data);
    }
}
