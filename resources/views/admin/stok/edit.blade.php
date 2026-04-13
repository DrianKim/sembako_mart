@extends('admin.layouts.app')
@section('title', 'Kelola Stok: ' . $produk->nama_produk)
@section('page-description', 'Edit batch yang ada atau tambah batch baru dari supplier.')

@section('content')
    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.dashboard') }}"
                    class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-green-600">
                    <i class="w-4 h-4 mr-2 fas fa-home"></i> Dashboard
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="w-6 h-6 text-gray-400 fas fa-chevron-right"></i>
                    <a href="{{ route('admin.stok') }}"
                        class="ml-1 text-sm font-medium text-gray-700 hover:text-green-600 md:ml-2">Stok Produk</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="w-6 h-6 text-gray-400 fas fa-chevron-right"></i>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Kelola Stok</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Notifikasi Error Validation -->
    @if ($errors->any())
        <div class="p-4 mb-6 border border-red-200 bg-red-50 rounded-xl">
            <div class="flex items-center gap-2 mb-2">
                <i class="text-red-600 fas fa-exclamation-triangle"></i>
                <h4 class="font-semibold text-red-800">Ada kesalahan pada inputan:</h4>
            </div>
            <ul class="ml-6 space-y-1 text-sm text-red-700 list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Info Produk -->
    <div class="p-5 mb-6 bg-white border border-gray-200 shadow-sm rounded-xl">
        <div class="flex items-center gap-4">
            @if ($produk->foto)
                <img src="{{ url($produk->foto) }}" alt="{{ $produk->nama_produk }}"
                    class="object-cover w-16 h-16 rounded-lg shadow">
            @else
                <div class="flex items-center justify-center w-16 h-16 bg-gray-100 rounded-lg">
                    <i class="text-2xl text-gray-400 fas fa-image"></i>
                </div>
            @endif
            <div>
                <h2 class="text-xl font-bold text-gray-800">{{ $produk->nama_produk }}</h2>
                <p class="text-sm text-gray-500">
                    Barcode: {{ $produk->barcode ?? '-' }} &nbsp;|&nbsp;
                    Satuan: {{ $produk->satuan }} &nbsp;|&nbsp;
                    Kategori: {{ $produk->kategori->nama_kategori ?? '-' }}
                </p>
                <div class="flex items-center gap-2 mt-1">
                    <span class="text-sm font-semibold text-gray-700">Total Stok:</span>
                    @php $totalStok = $produk->total_stok; @endphp
                    <span
                        class="px-3 py-0.5 text-sm font-bold rounded-full
                        {{ $totalStok > 15 ? 'bg-green-100 text-green-800' : ($totalStok > 5 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                        {{ number_format($totalStok) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

        {{-- KOLOM KIRI: Daftar Batch Aktif --}}
        <div class="overflow-hidden bg-white border border-gray-200 shadow-sm rounded-xl">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center w-9 h-9 bg-blue-100 rounded-lg">
                        <i class="text-blue-600 fas fa-layer-group"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800">Batch Aktif</h3>
                        <p class="text-xs text-gray-500">Klik batch untuk mengedit stok & tanggal kadaluarsa</p>
                    </div>
                </div>
            </div>

            <div class="divide-y divide-gray-100" id="batchList">
                @forelse ($produk->batchProduks as $batch)
                    <div class="p-4 transition-colors cursor-pointer hover:bg-gray-50 batch-item"
                        data-batch-id="{{ $batch->id }}" data-nomor-batch="{{ $batch->nomor_batch }}"
                        data-stok="{{ $batch->stok }}" data-harga-beli="{{ $batch->harga_beli }}"
                        data-tanggal="{{ $batch->tanggal_kadaluarsa ? \Carbon\Carbon::parse($batch->tanggal_kadaluarsa)->format('Y-m-d') : '' }}">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-semibold text-gray-800">
                                        {{ $batch->nomor_batch ?? 'Tanpa Nomor Batch' }}
                                    </span>
                                    @if ($batch->is_kadaluarsa)
                                        <span
                                            class="px-2 py-0.5 text-xs font-medium text-white bg-red-500 rounded-full">Kadaluarsa</span>
                                    @elseif ($batch->is_mendekati)
                                        <span
                                            class="px-2 py-0.5 text-xs font-medium text-white bg-yellow-500 rounded-full">Segera
                                            Kadaluarsa</span>
                                    @else
                                        <span
                                            class="px-2 py-0.5 text-xs font-medium text-white bg-green-500 rounded-full">Aktif</span>
                                    @endif
                                </div>
                                <p class="mt-1 text-xs text-gray-500">
                                    Stok: <span
                                        class="font-semibold text-gray-700">{{ number_format($batch->stok) }}</span>
                                    &nbsp;|&nbsp;
                                    Harga Beli: <span class="font-semibold text-orange-600">Rp
                                        {{ number_format($batch->harga_beli, 0, ',', '.') }}</span>
                                </p>
                                <p class="text-xs text-gray-400">
                                    Kadaluarsa:
                                    {{ $batch->tanggal_kadaluarsa ? \Carbon\Carbon::parse($batch->tanggal_kadaluarsa)->format('d M Y') : '-' }}
                                </p>
                            </div>
                            <div class="flex items-center gap-2 flex-shrink-0">
                                <button type="button"
                                    class="p-2 text-blue-600 transition rounded-lg bg-blue-50 hover:bg-blue-100 btn-edit-batch">
                                    <i class="text-xs fas fa-edit"></i>
                                </button>
                                <button type="button"
                                    class="p-2 text-red-600 transition rounded-lg bg-red-50 hover:bg-red-100 btn-hapus-batch"
                                    data-batch-id="{{ $batch->id }}"
                                    data-nomor-batch="{{ $batch->nomor_batch ?? 'Tanpa Nomor Batch' }}">
                                    <i class="text-xs fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-gray-400">
                        <i class="mb-2 text-3xl fas fa-inbox"></i>
                        <p class="text-sm">Belum ada batch aktif</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- KOLOM KANAN: Form Batch --}}
        <div class="overflow-hidden bg-white border border-green-200 shadow-sm rounded-xl transition-all"
            id="batchFormCard">

            {{-- Header dinamis --}}
            <div class="px-6 py-4 border-b border-green-100 bg-green-50 transition-all" id="formHeader">
                <div class="flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="flex items-center justify-center w-9 h-9 rounded-lg transition-colors"
                            id="formIconWrapper">
                            <i class="fas transition-colors" id="formIcon"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800" id="formTitle"></h3>
                            <p class="text-xs text-gray-500" id="formSubtitle"></p>
                        </div>
                    </div>

                    {{-- Button Batal: hanya muncul saat mode edit --}}
                    <button type="button" id="btnBatalEdit"
                        class="hidden items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 transition">
                        <i class="fas fa-times"></i> Batal
                    </button>
                </div>
            </div>

            {{-- ===== PANEL: Tambah Batch Baru ===== --}}
            <div id="panelTambah">
                <form action="{{ route('admin.stok.update', $produk->id) }}" method="POST" id="formTambahBatch">
                    @csrf @method('PUT')
                    <input type="hidden" name="aksi" value="tambah_batch">

                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block mb-1.5 text-sm font-semibold text-gray-700">Nomor Batch</label>
                                <input type="text" name="nomor_batch_baru" value="{{ old('nomor_batch_baru') }}"
                                    placeholder="Otomatis generate" readonly
                                    class="w-full px-4 py-2.5 text-gray-500 bg-gray-100 border border-gray-200 rounded-lg cursor-not-allowed">
                                @error('nomor_batch_baru')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block mb-1.5 text-sm font-semibold text-gray-700">
                                    Jumlah Stok <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="stok_baru" min="1" value="{{ old('stok_baru') }}"
                                    class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg @error('stok_baru') border-red-400 @enderror">
                                @error('stok_baru')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block mb-1.5 text-sm font-semibold text-gray-700">
                                    Harga Beli (Rp) <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="harga_beli_baru" min="0" step="100"
                                    value="{{ old('harga_beli_baru') }}"
                                    class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg @error('harga_beli_baru') border-red-400 @enderror">
                                @error('harga_beli_baru')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block mb-1.5 text-sm font-semibold text-gray-700">Tanggal Kadaluarsa</label>
                                <input type="date" name="tanggal_kadaluarsa_baru"
                                    value="{{ old('tanggal_kadaluarsa_baru') }}"
                                    min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                    class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg @error('tanggal_kadaluarsa_baru') border-red-400 @enderror">
                                @error('tanggal_kadaluarsa_baru')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="p-3 border-l-4 border-green-400 rounded-lg bg-green-50">
                            <p class="text-xs text-green-800">
                                <i class="mr-1 fas fa-info-circle"></i>
                                Batch baru akan ditambahkan sebagai stok masuk dari supplier.
                            </p>
                        </div>
                    </div>

                    <div class="px-6 py-4 border-t bg-gray-50 flex justify-end">
                        <button type="submit"
                            class="px-5 py-2 text-sm text-white rounded-lg shadow bg-gradient-to-r from-green-600 to-green-500 hover:from-green-700 hover:to-green-600">
                            <i class="mr-1 fas fa-plus"></i> Tambah Batch Baru
                        </button>
                    </div>
                </form>
            </div>

            {{-- ===== PANEL: Edit Batch ===== --}}
            <div id="panelEdit" class="hidden">
                <form action="{{ route('admin.stok.update', $produk->id) }}" method="POST" id="formEditBatch">
                    @csrf @method('PUT')
                    <input type="hidden" name="aksi" value="edit_batch">
                    <input type="hidden" name="batch_id" id="editBatchId">

                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block mb-1.5 text-sm font-semibold text-gray-700">Nomor Batch</label>
                            <input type="text" id="editNomorBatch" name="nomor_batch" readonly
                                class="w-full px-4 py-2.5 text-gray-500 bg-gray-100 border border-gray-200 rounded-lg cursor-not-allowed @error('nomor_batch') border-red-400 @enderror">
                            @error('nomor_batch')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-1.5 text-sm font-semibold text-gray-700">Stok Saat Ini</label>
                            <input type="text" id="editStokInfo" readonly
                                class="w-full px-4 py-2.5 text-gray-500 bg-gray-100 border border-gray-200 rounded-lg cursor-not-allowed">
                        </div>

                        {{-- Aksi Stok Radio --}}
                        <div>
                            <label class="block mb-1.5 text-sm font-semibold text-gray-700">
                                Aksi Stok <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-3 gap-2">
                                <label class="aksi-stok-option cursor-pointer">
                                    <input type="radio" name="aksi_stok" value="tambah" class="sr-only" checked>
                                    <div
                                        class="flex flex-col items-center justify-center gap-1 px-3 py-2.5 text-xs font-semibold border-2 rounded-lg transition-all border-green-400 bg-green-50 text-green-700 ring-2 ring-green-400 ring-offset-1 aksi-label">
                                        <i class="text-base fas fa-plus-circle"></i> Tambah
                                    </div>
                                </label>
                                <label class="aksi-stok-option cursor-pointer">
                                    <input type="radio" name="aksi_stok" value="kurangi" class="sr-only">
                                    <div
                                        class="flex flex-col items-center justify-center gap-1 px-3 py-2.5 text-xs font-semibold border-2 rounded-lg transition-all border-gray-200 bg-white text-gray-500 aksi-label">
                                        <i class="text-base fas fa-minus-circle"></i> Kurangi
                                    </div>
                                </label>
                                <label class="aksi-stok-option cursor-pointer">
                                    <input type="radio" name="aksi_stok" value="ganti" class="sr-only">
                                    <div
                                        class="flex flex-col items-center justify-center gap-1 px-3 py-2.5 text-xs font-semibold border-2 rounded-lg transition-all border-gray-200 bg-white text-gray-500 aksi-label">
                                        <i class="text-base fas fa-pen"></i> Ganti
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block mb-1.5 text-sm font-semibold text-gray-700">
                                    <span id="labelJumlah">Jumlah Tambah</span> <span class="text-red-500">*</span>
                                </label>
                                <input type="number" id="editJumlahStok" name="jumlah_stok" min="0"
                                    class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg @error('jumlah_stok') border-red-400 @enderror">
                                @error('jumlah_stok')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block mb-1.5 text-sm font-semibold text-gray-700">Hasil Stok</label>
                                <div id="previewHasilStok"
                                    class="flex items-center justify-center w-full px-4 py-2.5 text-lg font-bold border-2 border-dashed rounded-lg border-gray-200 text-gray-300">
                                    -
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block mb-1.5 text-sm font-semibold text-gray-700">Harga Beli (Rp)</label>
                                <input type="number" id="editHargaBeli" name="harga_beli" min="0"
                                    step="100"
                                    class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg @error('harga_beli') border-red-400 @enderror">
                                @error('harga_beli')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block mb-1.5 text-sm font-semibold text-gray-700">Tanggal Kadaluarsa</label>
                                <input type="date" id="editTanggalKadaluarsa" name="tanggal_kadaluarsa"
                                    class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg @error('tanggal_kadaluarsa') border-red-400 @enderror">
                                @error('tanggal_kadaluarsa')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div id="infoAksiStok" class="p-3 border-l-4 border-green-400 rounded-lg bg-green-50">
                            <p id="infoAksiTeks" class="text-xs text-green-800">
                                <i class="mr-1 fas fa-info-circle"></i>
                                Stok batch ini akan <strong>DITAMBAH</strong> sejumlah yang diisi.
                            </p>
                        </div>
                    </div>

                    <div class="px-6 py-4 border-t bg-gray-50 flex justify-end">
                        <button type="submit" id="btnSimpanEdit"
                            class="px-5 py-2 text-sm text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                            <i class="mr-1 fas fa-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

        </div>

    </div>

    <!-- Bottom Nav -->
    <div class="flex items-center justify-between mt-6">
        <a href="{{ route('admin.stok') }}"
            class="flex items-center px-6 py-3 transition bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
            <i class="mr-2 fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form id="formHapusBatch" action="" method="POST" class="hidden">
        @csrf @method('DELETE')
    </form>
@endsection

@push('scripts')
    <script>
        // SweetAlert Session
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Sukses!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#10b981'
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#ef4444'
            });
        @endif
        // ============================================================
        // CONFIG AKSI STOK
        // ============================================================
        const aksiConfig = {
            tambah: {
                border: 'border-green-400',
                bg: 'bg-green-50',
                text: 'text-green-700',
                ring: 'ring-green-400',
                label: 'Jumlah Tambah',
                infoBorder: 'border-green-400',
                infoBg: 'bg-green-50',
                infoText: 'text-green-800',
                infoMsg: 'Stok batch ini akan <strong>DITAMBAH</strong> sejumlah yang diisi.',
                previewColor: 'text-green-600',
                calc: (stok, jumlah) => stok + jumlah,
            },
            kurangi: {
                border: 'border-red-400',
                bg: 'bg-red-50',
                text: 'text-red-700',
                ring: 'ring-red-400',
                label: 'Jumlah Kurangi',
                infoBorder: 'border-red-400',
                infoBg: 'bg-red-50',
                infoText: 'text-red-800',
                infoMsg: 'Stok batch ini akan <strong>DIKURANGI</strong> sejumlah yang diisi. Tidak bisa minus.',
                previewColor: 'text-red-600',
                calc: (stok, jumlah) => Math.max(0, stok - jumlah),
            },
            ganti: {
                border: 'border-blue-400',
                bg: 'bg-blue-50',
                text: 'text-blue-700',
                ring: 'ring-blue-400',
                label: 'Stok Baru',
                infoBorder: 'border-blue-400',
                infoBg: 'bg-blue-50',
                infoText: 'text-blue-800',
                infoMsg: 'Stok batch ini akan <strong>DIGANTI</strong> sepenuhnya. Gunakan untuk koreksi.',
                previewColor: 'text-blue-600',
                calc: (stok, jumlah) => jumlah,
            },
        };

        // ============================================================
        // STATE & ELEMEN
        // ============================================================
        let stokSaatIni = 0;

        const panelTambah = document.getElementById('panelTambah');
        const panelEdit = document.getElementById('panelEdit');
        const batchFormCard = document.getElementById('batchFormCard');
        const formHeader = document.getElementById('formHeader');
        const formIconWrapper = document.getElementById('formIconWrapper');
        const formIcon = document.getElementById('formIcon');
        const formTitle = document.getElementById('formTitle');
        const formSubtitle = document.getElementById('formSubtitle');
        const btnBatalEdit = document.getElementById('btnBatalEdit');

        // ============================================================
        // INIT: tampilkan mode tambah saat halaman load
        // ============================================================
        setModeTambah();

        // ============================================================
        // MODE TAMBAH
        // ============================================================
        function setModeTambah() {
            // Panel
            panelTambah.classList.remove('hidden');
            panelEdit.classList.add('hidden');

            // Card & header warna hijau
            batchFormCard.className =
                'overflow-hidden bg-white border border-green-200 shadow-sm rounded-xl transition-all';
            formHeader.className = 'px-6 py-4 border-b border-green-100 bg-green-50 transition-all';

            // Icon & teks
            formIconWrapper.className = 'flex items-center justify-center w-9 h-9 rounded-lg bg-green-100';
            formIcon.className = 'fas fa-plus-circle text-green-600';
            formTitle.textContent = 'Tambah Batch Baru';
            formSubtitle.textContent = 'Dari supplier / pengiriman baru';

            // Sembunyikan tombol batal
            btnBatalEdit.classList.add('hidden');
            btnBatalEdit.classList.remove('flex');

            // Hapus highlight batch list kiri
            document.querySelectorAll('.batch-item').forEach(el =>
                el.classList.remove('bg-blue-50', 'ring-1', 'ring-blue-200'));
        }

        // ============================================================
        // MODE EDIT
        // ============================================================
        function setModeEdit(data) {
            stokSaatIni = parseInt(data.stok) || 0;

            // Isi field form edit
            document.getElementById('editBatchId').value = data.batchId;
            document.getElementById('editNomorBatch').value = data.nomorBatch || '';
            document.getElementById('editStokInfo').value = stokSaatIni;
            document.getElementById('editJumlahStok').value = '';
            document.getElementById('editHargaBeli').value = data.hargaBeli;
            document.getElementById('editTanggalKadaluarsa').value = data.tanggal || '';

            // Reset aksi ke "tambah"
            document.querySelector('input[name="aksi_stok"][value="tambah"]').checked = true;
            updateAksiUI();

            // Panel
            panelEdit.classList.remove('hidden');
            panelTambah.classList.add('hidden');

            // Card & header warna biru
            batchFormCard.className = 'overflow-hidden bg-white border border-blue-200 shadow-sm rounded-xl transition-all';
            formHeader.className = 'px-6 py-4 border-b border-blue-100 bg-blue-50 transition-all';

            // Icon & teks
            formIconWrapper.className = 'flex items-center justify-center w-9 h-9 rounded-lg bg-blue-100';
            formIcon.className = 'fas fa-edit text-blue-600';
            formTitle.textContent = 'Edit Batch';
            formSubtitle.textContent = 'Mengedit: ' + (data.nomorBatch || 'Tanpa Nomor Batch');

            // Tampilkan tombol batal
            btnBatalEdit.classList.remove('hidden');
            btnBatalEdit.classList.add('flex');

            // Highlight batch yang diklik di list kiri
            document.querySelectorAll('.batch-item').forEach(el =>
                el.classList.remove('bg-blue-50', 'ring-1', 'ring-blue-200'));
            const target = document.querySelector(`.batch-item[data-batch-id="${data.batchId}"]`);
            if (target) target.classList.add('bg-blue-50', 'ring-1', 'ring-blue-200');

            // Scroll ke form
            batchFormCard.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }

        // ============================================================
        // HAPUS BATCH
        // ============================================================
        document.querySelectorAll('.btn-hapus-batch').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.stopPropagation(); // jangan trigger klik batch-item

                const batchId = this.dataset.batchId;
                const nomorBatch = this.dataset.nomorBatch;

                Swal.fire({
                    title: 'Hapus Batch?',
                    html: `Batch <strong>${nomorBatch}</strong> akan dihapus permanen.<br>Stok batch ini akan hilang!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then(result => {
                    if (result.isConfirmed) {
                        const form = document.getElementById('formHapusBatch');
                        form.action = `{{ url('admin/stok/batch') }}/${batchId}`;
                        form.submit();
                    }
                });
            });
        });

        // ============================================================
        // KLIK BATCH ITEM (daftar kiri)
        // ============================================================
        document.querySelectorAll('.batch-item').forEach(function(item) {
            item.addEventListener('click', function() {
                setModeEdit({
                    batchId: this.dataset.batchId,
                    nomorBatch: this.dataset.nomorBatch,
                    stok: this.dataset.stok,
                    hargaBeli: this.dataset.hargaBeli,
                    tanggal: this.dataset.tanggal,
                });
            });
        });

        // ============================================================
        // TOMBOL BATAL → kembali ke mode tambah
        // ============================================================
        btnBatalEdit.addEventListener('click', setModeTambah);

        // ============================================================
        // AKSI STOK: update UI radio & info box
        // ============================================================
        function getAksiAktif() {
            return document.querySelector('input[name="aksi_stok"]:checked')?.value || 'tambah';
        }

        function updateAksiUI() {
            const aksi = getAksiAktif();
            const cfg = aksiConfig[aksi];

            document.getElementById('labelJumlah').textContent = cfg.label;

            const infoBox = document.getElementById('infoAksiStok');
            const infoTeks = document.getElementById('infoAksiTeks');
            infoBox.className = `p-3 border-l-4 ${cfg.infoBorder} rounded-lg ${cfg.infoBg}`;
            infoTeks.className = `text-xs ${cfg.infoText}`;
            infoTeks.innerHTML = `<i class="mr-1 fas fa-info-circle"></i> ${cfg.infoMsg}`;

            document.querySelectorAll('.aksi-stok-option').forEach(function(opt) {
                const radio = opt.querySelector('input[type="radio"]');
                const div = opt.querySelector('.aksi-label');
                const c = aksiConfig[radio.value];
                div.className = radio.checked ?
                    `flex flex-col items-center justify-center gap-1 px-3 py-2.5 text-xs font-semibold border-2 rounded-lg transition-all ${c.border} ${c.bg} ${c.text} ring-2 ${c.ring} ring-offset-1 aksi-label` :
                    'flex flex-col items-center justify-center gap-1 px-3 py-2.5 text-xs font-semibold border-2 rounded-lg transition-all border-gray-200 bg-white text-gray-500 aksi-label';
            });

            updatePreview();
        }

        function updatePreview() {
            const aksi = getAksiAktif();
            const cfg = aksiConfig[aksi];
            const jumlah = parseInt(document.getElementById('editJumlahStok').value) || 0;
            const el = document.getElementById('previewHasilStok');
            const isEmpty = document.getElementById('editJumlahStok').value === '';

            if (isEmpty || !document.getElementById('editBatchId').value) {
                el.textContent = '-';
                el.className =
                    'flex items-center justify-center w-full px-4 py-2.5 text-lg font-bold border-2 border-dashed rounded-lg border-gray-200 text-gray-300';
            } else {
                el.textContent = cfg.calc(stokSaatIni, jumlah);
                el.className =
                    `flex items-center justify-center w-full px-4 py-2.5 text-lg font-bold border-2 border-dashed rounded-lg border-gray-200 ${cfg.previewColor}`;
            }
        }

        document.querySelectorAll('input[name="aksi_stok"]').forEach(r => r.addEventListener('change', updateAksiUI));
        document.getElementById('editJumlahStok').addEventListener('input', updatePreview);

        // ============================================================
        // SUBMIT FORM EDIT: KONFIRMASI SWEETALERT
        // ============================================================
        document.getElementById('formEditBatch').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            const nomor = document.getElementById('editNomorBatch').value || 'Tanpa Nomor';
            const aksi = getAksiAktif();
            const jumlah = parseInt(document.getElementById('editJumlahStok').value) || 0;
            const hasil = aksiConfig[aksi].calc(stokSaatIni, jumlah);
            const aksiTeks = {
                tambah: 'ditambah',
                kurangi: 'dikurangi',
                ganti: 'diganti menjadi'
            };

            Swal.fire({
                title: 'Simpan perubahan batch?',
                html: `Batch <strong>${nomor}</strong>:<br>Stok akan <strong>${aksiTeks[aksi]} ${jumlah}</strong> → menjadi <strong>${hasil}</strong>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then(result => {
                if (result.isConfirmed) form.submit();
            });
        });
    </script>
@endpush
