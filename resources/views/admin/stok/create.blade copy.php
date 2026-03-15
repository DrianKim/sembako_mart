@extends('admin.layouts.app')
@section('title', 'Tambah Stok Produk')
@section('page-description', 'Halaman untuk menambah stok produk yang sudah ada.')

{{-- @php
    $produks = $data['produks'];
@endphp --}}

@section('content')
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
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Tambah Stok</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-sm">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-green-50 to-white">
            <div class="flex items-center">
                <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mr-4 bg-green-100 rounded-lg">
                    <i class="text-2xl text-green-600 fas fa-plus-circle"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-800">Tambah Stok Produk</h3>
                    <p class="text-sm text-gray-600">Pilih produk dan masukkan jumlah stok yang akan ditambahkan</p>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.stok.store') }}" method="POST" id="formStok">
            @csrf

            <div class="p-6">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Pilih Produk -->
                    <div class="md:col-span-2">
                        <label for="produk_id" class="block mb-2 text-sm font-semibold text-gray-700">
                            <i class="mr-1 text-green-600 fas fa-box"></i> Produk <span class="text-red-500">*</span>
                        </label>
                        <select id="produk_id" name="produk_id" required
                            class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('produk_id') border-red-500 @enderror">
                            <option value="">-- Pilih Produk --</option>
                            @foreach ($produks as $produk)
                                <option value="{{ $produk->id }}" data-stok="{{ $produk->stok }}"
                                    data-satuan="{{ $produk->satuan }}">
                                    {{ $produk->nama_produk }}
                                    ({{ $produk->barcode ?? 'BRS-' . str_pad($produk->id, 3, '0', STR_PAD_LEFT) }}) - Stok
                                    saat ini: {{ number_format($produk->stok) }} {{ $produk->satuan }}
                                </option>
                            @endforeach
                        </select>
                        @error('produk_id')
                            <p class="mt-1 text-sm text-red-500"><i
                                    class="mr-1 fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jumlah Stok Ditambahkan -->
                    <div>
                        <label for="stok" class="block mb-2 text-sm font-semibold text-gray-700">
                            <i class="mr-1 text-green-600 fas fa-plus-square"></i> Jumlah Stok Ditambahkan <span
                                class="text-red-500">*</span>
                        </label>
                        <input type="number" id="stok" name="stok" required min="1" step="1"
                            value="{{ old('stok') }}" placeholder="Contoh: 67"
                            class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('stok') border-red-500 @enderror">
                        @error('stok')
                            <p class="mt-1 text-sm text-red-500"><i
                                    class="mr-1 fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Masukkan jumlah stok yang ingin ditambahkan</p>
                    </div>

                    <!-- Preview Stok Saat Ini -->
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-700">
                            <i class="mr-1 text-green-600 fas fa-info-circle"></i> Stok Saat Ini
                        </label>
                        <div id="currentStok"
                            class="px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-gray-700 font-medium">
                            Pilih produk terlebih dahulu...
                        </div>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="p-4 mt-8 border-l-4 border-green-500 rounded-lg bg-green-50">
                    <p class="text-sm text-green-800">
                        <i class="mr-2 fas fa-info-circle"></i> Stok akan ditambahkan ke stok saat ini. Field bertanda <span
                            class="text-red-500">*</span> wajib diisi.
                    </p>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex items-center justify-between px-6 py-5 border-t bg-gray-50">
                <a href="{{ route('admin.stok') }}"
                    class="flex items-center px-6 py-3 transition bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                    <i class="mr-2 fas fa-arrow-left"></i> Kembali
                </a>
                <div class="flex gap-4">
                    <button type="reset"
                        class="px-6 py-3 transition bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        <i class="mr-2 fas fa-redo"></i> Reset
                    </button>
                    <button type="submit"
                        class="px-6 py-3 text-white transition rounded-lg shadow-md bg-gradient-to-r from-green-600 to-green-500 hover:shadow-lg hover:from-green-700 hover:to-green-600">
                        <i class="mr-2 fas fa-plus"></i> Tambah Stok
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const produkSelect = document.getElementById('produk_id');
    const currentStokDiv = document.getElementById('currentStok');

    produkSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value) {
            const stok = selectedOption.dataset.stok;
            const satuan = selectedOption.dataset.satuan;
            currentStokDiv.innerHTML = `<span class="font-bold text-green-600">${stok.toLocaleString()}</span> ${satuan}`;
        } else {
            currentStokDiv.textContent = 'Pilih produk terlebih dahulu...';
        }
    });

    // SweetAlert session messages
    @if (session('success'))
        Swal.fire({
            icon: 'success', title: 'Sukses!', text: '{{ session("success") }}',
            confirmButtonColor: '#10b981', iconColor: '#A5DC86'
        });
    @endif

    @if ($errors->any())
        Swal.fire({
            icon: 'error', title: 'Gagal!', text: '{{ $errors->first() }}',
            confirmButtonColor: '#ef4444', iconColor: '#ef4444'
        });
    @endif
</script>
@endpush

