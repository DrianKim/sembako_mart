@extends('kasir.layouts.app')
@section('title', 'Transaksi Baru')
@section('page-description', 'Input transaksi penjualan baru di kasir')

@section('content')
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <!-- Kiri: Daftar Produk -->
        <div class="lg:col-span-2">
            <div class="flex flex-col gap-4 mb-6 sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-xl font-bold text-gray-800">Pilih Produk</h2>

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                    <!-- Search -->
                    <div class="relative w-full sm:w-64">
                        <input type="text" id="searchProduk" placeholder="Cari nama atau barcode..."
                            class="w-full px-4 py-2.5 pl-10 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                        <i class="absolute text-gray-400 -translate-y-1/2 left-3 top-1/2 fas fa-search"></i>
                    </div>

                    <!-- Filter Stok -->
                    <select id="filterStok"
                        class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent sm:w-48">
                        <option value="semua">Semua Stok</option>
                        <option value="tersedia">Stok Tersedia</option>
                        <option value="sedikit">Stok Sedikit (< 10)</option>
                        <option value="habis">Stok Habis</option>
                    </select>
                </div>
            </div>

            <!-- Grid Card Produk (20 dummy) -->
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5" id="produkList">
                <!-- 1 -->
                <div class="overflow-hidden transition-all bg-white border border-gray-200 rounded-lg shadow-sm cursor-pointer card-hover group stok-tersedia"
                    data-produk-id="1" data-nama="Beras Pandan Premium 5kg" data-harga="78000" data-satuan="kg"
                    data-barcode="BRP-001" data-stok="45">
                    <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=400" alt="Beras"
                        class="object-cover w-full transition-transform duration-300 h-44 group-hover:scale-105">
                    <div class="p-4">
                        <h4
                            class="text-sm font-semibold text-gray-800 transition-colors line-clamp-2 group-hover:text-green-700">
                            Beras Pandan Premium 5kg</h4>
                        <p class="mt-1 text-xs text-gray-600">BRP-001</p>
                        <p class="mt-1 text-xs font-medium">Stok: <span class="font-bold text-green-600">45 kg</span></p>
                        <p class="mt-2 font-bold text-green-600">Rp 78.000 / kg</p>
                    </div>
                </div>

                <!-- 2 -->
                <div class="overflow-hidden transition-all bg-white border border-gray-200 rounded-lg shadow-sm cursor-pointer card-hover group stok-sedikit"
                    data-produk-id="2" data-nama="Minyak Goreng Sania 2L" data-harga="42500" data-satuan="liter"
                    data-barcode="MNG-002" data-stok="8">
                    <img src="https://images.unsplash.com/photo-1626957341926-98752fc2ba90?w=400" alt="Minyak"
                        class="object-cover w-full transition-transform duration-300 h-44 group-hover:scale-105">
                    <div class="p-4">
                        <h4
                            class="text-sm font-semibold text-gray-800 transition-colors line-clamp-2 group-hover:text-green-700">
                            Minyak Goreng Sania 2L</h4>
                        <p class="mt-1 text-xs text-gray-600">MNG-002</p>
                        <p class="mt-1 text-xs font-medium">Stok: <span class="font-bold text-yellow-600">8 liter</span></p>
                        <p class="mt-2 font-bold text-green-600">Rp 42.500 / liter</p>
                    </div>
                </div>

                <!-- 3 -->
                <div class="overflow-hidden transition-all bg-white border border-gray-200 rounded-lg shadow-sm cursor-pointer card-hover group stok-habis opacity-60"
                    data-produk-id="3" data-nama="Gula Pasir Gulaku 1kg" data-harga="18000" data-satuan="kg"
                    data-barcode="GLP-003" data-stok="0">
                    <img src="https://images.unsplash.com/photo-1556400666-a8c3349b0a4e?w=400" alt="Gula"
                        class="object-cover w-full transition-transform duration-300 h-44 group-hover:scale-105">
                    <div class="p-4">
                        <h4
                            class="text-sm font-semibold text-gray-800 transition-colors line-clamp-2 group-hover:text-green-700">
                            Gula Pasir Gulaku 1kg</h4>
                        <p class="mt-1 text-xs text-gray-600">GLP-003</p>
                        <p class="mt-1 text-xs font-medium">Stok: <span class="font-bold text-red-600">Habis</span></p>
                        <p class="mt-2 font-bold text-green-600">Rp 18.000 / kg</p>
                    </div>
                </div>

                <!-- 4 -->
                <div class="overflow-hidden transition-all bg-white border border-gray-200 rounded-lg shadow-sm cursor-pointer card-hover group stok-tersedia"
                    data-produk-id="4" data-nama="Telur Ayam Kampung 1 Tray" data-harga="65000" data-satuan="tray"
                    data-barcode="TLR-004" data-stok="120">
                    <img src="https://images.unsplash.com/photo-1598170845058-32b9d6a5da37?w=400" alt="Telur"
                        class="object-cover w-full transition-transform duration-300 h-44 group-hover:scale-105">
                    <div class="p-4">
                        <h4
                            class="text-sm font-semibold text-gray-800 transition-colors line-clamp-2 group-hover:text-green-700">
                            Telur Ayam Kampung 1 Tray</h4>
                        <p class="mt-1 text-xs text-gray-600">TLR-004</p>
                        <p class="mt-1 text-xs font-medium">Stok: <span class="font-bold text-green-600">120 tray</span></p>
                        <p class="mt-2 font-bold text-green-600">Rp 65.000 / tray</p>
                    </div>
                </div>

                <!-- 5 -->
                <div class="overflow-hidden transition-all bg-white border border-gray-200 rounded-lg shadow-sm cursor-pointer card-hover group stok-tersedia"
                    data-produk-id="5" data-nama="Tepung Terigu Segitiga Biru 1kg" data-harga="12500" data-satuan="kg"
                    data-barcode="TPG-005" data-stok="200">
                    <img src="https://images.unsplash.com/photo-1589984662646-e7b8d4d3c3c4?w=400" alt="Tepung"
                        class="object-cover w-full transition-transform duration-300 h-44 group-hover:scale-105">
                    <div class="p-4">
                        <h4
                            class="text-sm font-semibold text-gray-800 transition-colors line-clamp-2 group-hover:text-green-700">
                            Tepung Terigu Segitiga Biru 1kg</h4>
                        <p class="mt-1 text-xs text-gray-600">TPG-005</p>
                        <p class="mt-1 text-xs font-medium">Stok: <span class="font-bold text-green-600">200 kg</span></p>
                        <p class="mt-2 font-bold text-green-600">Rp 12.500 / kg</p>
                    </div>
                </div>

                <!-- 6 -->
                <div class="overflow-hidden transition-all bg-white border border-gray-200 rounded-lg shadow-sm cursor-pointer card-hover group stok-sedikit"
                    data-produk-id="6" data-nama="Minyakita 1L" data-harga="18000" data-satuan="liter"
                    data-barcode="MKT-006" data-stok="5">
                    <img src="https://images.unsplash.com/photo-1626957341926-98752fc2ba90?w=400" alt="Minyakita"
                        class="object-cover w-full transition-transform duration-300 h-44 group-hover:scale-105">
                    <div class="p-4">
                        <h4
                            class="text-sm font-semibold text-gray-800 transition-colors line-clamp-2 group-hover:text-green-700">
                            Minyakita 1L</h4>
                        <p class="mt-1 text-xs text-gray-600">MKT-006</p>
                        <p class="mt-1 text-xs font-medium">Stok: <span class="font-bold text-yellow-600">5 liter</span>
                        </p>
                        <p class="mt-2 font-bold text-green-600">Rp 18.000 / liter</p>
                    </div>
                </div>

                <!-- 7 -->
                <div class="overflow-hidden transition-all bg-white border border-gray-200 rounded-lg shadow-sm cursor-pointer card-hover group stok-tersedia"
                    data-produk-id="7" data-nama="Susu Bendera Frisian Flag 1L" data-harga="22000" data-satuan="liter"
                    data-barcode="SBS-007" data-stok="80">
                    <img src="https://images.unsplash.com/photo-1550581190-9be8e5e0d3d4?w=400" alt="Susu"
                        class="object-cover w-full transition-transform duration-300 h-44 group-hover:scale-105">
                    <div class="p-4">
                        <h4
                            class="text-sm font-semibold text-gray-800 transition-colors line-clamp-2 group-hover:text-green-700">
                            Susu Bendera Frisian Flag 1L</h4>
                        <p class="mt-1 text-xs text-gray-600">SBS-007</p>
                        <p class="mt-1 text-xs font-medium">Stok: <span class="font-bold text-green-600">80 liter</span>
                        </p>
                        <p class="mt-2 font-bold text-green-600">Rp 22.000 / liter</p>
                    </div>
                </div>

                <!-- 8 -->
                <div class="overflow-hidden transition-all bg-white border border-gray-200 rounded-lg shadow-sm cursor-pointer card-hover group stok-habis opacity-60"
                    data-produk-id="8" data-nama="Kecap Manis ABC 1L" data-harga="28000" data-satuan="liter"
                    data-barcode="KCP-008" data-stok="0">
                    <img src="https://images.unsplash.com/photo-1613769049987-b31b641f25b1?w=400" alt="Kecap"
                        class="object-cover w-full transition-transform duration-300 h-44 group-hover:scale-105">
                    <div class="p-4">
                        <h4
                            class="text-sm font-semibold text-gray-800 transition-colors line-clamp-2 group-hover:text-green-700">
                            Kecap Manis ABC 1L</h4>
                        <p class="mt-1 text-xs text-gray-600">KCP-008</p>
                        <p class="mt-1 text-xs font-medium">Stok: <span class="font-bold text-red-600">Habis</span></p>
                        <p class="mt-2 font-bold text-green-600">Rp 28.000 / liter</p>
                    </div>
                </div>

                <!-- 9 -->
                <div class="overflow-hidden transition-all bg-white border border-gray-200 rounded-lg shadow-sm cursor-pointer card-hover group stok-tersedia"
                    data-produk-id="9" data-nama="Sabun Mandi Lifebuoy 90g" data-harga="5500" data-satuan="pcs"
                    data-barcode="SBN-009" data-stok="150">
                    <img src="https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?w=400" alt="Sabun"
                        class="object-cover w-full transition-transform duration-300 h-44 group-hover:scale-105">
                    <div class="p-4">
                        <h4
                            class="text-sm font-semibold text-gray-800 transition-colors line-clamp-2 group-hover:text-green-700">
                            Sabun Mandi Lifebuoy 90g</h4>
                        <p class="mt-1 text-xs text-gray-600">SBN-009</p>
                        <p class="mt-1 text-xs font-medium">Stok: <span class="font-bold text-green-600">150 pcs</span>
                        </p>
                        <p class="mt-2 font-bold text-green-600">Rp 5.500 / pcs</p>
                    </div>
                </div>

                <!-- 10 -->
                <div class="overflow-hidden transition-all bg-white border border-gray-200 rounded-lg shadow-sm cursor-pointer card-hover group stok-sedikit"
                    data-produk-id="10" data-nama="Pasta Gigi Pepsodent 190g" data-harga="15000" data-satuan="pcs"
                    data-barcode="PST-010" data-stok="9">
                    <img src="https://images.unsplash.com/photo-1629202923760-3a4d5b5c4d5b?w=400" alt="Pasta Gigi"
                        class="object-cover w-full transition-transform duration-300 h-44 group-hover:scale-105">
                    <div class="p-4">
                        <h4
                            class="text-sm font-semibold text-gray-800 transition-colors line-clamp-2 group-hover:text-green-700">
                            Pasta Gigi Pepsodent 190g</h4>
                        <p class="mt-1 text-xs text-gray-600">PST-010</p>
                        <p class="mt-1 text-xs font-medium">Stok: <span class="font-bold text-yellow-600">9 pcs</span></p>
                        <p class="mt-2 font-bold text-green-600">Rp 15.000 / pcs</p>
                    </div>
                </div>

                <!-- 11 -->
                <div class="overflow-hidden transition-all bg-white border border-gray-200 rounded-lg shadow-sm cursor-pointer card-hover group stok-tersedia"
                    data-produk-id="11" data-nama="Sampo Sunsilk 160ml" data-harga="22000" data-satuan="pcs"
                    data-barcode="SMP-011" data-stok="90">
                    <img src="https://images.unsplash.com/photo-1625772299848-361b803ffa25?w=400" alt="Sampo"
                        class="object-cover w-full transition-transform duration-300 h-44 group-hover:scale-105">
                    <div class="p-4">
                        <h4
                            class="text-sm font-semibold text-gray-800 transition-colors line-clamp-2 group-hover:text-green-700">
                            Sampo Sunsilk 160ml</h4>
                        <p class="mt-1 text-xs text-gray-600">SMP-011</p>
                        <p class="mt-1 text-xs font-medium">Stok: <span class="font-bold text-green-600">90 pcs</span></p>
                        <p class="mt-2 font-bold text-green-600">Rp 22.000 / pcs</p>
                    </div>
                </div>

                <!-- 12 -->
                <div class="overflow-hidden transition-all bg-white border border-gray-200 rounded-lg shadow-sm cursor-pointer card-hover group stok-habis opacity-60"
                    data-produk-id="12" data-nama="Rokok Djarum Super 12" data-harga="28000" data-satuan="pcs"
                    data-barcode="RKG-012" data-stok="0">
                    <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=400" alt="Rokok"
                        class="object-cover w-full transition-transform duration-300 h-44 group-hover:scale-105">
                    <div class="p-4">
                        <h4
                            class="text-sm font-semibold text-gray-800 transition-colors line-clamp-2 group-hover:text-green-700">
                            Rokok Djarum Super 12</h4>
                        <p class="mt-1 text-xs text-gray-600">RKG-012</p>
                        <p class="mt-1 text-xs font-medium">Stok: <span class="font-bold text-red-600">Habis</span></p>
                        <p class="mt-2 font-bold text-green-600">Rp 28.000 / pcs</p>
                    </div>
                </div>

                <!-- 13 -->
                <div class="overflow-hidden transition-all bg-white border border-gray-200 rounded-lg shadow-sm cursor-pointer card-hover group stok-tersedia"
                    data-produk-id="13" data-nama="Biskuit Roma Kelapa 800g" data-harga="32000" data-satuan="pcs"
                    data-barcode="BSK-013" data-stok="60">
                    <img src="https://images.unsplash.com/photo-1559620192-032c4bc4674e?w=400" alt="Biskuit"
                        class="object-cover w-full transition-transform duration-300 h-44 group-hover:scale-105">
                    <div class="p-4">
                        <h4
                            class="text-sm font-semibold text-gray-800 transition-colors line-clamp-2 group-hover:text-green-700">
                            Biskuit Roma Kelapa 800g</h4>
                        <p class="mt-1 text-xs text-gray-600">BSK-013</p>
                        <p class="mt-1 text-xs font-medium">Stok: <span class="font-bold text-green-600">60 pcs</span></p>
                        <p class="mt-2 font-bold text-green-600">Rp 32.000 / pcs</p>
                    </div>
                </div>

                <!-- 14 -->
                <div class="overflow-hidden transition-all bg-white border border-gray-200 rounded-lg shadow-sm cursor-pointer card-hover group stok-sedikit"
                    data-produk-id="14" data-nama="Kopi Kapal Api 185g" data-harga="35000" data-satuan="pcs"
                    data-barcode="KPI-014" data-stok="7">
                    <img src="https://images.unsplash.com/photo-1559056199-8c995180c7c0?w=400" alt="Kopi"
                        class="object-cover w-full transition-transform duration-300 h-44 group-hover:scale-105">
                    <div class="p-4">
                        <h4
                            class="text-sm font-semibold text-gray-800 transition-colors line-clamp-2 group-hover:text-green-700">
                            Kopi Kapal Api 185g</h4>
                        <p class="mt-1 text-xs text-gray-600">KPI-014</p>
                        <p class="mt-1 text-xs font-medium">Stok: <span class="font-bold text-yellow-600">7 pcs</span></p>
                        <p class="mt-2 font-bold text-green-600">Rp 35.000 / pcs</p>
                    </div>
                </div>

                <!-- 15 -->
                <div class="overflow-hidden transition-all bg-white border border-gray-200 rounded-lg shadow-sm cursor-pointer card-hover group stok-tersedia"
                    data-produk-id="15" data-nama="Mie Instan Indomie Goreng 75g" data-harga="3500" data-satuan="pcs"
                    data-barcode="MII-015" data-stok="500">
                    <img src="https://images.unsplash.com/photo-1626800478097-7c07c6d3d2e0?w=400" alt="Mie Instan"
                        class="object-cover w-full transition-transform duration-300 h-44 group-hover:scale-105">
                    <div class="p-4">
                        <h4
                            class="text-sm font-semibold text-gray-800 transition-colors line-clamp-2 group-hover:text-green-700">
                            Mie Instan Indomie Goreng 75g</h4>
                        <p class="mt-1 text-xs text-gray-600">MII-015</p>
                        <p class="mt-1 text-xs font-medium">Stok: <span class="font-bold text-green-600">500 pcs</span>
                        </p>
                        <p class="mt-2 font-bold text-green-600">Rp 3.500 / pcs</p>
                    </div>
                </div>

                <!-- 16 -->
                <div class="overflow-hidden transition-all bg-white border border-gray-200 rounded-lg shadow-sm cursor-pointer card-hover group stok-habis opacity-60"
                    data-produk-id="16" data-nama="Roti Tawar Sari Roti 450g" data-harga="18000" data-satuan="pcs"
                    data-barcode="RTW-016" data-stok="0">
                    <img src="https://images.unsplash.com/photo-1589114471171-8d2e7e8d0c6e?w=400" alt="Roti"
                        class="object-cover w-full transition-transform duration-300 h-44 group-hover:scale-105">
                    <div class="p-4">
                        <h4
                            class="text-sm font-semibold text-gray-800 transition-colors line-clamp-2 group-hover:text-green-700">
                            Roti Tawar Sari Roti 450g</h4>
                        <p class="mt-1 text-xs text-gray-600">RTW-016</p>
                        <p class="mt-1 text-xs font-medium">Stok: <span class="font-bold text-red-600">Habis</span></p>
                        <p class="mt-2 font-bold text-green-600">Rp 18.000 / pcs</p>
                    </div>
                </div>

                <!-- 17 -->
                <div class="overflow-hidden transition-all bg-white border border-gray-200 rounded-lg shadow-sm cursor-pointer card-hover group stok-tersedia"
                    data-produk-id="17" data-nama="Air Mineral Aqua 600ml" data-harga="3500" data-satuan="pcs"
                    data-barcode="AIR-017" data-stok="300">
                    <img src="https://images.unsplash.com/photo-1616118132534-381148898bb4?w=400" alt="Air Mineral"
                        class="object-cover w-full transition-transform duration-300 h-44 group-hover:scale-105">
                    <div class="p-4">
                        <h4
                            class="text-sm font-semibold text-gray-800 transition-colors line-clamp-2 group-hover:text-green-700">
                            Air Mineral Aqua 600ml</h4>
                        <p class="mt-1 text-xs text-gray-600">AIR-017</p>
                        <p class="mt-1 text-xs font-medium">Stok: <span class="font-bold text-green-600">300 pcs</span>
                        </p>
                        <p class="mt-2 font-bold text-green-600">Rp 3.500 / pcs</p>
                    </div>
                </div>

                <!-- 18 -->
                <div class="overflow-hidden transition-all bg-white border border-gray-200 rounded-lg shadow-sm cursor-pointer card-hover group stok-sedikit"
                    data-produk-id="18" data-nama="Shampoo Clear Men 170ml" data-harga="28000" data-satuan="pcs"
                    data-barcode="SHM-018" data-stok="6">
                    <img src="https://images.unsplash.com/photo-1626800478097-7c07c6d3d2e0?w=400" alt="Shampoo"
                        class="object-cover w-full transition-transform duration-300 h-44 group-hover:scale-105">
                    <div class="p-4">
                        <h4
                            class="text-sm font-semibold text-gray-800 transition-colors line-clamp-2 group-hover:text-green-700">
                            Shampoo Clear Men 170ml</h4>
                        <p class="mt-1 text-xs text-gray-600">SHM-018</p>
                        <p class="mt-1 text-xs font-medium">Stok: <span class="font-bold text-yellow-600">6 pcs</span></p>
                        <p class="mt-2 font-bold text-green-600">Rp 28.000 / pcs</p>
                    </div>
                </div>

                <!-- 19 -->
                <div class="overflow-hidden transition-all bg-white border border-gray-200 rounded-lg shadow-sm cursor-pointer card-hover group stok-tersedia"
                    data-produk-id="19" data-nama="Sabun Cuci Piring Sunlight 800ml" data-harga="18000"
                    data-satuan="liter" data-barcode="SCP-019" data-stok="70">
                    <img src="https://images.unsplash.com/photo-1589924691995-400dc9ecc0af?w=400" alt="Sabun Cuci"
                        class="object-cover w-full transition-transform duration-300 h-44 group-hover:scale-105">
                    <div class="p-4">
                        <h4
                            class="text-sm font-semibold text-gray-800 transition-colors line-clamp-2 group-hover:text-green-700">
                            Sabun Cuci Piring Sunlight 800ml</h4>
                        <p class="mt-1 text-xs text-gray-600">SCP-019</p>
                        <p class="mt-1 text-xs font-medium">Stok: <span class="font-bold text-green-600">70 liter</span>
                        </p>
                        <p class="mt-2 font-bold text-green-600">Rp 18.000 / liter</p>
                    </div>
                </div>

                <!-- 20 -->
                <div class="overflow-hidden transition-all bg-white border border-gray-200 rounded-lg shadow-sm cursor-pointer card-hover group stok-habis opacity-60"
                    data-produk-id="20" data-nama="Detergen Rinso 770g" data-harga="32000" data-satuan="pcs"
                    data-barcode="DTG-020" data-stok="0">
                    <img src="https://images.unsplash.com/photo-1584305570908-5c2e6c3d1e3e?w=400" alt="Detergen"
                        class="object-cover w-full transition-transform duration-300 h-44 group-hover:scale-105">
                    <div class="p-4">
                        <h4
                            class="text-sm font-semibold text-gray-800 transition-colors line-clamp-2 group-hover:text-green-700">
                            Detergen Rinso 770g</h4>
                        <p class="mt-1 text-xs text-gray-600">DTG-020</p>
                        <p class="mt-1 text-xs font-medium">Stok: <span class="font-bold text-red-600">Habis</span></p>
                        <p class="mt-2 font-bold text-green-600">Rp 32.000 / pcs</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kanan: Keranjang Belanja - FIXED di kanan, garis tipis atas & bawah total -->
        <div
            class="fixed top-21 right-0 bottom-15 w-full lg:w-[420px] lg:max-w-md bg-white border-l border-gray-300 overflow-hidden flex flex-col z-20">
            <div class="flex flex-col h-full p-6">
                <h2 class="flex items-center justify-between mb-4 text-xl font-bold text-gray-800">
                    Keranjang Belanja
                    <span id="jumlahItem" class="text-sm font-medium text-gray-600">(0 item)</span>
                </h2>

                <!-- Input Nama Pelanggan -->
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-medium text-gray-700">Nama Pelanggan</label>
                    <input type="text" id="namaPelanggan" value="Umum"
                        placeholder="Masukkan nama pelanggan (opsional)"
                        class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                </div>

                <!-- Isi Keranjang: scroll internal -->
                <div id="keranjangList" class="flex flex-col flex-grow gap-4 pb-6 pr-2 overflow-y-auto custom-scrollbar">
                    <div class="flex items-center justify-center flex-1 py-10 text-center text-gray-500">
                        Belum ada produk di keranjang
                    </div>
                </div>

                <!-- Total & Pembayaran: garis tipis atas & bawah -->
                <div class="pt-4 pb-4 mt-3 border-t border-b border-gray-300">
                    <div class="flex items-center justify-between mb-4 text-lg font-semibold">
                        <span>Total</span>
                        <span id="totalHarga" class="text-green-600">Rp 0</span>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-700">Uang Bayar</label>
                        <input type="number" id="uangBayar" min="0" placeholder="Masukkan jumlah uang"
                            class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                    </div>

                    <div class="flex items-center justify-between mb-6 text-sm">
                        <span class="text-gray-600">Kembalian</span>
                        <span id="kembalian" class="font-bold text-green-600">Rp 0</span>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row">
                        <button id="btnBayar" disabled
                            class="flex-1 py-3 text-white transition-all rounded-lg bg-gradient-to-r from-green-600 to-green-500 hover:from-green-700 hover:to-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed">
                            <i class="mr-2 fas fa-check-circle"></i> Bayar Sekarang
                        </button>

                        <button id="btnClear" disabled
                            class="flex-1 py-3 text-white transition-all bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed">
                            <i class="mr-2 fas fa-trash-alt"></i> Clear Keranjang
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            let keranjang = [];
            let transaksiCounter = 1;

            // Tambah ke keranjang
            document.querySelectorAll('#produkList .card-hover').forEach(card => {
                card.addEventListener('click', () => {
                    const stok = parseInt(card.dataset.stok) || 0;
                    if (stok <= 0) {
                        Swal.fire({
                            title: 'Stok Habis!',
                            text: 'Produk ini tidak tersedia saat ini.',
                            icon: 'warning',
                            confirmButtonColor: '#22C55E'
                        });
                        return;
                    }

                    const produkId = card.dataset.produkId;
                    const nama = card.dataset.nama;
                    const harga = parseInt(card.dataset.harga);
                    const satuan = card.dataset.satuan;
                    const barcode = card.dataset.barcode;

                    const existing = keranjang.find(item => item.barcode === barcode);
                    if (existing) {
                        if (existing.qty + 1 > stok) {
                            Swal.fire({
                                title: 'Stok Tidak Cukup!',
                                text: `Hanya tersisa ${stok} ${satuan}`,
                                icon: 'warning',
                                confirmButtonColor: '#22C55E'
                            });
                            return;
                        }
                        existing.qty += 1;
                    } else {
                        keranjang.push({
                            produk_id: produkId,
                            nama,
                            harga,
                            satuan,
                            barcode,
                            qty: 1,
                            stok
                        });
                    }

                    renderKeranjang();
                });
            });

            function renderKeranjang() {
                const container = document.getElementById('keranjangList');
                container.innerHTML = '';

                document.getElementById('jumlahItem').textContent = `(${keranjang.length} item)`;

                if (keranjang.length === 0) {
                    container.innerHTML = '<div class="py-10 text-center text-gray-500">Belum ada produk di keranjang</div>';
                    document.getElementById('btnClear').disabled = true;
                    document.getElementById('btnBayar').disabled = true;
                    return;
                }

                document.getElementById('btnClear').disabled = false;

                keranjang.forEach((item, index) => {
                    const div = document.createElement('div');
                    div.className =
                        'flex flex-col sm:flex-row items-start sm:items-center justify-between p-4 bg-gray-50 rounded-lg gap-3';
                    div.innerHTML = `
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">${item.nama}</p>
                        <p class="text-sm text-gray-600">Rp ${item.harga.toLocaleString('id-ID')} / ${item.satuan}</p>
                        <p class="mt-1 text-sm font-medium text-gray-900">
                            Subtotal: <span class="font-bold text-green-600">Rp ${(item.harga * item.qty).toLocaleString('id-ID')}</span>
                        </p>
                    </div>
                    <div class="flex items-center justify-end w-full gap-4 sm:w-auto">
                        <button class="text-xl font-bold text-red-500 hover:text-red-700" onclick="kurangiQty(${index})">-</button>
                        <span class="w-8 font-bold text-center">${item.qty}</span>
                        <button class="text-xl font-bold text-green-500 hover:text-green-700" onclick="tambahQty(${index})">+</button>
                    </div>
                `;
                    container.appendChild(div);
                });

                hitungTotal();
            }

            window.tambahQty = function(index) {
                const item = keranjang[index];
                if (item.qty + 1 > item.stok) {
                    Swal.fire({
                        title: 'Stok Tidak Cukup!',
                        text: `Hanya tersisa ${item.stok} ${item.satuan}`,
                        icon: 'warning',
                        confirmButtonColor: '#22C55E'
                    });
                    return;
                }
                item.qty += 1;
                renderKeranjang();
            }

            window.kurangiQty = function(index) {
                const item = keranjang[index];
                if (item.qty > 1) {
                    item.qty -= 1;
                } else {
                    keranjang.splice(index, 1);
                }
                renderKeranjang();
            }

            function hitungTotal() {
                let total = 0;
                keranjang.forEach(item => total += item.harga * item.qty);

                document.getElementById('totalHarga').textContent = 'Rp ' + total.toLocaleString('id-ID');

                const bayar = parseInt(document.getElementById('uangBayar').value) || 0;
                const kembalian = bayar - total;
                document.getElementById('kembalian').textContent = kembalian >= 0 ? 'Rp ' + kembalian.toLocaleString('id-ID') :
                    'Rp 0';

                document.getElementById('btnBayar').disabled = (total === 0 || bayar < total);
            }

            document.getElementById('uangBayar')?.addEventListener('input', hitungTotal);

            // Tombol Bayar dengan Review Pesanan + Redirect ke Struk
            document.getElementById('btnBayar')?.addEventListener('click', () => {
                const total = keranjang.reduce((sum, item) => sum + item.harga * item.qty, 0);
                const bayar = parseInt(document.getElementById('uangBayar').value) || 0;
                const kembalian = bayar - total;
                const namaPelanggan = document.getElementById('namaPelanggan').value.trim() || 'Umum';

                if (bayar < total) {
                    Swal.fire({
                        title: 'Uang Kurang!',
                        text: 'Uang bayar harus lebih besar atau sama dengan total.',
                        icon: 'error',
                        confirmButtonColor: '#d33'
                    });
                    return;
                }

                // Review Pesanan
                let itemList =
                    '<table class="w-full mt-4 text-sm text-left border-collapse"><thead><tr class="border-b"><th>Produk</th><th class="text-center">Qty</th><th class="text-right">Subtotal</th></tr></thead><tbody>';
                keranjang.forEach(item => {
                    itemList +=
                        `<tr><td>${item.nama}</td><td class="text-center">${item.qty}</td><td class="text-right">Rp ${(item.harga * item.qty).toLocaleString('id-ID')}</td></tr>`;
                });
                itemList += '</tbody></table>';

                Swal.fire({
                    title: 'Review Pesanan Sebelum Bayar',
                    html: `
                    <div class="space-y-2 text-sm text-left">
                        <p><strong>Kasir:</strong> {{ Auth::user()->nama ?? 'Kasir' }}</p>
                        <p><strong>Tanggal:</strong> ${new Date().toLocaleString('id-ID', { dateStyle: 'medium', timeStyle: 'short' })}</p>
                        <p><strong>Pelanggan:</strong> ${namaPelanggan}</p>
                        ${itemList}
                        <hr class="my-3 border-gray-300">
                        <p class="text-lg font-bold">Total Belanja: Rp ${total.toLocaleString('id-ID')}</p>
                        <p>Uang Bayar: Rp ${bayar.toLocaleString('id-ID')}</p>
                        <p class="text-lg font-bold text-green-600">Kembalian: Rp ${kembalian.toLocaleString('id-ID')}</p>
                    </div>
                    <p class="mt-4 font-medium text-center text-gray-600">Pastikan sudah benar sebelum mencetak struk!</p>
                `,
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#22C55E',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Bayar & Cetak Struk',
                    cancelButtonText: 'Batalkan',
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        const trxNumber =
                            `TRX-${new Date().toISOString().slice(0,10).replace(/-/g,'')}-${String(Math.floor(Math.random() * 900) + 100).padStart(3,'0')}`;

                        // Redirect ke struk
                        window.location.href = "{{ route('kasir.struk') }}/" + trxNumber;
                    }
                });
            });

            // Tombol Clear Keranjang
            document.getElementById('btnClear')?.addEventListener('click', () => {
                Swal.fire({
                    title: 'Clear Keranjang?',
                    text: "Semua item akan dihapus. Lanjutkan?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#22C55E',
                    confirmButtonText: 'Ya, Clear',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        keranjang = [];
                        renderKeranjang();
                        Swal.fire({
                            title: 'Keranjang Dikosongkan!',
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                });
            });

            // Live Search + Filter Stok
            function applyFilters() {
                const searchTerm = document.getElementById('searchProduk').value.toLowerCase().trim();
                const stokFilter = document.getElementById('filterStok').value;

                document.querySelectorAll('#produkList .card-hover').forEach(card => {
                    const nama = card.dataset.nama.toLowerCase();
                    const barcode = card.dataset.barcode.toLowerCase();
                    const stok = parseInt(card.dataset.stok) || 0;

                    const matchSearch = nama.includes(searchTerm) || barcode.includes(searchTerm);

                    let matchStok = true;
                    if (stokFilter === 'tersedia') matchStok = stok > 0;
                    if (stokFilter === 'sedikit') matchStok = stok > 0 && stok < 10;
                    if (stokFilter === 'habis') matchStok = stok === 0;

                    card.style.display = (matchSearch && matchStok) ? '' : 'none';
                });
            }

            document.getElementById('searchProduk')?.addEventListener('input', applyFilters);
            document.getElementById('filterStok')?.addEventListener('change', applyFilters);
        </script>
    @endpush
@endsection
