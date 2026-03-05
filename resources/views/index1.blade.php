@extends('admin.layouts.app')

@section('title', 'Kelola User')

@section('content')
    <!-- Import font -->
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- HEADER -->
    <div class="mb-6">
        <h1 class="font-serif text-3xl font-bold leading-tight text-gray-900 md:text-4xl">Kelola Pengguna</h1>
        <p class="mt-1 text-sm text-gray-600">Manajemen akun & hak akses sistem</p>
    </div>

    <!-- FLASH MESSAGES -->
    @if (session('success'))
        <div
            class="flex items-center gap-3 px-5 py-3 mb-6 text-sm font-medium text-green-800 border border-green-200 rounded-xl bg-green-50 animate-fade-in">
            <i class="text-lg fas fa-circle-check"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div
            class="flex items-center gap-3 px-5 py-3 mb-6 text-sm font-medium text-red-800 border border-red-200 rounded-xl bg-red-50 animate-fade-in">
            <i class="text-lg fas fa-circle-xmark"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="px-5 py-4 mb-6 border border-orange-200 rounded-xl bg-orange-50 animate-fade-in">
            <p class="mb-2 text-xs font-bold tracking-wider text-orange-800 uppercase">
                <i class="mr-1 fas fa-triangle-exclamation"></i> Ada kesalahan:
            </p>
            <ul class="pl-6 space-y-1 text-sm text-orange-700 list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- FILTER BAR - TOMBOL CREATE ADA DI SINI, SEJAJAR -->
    <div class="p-5 mb-8 bg-white border border-gray-200 shadow-sm rounded-xl">
        <form method="GET" action="#" class="flex flex-col flex-wrap items-end gap-4 sm:flex-row sm:items-center">
            <!-- Search -->
            <div class="relative flex-1 min-w-[260px]">
                <input type="text" name="search" id="searchInput" placeholder="Cari nama lengkap atau username..."
                    value="{{ request('search') }}"
                    class="w-full pl-10 pr-10 py-2.5 bg-gray-50 border border-gray-300 rounded-xl text-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-200/50 transition-all placeholder:text-gray-400"
                    autocomplete="off">
                <i
                    class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                <button type="button" id="searchClear"
                    class="absolute hidden text-gray-400 transition-colors -translate-y-1/2 right-3 top-1/2 hover:text-red-500">
                    <i class="text-sm fas fa-times"></i>
                </button>
            </div>

            <!-- Role -->
            <select name="role" id="roleFilter"
                class="bg-gray-50 border border-gray-300 text-gray-700 text-sm rounded-xl focus:ring-teal-500 focus:border-teal-500 block py-2.5 pl-3.5 pr-10 custom-select-arrow min-w-[160px]">
                <option value="">Semua Role</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="kasir" {{ request('role') == 'kasir' ? 'selected' : '' }}>Kasir</option>
                <option value="owner" {{ request('role') == 'owner' ? 'selected' : '' }}>Owner</option>
            </select>

            <!-- Tombol Filter, Reset, Tambah Pengguna -->
            <div class="flex flex-wrap gap-3">
                <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 text-white text-sm font-medium rounded-xl bg-gradient-to-r from-teal-600 to-teal-700 shadow-md hover:shadow-lg transition-all">
                    <i class="text-xs fas fa-filter"></i> Filter
                </button>

                <a href="#"
                    class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-teal-700 bg-white border border-teal-200 rounded-xl hover:bg-teal-50 transition-all">
                    <i class="text-xs fas fa-undo-alt"></i> Reset
                </a>

                <!-- TOMBOL TAMBAH ADA DI SINI -->
                <button type="button"
                    class="inline-flex items-center gap-2 px-5 py-2.5 text-white text-sm font-medium rounded-xl bg-gradient-to-r from-teal-500 to-teal-600 shadow-md hover:shadow-lg transition-all"
                    data-bs-toggle="modal" data-bs-target="#createModal">
                    <i class="text-xs fas fa-user-plus"></i> Tambah Pengguna
                </button>
            </div>
        </form>

        <!-- Active tags -->
        @if (request('search') || request('role'))
            <div class="flex flex-wrap gap-2 mt-4">
                @if (request('search'))
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-teal-50 border border-teal-200 text-teal-700 text-xs font-medium">
                        <i class="text-xs fas fa-search"></i> "{{ request('search') }}"
                        <a href="{{ route('admin.users.index', array_merge(request()->except('search'), ['role' => request('role')])) }}"
                            class="ml-1 font-bold text-teal-400 hover:text-rose-500">&times;</a>
                    </span>
                @endif
                @if (request('role'))
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-teal-50 border border-teal-200 text-teal-700 text-xs font-medium">
                        <i class="text-xs fas fa-tag"></i> {{ ucfirst(request('role')) }}
                        <a href="{{ route('admin.users.index', array_merge(request()->except('role'), ['search' => request('search')])) }}"
                            class="ml-1 font-bold text-teal-400 hover:text-rose-500">&times;</a>
                    </span>
                @endif
            </div>
        @endif
    </div>

    <!-- TABEL -->
    <div class="overflow-hidden bg-white border border-gray-200 shadow-sm rounded-xl">
        <div class="p-4 border-b border-gray-200">
            <p class="text-sm text-gray-600">
                <span class="font-bold text-gray-900">2</span> pengguna ditemukan
                @if (request('search') || request('role'))
                    <span class="mx-2 text-gray-400">·</span>
                    <a href="{{ route('admin.users.index') }}" class="font-medium text-rose-500 hover:text-rose-700">Hapus
                        filter</a>
                @endif
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="text-xs tracking-wider text-white uppercase bg-gradient-to-r from-teal-800 to-teal-700">
                    <tr>
                        <th class="w-16 px-6 py-4 text-center">No</th>
                        <th class="px-6 py-4">Nama Lengkap</th>
                        <th class="px-6 py-4">Username</th>
                        <th class="px-6 py-4 text-center">Role</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    {{-- @forelse($users as $user) --}}
                    <tr class="transition-colors duration-150 hover:bg-teal-50/30">
                        <td class="px-6 py-4 font-medium text-center text-gray-600">1</td>
                        <td class="px-6 py-4 font-semibold text-gray-900">aduy</td>
                        <td class="px-6 py-4 text-gray-600">aduy1</td>
                        <td class="px-6 py-4 text-center">
                            {{-- @if ($user->role === 'admin') --}}
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 border border-purple-200">
                                <i class="text-xs fas fa-shield-halved"></i> Admin
                            </span>
                            {{-- @elseif ($user->role === 'kasir') --}}
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                <i class="text-xs fas fa-cash-register"></i> Kasir
                            </span>
                            {{-- @else --}}
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800 border border-amber-200">
                                <i class="text-xs fas fa-crown"></i> Owner
                            </span>
                            {{-- @endif --}}
                        </td>
                        <td class="px-6 py-4 text-center">
                            {{-- @if ($user->role === 'kasir') --}}
                            <form action="#" method="POST" class="inline">
                                @csrf
                                <button type="submit"
                                    class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-medium transition-all hover:scale-105
                                                       2">
                                    <span class="2"></span>
                                    2
                                </button>
                            </form>
                            {{-- @else --}}
                            <span
                                class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-medium
                                                 2">
                                <span class="2"></span>
                                2
                            </span>
                            {{-- @endif --}}
                        </td>
                        <td class="px-6 py-4 text-center">
                            {{-- <div class="flex flex-wrap items-center justify-center gap-2">
                                    <button type="button"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium bg-green-50 text-green-700 border border-green-200 rounded-lg hover:bg-green-100 transition-all"
                                            data-bs-toggle="modal" data-bs-target="#detailModal"
                                            data-nama="{{ $user->nama }}" data-username="{{ $user->username }}"
                                            data-nohp="{{ $user->no_hp ?? '-' }}" data-alamat="{{ $user->alamat ?? '-' }}"
                                            data-role="{{ $user->role }}" data-status="{{ $user->status }}">
                                        <i class="text-xs fas fa-eye"></i> Detail
                                    </button>

                                    <button type="button"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200 rounded-lg hover:bg-amber-100 transition-all"
                                            data-bs-toggle="modal" data-bs-target="#editModal"
                                            data-id="{{ $user->id }}" data-nama="{{ $user->nama }}"
                                            data-username="{{ $user->username }}" data-nohp="{{ $user->no_hp ?? '' }}"
                                            data-alamat="{{ $user->alamat ?? '' }}" data-role="{{ $user->role }}"
                                            data-status="{{ $user->status }}">
                                        <i class="text-xs fas fa-pen"></i> Edit
                                    </button>

                                    @if ($user->id !== auth()->id())
                                        <button type="button"
                                                class="btn-hapus inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium bg-red-50 text-red-700 border border-red-200 rounded-lg hover:bg-red-100 transition-all"
                                                data-id="{{ $user->id }}">
                                            <i class="text-xs fas fa-trash-can"></i> Hapus
                                        </button>
                                    @endif
                                </div> --}}
                        </td>
                    </tr>
                    {{-- @empty --}}
                    <tr>
                        <td colspan="6" class="py-16 text-center text-gray-500">
                            <i class="block mb-4 text-5xl fas fa-users-slash opacity-30"></i>
                            <p class="text-sm font-medium">
                                @if (request('search') || request('role'))
                                    Tidak ada pengguna yang cocok dengan filter
                                @else
                                    Belum ada data pengguna
                                @endif
                            </p>
                        </td>
                    </tr>
                    {{-- @endforelse --}}
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL CREATE (mirip edit, header teal) -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content rounded-2xl">
                <div class="p-5 text-white modal-header bg-gradient-to-r from-teal-600 to-teal-500 rounded-t-2xl">
                    <div class="flex items-center gap-4">
                        <div class="flex items-center justify-center w-10 h-10 text-xl rounded-xl bg-white/15">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div>
                            <h5 class="m-0 text-xl font-bold">Tambah Pengguna</h5>
                            <p class="mt-1 text-sm opacity-80">Field bertanda <span class="text-rose-200">*</span> wajib
                                diisi</p>
                        </div>
                    </div>
                    <button type="button" class="text-2xl text-white hover:text-gray-200" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form action="#" method="POST">
                    @csrf
                    <div class="p-6 modal-body">
                        <div class="mb-6">
                            <h6 class="mb-3 text-sm font-bold tracking-wider text-teal-700 uppercase">INFORMASI PRIBADI
                            </h6>
                            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap *</label>
                                    <input type="text" name="nama" required value="{{ old('nama') }}"
                                        placeholder="Nama Lengkap"
                                        class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg focus:border-teal-500 focus:ring-2 focus:ring-teal-200/30">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">No. Handphone</label>
                                    <input type="text" name="no_hp" value="{{ old('no_hp') }}"
                                        placeholder="No. Handphone"
                                        class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg focus:border-teal-500 focus:ring-2 focus:ring-teal-200/30">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Alamat</label>
                                    <textarea name="alamat" rows="2" placeholder="Alamat"
                                        class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg resize-none focus:border-teal-500 focus:ring-2 focus:ring-teal-200/30">{{ old('alamat') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <h6 class="mb-3 text-sm font-bold tracking-wider text-teal-700 uppercase">AKUN & HAK AKSES</h6>
                            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Username *</label>
                                    <input type="text" name="username" required value="{{ old('username') }}"
                                        placeholder="Username"
                                        class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg focus:border-teal-500 focus:ring-2 focus:ring-teal-200/30">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Password *</label>
                                    <div class="relative">
                                        <input type="password" name="password" id="c_pw" required
                                            placeholder="Min. 6 karakter"
                                            class="w-full px-4 py-2 pr-10 text-sm border border-gray-300 rounded-lg focus:border-teal-500 focus:ring-2 focus:ring-teal-200/30">
                                        <button type="button"
                                            class="absolute text-gray-500 -translate-y-1/2 right-3 top-1/2 hover:text-teal-600"
                                            onclick="togglePw('c_pw', this)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Role *</label>
                                    <select name="role" required
                                        class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg focus:border-teal-500 focus:ring-2 focus:ring-teal-200/30 custom-select-arrow">
                                        <option value="" disabled>Pilih Role</option>
                                        <option value="kasir">Kasir</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Status *</label>
                                    <select name="status" required
                                        class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg focus:border-teal-500 focus:ring-2 focus:ring-teal-200/30 custom-select-arrow">
                                        <option value="aktif">Aktif</option>
                                        <option value="nonaktif">Nonaktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 px-6 py-4 modal-footer bg-gray-50 rounded-b-2xl">
                        <button type="button"
                            class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-all text-sm font-medium"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit"
                            class="px-5 py-2.5 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-all text-sm font-medium flex items-center gap-2">
                            <i class="fas fa-floppy-disk"></i> Simpan Pengguna
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL DETAIL (mirip edit, header navy) -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 460px">
            <div class="modal-content rounded-2xl">
                <div class="p-5 text-white modal-header bg-gradient-to-r from-gray-800 to-gray-900 rounded-t-2xl">
                    <div class="flex items-center gap-4">
                        <div class="flex items-center justify-center w-10 h-10 text-xl rounded-xl bg-white/15">
                            <i class="fas fa-address-card"></i>
                        </div>
                        <div>
                            <h5 class="m-0 text-xl font-bold">Detail Pengguna</h5>
                            <p class="mt-1 text-sm opacity-80">Informasi lengkap akun</p>
                        </div>
                    </div>
                    <button type="button" class="text-2xl text-white hover:text-gray-200" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="p-6 modal-body" id="detailBody">
                    <!-- Content diisi via JS -->
                </div>
                <div class="flex justify-end px-6 py-4 modal-footer bg-gray-50 rounded-b-2xl">
                    <button type="button"
                        class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-all text-sm font-medium"
                        data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL EDIT (sudah sesuai screenshot) -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content rounded-2xl">
                <div class="p-5 text-white modal-header bg-gradient-to-r from-amber-600 to-amber-500 rounded-t-2xl">
                    <div class="flex items-center gap-4">
                        <div class="flex items-center justify-center w-10 h-10 text-xl rounded-xl bg-white/15">
                            <i class="fas fa-user-pen"></i>
                        </div>
                        <div>
                            <h5 class="m-0 text-xl font-bold">Edit Pengguna</h5>
                            <p class="mt-1 text-sm opacity-80" id="editSubtitle">Mengediting: Admin</p>
                        </div>
                    </div>
                    <button type="button" class="text-2xl text-white hover:text-gray-200" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="p-6 modal-body">
                        <div class="mb-6">
                            <h6 class="mb-3 text-sm font-bold tracking-wider uppercase text-amber-800">INFORMASI PRIBADI
                            </h6>
                            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap *</label>
                                    <input type="text" name="nama" required
                                        class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg focus:border-amber-500 focus:ring-2 focus:ring-amber-200/30">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">No. Handphone</label>
                                    <input type="text" name="no_hp"
                                        class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg focus:border-amber-500 focus:ring-2 focus:ring-amber-200/30">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Alamat</label>
                                    <textarea name="alamat" rows="2"
                                        class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg resize-none focus:border-amber-500 focus:ring-2 focus:ring-amber-200/30"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <h6 class="mb-3 text-sm font-bold tracking-wider uppercase text-amber-800">AKUN & HAK AKSES
                            </h6>
                            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Username *</label>
                                    <input type="text" name="username" required
                                        class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg focus:border-amber-500 focus:ring-2 focus:ring-amber-200/30">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Password Baru</label>
                                    <div class="relative">
                                        <input type="password" name="password" id="e_pw"
                                            placeholder="Kosongkan jika tidak diubah"
                                            class="w-full px-4 py-2 pr-10 text-sm border border-gray-300 rounded-lg focus:border-amber-500 focus:ring-2 focus:ring-amber-200/30">
                                        <button type="button"
                                            class="absolute -translate-y-1/2 right-3 top-1/2 text-amber-500 hover:text-amber-600"
                                            onclick="togglePw('e_pw', this)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <p class="mt-1 text-xs italic text-amber-500">Biarkan kosong jika tidak ingin mengubah
                                    </p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Role</label>
                                    <input type="text" value="{{ ucfirst(old('role', $user->role ?? '')) }}"
                                        class="w-full px-4 py-2 text-sm bg-gray-100 border border-gray-300 rounded-lg"
                                        readonly>
                                    <input type="hidden" name="role"
                                        value="{{ old('role', $user->role ?? 'kasir') }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Status</label>
                                    <select name="status" id="editStatus"
                                        class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg focus:border-amber-500 focus:ring-2 focus:ring-amber-200/30 custom-select-arrow">
                                        <option value="aktif">Aktif</option>
                                        <option value="nonaktif">Nonaktif</option>
                                    </select>
                                    <p class="mt-1 text-xs italic text-amber-500" id="statusHint"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 px-6 py-4 modal-footer bg-gray-50 rounded-b-2xl">
                        <button type="button"
                            class="px-5 py-2.5 bg-gray-100 text-amber-700 rounded-lg hover:bg-gray-200 transition-all text-sm font-medium"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit"
                            class="px-5 py-2.5 bg-gradient-to-r from-amber-600 to-amber-500 text-white rounded-lg hover:shadow-lg transition-all text-sm font-medium flex items-center gap-2">
                            <i class="fas fa-floppy-disk"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

{{-- @section('scripts')
    <script>
        // Toggle password visibility
        function togglePw(id, btn) {
            const input = document.getElementById(id);
            const icon = btn.querySelector('i');
            input.type = input.type === 'password' ? 'text' : 'password';
            icon.className = input.type === 'password' ? 'fas fa-eye' : 'fas fa-eye-slash';
        }

        // Re-open create modal on validation error
        @if ($errors->any())
            document.addEventListener('DOMContentLoaded', () => {
                new bootstrap.Modal(document.getElementById('createModal')).show();
            });
        @endif

        // Search clear button
        const searchInput = document.getElementById('searchInput');
        const searchClear = document.getElementById('searchClear');

        function syncClearButton() {
            searchClear.classList.toggle('hidden', searchInput.value.trim() === '');
        }

        searchInput.addEventListener('input', syncClearButton);
        searchClear.addEventListener('click', () => {
            searchInput.value = '';
            syncClearButton();
            searchInput.focus();
            if (window.location.search.includes('search=')) document.querySelector('form').submit();
        });
        syncClearButton();

        // Auto submit role filter
        document.getElementById('roleFilter')?.addEventListener('change', function() {
            this.form.submit();
        });

        // Detail modal dynamic content
        const detailConfig = {
            nama:   { icon: 'fa-user',       color: 'bg-green-100 text-green-700' },
            user:   { icon: 'fa-at',         color: 'bg-blue-100 text-blue-700' },
            pw:     { icon: 'fa-key',        color: 'bg-purple-100 text-purple-700' },
            phone:  { icon: 'fa-phone',      color: 'bg-teal-100 text-teal-700' },
            alamat: { icon: 'fa-map-pin',    color: 'bg-amber-100 text-amber-700' },
            role:   { icon: 'fa-shield-halved', color: 'bg-slate-100 text-slate-700' },
            status: { icon: 'fa-circle-dot', color: 'bg-green-100 text-green-700' },
        };

        function buildDetailRow(key, label, value) {
            const cfg = detailConfig[key] || { icon: 'fa-question', color: 'bg-gray-100 text-gray-700' };
            return `
                <div class="flex items-start gap-4 py-3 border-b border-gray-100 last:border-0">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center text-base ${cfg.color} flex-shrink-0">
                        <i class="fas ${cfg.icon}"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-0.5">${label}</p>
                        <p class="text-sm font-medium text-gray-900 break-words">${value}</p>
                    </div>
                </div>`;
        }

        document.querySelectorAll('[data-bs-target="#detailModal"]').forEach(btn => {
            btn.addEventListener('click', function() {
                const data = this.dataset;
                const roleBadges = {
                    admin: `<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 border border-purple-200"><i class="text-xs fas fa-shield-halved"></i> Admin</span>`,
                    kasir: `<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200"><i class="text-xs fas fa-cash-register"></i> Kasir</span>`,
                    owner: `<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800 border border-amber-200"><i class="text-xs fas fa-crown"></i> Owner</span>`,
                };

                const statusBadge = data.status === 'aktif'
                    ? `<span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200"><span class="inline-block w-2.5 h-2.5 rounded-full bg-green-500 ring-2 ring-green-500/30"></span>Aktif</span>`
                    : `<span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200"><span class="inline-block w-2.5 h-2.5 rounded-full bg-red-500 ring-2 ring-red-500/30"></span>Nonaktif</span>`;

                document.getElementById('detailBody').innerHTML = `
                    <div class="mb-6">
                        <h6 class="mb-3 text-sm font-bold tracking-wider text-gray-700 uppercase">INFORMASI PRIBADI</h6>
                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            ${buildDetailRow('nama', 'Nama Lengkap', data.nama)}
                            ${buildDetailRow('phone', 'No. Handphone', data.nohp)}
                            ${buildDetailRow('alamat', 'Alamat', data.alamat)}
                        </div>
                    </div>
                    <div>
                        <h6 class="mb-3 text-sm font-bold tracking-wider text-gray-700 uppercase">AKUN & HAK AKSES</h6>
                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            ${buildDetailRow('user', 'Username', data.username)}
                            ${buildDetailRow('pw', 'Password', '••••••••')}
                            ${buildDetailRow('role', 'Role', roleBadges[data.role] || data.role)}
                            ${buildDetailRow('status', 'Status', statusBadge)}
                        </div>
                    </div>
                `;
            });
        });

        // Edit modal data fill
        document.querySelectorAll('[data-bs-target="#editModal"]').forEach(btn => {
            btn.addEventListener('click', function() {
                const d = this.dataset;
                const form = document.getElementById('editForm');

                form.action = `/admin/users/${d.id}`;
                form.querySelector('[name="nama"]').value     = d.nama;
                form.querySelector('[name="username"]').value = d.username;
                form.querySelector('[name="no_hp"]').value    = d.nohp;
                form.querySelector('[name="alamat"]').value   = d.alamat;
                form.querySelector('[name="password"]').value = '';

                document.getElementById('editSubtitle').textContent = 'Mengediting: ' + d.nama;

                const statusEl = document.getElementById('editStatus');
                const hintEl   = document.getElementById('statusHint');
                statusEl.value = d.status.toLowerCase();

                const isKasir = d.role.toLowerCase() === 'kasir';
                statusEl.disabled = !isKasir;
                statusEl.style.opacity = isKasir ? '1' : '0.45';
                statusEl.style.cursor  = isKasir ? 'pointer' : 'not-allowed';

                hintEl.textContent = isKasir
                    ? 'Status kasir bisa diubah di sini atau via toggle di tabel.'
                    : 'Status Admin & Owner tidak bisa diubah dari sini.';
            });
        });

        // Delete confirmation
        document.querySelectorAll('.btn-hapus').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                Swal.fire({
                    title: 'Yakin hapus pengguna?',
                    text: 'Data akan dihapus permanen!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#10b981',
                    confirmButtonText: '<i class="mr-2 fas fa-trash-can"></i> Ya, hapus!',
                    cancelButtonText: 'Batal',
                    customClass: {
                        popup: 'rounded-2xl',
                        confirmButton: 'rounded-xl px-6 py-3',
                        cancelButton: 'rounded-xl px-6 py-3'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `/admin/users/${id}`;
                        form.innerHTML = '@csrf @method("DELETE")';
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection --}}
