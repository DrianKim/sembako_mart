<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Log;   // kalau mau catat log

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
    // Halaman Transaksi (view)
    public function transaksiIndex()
    {
        return view('kasir.transaksi', [
            'title' => 'Transaksi Baru'
        ]);
    }

    // === AJAX: Ambil daftar produk ===
    public function getProduk(Request $request)
    {
        $search = $request->search;
        $stokFilter = $request->stok_filter; 

        $query = Produk::with('kategori')
            ->select('id', 'nama_produk', 'harga_jual', 'stok', 'satuan', 'barcode', 'foto')
            ->where('stok', '>=', 0);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_produk', 'like', "%{$search}%")
                    ->orWhere('barcode', 'like', "%{$search}%");
            });
        }

        // Filter stok
        if ($stokFilter === 'tersedia') {
            $query->where('stok', '>', 0);
        } elseif ($stokFilter === 'sedikit') {
            $query->whereBetween('stok', [1, 9]);
        } elseif ($stokFilter === 'habis') {
            $query->where('stok', 0);
        }

        $products = $query->orderBy('nama_produk')->get();

        // Format untuk JS (sama seperti dummy kamu)
        $formatted = $products->map(function ($p) {
            return [
                'id'       => $p->id,
                'nama'     => $p->nama_produk,
                'harga'    => (int) $p->harga_jual,
                'satuan'   => $p->satuan,
                'barcode'  => $p->barcode,
                'stok'     => (int) $p->stok,
                'img' => $p->foto
                    ? env('SUPABASE_URL') . '/storage/v1/object/public/' . $p->foto
                    : 'https://via.placeholder.com/400x300?text=No+Image',
            ];
        });

        return response()->json($formatted);
    }

    // === Proses Bayar & Simpan Transaksi ===
    public function prosesBayar(Request $request)
    {
        $request->validate([
            'keranjang'       => 'required|array|min:1',
            'total_harga'     => 'required|numeric',
            'uang_bayar'      => 'required|numeric|min:' . $request->total_harga,
            'nama_pelanggan'  => 'nullable|string|max:100',
        ]);

        try {
            DB::beginTransaction();

            $kasirId = Auth::id();
            $namaPelanggan = $request->nama_pelanggan ?: 'Umum';

            // Generate nomor unik
            $nomorUnik = 'TRX-' . now()->format('Ymd') . '-' . str_pad(rand(100, 999), 3, '0', STR_PAD_LEFT);

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
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'produk_id'    => $item['produk_id'],
                    'qty'          => $item['qty'],
                    'harga_satuan' => $item['harga'],
                    'subtotal'     => $item['harga'] * $item['qty'],
                ]);

                // Kurangi stok
                Produk::where('id', $item['produk_id'])
                    ->decrement('stok', $item['qty']);
            }

            // Catat log
            Log::create([
                'id_user'   => $kasirId,
                'aktivitas' => "User " . auth()->user()->nama . " Melakukan transaksi {$nomorUnik} sebesar Rp " . number_format($request->total_harga),
                'waktu'     => now(),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'transaksi_id' => $transaksi->id,
                'nomor_unik'   => $nomorUnik,
                'message' => 'Transaksi berhasil disimpan'
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
