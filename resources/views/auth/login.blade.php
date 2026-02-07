<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Smart Toko Sembako</title>

    <!-- Google Fonts - Source Sans Pro -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600;700&display=swap"
        rel="stylesheet">

    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <!-- Logo -->
    <div class="absolute top-0 right-6">
        <img src="{{ asset('img/logo_toko_sembako.png') }}" alt="Logo Toko Sembako" class="h-24 w-24">
    </div>

    <!-- Login Container -->
    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden max-w-5xl w-full grid md:grid-cols-2">
        <!-- Left Side - Illustration -->
        <div class="hidden md:flex items-center justify-center bg-gradient-to-br from-orange-20 to-orange-50 p-12">
            <div class="text-center">
                <!-- Illustration Image -->
                <div class="mb-6">
                    <img src="{{ asset('img/fotologin.png') }}" alt="Shopping Illustration"
                        class="w-full h-auto max-w-md mx-auto">
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="p-12 flex flex-col justify-center">
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-gray-800 mb-5 text-center">LOGIN</h1>
                <p class="text-gray-600 text-center">Silahkan Login terlebih dahulu</p>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Login Form -->
            <form action="{{ route('login.submit') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Username Field -->
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <input type="text" name="username" placeholder="Username" value="{{ old('username') }}" required
                        class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent transition-all">
                </div>

                <!-- Password Field -->
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input type="password" name="password" placeholder="Password" required
                        class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent transition-all">
                </div>

                <!-- Login Button -->
                <button type="submit"
                    class="w-full bg-gradient-to-r from-[#EB661B] to-[#EDD38C] hover:from-[#D95A15] hover:to-[#E0C97A] text-white font-semibold py-3 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                    LOGIN
                </button>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <div class="absolute bottom-8 text-center w-full">
        <p class="text-gray-600 text-sm">
            © 2026 Made with <span class="text-red-500">❤</span> by <span class="font-semibold">𝓟</span>
        </p>
    </div>
</body>

</html>
