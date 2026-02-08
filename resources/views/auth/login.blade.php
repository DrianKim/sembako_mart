<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Smart Toko Sembako</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo_toko_sembako.png') }}">

    <!-- Google Fonts - Source Sans Pro -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600;700&display=swap"
        rel="stylesheet">

    @vite('resources/css/app.css')
</head>

<body class="flex items-center justify-center min-h-screen p-4 bg-gray-100">
    <!-- Logo -->
    <div class="absolute top-0 right-6">
        <img src="{{ asset('img/logo_toko_sembako.png') }}" alt="Logo Toko Sembako" class="w-24 h-24">
    </div>

    <!-- Back Button di pojok kiri atas -->
    <div class="absolute top-6 left-6">
        <a href="/"
            class="text-3xl font-bold text-orange-500 transition-transform duration-200 hover:text-orange-800 hover:scale-110">
            <i class="fas fa-arrow-left"></i>
        </a>
    </div>

    {{-- <div class="absolute top-6 left-6">
        <a href="/" class="flex items-center text-orange-500 transition-all duration-200 hover:text-orange-800">
            <!-- Icon panah kiri -->
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>
    </div> --}}

    <!-- Login Container -->
    <div class="grid w-full max-w-5xl overflow-hidden bg-white shadow-2xl rounded-2xl md:grid-cols-2">
        <!-- Left Side - Illustration -->
        <div class="items-center justify-center hidden p-12 md:flex bg-gradient-to-br from-orange-20 to-orange-50">
            <div class="text-center">
                <!-- Illustration Image -->
                <div class="mb-6">
                    <img src="{{ asset('img/fotologin.png') }}" alt="Shopping Illustration"
                        class="w-full h-auto max-w-md mx-auto">
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="flex flex-col justify-center p-12">
            <div class="mb-8">
                <h1 class="mb-5 text-4xl font-bold text-center text-gray-800">LOGIN</h1>
                <p class="text-center text-gray-600">Silahkan Login terlebih dahulu</p>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="px-4 py-3 mb-6 text-red-700 border border-red-200 rounded-lg bg-red-50">
                    <ul class="text-sm list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div class="px-4 py-3 mb-6 text-sm text-red-700 border border-red-200 rounded-lg bg-red-50">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('success'))
                <div class="px-4 py-3 mb-6 text-sm text-green-700 border border-green-200 rounded-lg bg-green-50">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Login Form -->
            <form action="{{ route('login.submit') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Username Field -->
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <input type="text" name="username" placeholder="Username" value="{{ old('username') }}" required
                        class="w-full py-3 pl-12 pr-4 transition-all border border-gray-200 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent">
                </div>

                <!-- Password Field -->
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input type="password" name="password" placeholder="Password" required
                        class="w-full py-3 pl-12 pr-4 transition-all border border-gray-200 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent">
                </div>

                <!-- Back -->
                <div class="text-center">
                    <p class="text-xs leading-relaxed text-justify text-gray-400">
                        Login ini hanya diperuntukkan bagi kasir, admin, dan owner.
                        Gunakan dengan aman dan jangan sebar informasi akun ke orang lain.
                        Semua aktivitas di halaman ini akan tercatat untuk keperluan audit dan manajemen.
                        Jika ada masalah login, hubungi pemilik toko atau admin IT.
                    </p>
                </div>

                <!-- Login Button -->
                <button type="submit"
                    class="w-full bg-gradient-to-r from-[#22C55E] to-[#10B981] hover:from-[#16A34A] hover:to-[#059669] text-white font-semibold py-3 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                    LOGIN
                </button>

            </form>
        </div>
    </div>

    <!-- Footer -->
    <div class="absolute w-full text-center bottom-8">
        <p class="text-sm text-gray-600">
            © 2026 Made with <span class="text-red-500">❤</span> by <span class="font-semibold">𝓟</span>
        </p>
    </div>
</body>

</html>
