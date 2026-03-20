@extends('admin.layouts.app')
@section('title', 'Tambah Kasir')
@section('page-description', 'Halaman untuk menambah data kasir baru.')

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
                    <a href="{{ route('admin.kasir') }}"
                        class="ml-1 text-sm font-medium text-gray-700 hover:text-green-600 md:ml-2">Kasir</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="w-6 h-6 text-gray-400 fas fa-chevron-right"></i>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Tambah Kasir</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-sm">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-green-50 to-white">
            <div class="flex items-center">
                <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mr-4 bg-green-100 rounded-lg">
                    <i class="text-2xl text-green-600 fas fa-user-plus"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-800">Tambah Kasir Baru</h3>
                    <p class="text-sm text-gray-600">Isi form di bawah untuk menambah data kasir baru</p>
                </div>
            </div>
        </div>

        <!-- FORM -->
        <form action="{{ route('admin.kasir.store') }}" method="POST" id="formKasir">
            @csrf

            <div class="p-6">
                <!-- ERROR SUMMARY -->
                @if ($errors->any())
                    <div class="p-4 mb-6 border border-red-200 rounded-lg bg-red-50">
                        <div class="flex items-start">
                            <i class="mt-1 mr-3 text-lg text-red-500 fas fa-exclamation-triangle"></i>
                            <div>
                                <p class="mb-1 text-sm font-semibold text-red-700">Periksa kembali:</p>
                                <ul class="space-y-1 text-sm text-red-700">
                                    @foreach ($errors->all() as $error)
                                        <li>• {{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- FORM FIELDS -->
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Nama -->
                    <div>
                        <label for="nama" class="block mb-2 text-sm font-semibold text-gray-700">
                            <i class="mr-1 text-green-600 fas fa-user"></i>
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nama" name="nama" required value="{{ old('nama') }}"
                            placeholder="Contoh: Andi Susanto"
                            class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('nama') border-red-500 ring-2 ring-red-200 @enderror">
                        @error('nama')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Username -->
                    <div>
                        <label for="username" class="block mb-2 text-sm font-semibold text-gray-700">
                            <i class="mr-1 text-green-600 fas fa-at"></i>
                            Username <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="username" name="username" required value="{{ old('username') }}"
                            placeholder="Contoh: andi_kasir"
                            class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('username') border-red-500 ring-2 ring-red-200 @enderror">
                        @error('username')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block mb-2 text-sm font-semibold text-gray-700">
                            <i class="mr-1 text-green-600 fas fa-lock"></i>
                            Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" id="password" name="password" required minlength="8" placeholder="********"
                            class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('password') border-red-500 ring-2 ring-red-200 @enderror">
                        @error('password')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Minimal 8 karakter</p>
                    </div>

                    <!-- No HP -->
                    <div>
                        <label for="no_hp" class="block mb-2 text-sm font-semibold text-gray-700">
                            <i class="mr-1 text-green-600 fas fa-phone"></i>
                            Nomor HP <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="no_hp" name="no_hp" required value="{{ old('no_hp') }}"
                            placeholder="Contoh: 081234567890"
                            class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('no_hp') border-red-500 ring-2 ring-red-200 @enderror">
                        @error('no_hp')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- INFO TIP -->
                <div class="p-4 mt-8 border-l-4 border-green-500 rounded bg-green-50">
                    <p class="text-sm text-green-800">
                        <i class="mr-2 fas fa-info-circle"></i>
                        Field bertanda <span class="text-red-500">*</span> wajib diisi. Password akan di-hash otomatis oleh
                        sistem.
                    </p>
                </div>
            </div>

            <!-- FOOTER BUTTONS -->
            <div class="flex items-center justify-between px-6 py-4 border-t bg-gray-50">
                <a href="{{ route('admin.kasir') }}"
                    class="flex items-center px-6 py-3 text-gray-700 transition-colors bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                    <i class="mr-2 fas fa-arrow-left"></i> Kembali
                </a>
                <div class="flex gap-3">
                    <button type="reset"
                        class="px-6 py-3 text-gray-700 transition-colors bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        <i class="mr-2 fas fa-redo"></i> Reset
                    </button>
                    <button type="submit"
                        class="flex items-center px-6 py-3 text-white transition-all bg-green-600 rounded-lg shadow-md hover:bg-green-700 hover:shadow-lg focus:ring-4 focus:ring-green-300">
                        <i class="mr-2 fas fa-save"></i> Simpan Kasir
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
