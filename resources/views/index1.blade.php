<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tuangeun by Mimih - Rumah Makan Khas Sunda Autentik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            padding-bottom: 120px;
        }
        @media (min-width: 768px) {
            body { padding-bottom: 100px; }
        }
        html { scroll-behavior: smooth; }
        .hero-bg {
            background: linear-gradient(135deg, #d1e8e2 0%, #a7d7c5 50%, #81c3b0 100%);
        }
    </style>
</head>

<body class="antialiased text-gray-800 bg-gray-50">

    <!-- ================= NAVBAR ================= -->
    <nav class="fixed top-0 left-0 right-0 z-50 border-b border-gray-100 shadow-sm bg-white/90 backdrop-blur-lg">
        <div class="flex items-center justify-between px-6 py-4 mx-auto max-w-7xl md:px-12">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/Logo.jpg') }}" class="object-cover w-10 h-10 rounded-full shadow-md md:w-12 md:h-12" alt="Logo Tuangeun by Mimih">
                <h1 class="text-xl font-bold md:text-2xl text-emerald-700">Tuangeun by Mimih</h1>
            </div>

            <ul class="items-center hidden gap-8 font-medium text-gray-700 md:flex">
                <li><a href="#beranda" class="transition hover:text-emerald-600">Beranda</a></li>
                <li><a href="#menu" class="transition hover:text-emerald-600">Menu</a></li>
                <li><a href="#tentang" class="transition hover:text-emerald-600">Tentang</a></li>
                <li><a href="#tentang" class="transition hover:text-emerald-600">Kontak</a></li> <!-- Tetap ada, scroll ke section yang sama -->
                <li><a href="#lokasi" class="transition hover:text-emerald-600">Lokasi</a></li>
            </ul>

            <a href="{{ route('login') }}"
               class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2.5 rounded-full font-medium shadow-md hover:shadow-lg transition duration-300 transform hover:scale-105">
                Login
            </a>
        </div>
    </nav>

    <!-- ================= HERO (DITAMBAH TAGLINE) ================= -->
    <section id="beranda" class="relative min-h-screen pt-32 pb-20 overflow-hidden hero-bg md:pt-40">
        <div class="absolute inset-0 pointer-events-none opacity-10">
            <div class="absolute rounded-full -top-20 -right-20 w-96 h-96 bg-emerald-300 blur-3xl"></div>
            <div class="absolute rounded-full bottom-10 left-10 w-80 h-80 bg-amber-300 blur-3xl"></div>
        </div>

        <div class="relative z-10 grid items-center gap-12 px-6 mx-auto max-w-7xl md:grid-cols-2">
            <div>
                <p class="text-lg font-medium md:text-xl text-emerald-700">Hoyong Tuang??</p>
                <h1 class="mt-3 text-5xl font-extrabold leading-tight text-gray-900 md:text-6xl lg:text-7xl">
                    Tong Hilap!!
                </h1>
                <p class="mt-6 text-xl leading-relaxed text-gray-800 md:text-2xl">
                    Mampir ka rumah makan <br>
                    <span class="font-bold text-emerald-700">Tuangeun by Mimih</span> ayeuna keneh!
                </p>

                <!-- Tagline baru -->
                <p class="mt-8 text-2xl italic font-semibold md:text-3xl text-emerald-800">
                    "Cita Rasa Autentik Sunda, Harga Ramah Kantong, Bikin Kangen Rumah!"
                </p>

                <div class="flex flex-wrap gap-4 mt-10">
                    <a href="#menu" class="px-8 py-4 font-semibold text-white transition transform rounded-full shadow-lg bg-emerald-600 hover:bg-emerald-700 hover:scale-105">
                        Lihat Menu
                    </a>
                    <a href="#tentang" class="px-8 py-4 font-semibold transition bg-white border-2 rounded-full text-emerald-700 border-emerald-600 hover:bg-emerald-50">
                        Tentang & Kontak
                    </a>
                </div>
            </div>

            <div class="relative">
                <img src="{{ asset('images/Liwet.jpg') }}"
                     class="object-cover w-full max-w-lg mx-auto transition duration-500 transform shadow-2xl rounded-3xl rotate-3 hover:rotate-0"
                     alt="Nasi Liwet Khas Sunda">
                <img src="{{ asset('images/Logo.jpg') }}"
                     class="absolute object-cover w-48 border-8 border-white shadow-xl -bottom-12 -right-12 md:w-64 rounded-2xl"
                     alt="Logo">
            </div>
        </div>
    </section>

    <!-- ================= MENU (8 CARD DUMMY) ================= -->
    <section id="menu" class="py-20 bg-white md:py-28">
        <div class="px-6 mx-auto text-center max-w-7xl">
            <h2 class="mb-4 text-4xl font-bold md:text-5xl text-emerald-700">Menu Favorit</h2>
            <p class="max-w-2xl mx-auto mb-12 text-lg text-gray-600 md:text-xl">Pilihan hidangan khas Sunda autentik dengan cita rasa rumahan yang bikin kangen</p>

            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                <!-- 6 Makanan -->
                <div class="overflow-hidden transition-all duration-300 bg-white shadow-xl group rounded-3xl hover:shadow-2xl hover:-translate-y-2">
                    <img src="https://picsum.photos/id/29/600/400" class="object-cover w-full h-56" alt="Nasi Liwet">
                    <div class="p-6">
                        <span class="inline-block px-3 py-1 text-xs rounded-full bg-emerald-100 text-emerald-700">Makanan</span>
                        <h3 class="mt-3 text-xl font-semibold">Nasi Liwet</h3>
                        <p class="mt-1 text-2xl font-bold text-emerald-600">Rp 25.000</p>
                    </div>
                </div>

                <div class="overflow-hidden transition-all duration-300 bg-white shadow-xl group rounded-3xl hover:shadow-2xl hover:-translate-y-2">
                    <img src="https://picsum.photos/id/201/600/400" class="object-cover w-full h-56" alt="Ayam Goreng">
                    <div class="p-6">
                        <span class="inline-block px-3 py-1 text-xs rounded-full bg-emerald-100 text-emerald-700">Makanan</span>
                        <h3 class="mt-3 text-xl font-semibold">Ayam Goreng</h3>
                        <p class="mt-1 text-2xl font-bold text-emerald-600">Rp 18.000</p>
                    </div>
                </div>

                <div class="overflow-hidden transition-all duration-300 bg-white shadow-xl group rounded-3xl hover:shadow-2xl hover:-translate-y-2">
                    <img src="https://picsum.photos/id/318/600/400" class="object-cover w-full h-56" alt="Ikan Bakar">
                    <div class="p-6">
                        <span class="inline-block px-3 py-1 text-xs rounded-full bg-emerald-100 text-emerald-700">Makanan</span>
                        <h3 class="mt-3 text-xl font-semibold">Ikan Bakar</h3>
                        <p class="mt-1 text-2xl font-bold text-emerald-600">Rp 35.000</p>
                    </div>
                </div>

                <div class="overflow-hidden transition-all duration-300 bg-white shadow-xl group rounded-3xl hover:shadow-2xl hover:-translate-y-2">
                    <img src="https://picsum.photos/id/251/600/400" class="object-cover w-full h-56" alt="Sayur Asem">
                    <div class="p-6">
                        <span class="inline-block px-3 py-1 text-xs rounded-full bg-emerald-100 text-emerald-700">Makanan</span>
                        <h3 class="mt-3 text-xl font-semibold">Sayur Asem</h3>
                        <p class="mt-1 text-2xl font-bold text-emerald-600">Rp 12.000</p>
                    </div>
                </div>

                <div class="overflow-hidden transition-all duration-300 bg-white shadow-xl group rounded-3xl hover:shadow-2xl hover:-translate-y-2">
                    <img src="https://picsum.photos/id/292/600/400" class="object-cover w-full h-56" alt="Karedok">
                    <div class="p-6">
                        <span class="inline-block px-3 py-1 text-xs rounded-full bg-emerald-100 text-emerald-700">Makanan</span>
                        <h3 class="mt-3 text-xl font-semibold">Karedok</h3>
                        <p class="mt-1 text-2xl font-bold text-emerald-600">Rp 15.000</p>
                    </div>
                </div>

                <div class="overflow-hidden transition-all duration-300 bg-white shadow-xl group rounded-3xl hover:shadow-2xl hover:-translate-y-2">
                    <img src="https://picsum.photos/id/1015/600/400" class="object-cover w-full h-56" alt="Sate Maranggi">
                    <div class="p-6">
                        <span class="inline-block px-3 py-1 text-xs rounded-full bg-emerald-100 text-emerald-700">Makanan</span>
                        <h3 class="mt-3 text-xl font-semibold">Sate Maranggi</h3>
                        <p class="mt-1 text-2xl font-bold text-emerald-600">Rp 22.000</p>
                    </div>
                </div>

                <!-- 2 Minuman -->
                <div class="overflow-hidden transition-all duration-300 bg-white shadow-xl group rounded-3xl hover:shadow-2xl hover:-translate-y-2">
                    <img src="https://picsum.photos/id/106/600/400" class="object-cover w-full h-56" alt="Es Teh Manis">
                    <div class="p-6">
                        <span class="inline-block px-3 py-1 text-xs rounded-full bg-amber-100 text-amber-700">Minuman</span>
                        <h3 class="mt-3 text-xl font-semibold">Es Teh Manis</h3>
                        <p class="mt-1 text-2xl font-bold text-emerald-600">Rp 8.000</p>
                    </div>
                </div>

                <div class="overflow-hidden transition-all duration-300 bg-white shadow-xl group rounded-3xl hover:shadow-2xl hover:-translate-y-2">
                    <img src="https://picsum.photos/id/160/600/400" class="object-cover w-full h-56" alt="Wedang Jahe">
                    <div class="p-6">
                        <span class="inline-block px-3 py-1 text-xs rounded-full bg-amber-100 text-amber-700">Minuman</span>
                        <h3 class="mt-3 text-xl font-semibold">Wedang Jahe</h3>
                        <p class="mt-1 text-2xl font-bold text-emerald-600">Rp 10.000</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= TENTANG + KONTAK (Tentang Kiri, Kontak Kanan) ================= -->
    <section id="tentang" class="py-20 md:py-28 bg-gradient-to-br from-emerald-50 to-teal-50">
        <div class="px-6 mx-auto max-w-7xl">
            <h2 class="mb-12 text-4xl font-bold text-center md:text-5xl text-emerald-700">Tentang Kami & Kontak</h2>

            <div class="grid items-start gap-12 md:grid-cols-2">
                <!-- Kiri: Tentang Kami -->
                <div class="space-y-8">
                    <div class="relative">
                        <img src="{{ asset('images/Liwet.jpg') }}"
                             class="object-cover w-full shadow-2xl rounded-3xl"
                             alt="Suasana Rumah Makan">
                        <div class="absolute -bottom-6 -right-6 bg-white rounded-2xl shadow-xl p-6 max-w-[220px]">
                            <p class="text-sm font-medium text-emerald-600">Sejak 2022</p>
                            <p class="text-4xl font-bold text-emerald-700">100K+</p>
                            <p class="text-gray-600">Pelanggan Puas</p>
                        </div>
                    </div>

                    <p class="text-lg leading-relaxed text-gray-700 md:text-xl">
                        Tuangeun by Mimih adalah rumah makan khas Sunda yang menyajikan hidangan autentik dengan suasana nyaman dan harga terjangkau.
                        Berawal dari produk makanan ringan di Instagram, kini kami bangga menyajikan cita rasa asli Sunda untuk keluarga Anda.
                    </p>

                    <div class="grid grid-cols-2 gap-6">
                        <div class="p-6 bg-white shadow rounded-2xl">
                            <span class="text-3xl">🍲</span>
                            <h4 class="mt-3 font-semibold">Bahan Segar</h4>
                            <p class="text-sm text-gray-600">Setiap hari bahan pilihan langsung dari petani lokal</p>
                        </div>
                        <div class="p-6 bg-white shadow rounded-2xl">
                            <span class="text-3xl">🏠</span>
                            <h4 class="mt-3 font-semibold">Suasana Rumah</h4>
                            <p class="text-sm text-gray-600">Makan seperti di rumah sendiri, ramah & hangat</p>
                        </div>
                    </div>
                </div>

                <!-- Kanan: Kontak Elegan -->
                <div class="p-10 bg-white border shadow-2xl rounded-3xl border-emerald-100">
                    <h3 class="mb-8 text-3xl font-semibold text-center text-emerald-700">Hubungi Kami</h3>
                    <div class="space-y-8 text-lg">
                        <div class="flex items-center gap-5">
                            <span class="text-5xl">📍</span>
                            <p class="font-medium text-gray-800">Subang, Jawa Barat</p>
                        </div>
                        <div class="flex items-center gap-5">
                            <span class="text-5xl">📞</span>
                            <p class="font-medium text-gray-800">0812-3456-7890</p>
                        </div>
                        <div class="flex items-center gap-5">
                            <span class="text-5xl">📸</span>
                            <a href="https://instagram.com/tuangeun_by_mimih" target="_blank" class="font-medium text-emerald-600 hover:underline">@tuangeun_by_mimih</a>
                        </div>
                        <div class="flex items-center gap-5">
                            <span class="text-5xl">📧</span>
                            <a href="mailto:tuangeunbymimih@gmail.com" class="font-medium text-emerald-600 hover:underline">tuangeunbymimih@gmail.com</a>
                        </div>
                    </div>

                    <a href="https://wa.me/6281234567890" target="_blank"
                       class="block py-4 mt-10 font-semibold text-center text-white transition transform bg-green-500 shadow-lg hover:bg-green-600 rounded-2xl hover:scale-105">
                        Chat WhatsApp Sekarang
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= LOKASI ================= -->
    <section id="lokasi" class="py-20 bg-white md:py-28">
        <div class="px-6 mx-auto max-w-7xl">
            <h2 class="mb-12 text-4xl font-bold text-center md:text-5xl text-emerald-700">Lokasi Kami</h2>

            <div class="grid items-start gap-8 lg:grid-cols-12">
                <div class="overflow-hidden border border-gray-100 shadow-2xl lg:col-span-7 rounded-3xl">
                    <iframe
                        class="w-full h-[520px]"
                        loading="lazy"
                        allowfullscreen
                        referrerpolicy="no-referrer-when-downgrade"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15839.000000000000!2d107.75000000000000!3d-6.56670000000000!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e691e353e7c1d0d%3A0x0!2sSubang%2C%20Jawa%20Barat!5e0!3m2!1sid!2sid!4v1730000000000!5m2!1sid!2sid">
                    </iframe>
                </div>

                <div class="space-y-6 lg:col-span-5">
                    <div class="p-8 bg-white border shadow-xl rounded-3xl border-emerald-100">
                        <h3 class="flex items-center gap-3 mb-4 text-2xl font-semibold text-emerald-700">
                            📍 Alamat Lengkap
                        </h3>
                        <p class="leading-relaxed text-gray-700">
                            Jl. Raya Subang No. 45, Kec. Subang, Kabupaten Subang, Jawa Barat 41211<br>
                            <span class="text-xs text-emerald-500">(Depan Pasar Tradisional Subang)</span>
                        </p>
                    </div>

                    <div class="p-8 bg-white border shadow-xl rounded-3xl border-emerald-100">
                        <h3 class="flex items-center gap-3 mb-4 text-2xl font-semibold text-emerald-700">
                            ⏰ Jam Operasional
                        </h3>
                        <div class="space-y-3 text-gray-700">
                            <div class="flex justify-between">
                                <span>Senin - Sabtu</span>
                                <span class="font-medium">08.00 - 21.00 WIB</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Minggu & Hari Libur</span>
                                <span class="font-medium">07.30 - 22.00 WIB</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= FOOTER FIXED ================= -->
    <footer class="fixed bottom-0 left-0 right-0 z-40 py-5 text-white shadow-2xl bg-emerald-800">
        <div class="flex flex-col items-center justify-between gap-4 px-6 mx-auto text-center max-w-7xl md:flex-row md:text-left">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/Logo.jpg') }}" class="object-cover w-10 h-10 rounded-full" alt="Logo">
                <p class="text-lg font-medium">Tuangeun by Mimih</p>
            </div>
            <p class="text-sm md:text-base">&copy; {{ date('Y') }} All rights reserved. Makan kenyang, hati senang!</p>
            <div class="flex gap-6">
                <a href="#tentang" class="transition hover:text-emerald-300">Tentang & Kontak</a>
                <a href="#lokasi" class="transition hover:text-emerald-300">Lokasi</a>
                <a href="https://instagram.com/tuangeun_by_mimih" target="_blank" class="transition hover:text-emerald-300">Instagram</a>
            </div>
        </div>
    </footer>

</body>
</html>
