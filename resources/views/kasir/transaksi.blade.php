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

            <!-- Grid Card Produk -->
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5" id="produkList">
                <!-- Card dirender via JS -->
            </div>

            <!-- Pagination - Simpel & Elegan -->
            <div class="flex flex-col items-center justify-center gap-4 mt-8 sm:flex-row" id="pagination">
                <button id="prevPage" class="flex items-center px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-green-50 hover:border-green-300 hover:text-green-700 transition-all disabled:opacity-50 disabled:hover:bg-white disabled:hover:border-gray-300 disabled:cursor-not-allowed">
                    <i class="mr-2 text-xs fas fa-chevron-left"></i> Prev
                </button>

                <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-3" id="pageNumbers">
                    <!-- Nomor halaman dirender via JS -->
                </div>

                <button id="nextPage" class="flex items-center px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-green-50 hover:border-green-300 hover:text-green-700 transition-all disabled:opacity-50 disabled:hover:bg-white disabled:hover:border-gray-300 disabled:cursor-not-allowed">
                    Next <i class="ml-2 text-xs fas fa-chevron-right"></i>
                </button>
            </div>
        </div>

        <!-- Kanan: Keranjang Belanja - FIXED di desktop, BOTTOM di mobile -->
        <div class="lg:fixed lg:top-20 lg:right-0 lg:bottom-14 lg:w-[420px] lg:max-w-md w-full bg-white border-t lg:border-l border-gray-300 overflow-hidden flex flex-col z-20 lg:shadow-xl mt-auto lg:mt-0">
            <div class="flex flex-col h-full p-5 lg:p-6">
                <h2 class="flex items-center justify-between mb-3 text-xl font-bold text-gray-800 lg:mb-4">
                    Keranjang Belanja
                    <span id="jumlahItem" class="text-sm font-medium text-gray-600">(0 item)</span>
                </h2>

                <!-- Input Nama Pelanggan -->
                <div class="mb-3 lg:mb-4">
                    <label class="block mb-1.5 lg:mb-2 text-sm font-medium text-gray-700">Nama Pelanggan</label>
                    <input type="text" id="namaPelanggan" value="Umum" placeholder="Masukkan nama pelanggan (opsional)"
                           class="w-full px-4 py-2 lg:py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                </div>

                <!-- Isi Keranjang: scroll internal -->
                <div id="keranjangList" class="flex flex-col flex-grow gap-3 pb-4 pr-2 overflow-y-auto lg:gap-4 lg:pb-6 custom-scrollbar">
                    <div class="flex items-center justify-center flex-1 py-8 text-center text-gray-500 lg:py-10">
                        Belum ada produk di keranjang
                    </div>
                </div>

                <!-- Total & Pembayaran: garis tipis atas & bawah -->
                <div class="pt-3 pb-3 mt-2 border-t border-b border-gray-300 lg:pt-4 lg:pb-4 lg:mt-3">
                    <div class="flex items-center justify-between mb-3 text-lg font-semibold lg:mb-4">
                        <span>Total</span>
                        <span id="totalHarga" class="text-green-600">Rp 0</span>
                    </div>

                    <div class="mb-3 lg:mb-4">
                        <label class="block mb-1.5 lg:mb-2 text-sm font-medium text-gray-700">Uang Bayar</label>
                        <input type="number" id="uangBayar" min="0" placeholder="Masukkan jumlah uang"
                               class="w-full px-4 py-2 lg:py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                    </div>

                    <div class="flex items-center justify-between mb-4 text-sm lg:mb-6">
                        <span class="text-gray-600">Kembalian</span>
                        <span id="kembalian" class="font-bold text-green-600">Rp 0</span>
                    </div>

                    <div class="flex flex-col gap-2.5 lg:gap-3 sm:flex-row">
                        <button id="btnBayar" disabled
                                class="flex-1 py-2.5 lg:py-3 text-white transition-all rounded-lg bg-gradient-to-r from-green-600 to-green-500 hover:from-green-700 hover:to-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed">
                            <i class="mr-2 fas fa-check-circle"></i> Bayar Sekarang
                        </button>

                        <button id="btnClear" disabled
                                class="flex-1 py-2.5 lg:py-3 text-white transition-all bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed">
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

        // === PAGINATION PRODUK ===
        const itemsPerPage = 12;
        let currentPage = 1;
        let filteredProducts = []; // ini yang akan dirender (awalnya semua)

        const allProducts = [
            { id:1, nama:"Beras Pandan Premium 5kg", harga:78000, satuan:"kg", barcode:"BRP-001", stok:45, img:"https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=400" },
            { id:2, nama:"Minyak Goreng Sania 2L", harga:42500, satuan:"liter", barcode:"MNG-002", stok:8, img:"https://images.unsplash.com/photo-1626957341926-98752fc2ba90?w=400" },
            { id:3, nama:"Gula Pasir Gulaku 1kg", harga:18000, satuan:"kg", barcode:"GLP-003", stok:0, img:"https://images.unsplash.com/photo-1556400666-a8c3349b0a4e?w=400" },
            { id:4, nama:"Telur Ayam Kampung 1 Tray", harga:65000, satuan:"tray", barcode:"TLR-004", stok:120, img:"https://images.unsplash.com/photo-1598170845058-32b9d6a5da37?w=400" },
            { id:5, nama:"Tepung Terigu Segitiga Biru 1kg", harga:12500, satuan:"kg", barcode:"TPG-005", stok:200, img:"https://images.unsplash.com/photo-1589984662646-e7b8d4d3c3c4?w=400" },
            { id:6, nama:"Minyakita 1L", harga:18000, satuan:"liter", barcode:"MKT-006", stok:5, img:"https://images.unsplash.com/photo-1626957341926-98752fc2ba90?w=400" },
            { id:7, nama:"Susu Bendera Frisian Flag 1L", harga:22000, satuan:"liter", barcode:"SBS-007", stok:80, img:"https://images.unsplash.com/photo-1550581190-9be8e5e0d3d4?w=400" },
            { id:8, nama:"Kecap Manis ABC 1L", harga:28000, satuan:"liter", barcode:"KCP-008", stok:0, img:"https://images.unsplash.com/photo-1613769049987-b31b641f25b1?w=400" },
            { id:9, nama:"Sabun Mandi Lifebuoy 90g", harga:5500, satuan:"pcs", barcode:"SBN-009", stok:150, img:"https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?w=400" },
            { id:10, nama:"Pasta Gigi Pepsodent 190g", harga:15000, satuan:"pcs", barcode:"PST-010", stok:9, img:"https://images.unsplash.com/photo-1629202923760-3a4d5b5c4d5b?w=400" },
            { id:11, nama:"Sampo Sunsilk 160ml", harga:22000, satuan:"pcs", barcode:"SMP-011", stok:90, img:"https://images.unsplash.com/photo-1625772299848-361b803ffa25?w=400" },
            { id:12, nama:"Rokok Djarum Super 12", harga:28000, satuan:"pcs", barcode:"RKG-012", stok:0, img:"https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=400" },
            { id:13, nama:"Biskuit Roma Kelapa 800g", harga:32000, satuan:"pcs", barcode:"BSK-013", stok:60, img:"https://images.unsplash.com/photo-1559620192-032c4bc4674e?w=400" },
            { id:14, nama:"Kopi Kapal Api 185g", harga:35000, satuan:"pcs", barcode:"KPI-014", stok:7, img:"https://images.unsplash.com/photo-1559056199-8c995180c7c0?w=400" },
            { id:15, nama:"Mie Instan Indomie Goreng 75g", harga:3500, satuan:"pcs", barcode:"MII-015", stok:500, img:"https://images.unsplash.com/photo-1626800478097-7c07c6d3d2e0?w=400" },
            { id:16, nama:"Roti Tawar Sari Roti 450g", harga:18000, satuan:"pcs", barcode:"RTW-016", stok:0, img:"https://images.unsplash.com/photo-1589114471171-8d2e7e8d0c6e?w=400" },
            { id:17, nama:"Air Mineral Aqua 600ml", harga:3500, satuan:"pcs", barcode:"AIR-017", stok:300, img:"https://images.unsplash.com/photo-1616118132534-381148898bb4?w=400" },
            { id:18, nama:"Shampoo Clear Men 170ml", harga:28000, satuan:"pcs", barcode:"SHM-018", stok:6, img:"https://images.unsplash.com/photo-1626800478097-7c07c6d3d2e0?w=400" },
            { id:19, nama:"Sabun Cuci Piring Sunlight 800ml", harga:18000, satuan:"liter", barcode:"SCP-019", stok:70, img:"https://images.unsplash.com/photo-1589924691995-400dc9ecc0af?w=400" },
            { id:20, nama:"Detergen Rinso 770g", harga:32000, satuan:"pcs", barcode:"DTG-020", stok:0, img:"https://images.unsplash.com/photo-1584305570908-5c2e6c3d1e3e?w=400" },
        ];

        // Set awal filteredProducts = semua produk
        filteredProducts = [...allProducts];

        function renderProducts(page = 1) {
            const container = document.getElementById('produkList');
            container.innerHTML = '';

            const start = (page - 1) * itemsPerPage;
            const end = start + itemsPerPage;
            const paginated = filteredProducts.slice(start, end);

            paginated.forEach(product => {
                const stokClass = product.stok > 10 ? 'stok-tersedia' : product.stok > 0 ? 'stok-sedikit' : 'stok-habis opacity-60';
                const stokText = product.stok > 0 ? `${product.stok} ${product.satuan}` : 'Habis';
                const stokColor = product.stok > 10 ? 'text-green-600' : product.stok > 0 ? 'text-yellow-600' : 'text-red-600';

                const card = document.createElement('div');
                card.className = `overflow-hidden transition-all bg-white border border-gray-200 rounded-lg shadow-sm cursor-pointer card-hover group ${stokClass}`;
                card.dataset.produkId = product.id;
                card.dataset.nama = product.nama;
                card.dataset.harga = product.harga;
                card.dataset.satuan = product.satuan;
                card.dataset.barcode = product.barcode;
                card.dataset.stok = product.stok;

                card.innerHTML = `
                    <img src="${product.img}" alt="${product.nama}"
                         class="object-cover w-full transition-transform duration-300 h-44 group-hover:scale-105">
                    <div class="p-4">
                        <h4 class="text-sm font-semibold text-gray-800 transition-colors line-clamp-2 group-hover:text-green-700">
                            ${product.nama}
                        </h4>
                        <p class="mt-1 text-xs text-gray-600">${product.barcode}</p>
                        <p class="mt-1 text-xs font-medium">Stok: <span class="font-bold ${stokColor}">${stokText}</span></p>
                        <p class="mt-2 font-bold text-green-600">Rp ${product.harga.toLocaleString('id-ID')} / ${product.satuan}</p>
                    </div>
                `;

                container.appendChild(card);
            });

            renderPagination(page);
            attachProductClick();
        }

        function renderPagination(page) {
            const totalPages = Math.ceil(filteredProducts.length / itemsPerPage);
            const pageNumbersContainer = document.getElementById('pageNumbers');
            pageNumbersContainer.innerHTML = '';

            const maxVisible = 5;
            let start = Math.max(1, page - Math.floor(maxVisible / 2));
            let end = Math.min(totalPages, start + maxVisible - 1);

            if (end - start + 1 < maxVisible) {
                start = Math.max(1, end - maxVisible + 1);
            }

            if (start > 1) {
                pageNumbersContainer.appendChild(createPageButton(1, page === 1));
                if (start > 2) pageNumbersContainer.appendChild(createEllipsis());
            }

            for (let i = start; i <= end; i++) {
                pageNumbersContainer.appendChild(createPageButton(i, page === i));
            }

            if (end < totalPages) {
                if (end < totalPages - 1) pageNumbersContainer.appendChild(createEllipsis());
                pageNumbersContainer.appendChild(createPageButton(totalPages, page === totalPages));
            }

            document.getElementById('prevPage').disabled = page === 1;
            document.getElementById('nextPage').disabled = page === totalPages || totalPages === 0;
        }

        function createPageButton(num, active) {
            const btn = document.createElement('button');
            btn.className = `px-3.5 py-2 text-sm font-medium rounded-lg transition-all ${
                active ? 'bg-green-600 text-white shadow-sm' : 'bg-white border border-gray-300 text-gray-700 hover:bg-green-50 hover:border-green-300 hover:text-green-700'
            }`;
            btn.textContent = num;
            btn.addEventListener('click', () => {
                currentPage = num;
                renderProducts(currentPage);
            });
            return btn;
        }

        function createEllipsis() {
            const span = document.createElement('span');
            span.className = 'px-2 py-2 text-sm text-gray-500';
            span.textContent = '...';
            return span;
        }

        function attachProductClick() {
            document.querySelectorAll('#produkList .card-hover').forEach(card => {
                card.addEventListener('click', () => {
                    const stok = parseInt(card.dataset.stok) || 0;
                    if (stok <= 0) {
                        Swal.fire({ title: 'Stok Habis!', text: 'Produk ini tidak tersedia.', icon: 'warning', confirmButtonColor: '#22C55E' });
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
                            Swal.fire({ title: 'Stok Tidak Cukup!', text: `Hanya tersisa ${stok} ${satuan}`, icon: 'warning', confirmButtonColor: '#22C55E' });
                            return;
                        }
                        existing.qty += 1;
                    } else {
                        keranjang.push({ produk_id: produkId, nama, harga, satuan, barcode, qty: 1, stok });
                    }

                    renderKeranjang();
                });
            });
        }

        // Pagination buttons
        document.getElementById('prevPage')?.addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                renderProducts(currentPage);
            }
        });

        document.getElementById('nextPage')?.addEventListener('click', () => {
            const totalPages = Math.ceil(filteredProducts.length / itemsPerPage);
            if (currentPage < totalPages) {
                currentPage++;
                renderProducts(currentPage);
            }
        });

        // Filter & Search
        function applyFilters() {
            const searchTerm = document.getElementById('searchProduk').value.toLowerCase().trim();
            const stokFilter = document.getElementById('filterStok').value;

            filteredProducts = allProducts.filter(product => {
                const nama = product.nama.toLowerCase();
                const barcode = product.barcode.toLowerCase();
                const stok = product.stok;

                const matchSearch = nama.includes(searchTerm) || barcode.includes(searchTerm);

                let matchStok = true;
                if (stokFilter === 'tersedia') matchStok = stok > 0;
                if (stokFilter === 'sedikit') matchStok = stok > 0 && stok < 10;
                if (stokFilter === 'habis') matchStok = stok === 0;

                return matchSearch && matchStok;
            });

            currentPage = 1;
            renderProducts(currentPage);
        }

        document.getElementById('searchProduk')?.addEventListener('input', applyFilters);
        document.getElementById('filterStok')?.addEventListener('change', applyFilters);

        // Initial render (semua produk)
        filteredProducts = [...allProducts];
        renderProducts(1);

        // === KODE KERANJANG TETAP (sama seperti kamu) ===
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
                div.className = 'flex flex-col sm:flex-row items-start sm:items-center justify-between p-4 bg-gray-50 rounded-lg gap-3';
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
            document.getElementById('kembalian').textContent = kembalian >= 0 ? 'Rp ' + kembalian.toLocaleString('id-ID') : 'Rp 0';

            document.getElementById('btnBayar').disabled = (total === 0 || bayar < total);
        }

        document.getElementById('uangBayar')?.addEventListener('input', hitungTotal);

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

            let itemList = '<table class="w-full mt-4 text-sm text-left border-collapse"><thead><tr class="border-b"><th>Produk</th><th class="text-center">Qty</th><th class="text-right">Subtotal</th></tr></thead><tbody>';
            keranjang.forEach(item => {
                itemList += `<tr><td>${item.nama}</td><td class="text-center">${item.qty}</td><td class="text-right">Rp ${(item.harga * item.qty).toLocaleString('id-ID')}</td></tr>`;
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
                    const trxNumber = `TRX-${new Date().toISOString().slice(0,10).replace(/-/g,'')}-${String(Math.floor(Math.random() * 900) + 100).padStart(3,'0')}`;
                    const dummyId = Math.floor(Math.random() * 1000) + 1;
                    window.location.href = "{{ route('kasir.struk', ['id' => ':id']) }}".replace(':id', dummyId);
                }
            });
        });

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
                    Swal.fire({ title: 'Keranjang Dikosongkan!', icon: 'success', timer: 1500, showConfirmButton: false });
                }
            });
        });
    </script>
@endpush
@endsection
