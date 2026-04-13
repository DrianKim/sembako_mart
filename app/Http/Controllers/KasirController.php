<?php

namespace App\Http\Controllers;

use App\Models\BatchProduk;
use App\Models\DetailTransaksi;
use App\Models\Log;
use App\Models\Produk;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KasirController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        $kasirId   = Auth::id();
        $today     = Carbon::today();
        $yesterday = Carbon::yesterday();

        // Omzet hari ini (hanya transaksi kasir ini)
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

        // Jumlah transaksi hari ini
        $transaksiHariIni = Transaksi::where('kasir_id', $kasirId)
            ->whereDate('tanggal_transaksi', $today)
            ->count();

        // Rata-rata omzet per transaksi
        $rataRata = $transaksiHariIni > 0 ? $omzetHariIni / $transaksiHariIni : 0;

        // Produk stok rendah (global)
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

        $data = [
            'title'             => 'Dashboard Kasir',
            'omzetHariIni'      => $omzetHariIni,
            'omzetKemarin'      => $omzetKemarin,
            'persenOmzet'       => $persenOmzet,
            'transaksiHariIni'  => $transaksiHariIni,
            'rataRata'          => $rataRata,
            'produkStokRendah'  => $produkStokRendah,
            'transaksiTerbaru'  => $transaksiTerbaru,
        ];

        return view('kasir.dashboard', $data);
    }

    // Transaksi
    public function transaksiIndex()
    {
        return view('kasir.transaksi', [
            'title' => 'Transaksi Baru'
        ]);
    }

    public function getProduk(Request $request)
    {
        $search     = $request->search;
        $stokFilter = $request->stok_filter;
        $now        = now();
        $batas      = now()->addDays(30);

        $query = Produk::with(['kategori', 'batchProduks' => function ($q) use ($now) {
            $q->whereNull('deleted_at')
                ->where('stok', '>', 0)
                ->where(function ($q2) use ($now) {
                    // Hanya batch yang BELUM kadaluarsa
                    $q2->whereNull('tanggal_kadaluarsa')
                        ->orWhere('tanggal_kadaluarsa', '>=', $now);
                })
                ->orderBy('tanggal_kadaluarsa'); // FIFO
        }])
        ->when($search, function ($q) use ($search) {
            $q->where(function ($q2) use ($search) {
                $q2->where('nama_produk', 'like', "%{$search}%")
                    ->orWhere('barcode', 'like', "%{$search}%");
            });
        });

        $products = $query->orderBy('nama_produk')->get();

        $formatted = $products->map(function ($p) use ($stokFilter, $now, $batas) {
            // Stok hanya dari batch valid (kadaluarsa sudah difilter di query)
            $totalStok = $p->batchProduks->sum('stok');
            $hargaBeli = $p->batchProduks->first()?->harga_beli ?? 0;

            if ($stokFilter === 'tersedia' && $totalStok <= 0) return null;
            if ($stokFilter === 'sedikit' && ($totalStok <= 0 || $totalStok >= 10)) return null;
            if ($stokFilter === 'habis'   && $totalStok > 0) return null;

            // Cek batch kadaluarsa (semua batch, termasuk yg stok 0) — untuk badge warning
            $allBatches = $p->batchProduks; // sudah exclude kadaluarsa dari query
            // Tapi kita perlu load semua untuk cek mendekati
            $mendekatiKadaluarsa = $allBatches->filter(function ($b) use ($now, $batas) {
                if (!$b->tanggal_kadaluarsa) return false;
                $exp = Carbon::parse($b->tanggal_kadaluarsa);
                return $exp->gte($now) && $exp->lte($batas);
            })->count();

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
                'ada_kadaluarsa'       => false, // ga mungkin ada, udah difilter
                'mendekati_kadaluarsa' => $mendekatiKadaluarsa > 0,
                'img'                  => $p->foto ?: 'https://placehold.co/400x300?text=No+Image',
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
                $now = now();

                // Validasi stok
                $totalStok = BatchProduk::where('produk_id', $item['produk_id'])
                    ->whereNull('deleted_at')
                    ->where('stok', '>', 0)
                    ->where(function ($q) use ($now) {
                        $q->whereNull('tanggal_kadaluarsa')
                            ->orWhere('tanggal_kadaluarsa', '>=', $now);
                    })
                    ->sum('stok');

                if ($totalStok < $item['qty']) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => "Stok produk '{$item['nama']}' tidak mencukupi. Sisa stok valid: {$totalStok}"
                    ], 422);
                }

                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'produk_id'    => $item['produk_id'],
                    'qty'          => $item['qty'],
                    'harga_satuan' => $item['harga'],
                    'subtotal'     => $item['harga'] * $item['qty'],
                ]);

                // FIFO 
                $sisaKurang = $item['qty'];

                $batches = BatchProduk::where('produk_id', $item['produk_id'])
                    ->whereNull('deleted_at')
                    ->where('stok', '>', 0)
                    ->where(function ($q) use ($now) {
                        $q->whereNull('tanggal_kadaluarsa')
                            ->orWhere('tanggal_kadaluarsa', '>=', $now);
                    })
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
        $perPage  = (int) $request->get('per_page', 10);

        if (!in_array($perPage, [10, 20, 50, 100])) {
            $perPage = 10;
        }

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
            ->paginate($perPage)
            ->appends([
                'search'    => $search,
                'from_date' => $fromDate,
                'to_date'   => $toDate,
                'per_page'  => $perPage
            ]);

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
            'search'     => $search,
            'from_date'  => $fromDate,
            'to_date'    => $toDate,
            'per_page'   => $perPage,
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
        $perPage = (int) $request->get('per_page', 10);

        if (!in_array($perPage, [10, 20, 50, 100])) {
            $perPage = 10;
        }

        $logs = Log::with('user:id,nama,role')
            ->where('id_user', auth()->id())
            ->when($search, function ($query, $search) {
                $query->where('aktivitas', 'like', "%{$search}%");
            })
            ->orderBy('waktu', 'desc')
            ->paginate($perPage)
            ->appends([
                'search'   => $search,
                'per_page' => $perPage
            ]);

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
            'title'    => 'Log Aktivitas',
            'logs'     => $logs,
            'search'   => $search,
            'per_page' => $perPage,
        ];

        return view('kasir.log_aktivitas', $data);
    }
}
