@extends('admin.layouts.app')
@section('title', 'Tambah Kategori')
@section('page-description', 'Halaman untuk menambah kategori produk baru.')

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
                    <a href="{{ route('admin.kategori') }}"
                        class="ml-1 text-sm font-medium text-gray-700 hover:text-green-600 md:ml-2">
                        Kategori Produk
                    </a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="w-6 h-6 text-gray-400 fas fa-chevron-right"></i>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Tambah Kategori</span>
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
                    <h3 class="text-xl font-bold text-gray-800">Tambah Kategori Baru</h3>
                    <p class="text-sm text-gray-600">Isi form di bawah untuk menambah kategori produk baru</p>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.kategori.store') }}" method="POST" id="formKategori">
            @csrf
            <div class="p-6">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <label for="nama_kategori" class="block mb-2 text-sm font-semibold text-gray-700">
                            <i class="mr-1 text-green-600 fas fa-tag"></i>
                            Nama Kategori <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nama_kategori" name="nama_kategori" required autofocus
                            value="{{ old('nama_kategori') }}" placeholder="Contoh: Beras & Tepung"
                            class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                        @error('nama_kategori')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="p-4 mt-8 border-l-4 border-green-500 rounded bg-green-50">
                    <p class="text-sm text-green-800">
                        <i class="mr-2 fas fa-info-circle"></i>
                        Field bertanda <span class="text-red-500">*</span> wajib diisi. Pastikan data sudah benar sebelum simpan.
                    </p>
                </div>
            </div>

            <div class="flex items-center justify-between px-6 py-4 border-t bg-gray-50">
                <a href="{{ route('admin.kategori') }}"
                    class="flex items-center px-6 py-3 transition-colors bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                    <i class="mr-2 fas fa-arrow-left"></i> Kembali
                </a>
                <div class="flex gap-4">
                    <button type="reset"
                        class="px-6 py-3 transition-colors bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        <i class="mr-2 fas fa-redo"></i> Reset
                    </button>
                    <button type="submit"
                        class="px-6 py-3 text-white transition-colors bg-green-600 rounded-lg shadow-md hover:bg-green-700">
                        <i class="mr-2 fas fa-save"></i> Simpan Kategori
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        // SweetAlert untuk success/error dari session
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 2500,
                showConfirmButton: false,
                position: 'top-end',
                toast: true
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                timer: 3000,
                showConfirmButton: false,
                position: 'top-end',
                toast: true
            });
        @endif

        // Client-side validation sederhana
        document.getElementById('formKategori').addEventListener('submit', function(e) {
            const nama = document.getElementById('nama_kategori').value.trim();
            if (!nama) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Nama kategori wajib diisi!',
                    confirmButtonColor: '#10b981'
                });
                document.getElementById('nama_kategori').focus();
            }
        });
    </script>
@endpush
