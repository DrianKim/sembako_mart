<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
                'html'       => view('owner.produk._table', compact('produks'))->render(),
                'pagination' => view('owner.produk._pagination', compact('produks'))->render(),
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

        return view('owner.produk.index', $data);
    }

    // User Management (Owner)
    public function userIndex(Request $request)
    {
        $search       = $request->get('search');
        $statusFilter = $request->get('status');
        $roleFilter   = $request->get('role');

        $users = User::whereIn('role', ['admin', 'kasir'])
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
            ->when($roleFilter, function ($q) use ($roleFilter) {
                $q->where('role', $roleFilter);
            })
            ->orderBy('nama')
            ->paginate(10);

        if ($request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'html'       => view('owner.user._table', compact('users'))->render(),
                'pagination' => view('owner.user._pagination', compact('users'))->render(),
                'total'      => $users->total(),
                'from'       => $users->firstItem() ?? 0,
                'to'         => $users->lastItem() ?? 0,
            ]);
        }

        $data = [
            'title'  => 'Daftar User',
            'users'  => $users,
            'search' => $search,
            'status' => $statusFilter,
            'role'   => $roleFilter,
        ];

        return view('owner.user.index', $data);
    }

    public function userCreate()
    {
        return view('owner.user.create');
    }

    public function userStore(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:8',
            'no_hp'    => 'required|string|max:20|regex:/^08[0-9]{8,12}$/',
            'role'     => 'required|in:admin,kasir',
        ]);

        User::create([
            'nama'     => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'no_hp'    => $request->no_hp,
            'role'     => $request->role,
            'status'   => 'aktif',
        ]);

        Log::create([
            'id_user'   => auth()->id(),
            'aktivitas' => "User " . auth()->user()->nama . " Menambahkan user baru ({$request->role}): '{$request->nama}'",
            'waktu'     => now(),
        ]);

        return redirect()->route('owner.user')->with('success', "User {$request->nama} berhasil ditambahkan!");
    }

    public function userEdit($id)
    {
        $user = User::whereIn('role', ['admin', 'kasir'])->findOrFail($id);

        return view('owner.user.edit', compact('user'));
    }

    public function userUpdate(Request $request, $id)
    {
        $user = User::whereIn('role', ['admin', 'kasir'])->findOrFail($id);

        $request->validate([
            'nama'     => 'required|string|max:255',
            'no_hp'    => 'required|string|max:20|regex:/^08[0-9]{8,12}$/',
            'password' => 'nullable|string|min:8',
            'role'     => 'required|in:admin,kasir',
        ]);

        $updateData = [
            'nama'   => $request->nama,
            'no_hp'  => $request->no_hp,
            'role'   => $request->role,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        Log::create([
            'id_user'   => auth()->id(),
            'aktivitas' => "User " . auth()->user()->nama . " Memperbarui user ({$user->role}): '{$user->nama}'",
            'waktu'     => now(),
        ]);

        return redirect()->route('owner.user')->with('success', "User {$user->nama} berhasil diperbarui!");
    }

    public function userToggleStatus($id)
    {
        $user = User::whereIn('role', ['admin', 'kasir'])->findOrFail($id);

        $oldStatus  = $user->status;
        $user->status = $user->status == 'aktif' ? 'nonaktif' : 'aktif';
        $user->save();

        Log::create([
            'id_user'   => auth()->id(),
            'aktivitas' => "User " . auth()->user()->nama . " Mengubah status user ({$user->nama}): {$oldStatus} -> {$user->status}",
            'waktu'     => now(),
        ]);

        return redirect()->route('owner.user')
            ->with('success', "Status user {$user->nama} berhasil diubah menjadi {$user->status}");
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
    public function logIndex(Request $request)
    {
        $search = $request->get('search');
        $role   = $request->get('role');

        $logs = Log::with('user:id,nama,role')
            ->whereHas('user', function ($q) {
                $q->whereIn('role', ['admin', 'kasir']);
            })
            ->when($search, function ($query) use ($search) {
                $lower = strtolower($search);
                $query->where(function ($q) use ($lower) {
                    $q->whereRaw('LOWER(aktivitas) LIKE ?', ["%{$lower}%"])
                        ->orWhereHas('user', function ($qu) use ($lower) {
                            $qu->whereRaw('LOWER(nama) LIKE ?', ["%{$lower}%"]);
                        });
                });
            })
            ->when($role, function ($query) use ($role) {
                $query->whereHas('user', function ($q) use ($role) {
                    $q->where('role', $role);
                });
            })
            ->orderBy('waktu', 'desc')
            ->paginate(10);

        if ($request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'html'       => view('owner.log._table', compact('logs'))->render(),
                'pagination' => view('owner.log._pagination', compact('logs'))->render(),
                'total'      => $logs->total(),
                'from'       => $logs->firstItem() ?? 0,
                'to'         => $logs->lastItem() ?? 0,
            ]);
        }

        $data = [
            'title'  => 'Log Aktivitas',
            'logs'   => $logs,
            'search' => $search,
            'role'   => $role,
        ];

        return view('owner.log.log_aktivitas', $data);
    }
}
