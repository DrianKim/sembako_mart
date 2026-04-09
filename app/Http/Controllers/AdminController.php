<?php

namespace App\Http\Controllers;

use App\Models\BatchProduk;
use App\Models\Kategori;
use App\Models\Log;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{

    // dashboard
    public function dashboard()
{
    $today = \Carbon\Carbon::today();
    $yesterday = \Carbon\Carbon::yesterday();

    // Omzet hari ini
    $omzetHariIni = Transaksi::whereDate('tanggal_transaksi', $today)
        ->sum('total_harga');

    // Omzet kemarin (untuk persentase perubahan)
    $omzetKemarin = Transaksi::whereDate('tanggal_transaksi', $yesterday)
        ->sum('total_harga');

    $persenOmzet = $omzetKemarin > 0
        ? round((($omzetHariIni - $omzetKemarin) / $omzetKemarin) * 100, 1)
        : 0;

    // Jumlah transaksi hari ini
    $transaksiHariIni = Transaksi::whereDate('tanggal_transaksi', $today)->count();

    // Rata-rata per transaksi
    $rataRataTransaksi = $transaksiHariIni > 0
        ? $omzetHariIni / $transaksiHariIni
        : 0;

    // Produk dengan total stok < 10
    $produkStokRendah = BatchProduk::selectRaw('produk_id, SUM(stok) as total_stok')
        ->whereNull('deleted_at')
        ->groupBy('produk_id')
        ->havingRaw('SUM(stok) < 10')
        ->count();

    // Kasir aktif
    $kasirAktif = User::where('role', 'kasir')
        ->where('status', 'aktif')
        ->count();

    // Omzet 7 hari terakhir (untuk chart)
    $omzet7Hari = Transaksi::selectRaw('DATE(tanggal_transaksi) as tanggal, SUM(total_harga) as total')
        ->whereBetween('tanggal_transaksi', [
            \Carbon\Carbon::now()->subDays(6)->startOfDay(),
            \Carbon\Carbon::now()->endOfDay(),
        ])
        ->groupBy('tanggal')
        ->orderBy('tanggal')
        ->get()
        ->keyBy('tanggal');

    // Generate lengkap 7 hari (isi 0 kalau ga ada transaksi)
    $chartLabels = [];
    $chartData = [];
    for ($i = 6; $i >= 0; $i--) {
        $date = \Carbon\Carbon::now()->subDays($i);
        $key = $date->toDateString();
        $chartLabels[] = $date->locale('id')->translatedFormat('d M');
        $chartData[] = isset($omzet7Hari[$key]) ? (float) $omzet7Hari[$key]->total : 0;
    }

    // 5 Transaksi terbaru
    $transaksiTerbaru = Transaksi::with('kasir')
        ->latest('tanggal_transaksi')
        ->limit(5)
        ->get();

    // Produk hampir kadaluarsa (dalam 7 hari ke depan)
    $produkHampirKadaluarsa = BatchProduk::with('produk')
        ->whereNull('deleted_at')
        ->whereNotNull('tanggal_kadaluarsa')
        ->whereBetween('tanggal_kadaluarsa', [
            \Carbon\Carbon::today(),
            \Carbon\Carbon::today()->addDays(7),
        ])
        ->where('stok', '>', 0)
        ->orderBy('tanggal_kadaluarsa')
        ->limit(5)
        ->get();

    return view('admin.dashboard', compact(
        'omzetHariIni',
        'omzetKemarin',
        'persenOmzet',
        'transaksiHariIni',
        'rataRataTransaksi',
        'produkStokRendah',
        'kasirAktif',
        'chartLabels',
        'chartData',
        'transaksiTerbaru',
        'produkHampirKadaluarsa',
    ));
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
            ->orderBy('nama_kategori')
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

        $produks = Produk::with(['kategori', 'batchProduks' => function ($q) {
            $q->whereNull('deleted_at')->latest();
        }])
            ->when($search, function ($query, $search) {
                $lower = strtolower($search);
                $query->whereRaw('LOWER(nama_produk) LIKE ?', ["%{$lower}%"])
                    ->orWhereRaw('LOWER(barcode) LIKE ?', ["%{$lower}%"])
                    ->orWhereHas(
                        'kategori',
                        fn($q) => $q->whereRaw('LOWER(nama_kategori) LIKE ?', ["%{$lower}%"])
                    );
            })
            ->orderBy('nama_produk')
            ->paginate(10)
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

        return view('admin.produk.index', [
            'title'   => 'Produk',
            'produks' => $produks,
            'search'  => $search,
        ]);
    }

    public function produkCreate()
    {
        return view('admin.produk.create', [
            'title'    => 'Tambah Produk',
            'kategoris' => Kategori::all(),
        ]);
    }

    public function produkStore(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id',
            'harga_jual' => 'required|numeric|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'barcode' => 'nullable|string|max:255|unique:produk,barcode',
            'satuan' => 'required|in:kg,pcs,liter',
            // Batch
            'nomor_batch' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('batch_produk', 'nomor_batch')->whereNull('deleted_at'),
            ],
            'stok_awal' => 'required|integer|min:0',
            'harga_beli' => 'required|numeric|min:0',
            'tanggal_kadaluarsa' => 'nullable|date|after:today',
        ], [
            'nama_produk.required' => 'Nama produk wajib diisi!',
            'kategori_id.required' => 'Kategori wajib dipilih!',
            'kategori_id.exists' => 'Kategori tidak valid!',
            'harga_jual.required' => 'Harga jual wajib diisi!',
            'harga_jual.numeric' => 'Harga jual harus berupa angka!',
            'harga_jual.min' => 'Harga jual tidak boleh negatif!',
            'foto.image' => 'File harus berupa gambar!',
            'foto.mimes' => 'Format gambar harus jpeg, png, jpg, atau webp!',
            'foto.max' => 'Ukuran gambar maksimal 2MB!',
            'barcode.string' => 'Barcode harus berupa teks!',
            'barcode.max' => 'Barcode maksimal 255 karakter!',
            'barcode.unique' => 'Barcode sudah digunakan oleh produk lain!',
            'satuan.required' => 'Satuan wajib dipilih!',
            'satuan.in' => 'Satuan tidak valid!',
            'nomor_batch.unique' => 'Nomor batch sudah digunakan oleh batch lain!',
            'stok_awal.required' => 'Stok awal wajib diisi!',
            'stok_awal.integer' => 'Stok awal harus berupa angka bulat!',
            'stok_awal.min' => 'Stok awal minimal 0!',
            'harga_beli.required' => 'Harga beli wajib diisi!',
            'harga_beli.numeric' => 'Harga beli harus berupa angka!',
            'harga_beli.min' => 'Harga beli tidak boleh negatif!',
            'tanggal_kadaluarsa.date' => 'Tanggal kadaluarsa harus berupa tanggal yang valid!',
            'tanggal_kadaluarsa.after' => 'Tanggal kadaluarsa harus setelah hari ini!',
        ]);

        $imgUrl = null;
        $disk = 'supabase';

        if ($request->hasFile('foto')) {
            try {
                // Pakai storeAs supaya nama file unik + folder jelas
                $filename = 'produk/' . time() . '_' . Str::random(10) . '.' .
                    $request->file('foto')->getClientOriginalExtension();

                $imgPath = $request->file('foto')->storeAs('', $filename, $disk);

                if (!$imgPath) {
                    return redirect()->back()->with('error', 'Gagal mengunggah foto ke Supabase.');
                }

                $bucket = env('SUPABASE_BUCKET', 'public');
                $baseUrl = rtrim(env('SUPABASE_PUBLIC_URL'), '/');

                // Cara yang lebih benar untuk Supabase
                $imgUrl = $baseUrl . '/storage/v1/object/public/' . $bucket . '/' . $imgPath;
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Gagal mengunggah foto: ' . $e->getMessage());
            }
        }

        $produk = Produk::create([
            'kategori_id' => $request->kategori_id,
            'nama_produk' => $request->nama_produk,
            'harga_jual' => $request->harga_jual,
            'foto' => $imgUrl,
            'barcode' => $request->barcode,
            'satuan' => $request->satuan,
        ]);

        // Buat batch pertama
        $nomorBatch = $request->nomor_batch ?: $this->generateNomorBatch($produk);

        $produk->batchProduks()->create([
            'nomor_batch'        => $nomorBatch,
            'stok'               => $request->stok_awal,
            'harga_beli'         => $request->harga_beli,
            'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa,
        ]);

        Log::create([
            'id_user' => auth()->id(),
            'aktivitas' => "User " . auth()->user()->nama . " Menambahkan produk baru: '{$request->nama_produk}'",
            'waktu' => now(),
        ]);

        return redirect()->route('admin.produk')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function produkEdit($id)
    {
        $produk = Produk::with(['kategori', 'batchProduks' => function ($q) {
            $q->whereNull('deleted_at')->latest();
        }])->findOrFail($id);

        return view('admin.produk.edit', [
            'title'    => 'Edit Produk',
            'produk'   => $produk,
            'kategoris' => Kategori::all(),
        ]);
    }

    public function produkUpdate(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id',
            'harga_jual'  => 'required|numeric|min:0',
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'barcode'     => 'nullable|string|max:255|unique:produk,barcode,' . $id,
            'satuan'      => 'required|in:kg,pcs,liter',
        ], [
            'nama_produk.required' => 'Nama produk wajib diisi!',
            'kategori_id.required' => 'Kategori wajib dipilih!',
            'kategori_id.exists' => 'Kategori tidak valid!',
            'harga_jual.required' => 'Harga jual wajib diisi!',
            'harga_jual.numeric' => 'Harga jual harus berupa angka!',
            'harga_jual.min' => 'Harga jual tidak boleh negatif!',
            'foto.image' => 'File harus berupa gambar!',
            'foto.mimes' => 'Format gambar harus jpeg, png, jpg, atau webp!',
            'foto.max' => 'Ukuran gambar maksimal 2MB!',
            'barcode.unique' => 'Barcode sudah digunakan oleh produk lain!',
            'satuan.required' => 'Satuan wajib dipilih!',
            'satuan.in' => 'Satuan tidak valid!',
        ]);

        $fotoPath = $produk->foto;   // default pakai foto lama

        if ($request->hasFile('foto')) {
            try {
                // === HAPUS FOTO LAMA DI SUPABASE (manual, tanpa deleteFromSupabase) ===
                if ($produk->foto) {
                    try {
                        // Ambil path dari URL lama
                        $oldUrl = $produk->foto;
                        $baseUrl = rtrim(env('SUPABASE_PUBLIC_URL'), '/') . '/storage/v1/object/public/' . env('SUPABASE_BUCKET', 'public') . '/';

                        $oldPath = str_replace($baseUrl, '', $oldUrl);

                        // Hapus file lama dari Supabase
                        Storage::disk('supabase')->delete($oldPath);
                    } catch (\Exception $e) {
                        // Tidak menghentikan proses kalau gagal hapus lama
                        Log::error('Gagal menghapus foto lama: ' . $e->getMessage());
                    }
                }

                // === UPLOAD FOTO BARU ===
                $filename = 'produk/' . time() . '_' . Str::random(10) . '.' .
                    $request->file('foto')->getClientOriginalExtension();

                $imgPath = $request->file('foto')->storeAs('', $filename, 'supabase');

                if (!$imgPath) {
                    return redirect()->back()->with('error', 'Gagal mengunggah foto ke Supabase.');
                }

                $bucket = env('SUPABASE_BUCKET', 'public');
                $baseUrl = rtrim(env('SUPABASE_PUBLIC_URL'), '/');

                $fotoPath = $baseUrl . '/storage/v1/object/public/' . $bucket . '/' . $imgPath;
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Gagal mengunggah foto: ' . $e->getMessage());
            }
        }

        $produk->update([
            'kategori_id' => $request->kategori_id,
            'nama_produk' => $request->nama_produk,
            'harga_jual'  => $request->harga_jual,
            'foto'        => $fotoPath,
            'barcode'     => $request->barcode,
            'satuan'      => $request->satuan,
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

        // Hapus foto dari Supabase Storage (manual, tanpa deleteFromSupabase)
        if ($produk->foto) {
            try {
                // Ambil path foto dari URL
                $baseUrl = rtrim(env('SUPABASE_PUBLIC_URL'), '/') . '/storage/v1/object/public/' . env('SUPABASE_BUCKET', 'public') . '/';
                $filePath = str_replace($baseUrl, '', $produk->foto);

                // Hapus file dari Supabase
                if ($filePath) {
                    Storage::disk('supabase')->delete($filePath);
                }
            } catch (\Exception $e) {
                // Tidak menghentikan proses delete produk kalau gagal hapus foto
                Log::error('Gagal menghapus foto dari Supabase: ' . $e->getMessage());
            }
        }

        // Hapus batch terkait
        $produk->batchProduks()->each(fn($b) => $b->delete());

        // Hapus produk
        $produk->delete();

        Log::create([
            'id_user'   => auth()->id(),
            'aktivitas' => "User " . auth()->user()->nama . " Menghapus produk: '{$produk->nama_produk}'",
            'waktu'     => now(),
        ]);

        return redirect()->route('admin.produk')->with('success', 'Produk berhasil dihapus!');
    }

    public function stokIndex(Request $request)
    {
        $search     = $request->get('search');
        $stokFilter = $request->get('stok_filter');

        $produks = Produk::with(['kategori', 'batchProduks' => function ($q) {
            $q->whereNull('deleted_at')
                ->orderByRaw('stok = 0 ASC')
                ->orderBy('tanggal_kadaluarsa', 'asc');
        }])
            ->when($search, function ($q) use ($search) {
                $lower = strtolower($search);
                $q->whereRaw('LOWER(nama_produk) LIKE ?', ["%{$lower}%"])
                    ->orWhereRaw('LOWER(barcode) LIKE ?', ["%{$lower}%"])
                    ->orWhereHas(
                        'kategori',
                        fn($q) => $q->whereRaw('LOWER(nama_kategori) LIKE ?', ["%{$lower}%"])
                    );
            })
            ->when($stokFilter, function ($q) use ($stokFilter) {
                $q->withSum(['batchProduks as total_stok_sum' => function ($query) {
                    $query->whereNull('deleted_at');
                }], 'stok');

                if ($stokFilter === 'aman') {
                    $q->having('total_stok_sum', '>', 15);
                } elseif ($stokFilter === 'peringatan') {
                    $q->having('total_stok_sum', '>=', 6)
                        ->having('total_stok_sum', '<=', 15);
                } elseif ($stokFilter === 'kritis') {
                    $q->having('total_stok_sum', '<=', 5);
                }
            })
            ->orderBy('nama_produk')
            ->paginate(10)
            ->appends(['search' => $search, 'stok_filter' => $stokFilter]);

        if ($request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'html'       => view('admin.stok._table', compact('produks'))->render(),
                'pagination' => view('admin.stok._pagination', compact('produks'))->render(),
                'total'      => $produks->total(),
                'from'       => $produks->firstItem() ?? 0,
                'to'         => $produks->lastItem() ?? 0,
            ]);
        }

        return view('admin.stok.index', [
            'title'       => 'Stok Produk',
            'produks'     => $produks,
            'search'      => $search,
            'stok_filter' => $stokFilter,
        ]);
    }

    public function stokEdit($id)
    {
        $produk = Produk::with(['kategori', 'batchProduks' => function ($q) {
            $q->whereNull('deleted_at')
                ->orderByRaw('stok = 0 ASC')
                ->orderBy('tanggal_kadaluarsa', 'asc');
        }])->findOrFail($id);

        return view('admin.stok.edit', [
            'title'  => 'Kelola Stok: ' . $produk->nama_produk,
            'produk' => $produk,
        ]);
    }

    public function stokUpdate(Request $request, $id)
    {
        $produk = Produk::with('batchProduks')->findOrFail($id);
        $aksi   = $request->input('aksi');

        // ==============================
        // AKSI 1: Edit batch yang ada
        // ==============================
        if ($aksi === 'edit_batch') {
            $request->validate([
                'batch_id'           => 'required|exists:batch_produk,id',
                // Ignore batch yang sedang diedit (by batch_id) + ignore soft-deleted
                'nomor_batch'        => [
                    'nullable',
                    'string',
                    'max:255',
                    Rule::unique('batch_produk', 'nomor_batch')
                        ->ignore($request->batch_id)      // abaikan batch yg sedang diedit
                        ->whereNull('deleted_at'),         // abaikan yang sudah soft-deleted
                ],
                'aksi_stok'          => 'required|in:tambah,kurangi,ganti',
                'jumlah_stok'        => 'required|integer|min:0',
                'harga_beli'         => 'required|numeric|min:0',
                'tanggal_kadaluarsa' => 'nullable|date',
            ], [
                'nomor_batch.unique'   => 'Nomor batch sudah digunakan oleh batch lain!',
                'aksi_stok.required'   => 'Pilih aksi stok!',
                'jumlah_stok.required' => 'Jumlah stok wajib diisi!',
                'jumlah_stok.integer'  => 'Jumlah stok harus berupa angka bulat!',
                'jumlah_stok.min'      => 'Jumlah stok tidak boleh negatif!',
                'harga_beli.required'  => 'Harga beli wajib diisi!',
                'harga_beli.numeric'   => 'Harga beli harus berupa angka!',
            ]);

            $batch = BatchProduk::where('id', $request->batch_id)
                ->where('produk_id', $id)
                ->whereNull('deleted_at')
                ->firstOrFail();

            $stokLama  = $batch->stok;
            $jumlah    = (int) $request->jumlah_stok;
            $aksiStok  = $request->aksi_stok;

            $stokBaru = match ($aksiStok) {
                'tambah'  => $stokLama + $jumlah,
                'kurangi' => max(0, $stokLama - $jumlah),
                'ganti'   => $jumlah,
            };

            $aksiLabel = match ($aksiStok) {
                'tambah'  => "ditambah {$jumlah}",
                'kurangi' => "dikurangi {$jumlah}",
                'ganti'   => "diganti menjadi {$jumlah}",
            };

            $batch->update([
                'nomor_batch'        => $request->nomor_batch,
                'stok'               => $stokBaru,
                'harga_beli'         => $request->harga_beli,
                'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa ?: null,
            ]);

            Log::create([
                'id_user'   => auth()->id(),
                'aktivitas' => "User " . auth()->user()->nama . " mengedit batch '{$batch->nomor_batch}' produk '{$produk->nama_produk}': stok {$aksiLabel} ({$stokLama} → {$stokBaru})",
                'waktu'     => now(),
            ]);

            return redirect()->route('admin.stok.edit', $id)
                ->with('success', "Batch berhasil diperbarui! Stok {$aksiLabel} → {$stokBaru}");
        }

        // ==============================
        // AKSI 2: Tambah batch baru
        // ==============================
        if ($aksi === 'tambah_batch') {
            $request->validate([
                'stok_baru'               => 'required|integer|min:1',
                'harga_beli_baru'         => 'required|numeric|min:0',
                // Tidak perlu ignore karena ini batch baru, cukup skip soft-deleted
                'nomor_batch_baru'        => [
                    'nullable',
                    'string',
                    'max:255',
                    Rule::unique('batch_produk', 'nomor_batch')
                        ->whereNull('deleted_at'),
                ],
                'tanggal_kadaluarsa_baru' => 'nullable|date|after:today',
            ], [
                'stok_baru.required'            => 'Jumlah stok wajib diisi!',
                'stok_baru.integer'             => 'Stok harus berupa angka bulat!',
                'stok_baru.min'                 => 'Stok minimal 1!',
                'harga_beli_baru.required'      => 'Harga beli wajib diisi!',
                'harga_beli_baru.numeric'       => 'Harga beli harus berupa angka!',
                'nomor_batch_baru.unique'       => 'Nomor batch sudah digunakan oleh batch lain!',
                'tanggal_kadaluarsa_baru.date'  => 'Tanggal kadaluarsa tidak valid!',
                'tanggal_kadaluarsa_baru.after' => 'Tanggal kadaluarsa harus setelah hari ini!',
            ]);

            $nomorBatch = $request->nomor_batch_baru
                ?: $this->generateNomorBatch($produk);

            $batch = $produk->batchProduks()->create([
                'nomor_batch'        => $nomorBatch,
                'stok'               => $request->stok_baru,
                'harga_beli'         => $request->harga_beli_baru,
                'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa_baru ?: null,
            ]);

            Log::create([
                'id_user'   => auth()->id(),
                'aktivitas' => "User " . auth()->user()->nama . " menambahkan batch baru '{$batch->nomor_batch}' untuk produk '{$produk->nama_produk}': stok {$request->stok_baru}",
                'waktu'     => now(),
            ]);

            return redirect()->route('admin.stok.edit', $id)
                ->with('success', "Batch baru berhasil ditambahkan! Stok +{$request->stok_baru} {$produk->satuan}");
        }

        return redirect()->route('admin.stok.edit', $id)->with('error', 'Aksi tidak dikenali.');
    }

    // Tambah helper method di controller
    private function generateNomorBatch(Produk $produk): string
    {
        $prefix = strtoupper(preg_replace('/[^A-Za-z]/', '', $produk->nama_produk));
        $prefix = substr($prefix, 0, 3);
        $tanggal = now()->format('Ymd');
        $base = "{$prefix}-{$tanggal}-";

        $existing = BatchProduk::where('nomor_batch', 'like', $base . '%')
            ->whereNull('deleted_at')
            ->pluck('nomor_batch')
            ->map(fn($nb) => str_replace($base, '', $nb))
            ->toArray();

        $suffix = 'A';
        while (in_array($suffix, $existing)) {
            $suffix = $this->nextSuffix($suffix);
        }

        return $base . $suffix;
    }

    private function nextSuffix(string $current): string
    {
        $len = strlen($current);
        $chars = str_split($current);

        for ($i = $len - 1; $i >= 0; $i--) {
            if ($chars[$i] < 'Z') {
                $chars[$i] = chr(ord($chars[$i]) + 1);
                return implode('', $chars);
            }
            $chars[$i] = 'A';
        }

        return 'A' . implode('', $chars);
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

    public function riwayatTransaksiIndex(Request $request)
    {
        $search   = $request->get('search', '');
        $fromDate = $request->get('from_date', '');
        $toDate   = $request->get('to_date', '');

        $transaksis = Transaksi::with('kasir')
            ->when($search, function ($q) use ($search) {
                $lower = strtolower($search);

                $q->where(function ($q2) use ($lower) {
                    $q2->whereRaw('LOWER(nama_pelanggan) LIKE ?', ["%{$lower}%"])
                        ->orWhereRaw('LOWER(nomor_unik) LIKE ?', ["%{$lower}%"])
                        ->orWhereHas('kasir', function ($q3) use ($lower) {
                            $q3->whereRaw('LOWER(nama) LIKE ?', ["%{$lower}%"]);
                        });
                });
            })
            ->when($fromDate, fn($q) => $q->whereDate('tanggal_transaksi', '>=', $fromDate))
            ->when($toDate,   fn($q) => $q->whereDate('tanggal_transaksi', '<=', $toDate))
            ->orderBy('tanggal_transaksi', 'desc')
            ->paginate(5)
            ->appends(compact('search', 'fromDate', 'toDate'));

        if ($request->ajax()) {
            return response()->json([
                'html'       => view('admin.riwayat_transaksi._table', compact('transaksis'))->render(),
                'pagination' => view('admin.riwayat_transaksi._pagination', compact('transaksis'))->render(),
                'total'      => $transaksis->total(),
                'from'       => $transaksis->firstItem() ?? 0,
                'to'         => $transaksis->lastItem() ?? 0,
            ]);
        }

        $data = [
            'title'      => 'Riwayat Transaksi',
            'transaksis' => $transaksis,
        ];

        return view('admin.riwayat_transaksi.index', $data);
    }

    public function riwayatTransaksiEdit($id)
    {
        $transaksi = Transaksi::with('kasir')->findOrFail($id);

        return view('admin.riwayat_transaksi.edit', [
            'title'      => 'Edit Transaksi',
            'transaksi'  => $transaksi,
        ]);
    }

    public function riwayatTransaksiUpdate(Request $request, $id)
    {
        $request->validate([
            'nama_pelanggan' => 'nullable|string|max:255',
            'total_harga'    => 'required|numeric|min:0',
            'uang_bayar'     => 'nullable|numeric|min:0',
        ]);

        // Validasi manual: uang bayar tidak boleh kurang dari total
        $uang_bayar = $request->uang_bayar ?? 0;
        if ($uang_bayar < $request->total_harga) {
            return back()
                ->withInput()
                ->withErrors(['uang_bayar' => 'Uang bayar tidak boleh kurang dari total harga.']);
        }

        $transaksi    = Transaksi::findOrFail($id);
        $uang_kembali = $uang_bayar - $request->total_harga;

        $oldNama  = $transaksi->nama_pelanggan;
        $oldTotal = $transaksi->total_harga;
        $oldBayar = $transaksi->uang_bayar;
        $kode     = $transaksi->nomor_unik;

        $transaksi->update([
            'nama_pelanggan' => $request->nama_pelanggan ?? $transaksi->nama_pelanggan,
            'total_harga'    => $request->total_harga,
            'uang_bayar'     => $uang_bayar,
            'uang_kembali'   => $uang_kembali,
        ]);

        Log::create([
            'id_user'   => auth()->id(),
            'aktivitas' => "User " . auth()->user()->nama .
                " mengubah transaksi (Kode: {$kode}) | " .
                "Nama: {$oldNama} -> {$transaksi->nama_pelanggan}, " .
                "Total: {$oldTotal} -> {$transaksi->total_harga}, " .
                "Bayar: {$oldBayar} -> {$transaksi->uang_bayar}",
            'waktu'     => now(),
        ]);

        return redirect()->route('admin.riwayat_transaksi')->with('success', 'Transaksi berhasil diperbarui!');
    }

    public function struk($id)
    {
        $transaksi = Transaksi::with(['kasir', 'detailTransaksi.produk'])->findOrFail($id);

        return view('admin.riwayat_transaksi.struk', compact('transaksi'));
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
