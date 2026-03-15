@extends('admin.layouts.app')
@section('title', 'Tambah Stok Produk')
@section('page-description', 'Halaman untuk menambah jumlah stok produk.')

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
    </nav>

    <!-- Header -->
    <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-green-50 to-white">
        <div class="flex items-center">
            <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mr-4 bg-green-100 rounded-lg">
                <i class="text-2xl text-green-600 fas fa-plus-circle"></i>
            </div>
            <div>
                <h3 class="text-xl font-bold text-gray-800">Tambah Stok: {{ $produk->nama_produk }}</h3>
                <p class="text-sm text-gray-600">Kode:
                    {{ $produk->barcode ?? 'BRS-' . str_pad($produk->id, 3, '0', STR_PAD_LEFT) }} | Satuan:
                    {{ $produk->satuan }}</p>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.stok.store', $produk->id) }}" method="POST" id="formStok">
        @csrf

        <div class="p-6">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <!-- Nama Produk (readonly) -->
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        <i class="mr-1 text-green-600 fas fa-tag"></i> Nama Produk
                    </label>
                    <input type="text" value="{{ $produk->nama_produk }}"
                        class="w-full px-4 py-2.5 bg-gray-100 border border-gray-300 rounded-lg cursor-not-allowed"
                        readonly>
                </div>

                <!-- Stok Saat Ini (readonly) -->
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        <i class="mr-1 text-green-600 fas fa-boxes"></i> Stok Saat Ini
                    </label>
                    <input type="text" value="{{ number_format($produk->stok) }}"
                        class="w-full px-4 py-2.5 bg-gray-100 border border-gray-300 rounded-lg cursor-not-allowed"
                        readonly>
                </div>

                <!-- Tambahkan Stok -->
                <div class="md:col-span-2">
                    <label for="stok" class="block mb-2 text-sm font-semibold text-gray-700">
                        <i class="mr-1 text-green-600 fas fa-plus-square"></i> Tambahkan Stok <span
                            class="text-red-500">*</span>
                    </label>
                    <input type="number" id="stok" name="stok" required min="1" step="1"
                        value="{{ old('stok') }}" placeholder="Contoh: 25"
                        class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('stok') border-red-500 @enderror">
                    @error('stok')
                        <p class="mt-1 text-sm text-red-500"><i class="mr-1 fas fa-exclamation-circle"></i>{{ $message }}
                        </p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Masukkan jumlah stok yang ingin ditambahkan ke
                        {{ $produk->nama_produk }}</p>
                </div>
            </div>

            <!-- Info Box -->
            <div class="p-4 mt-8 border-l-4 border-green-500 rounded-lg bg-green-50">
                <p class="text-sm text-green-800">
                    <i class="mr-2 fas fa-info-circle"></i> Stok lama ({{ number_format($produk->stok) }}) + stok baru =
                    total stok terbaru.
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
                    <i class="mr-2 fas fa-save"></i> Tambah Stok
                </button>
            </div>
        </div>
    </form>
@endsection
