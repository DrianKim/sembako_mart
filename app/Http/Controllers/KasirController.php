<?php

namespace App\Http\Controllers;

use App\Models\BatchProduk;
use App\Models\DetailTransaksi;
use App\Models\Log;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KasirController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        $kasirId = Auth::id();
        $today   = \Carbon\Carbon::today();
        $yesterday = \Carbon\Carbon::yesterday();

        // Omzet hari ini (kasir ini aja)
        $omzetHariIni = Transaksi::where('kasir_id', $kasirId)
            ->whereDate('tanggal_transaksi', $today)
            ->sum('total_harga');

        // Omzet kemarin (untuk persentase)
        $omzetKemarin = Transaksi::where('kasir_id', $kasirId)
            ->whereDate('tanggal_transaksi', $yesterday)
            ->sum('total_harga');

        $persenOmzet = $omzetKemarin > 0
            ? round((($omzetHariIni - $omzetKemarin) / $omzetKemarin) * 100, 1)
            : 0;

        // Jumlah transaksi hari ini (kasir ini)
        $transaksiHariIni = Transaksi::where('kasir_id', $kasirId)
            ->whereDate('tanggal_transaksi', $today)
            ->count();

        // Rata-rata per transaksi
        $rataRata = $transaksiHariIni > 0 ? $omzetHariIni / $transaksiHariIni : 0;

        // Produk stok rendah (global, bukan per kasir)
        $produkStokRendah = BatchProduk::selectRaw('produk_id, SUM(stok) as total_stok')
            ->whereNull('deleted_at')
            ->groupBy('produk_id')
            ->havingRaw('SUM(stok) < 10')
            ->count();

        // 5 transaksi terbaru kasir ini
        $transaksiTerbaru = Transaksi::where('kasir_id', $kasirId)
            ->latest('tanggal_transaksi')
            ->limit(5)
            ->get();

        return view('kasir.dashboard', compact(
            'omzetHariIni',
            'omzetKemarin',
            'persenOmzet',
            'transaksiHariIni',
            'rataRata',
            'produkStokRendah',
            'transaksiTerbaru',
        ));
    }

    // Transaksi
    public function transaksiIndex()
    {
        return view('kasir.transaksi', [
            'title' => 'Transaksi Baru'
        ]);
    }

    // AJAX: Ambil daftar produk
    public function getProduk(Request $request)
    {
        $search = $request->search;
        $stokFilter = $request->stok_filter;

        $query = Produk::with(['kategori', 'batchProduks' => function ($q) {
            $q->whereNull('deleted_at')
                ->where('stok', '>', 0)
                ->orderBy('tanggal_kadaluarsa'); // FIFO: yang mau expired duluan
        }])
            ->when($search, function ($q) use ($search) {
                $q->where(function ($q2) use ($search) {
                    $q2->where('nama_produk', 'like', "%{$search}%")
                        ->orWhere('barcode', 'like', "%{$search}%");
                });
            });

        $products = $query->orderBy('nama_produk')->get();

        $formatted = $products->map(function ($p) use ($stokFilter) {
            $totalStok = $p->batchProduks->sum('stok');
            $hargaBeli = $p->batchProduks->first()?->harga_beli ?? 0;

            // Filter stok
            if ($stokFilter === 'tersedia' && $totalStok <= 0) return null;
            if ($stokFilter === 'sedikit' && ($totalStok <= 0 || $totalStok >= 10)) return null;
            if ($stokFilter === 'habis' && $totalStok > 0) return null;

            // Cek ada batch hampir/sudah kadaluarsa
            $adaKadaluarsa = $p->batchProduks->filter(
                fn($b) =>
                $b->tanggal_kadaluarsa &&
                    \Carbon\Carbon::parse($b->tanggal_kadaluarsa)->isPast()
            )->count();

            $mendekatiKadaluarsa = $p->batchProduks->filter(
                fn($b) =>
                $b->tanggal_kadaluarsa &&
                    !\Carbon\Carbon::parse($b->tanggal_kadaluarsa)->isPast() &&
                    \Carbon\Carbon::parse($b->tanggal_kadaluarsa)->diffInDays(now()) <= 30
            )->count();

            return [
                'id'                   => $p->id,
                'nama'                 => $p->nama_produk,
                'harga'                => (int) $p->harga_jual,
                'harga_beli'           => (int) $hargaBeli,
                'satuan'               => $p->satuan,
                'barcode'              => $p->barcode,
                'stok'                 => (int) $totalStok,
                'kategori_id'          => $p->kategori_id,
                'kategori_nama'        => $p->kategori->nama_kategori ?? 'Lainnya',
                'ada_kadaluarsa'       => $adaKadaluarsa > 0,
                'mendekati_kadaluarsa' => $mendekatiKadaluarsa > 0,
                'img' => $p->foto
                    ? $p->foto
                    : 'https://placehold.co/400x300?text=No+Image',
            ];
        })->filter()->values();

        return response()->json($formatted);
    }

    // Proses Bayar & Simpan Transaksi
    public function prosesBayar(Request $request)
    {
        $request->validate([
            'keranjang'      => 'required|array|min:1',
            'total_harga'    => 'required|numeric',
            'uang_bayar'     => 'required|numeric|min:' . $request->total_harga,
            'nama_pelanggan' => 'nullable|string|max:100',
        ]);

        try {
            DB::beginTransaction();

            $kasirId = Auth::id();
            $namaPelanggan = $request->nama_pelanggan ?: 'Umum';
            $nomorUnik = 'SMRT-' . now()->format('Ymd') . '-' . chr(65 + Transaksi::whereDate('created_at', now()->toDateString())->count());

            $transaksi = Transaksi::create([
                'kasir_id'          => $kasirId,
                'tanggal_transaksi' => now(),
                'nama_pelanggan'    => $namaPelanggan,
                'nomor_unik'        => $nomorUnik,
                'total_harga'       => $request->total_harga,
                'uang_bayar'        => $request->uang_bayar,
                'uang_kembali'      => $request->uang_bayar - $request->total_harga,
            ]);

            foreach ($request->keranjang as $item) {
                // Validasi stok total dulu
                $totalStok = BatchProduk::where('produk_id', $item['produk_id'])
                    ->whereNull('deleted_at')
                    ->sum('stok');

                if ($totalStok < $item['qty']) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => "Stok produk '{$item['nama']}' tidak mencukupi. Sisa: {$totalStok}"
                    ], 422);
                }

                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'produk_id'    => $item['produk_id'],
                    'qty'          => $item['qty'],
                    'harga_satuan' => $item['harga'],
                    'subtotal'     => $item['harga'] * $item['qty'],
                ]);

                // FIFO: kurangi dari batch paling dekat kadaluarsa
                $sisaKurang = $item['qty'];

                $batches = BatchProduk::where('produk_id', $item['produk_id'])
                    ->whereNull('deleted_at')
                    ->where('stok', '>', 0)
                    ->orderByRaw('tanggal_kadaluarsa IS NULL, tanggal_kadaluarsa ASC')
                    ->get();

                foreach ($batches as $batch) {
                    if ($sisaKurang <= 0) break;

                    if ($batch->stok >= $sisaKurang) {
                        $batch->decrement('stok', $sisaKurang);
                        $sisaKurang = 0;
                    } else {
                        $sisaKurang -= $batch->stok;
                        $batch->update(['stok' => 0]);
                    }
                }
            }

            Log::create([
                'id_user'   => $kasirId,
                'aktivitas' => "User " . auth()->user()->nama . " Melakukan transaksi {$nomorUnik} sebesar Rp " . number_format($request->total_harga),
                'waktu'     => now(),
            ]);

            DB::commit();

            return response()->json([
                'success'      => true,
                'transaksi_id' => $transaksi->id,
                'nomor_unik'   => $nomorUnik,
                'message'      => 'Transaksi berhasil disimpan'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan transaksi: ' . $e->getMessage()
            ], 500);
        }
    }

    // Riwayat Transaksi
    public function riwayatTransaksi(Request $request)
    {
        $search   = $request->get('search', '');
        $fromDate = $request->get('from_date', '');
        $toDate   = $request->get('to_date', '');

        $transaksis = Transaksi::with('kasir')
            ->where('kasir_id', Auth::id())
            ->when($search, function ($q) use ($search) {
                $lower = strtolower($search);

                $q->where(function ($q2) use ($lower) {
                    $q2->whereRaw('LOWER(nama_pelanggan) LIKE ?', ["%{$lower}%"])
                        ->orWhereRaw('LOWER(nomor_unik) LIKE ?', ["%{$lower}%"]);
                });
            })
            ->when($fromDate, fn($q) => $q->whereDate('tanggal_transaksi', '>=', $fromDate))
            ->when($toDate,   fn($q) => $q->whereDate('tanggal_transaksi', '<=', $toDate))
            ->orderBy('tanggal_transaksi', 'desc')
            ->paginate(10)
            ->appends(compact('search', 'fromDate', 'toDate'));

        if ($request->ajax()) {
            return response()->json([
                'html'       => view('kasir._riwayat_table', compact('transaksis'))->render(),
                'pagination' => view('kasir._riwayat_pagination', compact('transaksis'))->render(),
                'total'      => $transaksis->total(),
                'from'       => $transaksis->firstItem() ?? 0,
                'to'         => $transaksis->lastItem() ?? 0,
            ]);
        }

        $data = [
            'title'      => 'Riwayat Transaksi',
            'transaksis' => $transaksis,
        ];

        return view('kasir.riwayat_transaksi', $data);
    }

    // Struk
    public function struk($id)
    {
        $transaksi = Transaksi::with(['kasir', 'detailTransaksi.produk'])->findOrFail($id);

        return view('kasir.struk', compact('transaksi'));
    }

    // Log Aktivitas
    public function logIndex(Request $request)
    {
        $search = $request->get('search');

        $logs = Log::with('user:id,nama,role')
            ->where('id_user', auth()->id())
            ->when($search, function ($query, $search) {
                $query->where('aktivitas', 'like', "%{$search}%");
            })
            ->orderBy('waktu', 'desc')
            ->paginate(10);

        if ($request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'html'       => view('kasir._log_table', compact('logs'))->render(),
                'pagination' => view('kasir._log_pagination', compact('logs'))->render(),
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

        return view('kasir.log_aktivitas', $data);
    }
}
