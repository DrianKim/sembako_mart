<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sembako Mart - Toko Sembako Terpercaya di Kota Anda</title>

    <!-- Google Fonts - Source Sans Pro -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600;700;800&display=swap"
        rel="stylesheet">

    @vite('resources/css/app.css')

    <style>
        /* Custom animations */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-float {
            animation: float 4s ease-in-out infinite;
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }

        /* Gradient text */
        .gradient-text {
            background: linear-gradient(135deg, #EB661B 0%, #22C55E 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #EB661B 0%, #22C55E 100%);
            border-radius: 5px;
        }

        /* Shine effect for product cards */
        .product-card {
            position: relative;
            overflow: hidden;
        }

        .product-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .product-card:hover::before {
            left: 100%;
        }
    </style>
</head>

<body class="bg-white font-sans">
    <!-- Navigation Bar -->
    <nav class="fixed w-full bg-white/95 backdrop-blur-sm shadow-md z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <img id="logo" src="{{ asset('img/logo_toko_sembako.png') }}" alt="Logo Sembako Mart"
                        class="h-14 w-14 cursor-pointer">
                    <div>
                        <span class="text-2xl font-bold gradient-text">Sembako Mart</span>
                        <p class="text-xs text-gray-600">Kebutuhan Sehari-hari Lengkap</p>
                    </div>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#beranda" class="text-gray-700 hover:text-orange-500 font-semibold transition">Beranda</a>
                    <a href="#tentang" class="text-gray-700 hover:text-orange-500 font-semibold transition">Tentang
                        Kami</a>
                    <a href="#produk" class="text-gray-700 hover:text-orange-500 font-semibold transition">Produk</a>
                    <a href="#lokasi" class="text-gray-700 hover:text-orange-500 font-semibold transition">Lokasi</a>
                    <a href="#kontak"
                        class="bg-gradient-to-r from-[#EB661B] to-[#22C55E] text-white px-6 py-2.5 rounded-full font-semibold hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                        Hubungi Kami
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" class="md:hidden text-gray-700 hover:text-orange-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t">
            <div class="px-4 pt-2 pb-4 space-y-2">
                <a href="#beranda" class="block py-2 text-gray-700 hover:text-orange-500 font-semibold">Beranda</a>
                <a href="#tentang" class="block py-2 text-gray-700 hover:text-orange-500 font-semibold">Tentang Kami</a>
                <a href="#produk" class="block py-2 text-gray-700 hover:text-orange-500 font-semibold">Produk</a>
                <a href="#lokasi" class="block py-2 text-gray-700 hover:text-orange-500 font-semibold">Lokasi</a>
                <a href="#kontak" class="block py-2 text-gray-700 hover:text-orange-500 font-semibold">Kontak</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="beranda" class="pt-32 pb-20 bg-gradient-to-br from-orange-50 via-white to-green-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="animate-fade-in-up">
                    <div class="inline-block bg-gradient-to-r from-orange-100 to-green-100 px-4 py-2 rounded-full mb-4">
                        <span class="text-sm font-semibold text-orange-700">🎉 Buka Setiap Hari</span>
                    </div>
                    <h1 class="text-5xl md:text-6xl font-bold text-gray-800 mb-6 leading-tight">
                        Belanja <span class="gradient-text">Sembako</span> Lengkap & Terpercaya!
                    </h1>
                    <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                        Dapatkan kebutuhan sembako harian Anda dengan harga terjangkau dan kualitas terjamin. Kami
                        melayani dengan sepenuh hati!
                    </p>

                    <!-- Features -->
                    <div class="grid grid-cols-2 gap-4 mb-8">
                        <div class="flex items-center space-x-3">
                            <div
                                class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span class="text-gray-700 font-semibold">Harga Terjangkau</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div
                                class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span class="text-gray-700 font-semibold">Produk Lengkap</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div
                                class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span class="text-gray-700 font-semibold">Kualitas Terjamin</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div
                                class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span class="text-gray-700 font-semibold">Lokasi Strategis</span>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-4">
                        <a href="#produk"
                            class="bg-gradient-to-r from-[#EB661B] to-[#EDD38C] hover:from-[#D95A15] hover:to-[#E0C97A] text-white px-8 py-4 rounded-lg font-bold text-lg shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-200">
                            Lihat Produk
                        </a>
                        <a href="#lokasi"
                            class="bg-white border-2 border-green-500 text-green-600 px-8 py-4 rounded-lg font-bold text-lg hover:bg-green-50 transform hover:-translate-y-1 transition-all duration-200">
                            Kunjungi Toko
                        </a>
                    </div>
                </div>

                <!-- Right Image -->
                <div class="relative">
                    <div class="absolute -top-4 -right-4 w-72 h-72 bg-orange-200 rounded-full opacity-20 blur-3xl">
                    </div>
                    <div class="absolute -bottom-4 -left-4 w-72 h-72 bg-green-200 rounded-full opacity-20 blur-3xl">
                    </div>
                    <img src="{{ asset('img/fotologin.png') }}" alt="Shopping"
                        class="relative z-10 w-full h-auto animate-float drop-shadow-2xl">
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="tentang" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
                    Tentang <span class="gradient-text">Sembako Mart</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Toko sembako terpercaya yang telah melayani kebutuhan masyarakat dengan dedikasi tinggi
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Value 1 -->
                <div
                    class="bg-gradient-to-br from-orange-50 to-white p-8 rounded-2xl border-2 border-orange-100 hover:shadow-xl transform hover:-translate-y-2 transition-all duration-300">
                    <div
                        class="w-16 h-16 bg-gradient-to-r from-[#EB661B] to-[#EDD38C] rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Buka Setiap Hari</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Kami buka setiap hari untuk melayani kebutuhan sembako Anda. Senin - Minggu, pagi hingga malam.
                    </p>
                </div>

                <!-- Value 2 -->
                <div
                    class="bg-gradient-to-br from-green-50 to-white p-8 rounded-2xl border-2 border-green-100 hover:shadow-xl transform hover:-translate-y-2 transition-all duration-300">
                    <div
                        class="w-16 h-16 bg-gradient-to-r from-[#22C55E] to-[#86EFAC] rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Produk Berkualitas</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Semua produk yang kami jual adalah produk pilihan dengan kualitas terjamin dan harga bersaing.
                    </p>
                </div>

                <!-- Value 3 -->
                <div
                    class="bg-gradient-to-br from-orange-50 to-white p-8 rounded-2xl border-2 border-orange-100 hover:shadow-xl transform hover:-translate-y-2 transition-all duration-300">
                    <div
                        class="w-16 h-16 bg-gradient-to-r from-[#EB661B] to-[#EDD38C] rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Pelayanan Ramah</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Tim kami siap melayani Anda dengan ramah dan membantu menemukan produk yang Anda butuhkan.
                    </p>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid md:grid-cols-4 gap-8 mt-16">
                <div class="text-center">
                    <div class="text-5xl font-bold gradient-text mb-2">5+</div>
                    <div class="text-gray-600 font-semibold">Tahun Beroperasi</div>
                </div>
                <div class="text-center">
                    <div class="text-5xl font-bold gradient-text mb-2">500+</div>
                    <div class="text-gray-600 font-semibold">Produk Tersedia</div>
                </div>
                <div class="text-center">
                    <div class="text-5xl font-bold gradient-text mb-2">1000+</div>
                    <div class="text-gray-600 font-semibold">Pelanggan Setia</div>
                </div>
                <div class="text-center">
                    <div class="text-5xl font-bold gradient-text mb-2">100%</div>
                    <div class="text-gray-600 font-semibold">Kepuasan</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section id="produk" class="py-20 bg-gradient-to-br from-orange-50 via-white to-green-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
                    Produk <span class="gradient-text">Kami</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Berbagai macam kebutuhan sembako berkualitas dengan harga terjangkau
                </p>
            </div>

            <!-- Product Categories -->
            <div class="grid md:grid-cols-4 gap-6 mb-12">
                <!-- Category 1 -->
                <div
                    class="product-card bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300">
                    <div class="h-48 bg-gradient-to-br from-orange-400 to-orange-200 flex items-center justify-center">
                        <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Beras Premium</h3>
                        <p class="text-gray-600 text-sm mb-3">Berbagai merk beras pilihan berkualitas</p>
                        <div class="flex items-center justify-between">
                            <span class="text-orange-600 font-bold">Mulai Rp 50.000</span>
                        </div>
                    </div>
                </div>

                <!-- Category 2 -->
                <div
                    class="product-card bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300">
                    <div class="h-48 bg-gradient-to-br from-green-400 to-green-200 flex items-center justify-center">
                        <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Minyak Goreng</h3>
                        <p class="text-gray-600 text-sm mb-3">Minyak goreng berkualitas untuk masak</p>
                        <div class="flex items-center justify-between">
                            <span class="text-green-600 font-bold">Mulai Rp 15.000</span>
                        </div>
                    </div>
                </div>

                <!-- Category 3 -->
                <div
                    class="product-card bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300">
                    <div class="h-48 bg-gradient-to-br from-orange-400 to-orange-200 flex items-center justify-center">
                        <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Bumbu Dapur</h3>
                        <p class="text-gray-600 text-sm mb-3">Lengkapi dapur dengan bumbu pilihan</p>
                        <div class="flex items-center justify-between">
                            <span class="text-orange-600 font-bold">Mulai Rp 5.000</span>
                        </div>
                    </div>
                </div>

                <!-- Category 4 -->
                <div
                    class="product-card bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300">
                    <div class="h-48 bg-gradient-to-br from-green-400 to-green-200 flex items-center justify-center">
                        <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Makanan Instan</h3>
                        <p class="text-gray-600 text-sm mb-3">Mie instan dan makanan siap saji</p>
                        <div class="flex items-center justify-between">
                            <span class="text-green-600 font-bold">Mulai Rp 2.500</span>
                        </div>
                    </div>
                </div>

                <!-- Category 5 -->
                <div
                    class="product-card bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300">
                    <div class="h-48 bg-gradient-to-br from-orange-400 to-orange-200 flex items-center justify-center">
                        <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Gula & Kopi</h3>
                        <p class="text-gray-600 text-sm mb-3">Gula pasir, gula merah, kopi sachet</p>
                        <div class="flex items-center justify-between">
                            <span class="text-orange-600 font-bold">Mulai Rp 10.000</span>
                        </div>
                    </div>
                </div>

                <!-- Category 6 -->
                <div
                    class="product-card bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300">
                    <div class="h-48 bg-gradient-to-br from-green-400 to-green-200 flex items-center justify-center">
                        <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Sabun & Detergen</h3>
                        <p class="text-gray-600 text-sm mb-3">Kebutuhan mandi dan cuci pakaian</p>
                        <div class="flex items-center justify-between">
                            <span class="text-green-600 font-bold">Mulai Rp 3.000</span>
                        </div>
                    </div>
                </div>

                <!-- Category 7 -->
                <div
                    class="product-card bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300">
                    <div class="h-48 bg-gradient-to-br from-orange-400 to-orange-200 flex items-center justify-center">
                        <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Telur & Susu</h3>
                        <p class="text-gray-600 text-sm mb-3">Telur ayam segar dan susu kotak</p>
                        <div class="flex items-center justify-between">
                            <span class="text-orange-600 font-bold">Mulai Rp 25.000</span>
                        </div>
                    </div>
                </div>

                <!-- Category 8 -->
                <div
                    class="product-card bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300">
                    <div class="h-48 bg-gradient-to-br from-green-400 to-green-200 flex items-center justify-center">
                        <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Snack & Minuman</h3>
                        <p class="text-gray-600 text-sm mb-3">Cemilan dan minuman dingin segar</p>
                        <div class="flex items-center justify-between">
                            <span class="text-green-600 font-bold">Mulai Rp 1.000</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Note -->
            <div class="bg-white rounded-2xl shadow-lg p-8 border-2 border-orange-100">
                <div class="flex items-start space-x-4">
                    <div
                        class="w-12 h-12 bg-gradient-to-r from-[#EB661B] to-[#22C55E] rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Catatan Penting</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Harga dapat berubah sewaktu-waktu mengikuti harga pasar. Stok produk selalu kami update
                            untuk memastikan ketersediaan.
                            Untuk info produk dan harga terbaru, silakan kunjungi toko kami langsung atau hubungi nomor
                            kontak yang tersedia.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Location Section -->
    <section id="lokasi" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
                    Lokasi <span class="gradient-text">Toko</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Temukan kami di lokasi yang strategis dan mudah dijangkau
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-12">
                <!-- Map -->
                <div class="rounded-2xl overflow-hidden shadow-xl">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.0!2d106.8!3d-6.2!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMTInMDAuMCJTIDEwNsKwNDgnMDAuMCJF!5e0!3m2!1sen!2sid!4v1234567890"
                        width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        class="grayscale hover:grayscale-0 transition duration-300">
                    </iframe>
                </div>

                <!-- Store Info -->
                <div class="space-y-6">
                    <!-- Address -->
                    <div
                        class="bg-gradient-to-br from-orange-50 to-white p-6 rounded-2xl border-2 border-orange-100 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-start space-x-4">
                            <div
                                class="w-12 h-12 bg-gradient-to-r from-[#EB661B] to-[#EDD38C] rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800 text-lg mb-2">Alamat Lengkap</h3>
                                <p class="text-gray-600 leading-relaxed">
                                    Jl. Raya Sembako No. 123<br>
                                    Kelurahan Makmur, Kecamatan Sejahtera<br>
                                    Jakarta Selatan 12345
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Opening Hours -->
                    <div
                        class="bg-gradient-to-br from-green-50 to-white p-6 rounded-2xl border-2 border-green-100 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-start space-x-4">
                            <div
                                class="w-12 h-12 bg-gradient-to-r from-[#22C55E] to-[#86EFAC] rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800 text-lg mb-2">Jam Operasional</h3>
                                <div class="space-y-1 text-gray-600">
                                    <p><span class="font-semibold">Senin - Sabtu:</span> 07.00 - 21.00 WIB</p>
                                    <p><span class="font-semibold">Minggu:</span> 08.00 - 20.00 WIB</p>
                                    <p class="text-green-600 font-semibold mt-2">✓ Buka Setiap Hari</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Info -->
                    <div
                        class="bg-gradient-to-br from-orange-50 to-white p-6 rounded-2xl border-2 border-orange-100 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-start space-x-4">
                            <div
                                class="w-12 h-12 bg-gradient-to-r from-[#EB661B] to-[#EDD38C] rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800 text-lg mb-2">Hubungi Kami</h3>
                                <div class="space-y-1 text-gray-600">
                                    <p><span class="font-semibold">Telepon:</span> (021) 1234-5678</p>
                                    <p><span class="font-semibold">WhatsApp:</span> +62 812-3456-7890</p>
                                    <p><span class="font-semibold">Email:</span> info@sembakomart.com</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Direction Button -->
                    <a href="https://maps.google.com" target="_blank"
                        class="block w-full bg-gradient-to-r from-[#EB661B] to-[#22C55E] hover:from-[#D95A15] hover:to-[#16A34A] text-white font-bold py-4 rounded-lg shadow-lg hover:shadow-xl text-center transform hover:-translate-y-1 transition-all duration-200">
                        📍 Buka di Google Maps
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="kontak" class="py-20 bg-gradient-to-br from-orange-50 via-white to-green-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
                    Ada <span class="gradient-text">Pertanyaan?</span>
                </h2>
                <p class="text-xl text-gray-600">
                    Jangan ragu untuk menghubungi kami. Tim kami siap membantu Anda!
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow-2xl p-8 md:p-12">
                <form action="#" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Nama Lengkap</label>
                            <input type="text" name="name" required
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent transition-all">
                        </div>

                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Nomor Telepon</label>
                            <input type="tel" name="phone" required
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Email</label>
                        <input type="email" name="email" required
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent transition-all">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Pesan</label>
                        <textarea name="message" rows="5" required
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent transition-all"></textarea>
                    </div>

                    <button type="submit"
                        class="w-full bg-gradient-to-r from-[#EB661B] to-[#22C55E] hover:from-[#D95A15] hover:to-[#16A34A] text-white font-bold py-4 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200">
                        Kirim Pesan
                    </button>
                </form>

                <!-- Quick Contact -->
                <div class="grid md:grid-cols-3 gap-4 mt-8 pt-8 border-t border-gray-200">
                    <a href="tel:02112345678"
                        class="flex items-center justify-center space-x-2 p-3 bg-orange-50 rounded-lg hover:bg-orange-100 transition">
                        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <span class="text-sm font-semibold text-gray-700">Telepon</span>
                    </a>

                    <a href="https://wa.me/6281234567890" target="_blank"
                        class="flex items-center justify-center space-x-2 p-3 bg-green-50 rounded-lg hover:bg-green-100 transition">
                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                        </svg>
                        <span class="text-sm font-semibold text-gray-700">WhatsApp</span>
                    </a>

                    <a href="mailto:info@sembakomart.com"
                        class="flex items-center justify-center space-x-2 p-3 bg-orange-50 rounded-lg hover:bg-orange-100 transition">
                        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span class="text-sm font-semibold text-gray-700">Email</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <!-- About -->
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <img src="{{ asset('img/logo_toko_sembako.png') }}" alt="Logo" class="h-10 w-10">
                        <span class="text-xl font-bold">Sembako Mart</span>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Toko sembako terpercaya yang melayani kebutuhan sehari-hari Anda dengan harga terjangkau dan
                        kualitas terjamin.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="font-bold text-lg mb-4">Menu</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="#beranda" class="hover:text-orange-400 transition">Beranda</a></li>
                        <li><a href="#tentang" class="hover:text-orange-400 transition">Tentang Kami</a></li>
                        <li><a href="#produk" class="hover:text-orange-400 transition">Produk</a></li>
                        <li><a href="#lokasi" class="hover:text-orange-400 transition">Lokasi</a></li>
                        <li><a href="#kontak" class="hover:text-orange-400 transition">Kontak</a></li>
                    </ul>
                </div>

                <!-- Products -->
                <div>
                    <h4 class="font-bold text-lg mb-4">Produk Kami</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li>Beras & Minyak Goreng</li>
                        <li>Bumbu Dapur</li>
                        <li>Makanan Instan</li>
                        <li>Sabun & Detergen</li>
                        <li>Snack & Minuman</li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="font-bold text-lg mb-4">Hubungi Kami</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li>📍 Jl. Raya Sembako No. 123<br>Jakarta Selatan 12345</li>
                        <li>📞 (021) 1234-5678</li>
                        <li>📱 +62 812-3456-7890</li>
                        <li>✉️ info@sembakomart.com</li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Footer -->
            <div class="border-t border-gray-800 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-400 text-sm mb-4 md:mb-0">
                        © 2026 Sembako Mart. Made with <span class="text-red-500">❤</span> by <span
                            class="font-semibold">𝓟</span>
                    </p>

                    <!-- Social Media -->
                    <div class="flex space-x-4">
                        <a href="#"
                            class="w-10 h-10 bg-gradient-to-r from-[#EB661B] to-[#EDD38C] rounded-full flex items-center justify-center hover:opacity-80 transition">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                        </a>
                        <a href="#"
                            class="w-10 h-10 bg-gradient-to-r from-[#22C55E] to-[#86EFAC] rounded-full flex items-center justify-center hover:opacity-80 transition">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073z" />
                                <path
                                    d="M12 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zm0 10.162a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
                            </svg>
                        </a>
                        <a href="https://wa.me/6281234567890" target="_blank"
                            class="w-10 h-10 bg-gradient-to-r from-[#EB661B] to-[#EDD38C] rounded-full flex items-center justify-center hover:opacity-80 transition">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Smooth Scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    // Close mobile menu if open
                    mobileMenu.classList.add('hidden');
                }
            });
        });

        // Navbar shadow on scroll
        window.addEventListener('scroll', () => {
            const nav = document.querySelector('nav');
            if (window.scrollY > 10) {
                nav.classList.add('shadow-lg');
            } else {
                nav.classList.remove('shadow-lg');
            }
        });

        // Scroll reveal animation
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe all sections
        document.querySelectorAll('section').forEach(section => {
            section.style.opacity = '0';
            section.style.transform = 'translateY(20px)';
            section.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(section);
        });
    </script>

    <script>
        let clickCount = 0;
        const logo = document.getElementById('logo');

        logo.addEventListener('click', () => {
            clickCount++;

            if (clickCount === 3) {
                window.location.href = '/login';
            }

            setTimeout(() => {
                clickCount = 0;
            }, 1000);
        });
    </script>
</body>

</html>
