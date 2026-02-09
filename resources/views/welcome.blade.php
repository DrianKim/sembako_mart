<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sembamok Mart - Toko Sembamok Terpercaya di Kota Anda</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo_toko_sembako.png') }}">
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
            background: linear-gradient(90deg, #EB661B 0%, #22C55E 20%, #10B981 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #22C55E 0%, #10B981 100%);
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

<body class="font-sans bg-white">
    <!-- Navigation Bar -->
    <nav class="fixed z-50 w-full shadow-md bg-white/95 backdrop-blur-sm">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <img id="logo" src="{{ asset('img/logo_toko_sembako.png') }}" alt="Logo Sembako Mart"
                        class="cursor-pointer h-14 w-14">
                    <div>
                        <h1 class="text-2xl font-bold">
                            <span style="color: #EB661B;">S</span><span class="gradient-text">embako Mart</span>
                        </h1>
                        <p class="text-xs text-gray-600">Kebutuhan Sehari-hari Lengkap</p>
                    </div>
                </div>
                <!-- Desktop Menu -->
                <div class="items-center hidden space-x-8 md:flex">
                    <a href="#beranda" class="font-semibold text-gray-700 transition hover:text-green-500">Beranda</a>
                    <a href="#tentang" class="font-semibold text-gray-700 transition hover:text-green-500">Tentang
                        Kami</a>
                    <a href="#produk" class="font-semibold text-gray-700 transition hover:text-green-500">Produk</a>
                    <a href="#lokasi" class="font-semibold text-gray-700 transition hover:text-green-500">Lokasi</a>
                    <a href="https://wa.me/6285143266694?text=Halo,%20saya%20ingin%20membeli%20*Sesuatu*%0AApakah%20stok%20tersedia?"
                        target="_blank"
                        class="bg-gradient-to-r from-[#22C55E] to-[#10B981] text-white px-6 py-2.5 rounded-full font-semibold hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                        Hubungi Kami
                    </a>
                </div>
                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" class="text-gray-700 md:hidden hover:text-green-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden bg-white border-t md:hidden">
            <div class="px-4 pt-2 pb-4 space-y-2">
                <a href="#beranda" class="block py-2 font-semibold text-gray-700 hover:text-green-500">Beranda</a>
                <a href="#tentang" class="block py-2 font-semibold text-gray-700 hover:text-green-500">Tentang Kami</a>
                <a href="#produk" class="block py-2 font-semibold text-gray-700 hover:text-green-500">Produk</a>
                <a href="#lokasi" class="block py-2 font-semibold text-gray-700 hover:text-green-500">Lokasi</a>
            </div>
        </div>
    </nav>
    <!-- Hero Section -->
    <section id="beranda" class="pt-32 pb-20 bg-gradient-to-br from-green-50 via-white to-green-50">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid items-center gap-12 md:grid-cols-2">
                <!-- Left Content -->
                <div class="animate-fade-in-up">
                    <div class="inline-block px-4 py-2 mb-4 rounded-full bg-gradient-to-r from-green-100 to-green-100">
                        <span class="text-sm font-semibold text-green-700">🎉 Buka Setiap Hari</span>
                    </div>
                    <h1 class="mb-6 text-5xl font-bold leading-tight text-gray-800 md:text-6xl">
                        Belanja <span style="color: #EB661B;">S</span><span class="gradient-text">embako</span> Lengkap
                        & Terpercaya!
                    </h1>
                    <p class="mb-8 text-xl leading-relaxed text-gray-600">
                        Dapatkan kebutuhan sembako harian Anda dengan harga terjangkau dan kualitas terjamin. Kami
                        melayani dengan sepenuh hati!
                    </p>
                    <!-- Features -->
                    <div class="grid grid-cols-2 gap-4 mb-8">
                        <div class="flex items-center space-x-3">
                            <div
                                class="flex items-center justify-center flex-shrink-0 w-10 h-10 bg-orange-100 rounded-full">
                                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span class="font-semibold text-gray-700">Harga Terjangkau</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div
                                class="flex items-center justify-center flex-shrink-0 w-10 h-10 bg-green-100 rounded-full">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span class="font-semibold text-gray-700">Produk Lengkap</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div
                                class="flex items-center justify-center flex-shrink-0 w-10 h-10 bg-orange-100 rounded-full">
                                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span class="font-semibold text-gray-700">Kualitas Terjamin</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div
                                class="flex items-center justify-center flex-shrink-0 w-10 h-10 bg-green-100 rounded-full">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span class="font-semibold text-gray-700">Lokasi Strategis</span>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-4">
                        <a href="#produk"
                            class="bg-gradient-to-r from-[#22C55E] to-[#10B981] hover:from-[#16A34A] hover:to-[#059669] text-white px-8 py-4 rounded-lg font-bold text-lg shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-200">
                            Lihat Produk
                        </a>
                        <a href="#lokasi"
                            class="px-8 py-4 text-lg font-bold text-green-600 transition-all duration-200 transform bg-white border-2 border-green-500 rounded-lg hover:bg-green-50 hover:-translate-y-1">
                            Kunjungi Toko
                        </a>
                    </div>
                </div>
                <!-- Right Image -->
                <div class="relative">
                    <div class="absolute bg-green-200 rounded-full -top-4 -right-4 w-72 h-72 opacity-20 blur-3xl">
                    </div>
                    <div class="absolute bg-orange-200 rounded-full -bottom-4 -left-4 w-72 h-72 opacity-20 blur-3xl">
                    </div>
                    <img src="{{ asset('img/fotologin.png') }}" alt="Shopping"
                        class="relative z-10 w-full h-auto animate-float drop-shadow-2xl">
                </div>
            </div>
        </div>
    </section>
    <!-- About Section -->
    <section id="tentang" class="py-20 bg-white">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mb-16 text-center">
                <h2 class="mb-4 text-4xl font-bold text-gray-800 md:text-5xl">
                    Tentang Sembako Mart
                    {{-- <span class="gradient-text"></span> --}}
                </h2>
                <p class="max-w-3xl mx-auto text-xl text-gray-600">
                    Toko sembamok terpercaya yang telah melayani kebutuhan masyarakat dengan dedikasi tinggi
                </p>
            </div>
            <div class="grid gap-8 md:grid-cols-3">
                <!-- Value 1 -->
                <div
                    class="p-8 transition-all duration-300 transform border-2 border-green-100 bg-gradient-to-br from-green-50 to-white rounded-2xl hover:shadow-xl hover:-translate-y-2">
                    <div
                        class="w-16 h-16 bg-gradient-to-r from-[#22C55E] to-[#10B981] rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="mb-3 text-2xl font-bold text-gray-800">Buka Setiap Hari</h3>
                    <p class="leading-relaxed text-gray-600">
                        Kami buka setiap hari untuk melayani kebutuhan sembako Anda. Senin - Minggu, pagi hingga malam.
                    </p>
                </div>
                <!-- Value 2 -->
                <div
                    class="p-8 transition-all duration-300 transform border-2 border-orange-100 bg-gradient-to-br from-orange-50 to-white rounded-2xl hover:shadow-xl hover:-translate-y-2">
                    <div
                        class="w-16 h-16 bg-gradient-to-r from-[#FB923C] to-[#F97316] rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </div>
                    <h3 class="mb-3 text-2xl font-bold text-gray-800">Produk Berkualitas</h3>
                    <p class="leading-relaxed text-gray-600">
                        Semua produk yang kami jual adalah produk pilihan dengan kualitas terjamin dan harga bersaing.
                    </p>
                </div>
                <!-- Value 3 -->
                <div
                    class="p-8 transition-all duration-300 transform border-2 border-green-100 bg-gradient-to-br from-green-50 to-white rounded-2xl hover:shadow-xl hover:-translate-y-2">
                    <div
                        class="w-16 h-16 bg-gradient-to-r from-[#22C55E] to-[#10B981] rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="mb-3 text-2xl font-bold text-gray-800">Pelayanan Ramah</h3>
                    <p class="leading-relaxed text-gray-600">
                        Tim kami siap melayani Anda dengan ramah dan membantu menemukan produk yang Anda butuhkan.
                    </p>
                </div>
            </div>
            <!-- Stats -->
            <div class="grid gap-8 mt-16 md:grid-cols-4">
                <div class="text-center">
                    <div class="mb-2 text-5xl font-bold gradient-text">5+</div>
                    <div class="font-semibold text-gray-600">Tahun Beroperasi</div>
                </div>
                <div class="text-center">
                    <div class="mb-2 text-5xl font-bold gradient-text">500+</div>
                    <div class="font-semibold text-gray-600">Produk Tersedia</div>
                </div>
                <div class="text-center">
                    <div class="mb-2 text-5xl font-bold gradient-text">1000+</div>
                    <div class="font-semibold text-gray-600">Pelanggan Setia</div>
                </div>
                <div class="text-center">
                    <div class="mb-2 text-5xl font-bold gradient-text">100%</div>
                    <div class="font-semibold text-gray-600">Kepuasan</div>
                </div>
            </div>
        </div>
    </section>
    <!-- Products Section -->
    <section id="produk" class="py-20 bg-gradient-to-br from-green-50 via-white to-green-50">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mb-16 text-center">
                <h2 class="mb-4 text-4xl font-bold text-gray-800 md:text-5xl">
                    Produk Kami
                    {{-- <span class="gradient-text"></span> --}}
                </h2>
                <p class="max-w-2xl mx-auto text-xl text-gray-600">
                    Berbagai macam kebutuhan sembako berkualitas dengan harga terjangkau
                </p>
            </div>
            <!-- Product Categories -->
            <div class="grid gap-6 mb-12 md:grid-cols-4">

                <!-- 1. Beras Premium -->
                <div
                    class="overflow-hidden transition-all duration-300 transform bg-white shadow-lg product-card rounded-2xl hover:shadow-2xl hover:-translate-y-2">
                    <div class="relative flex items-center justify-center h-48">
                        <img src="{{ asset('img/beras_premium.jpg') }}" alt="Beras Premium"
                            class="object-cover w-full h-full rounded-t-2xl">
                        <div
                            class="absolute px-3 py-1 rounded-full shadow-md top-3 right-3 bg-green-700/90 backdrop-blur-sm">
                            <span class="text-xs font-semibold text-white">Stok Tersedia</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="mb-2 text-xl font-bold text-gray-800">Beras Premium</h3>
                        <p class="mb-4 text-sm text-gray-600">Berbagai merk beras pilihan berkualitas</p>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-lg font-bold text-green-600">Mulai Rp 50.000</span>
                        </div>
                        <a href="https://wa.me/6285143266694?text=Halo,%20saya%20ingin%20membeli%20*Beras%20Premium*%0AApakah%20stok%20tersedia?"
                            target="_blank"
                            class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-3 px-4 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                            </svg>
                            Order Sekarang
                        </a>
                    </div>
                </div>

                <!-- 2. Minyak Goreng -->
                <div
                    class="overflow-hidden transition-all duration-300 transform bg-white shadow-lg product-card rounded-2xl hover:shadow-2xl hover:-translate-y-2">
                    <div class="relative flex items-center justify-center h-48">
                        <img src="{{ asset('img/minyak_goreng.jpg') }}" alt="Minyak Goreng"
                            class="object-cover w-full h-full rounded-t-2xl">
                        <div
                            class="absolute px-3 py-1 rounded-full shadow-md top-3 right-3 bg-green-700/90 backdrop-blur-sm">
                            <span class="text-xs font-semibold text-white">Stok Tersedia</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="mb-2 text-xl font-bold text-gray-800">Minyak Goreng</h3>
                        <p class="mb-4 text-sm text-gray-600">Minyak goreng berkualitas untuk masak</p>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-lg font-bold text-green-600">Mulai Rp 15.000</span>
                        </div>
                        <a href="https://wa.me/6285143266694?text=Halo,%20saya%20ingin%20membeli%20*Minyak%20Goreng*%0AApakah%20stok%20tersedia?"
                            target="_blank"
                            class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-3 px-4 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                            </svg>
                            Order Sekarang
                        </a>
                    </div>
                </div>

                <!-- 3. Bumbu Dapur -->
                <div
                    class="overflow-hidden transition-all duration-300 transform bg-white shadow-lg product-card rounded-2xl hover:shadow-2xl hover:-translate-y-2">
                    <div class="relative flex items-center justify-center h-48">
                        <img src="{{ asset('img/bumbu_dapur.jpg') }}" alt="Bumbu Dapur"
                            class="object-cover w-full h-full rounded-t-2xl">
                        <div
                            class="absolute px-3 py-1 rounded-full shadow-md top-3 right-3 bg-green-700/90 backdrop-blur-sm">
                            <span class="text-xs font-semibold text-white">Stok Tersedia</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="mb-2 text-xl font-bold text-gray-800">Bumbu Dapur</h3>
                        <p class="mb-4 text-sm text-gray-600">Lengkapi dapur dengan bumbu pilihan</p>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-lg font-bold text-green-600">Mulai Rp 5.000</span>
                        </div>
                        <a href="https://wa.me/6285143266694?text=Halo,%20saya%20ingin%20membeli%20*Bumbu%20Dapur*%0AApakah%20stok%20tersedia?"
                            target="_blank"
                            class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-3 px-4 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                            </svg>
                            Order Sekarang
                        </a>
                    </div>
                </div>

                <!-- 4. Makanan Instan -->
                <div
                    class="overflow-hidden transition-all duration-300 transform bg-white shadow-lg product-card rounded-2xl hover:shadow-2xl hover:-translate-y-2">
                    <div class="relative flex items-center justify-center h-48">
                        <img src="{{ asset('img/makanan_instan.jpg') }}" alt="Makanan Instan"
                            class="object-cover w-full h-full rounded-t-2xl">
                        <div
                            class="absolute px-3 py-1 rounded-full shadow-md top-3 right-3 bg-green-700/90 backdrop-blur-sm">
                            <span class="text-xs font-semibold text-white">Stok Tersedia</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="mb-2 text-xl font-bold text-gray-800">Makanan Instan</h3>
                        <p class="mb-4 text-sm text-gray-600">Mie instan dan makanan siap saji</p>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-lg font-bold text-green-600">Mulai Rp 2.500</span>
                        </div>
                        <a href="https://wa.me/6285143266694?text=Halo,%20saya%20ingin%20membeli%20*Makanan%20Instan*%0AApakah%20stok%20tersedia?"
                            target="_blank"
                            class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-3 px-4 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                            </svg>
                            Order Sekarang
                        </a>
                    </div>
                </div>

                <!-- 5. Gula & Kopi -->
                <div
                    class="overflow-hidden transition-all duration-300 transform bg-white shadow-lg product-card rounded-2xl hover:shadow-2xl hover:-translate-y-2">
                    <div class="relative flex items-center justify-center h-48">
                        <img src="{{ asset('img/gula_kopi.jpg') }}" alt="Gula & Kopi"
                            class="object-cover w-full h-full rounded-t-2xl">
                        <div
                            class="absolute px-3 py-1 rounded-full shadow-md top-3 right-3 bg-green-700/90 backdrop-blur-sm">
                            <span class="text-xs font-semibold text-white">Stok Tersedia</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="mb-2 text-xl font-bold text-gray-800">Gula & Kopi</h3>
                        <p class="mb-4 text-sm text-gray-600">Gula pasir, gula merah, kopi sachet</p>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-lg font-bold text-green-600">Mulai Rp 10.000</span>
                        </div>
                        <a href="https://wa.me/6285143266694?text=Halo,%20saya%20ingin%20membeli%20*Gula%20%26%20Kopi*%0AApakah%20stok%20tersedia?"
                            target="_blank"
                            class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-3 px-4 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                            </svg>
                            Order Sekarang
                        </a>
                    </div>
                </div>

                <!-- 6. Sabun & Detergen -->
                <div
                    class="overflow-hidden transition-all duration-300 transform bg-white shadow-lg product-card rounded-2xl hover:shadow-2xl hover:-translate-y-2">
                    <div class="relative flex items-center justify-center h-48">
                        <img src="{{ asset('img/sabun_detergen.jpg') }}" alt="Sabun & Detergen"
                            class="object-cover w-full h-full rounded-t-2xl">
                        <div
                            class="absolute px-3 py-1 rounded-full shadow-md top-3 right-3 bg-green-700/90 backdrop-blur-sm">
                            <span class="text-xs font-semibold text-white">Stok Tersedia</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="mb-2 text-xl font-bold text-gray-800">Sabun & Detergen</h3>
                        <p class="mb-4 text-sm text-gray-600">Kebutuhan mandi dan cuci pakaian</p>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-lg font-bold text-green-600">Mulai Rp 3.000</span>
                        </div>
                        <a href="https://wa.me/6285143266694?text=Halo,%20saya%20ingin%20membeli%20*Sabun%20%26%20Detergen*%0AApakah%20stok%20tersedia?"
                            target="_blank"
                            class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-3 px-4 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                            </svg>
                            Order Sekarang
                        </a>
                    </div>
                </div>

                <!-- 7. Telur & Susu -->
                <div
                    class="overflow-hidden transition-all duration-300 transform bg-white shadow-lg product-card rounded-2xl hover:shadow-2xl hover:-translate-y-2">
                    <div class="relative flex items-center justify-center h-48">
                        <img src="{{ asset('img/susu_telur.jpg') }}" alt="Telur & Susu"
                            class="object-cover w-full h-full rounded-t-2xl">
                        <div
                            class="absolute px-3 py-1 rounded-full shadow-md top-3 right-3 bg-green-700/90 backdrop-blur-sm">
                            <span class="text-xs font-semibold text-white">Stok Tersedia</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="mb-2 text-xl font-bold text-gray-800">Telur & Susu</h3>
                        <p class="mb-4 text-sm text-gray-600">Telur ayam segar dan susu kotak</p>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-lg font-bold text-green-600">Mulai Rp 25.000</span>
                        </div>
                        <a href="https://wa.me/6285143266694?text=Halo,%20saya%20ingin%20membeli%20*Telur%20%26%20Susu*%0AApakah%20stok%20tersedia?"
                            target="_blank"
                            class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-3 px-4 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                            </svg>
                            Order Sekarang
                        </a>
                    </div>
                </div>

                <!-- 8. Snack & Minuman -->
                <div
                    class="overflow-hidden transition-all duration-300 transform bg-white shadow-lg product-card rounded-2xl hover:shadow-2xl hover:-translate-y-2">
                    <div class="relative flex items-center justify-center h-48">
                        <img src="{{ asset('img/snack_minuman.jpg') }}" alt="Snack & Minuman"
                            class="object-cover w-full h-full rounded-t-2xl">
                        <div
                            class="absolute px-3 py-1 rounded-full shadow-md top-3 right-3 bg-green-700/90 backdrop-blur-sm">
                            <span class="text-xs font-semibold text-white">Stok Tersedia</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="mb-2 text-xl font-bold text-gray-800">Snack & Minuman</h3>
                        <p class="mb-4 text-sm text-gray-600">Cemilan dan minuman dingin segar</p>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-lg font-bold text-green-600">Mulai Rp 1.000</span>
                        </div>
                        <a href="https://wa.me/6285143266694?text=Halo,%20saya%20ingin%20membeli%20*Snack%20%26%20Minuman*%0AApakah%20stok%20tersedia?"
                            target="_blank"
                            class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-3 px-4 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                            </svg>
                            Order Sekarang
                        </a>
                    </div>
                </div>
            </div>
            <!-- Product Note -->
            <div class="p-8 bg-white border-2 border-green-100 shadow-lg rounded-2xl">
                <div class="flex items-start space-x-4">
                    <div
                        class="w-12 h-12 bg-gradient-to-r from-[#22C55E] to-[#10B981] rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0  118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="mb-2 text-xl font-bold text-gray-800">Catatan Penting</h3>
                        <p class="leading-relaxed text-gray-600">
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
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mb-16 text-center">
                <h2 class="mb-4 text-4xl font-bold text-gray-800 md:text-5xl">
                    Lokasi Toko
                    {{-- <span class="gradient-text"></span> --}}
                </h2>
                <p class="max-w-2xl mx-auto text-xl text-gray-600">
                    Temukan kami di lokasi yang strategis dan mudah dijangkau
                </p>
            </div>
            <div class="grid gap-12 md:grid-cols-2">
                <!-- Map -->
                <div class="overflow-hidden shadow-xl rounded-2xl">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d700.6873417953105!2d107.77299258192721!3d-6.56124109264776!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e693b7aeba2cdd7%3A0x6592eba2241aae3b!2sGg.%20A.%20Ipeng%2044%2C%20Karanganyar%2C%20Kec.%20Subang%2C%20Kabupaten%20Subang%2C%20Jawa%20Barat%2041211!5e0!3m2!1sid!2sid!4v1770466474492!5m2!1sid!2sid"
                        width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        class="transition duration-300 grayscale hover:grayscale-0">
                    </iframe>
                </div>
                <!-- Store Info -->
                <div class="space-y-6">
                    <!-- Address -->
                    <div
                        class="p-6 transition-all duration-300 border-2 border-green-100 bg-gradient-to-br from-green-50 to-white rounded-2xl hover:shadow-lg">
                        <div class="flex items-start space-x-4">
                            <div
                                class="w-12 h-12 bg-gradient-to-r from-[#22C55E] to-[#10B981] rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="mb-2 text-lg font-bold text-gray-800">Alamat Lengkap</h3>
                                <p class="leading-relaxed text-gray-600">
                                    Gg. A. Ipeng 44 <br>
                                    Karanganyar, Kec. Subang, Kabupaten Subang <br>
                                    Jawa Barat 41211
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- Opening Hours -->
                    <div
                        class="p-6 transition-all duration-300 border-2 border-orange-100 bg-gradient-to-br from-orange-50 to-white rounded-2xl hover:shadow-lg">
                        <div class="flex items-start space-x-4">
                            <div
                                class="w-12 h-12 bg-gradient-to-r from-[#FB923C] to-[#F97316] rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="mb-2 text-lg font-bold text-gray-800">Jam Operasional</h3>
                                <div class="space-y-1 text-gray-600">
                                    <p><span class="font-semibold">Senin - Sabtu:</span> 07.00 - 21.00 WIB</p>
                                    <p><span class="font-semibold">Minggu:</span> 08.00 - 20.00 WIB</p>
                                    <p class="mt-2 font-semibold text-green-600">✓ Buka Setiap Hari</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Contact Info -->
                    {{-- <div
                        class="p-6 transition-all duration-300 border-2 border-green-100 bg-gradient-to-br from-green-50 to-white rounded-2xl hover:shadow-lg">
                        <div class="flex items-start space-x-4">
                            <div
                                class="w-12 h-12 bg-gradient-to-r from-[#22C55E] to-[#10B981] rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="mb-2 text-lg font-bold text-gray-800">Hubungi Kami</h3>
                                <div class="space-y-1 text-gray-600">
                                    <p><span class="font-semibold">Telepon:</span> (021) 1234-5678</p>
                                    <p><span class="font-semibold">WhatsApp:</span> +62 812-3456-7890</p>
                                    <p><span class="font-semibold">Email:</span> info@sembakomart.com</p>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <!-- Direction Button -->
                    <a href="https://maps.google.com" target="_blank"
                        class="block w-full bg-gradient-to-r from-[#22C55E] to-[#10B981] hover:from-[#16A34A] hover:to-[#059669] text-white font-bold py-4 rounded-lg shadow-lg hover:shadow-xl text-center transform hover:-translate-y-1 transition-all duration-200">
                        📍 Buka di Google Maps
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer -->
    <footer class="py-12 text-white bg-gray-900">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid gap-8 mb-8 md:grid-cols-4">
                <!-- About -->
                <div>
                    <div class="flex items-center mb-4 space-x-2">
                        <img src="{{ asset('img/logo_toko_sembako.png') }}" alt="Logo" class="w-10 h-10">
                        <span class="text-xl font-bold">Sembako Mart</span>
                    </div>
                    <p class="text-sm leading-relaxed text-gray-400">
                        Toko sembako terpercaya yang melayani kebutuhan sehari-hari Anda dengan harga terjangkau dan
                        kualitas terjamin.
                    </p>
                </div>
                <!-- Quick Links -->
                <div>
                    <h4 class="mb-4 text-lg font-bold">Menu</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#beranda" class="transition hover:text-green-400">Beranda</a></li>
                        <li><a href="#tentang" class="transition hover:text-green-400">Tentang Kami</a></li>
                        <li><a href="#produk" class="transition hover:text-green-400">Produk</a></li>
                        <li><a href="#lokasi" class="transition hover:text-green-400">Lokasi</a></li>
                    </ul>
                </div>
                <!-- Products -->
                <div>
                    <h4 class="mb-4 text-lg font-bold">Produk Kami</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li>Beras & Minyak Goreng</li>
                        <li>Bumbu Dapur</li>
                        <li>Makanan Instan</li>
                        <li>Sabun & Detergen</li>
                        <li>Snack & Minuman</li>
                    </ul>
                </div>
                <!-- Contact -->
                <div>
                    <h4 class="mb-4 text-lg font-bold">Hubungi Kami</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li>📍 Gg. A. Ipeng 44<br>Subang</li>
                        {{-- <li>📞 (021) 1234-5678</li> --}}
                        <li>📱 +62 851-4326-6694</li>
                        <li>✉️ info@sembakomart.com</li>
                    </ul>
                </div>
            </div>
            <!-- Bottom Footer -->
            <div class="pt-8 border-t border-gray-800">
                <div class="flex flex-col items-center justify-between md:flex-row">
                    <p class="mb-4 text-sm text-gray-400 md:mb-0">
                        © 2026 Sembako Mart. Made with <span class="text-red-500">❤</span> by <span
                            class="font-semibold">𝓟</span>
                    </p>
                    <!-- Social Media -->
                    <div class="flex space-x-4">
                        <a href="https://www.facebook.com/muhamad.enza.3" target="_blank"
                            class="w-10 h-10 bg-gradient-to-r from-[#22C55E] to-[#10B981] rounded-full flex items-center justify-center hover:opacity-80 transition">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                        </a>
                        <a href="https://www.instagram.com/inkspirationpress" target="_blank"
                            class="w-10 h-10 bg-gradient-to-r from-[#FB923C] to-[#F97316] rounded-full flex items-center justify-center hover:opacity-80 transition">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073z" />
                                <path
                                    d="M12 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zm0 10.162a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
                            </svg>
                        </a>
                        <a href="https://wa.me/6285143266694?text=Halo,%20saya%20ingin%20membeli%20*Sesuatu*%0AApakah%20stok%20tersedia?"
                            target="_blank"
                            class="w-10 h-10 bg-gradient-to-r from-[#22C55E] to-[#10B981] rounded-full flex items-center justify-center hover:opacity-80 transition">
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
                fetch('/allow-login', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        },
                    })
                    .then(response => {
                        if (response.ok) {
                            window.location.href = '/login';
                        }
                    })
                    .catch(err => console.error(err));

                clickCount = 0;
            }

            setTimeout(() => {
                clickCount = 0;
            }, 1200);
        });
    </script>
</body>

</html>
