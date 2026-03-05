@extends('owner.layouts.app')
@section('title', 'Edit User')
@section('page-description', 'Halaman untuk mengedit data user.')

@section('content')
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('owner.dashboard') }}"
                    class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-green-600">
                    <i class="w-4 h-4 mr-2 fas fa-home"></i> Dashboard
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="w-6 h-6 text-gray-400 fas fa-chevron-right"></i>
                    <a href="{{ route('owner.user') }}"
                        class="ml-1 text-sm font-medium text-gray-700 hover:text-green-600 md:ml-2">Daftar User</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="w-6 h-6 text-gray-400 fas fa-chevron-right"></i>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Edit User</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-sm">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-green-50 to-white">
            <div class="flex items-center">
                <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mr-4 bg-green-100 rounded-lg">
                    <i class="text-2xl text-green-600 fas fa-user-edit"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-800">Edit Data User: {{ $user->nama ?? 'User' }}</h3>
                    <p class="text-sm text-gray-600">Username: {{ $user->username ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <form action="{{ route('owner.user.update', $user->id) }}" method="POST" id="formUserEdit">
            @csrf
            @method('PUT')

            <div class="p-6">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Nama Lengkap -->
                    <div>
                        <label for="nama" class="block mb-2 text-sm font-semibold text-gray-700">
                            <i class="mr-1 text-green-600 fas fa-user"></i>
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nama" name="nama" required value="{{ old('nama', $user->nama) }}"
                            class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('nama') border-red-500 @enderror">
                        @error('nama')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Username (readonly) -->
                    <div>
                        <label for="username" class="block mb-2 text-sm font-semibold text-gray-700">
                            <i class="mr-1 text-green-600 fas fa-at"></i>
                            Username
                        </label>
                        <input type="text" id="username" name="username" value="{{ old('username', $user->username) }}"
                            readonly
                            class="w-full px-4 py-2.5 bg-gray-100 border border-gray-300 rounded-lg cursor-not-allowed">
                    </div>

                    <!-- Password Baru (opsional) -->
                    <div>
                        <label for="password" class="block mb-2 text-sm font-semibold text-gray-700">
                            <i class="mr-1 text-green-600 fas fa-lock"></i>
                            Password Baru (kosongkan jika tidak ingin ubah)
                        </label>
                        <input type="password" id="password" name="password" placeholder="********"
                            class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('password') border-red-500 @enderror">
                        <p class="mt-1 text-xs text-gray-500">Minimal 8 karakter. Kosongkan jika tidak diubah.</p>
                        @error('password')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- No HP -->
                    <div>
                        <label for="no_hp" class="block mb-2 text-sm font-semibold text-gray-700">
                            <i class="mr-1 text-green-600 fas fa-phone"></i>
                            Nomor HP <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="no_hp" name="no_hp" required
                            value="{{ old('no_hp', $user->no_hp) }}"
                            class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('no_hp') border-red-500 @enderror">
                        @error('no_hp')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-700">
                            <i class="mr-1 text-green-600 fas fa-toggle-on"></i>
                            Status <span class="text-red-500">*</span>
                        </label>
                        <div class="flex gap-6">
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="status" value="aktif"
                                    {{ old('status', $user->status) == 'aktif' ? 'checked' : '' }}
                                    class="w-5 h-5 text-green-600 focus:ring-green-500">
                                <span class="ml-2 text-gray-700">Aktif</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="status" value="nonaktif"
                                    {{ old('status', $user->status) == 'nonaktif' ? 'checked' : '' }}
                                    class="w-5 h-5 text-red-600 focus:ring-red-500">
                                <span class="ml-2 text-gray-700">Nonaktif</span>
                            </label>
                        </div>
                        @error('status')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role -->
                    <div>
                        <label for="role" class="block mb-2 text-sm font-semibold text-gray-700">
                            <i class="mr-1 text-green-600 fas fa-user-shield"></i>
                            Role <span class="text-red-500">*</span>
                        </label>
                        <select id="role" name="role" required
                            class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('role') border-red-500 @enderror">
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin
                            </option>
                            <option value="kasir" {{ old('role', $user->role) == 'kasir' ? 'selected' : '' }}>Kasir
                            </option>
                        </select>
                        @error('role')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Info Box -->
                <div class="p-4 mt-8 border-l-4 border-green-500 rounded bg-green-50">
                    <p class="text-sm text-green-800">
                        <i class="mr-2 fas fa-info-circle"></i>
                        Field bertanda <span class="text-red-500">*</span> wajib diisi. Password hanya diubah jika diisi.
                    </p>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-between px-6 py-4 border-t bg-gray-50">
                <a href="{{ route('owner.user') }}"
                    class="flex items-center px-6 py-3 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                    <i class="mr-2 fas fa-arrow-left"></i> Kembali
                </a>
                <div class="flex gap-4">
                    <button type="reset" class="px-6 py-3 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        <i class="mr-2 fas fa-redo"></i> Reset
                    </button>
                    <button type="submit"
                        class="px-6 py-3 text-white bg-green-600 rounded-lg shadow-md hover:bg-green-700">
                        <i class="mr-2 fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
