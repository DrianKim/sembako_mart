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
                        <option value="sedikit">Stok Sedikit (&lt; 10)</option>
                        <option value="habis">Stok Habis</option>
                    </select>
                </div>
            </div>

            <!-- Chip Filter Kategori -->
            <div class="flex flex-wrap gap-2 mb-4" id="chipKategori">
                <!-- dirender via JS -->
            </div>

            <!-- Grid Card Produk -->
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5" id="produkList">
                <!-- Card dirender via JS -->
            </div>

            <!-- Pagination -->
            <div class="flex flex-col items-center justify-center gap-4 mt-8 sm:flex-row" id="pagination">
                <button id="prevPage"
                    class="flex items-center px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-green-50 hover:border-green-300 hover:text-green-700 transition-all disabled:opacity-50 disabled:hover:bg-white disabled:hover:border-gray-300 disabled:cursor-not-allowed">
                    <i class="mr-2 text-xs fas fa-chevron-left"></i> Prev
                </button>
                <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-3" id="pageNumbers"></div>
                <button id="nextPage"
                    class="flex items-center px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-green-50 hover:border-green-300 hover:text-green-700 transition-all disabled:opacity-50 disabled:hover:bg-white disabled:hover:border-gray-300 disabled:cursor-not-allowed">
                    Next <i class="ml-2 text-xs fas fa-chevron-right"></i>
                </button>
            </div>
        </div>

        <!-- Kanan: Keranjang Belanja -->
        <div
            class="lg:fixed lg:top-20 lg:right-0 lg:bottom-14 lg:w-[420px] lg:max-w-md w-full bg-white border-t lg:border-l border-gray-300 overflow-hidden flex flex-col z-20 lg:shadow-xl mt-auto lg:mt-0">
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

                <!-- Isi Keranjang -->
                <div id="keranjangList"
                    class="flex flex-col flex-grow gap-3 pb-4 pr-2 overflow-y-auto lg:gap-4 lg:pb-6 custom-scrollbar">
                    <div class="flex items-center justify-center flex-1 py-8 text-center text-gray-500 lg:py-10">
                        Belum ada produk di keranjang
                    </div>
                </div>

                <!-- Total & Pembayaran -->
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
                            class="flex-1 py-2.5 lg:py-3 text-white transition-all bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed">
                            <i class="mr-2 fas fa-trash-alt"></i> Clear Keranjang
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let keranjang = [];
        const itemsPerPage = 10;
        let currentPage = 1;
        let allProducts = [];
        let filteredProducts = [];
        let selectedKategori = ['semua'];

        // LOAD PRODUK DARI DATABASE
        function loadProduk() {
            const search = document.getElementById('searchProduk').value.trim();
            const stokFilter = document.getElementById('filterStok').value;

            const params = new URLSearchParams({
                search,
                stok_filter: stokFilter
            });

            fetch(`{{ route('kasir.transaksi.get_produk') }}?${params}`)
                .then(res => res.json())
                .then(response => {
                    allProducts = response;
                    renderChipKategori(allProducts);
                    applyFilters();
                })
                .catch(() => {
                    Swal.fire('Error', 'Gagal memuat daftar produk', 'error');
                });
        }

        function applyFilters() {
            const searchTerm = document.getElementById('searchProduk').value.toLowerCase().trim();
            const stokFilter = document.getElementById('filterStok').value;

            filteredProducts = allProducts.filter(product => {
                const nama = product.nama.toLowerCase();
                const barcode = (product.barcode || '').toLowerCase();
                const stok = product.stok;

                const matchSearch = nama.includes(searchTerm) || barcode.includes(searchTerm);

                let matchStok = true;
                if (stokFilter === 'tersedia') matchStok = stok > 0;
                if (stokFilter === 'sedikit') matchStok = stok > 0 && stok < 10;
                if (stokFilter === 'habis') matchStok = stok === 0;

                // === LOGIC MULTI KATEGORI (OR) ===
                const matchKategori = selectedKategori.includes('semua') ||
                    selectedKategori.includes(String(product.kategori_id));

                return matchSearch && matchStok && matchKategori;
            });

            currentPage = 1;
            renderProducts(currentPage);
        }

        function renderChipKategori(products) {
            const container = document.getElementById('chipKategori');
            const kategoriMap = {};

            products.forEach(p => {
                if (!kategoriMap[p.kategori_id]) {
                    kategoriMap[p.kategori_id] = p.kategori_nama;
                }
            });

            container.innerHTML = '';

            // Chip "Semua"
            container.appendChild(buatChip('semua', 'Semua', selectedKategori.includes('semua')));

            // Chip kategori lainnya
            Object.entries(kategoriMap).forEach(([id, nama]) => {
                container.appendChild(buatChip(id, nama, selectedKategori.includes(id)));
            });
        }

        function buatChip(id, label, active) {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.textContent = label;

            btn.className = active ?
                'px-4 py-2 text-sm font-semibold rounded-full border-2 border-green-500 bg-green-500 text-white transition-all shadow-sm' :
                'px-4 py-2 text-sm font-semibold rounded-full border-2 border-gray-200 bg-white text-gray-600 hover:border-green-400 hover:text-green-600 transition-all';

            btn.addEventListener('click', () => {
                if (id === 'semua') {
                    selectedKategori = ['semua'];
                } else {
                    // Hapus 'semua' jika ada
                    if (selectedKategori.includes('semua')) {
                        selectedKategori = [];
                    }

                    if (selectedKategori.includes(id)) {
                        // Unselect kategori ini
                        selectedKategori = selectedKategori.filter(k => k !== id);
                    } else {
                        // Select kategori ini
                        selectedKategori.push(id);
                    }

                    // Jika tidak ada kategori yang dipilih, kembali ke 'semua'
                    if (selectedKategori.length === 0) {
                        selectedKategori = ['semua'];
                    }
                }

                renderChipKategori(allProducts);
                applyFilters();
            });

            return btn;
        }

        // RENDER PRODUK
        function renderProducts(page = 1) {
            const container = document.getElementById('produkList');
            container.innerHTML = '';

            const start = (page - 1) * itemsPerPage;
            const end = start + itemsPerPage;
            const paginated = filteredProducts.slice(start, end);

            if (paginated.length === 0) {
                container.innerHTML =
                    `<div class="py-12 text-center text-gray-500 col-span-full">Tidak ada produk yang sesuai</div>`;
                renderPagination(page);
                return;
            }

            paginated.forEach(product => {
                const stokClass = product.stok > 10 ? 'stok-tersedia' : product.stok > 0 ? 'stok-sedikit' :
                    'stok-habis opacity-60';
                const stokText = product.stok > 0 ? `${product.stok}` : 'Habis';
                const stokColor = product.stok > 10 ? 'text-green-600' : product.stok > 0 ? 'text-yellow-600' :
                    'text-red-600';

                const card = document.createElement('div');
                card.className =
                    `overflow-hidden transition-all bg-white border border-gray-200 rounded-lg shadow-sm cursor-pointer card-hover group ${stokClass}`;
                card.dataset.produkId = product.id;
                card.dataset.nama = product.nama;
                card.dataset.harga = product.harga;
                card.dataset.satuan = product.satuan;
                card.dataset.barcode = product.barcode;
                card.dataset.stok = product.stok;

                card.innerHTML = `
                <div class="relative">
                    <img src="${product.img}" alt="${product.nama}"
                        class="object-cover w-full transition-transform duration-300 h-44 group-hover:scale-105">
                    ${product.ada_kadaluarsa ? `
                                                                <span class="absolute top-2 left-2 px-2 py-0.5 text-xs font-bold text-white bg-red-500 rounded-full">
                                                                    <i class="mr-1 fas fa-exclamation-circle"></i>Kadaluarsa
                                                                </span>` : ''}

                </div>
                <div class="p-4">
                    <h4 class="text-sm font-semibold text-gray-800 transition-colors line-clamp-2 group-hover:text-green-700">
                        ${product.nama}
                    </h4>
                    <p class="mt-1 text-xs text-gray-500">${product.barcode ?? '-'}</p>
                    <p class="mt-1 text-xs font-medium">Stok: <span class="font-bold ${stokColor}">${stokText}</span></p>
                    <p class="mt-2 font-bold text-green-600">Rp ${Number(product.harga).toLocaleString('id-ID')}</p>
                </div>
            `;

                container.appendChild(card);
            });

            renderPagination(page);
            attachProductClick();
        }

        // PAGINATION
        function renderPagination(page) {
            const totalPages = Math.ceil(filteredProducts.length / itemsPerPage);
            const container = document.getElementById('pageNumbers');
            container.innerHTML = '';

            const maxVisible = 5;
            let start = Math.max(1, page - Math.floor(maxVisible / 2));
            let end = Math.min(totalPages, start + maxVisible - 1);
            if (end - start + 1 < maxVisible) start = Math.max(1, end - maxVisible + 1);

            if (start > 1) {
                container.appendChild(createPageButton(1, page === 1));
                if (start > 2) container.appendChild(createEllipsis());
            }
            for (let i = start; i <= end; i++) {
                container.appendChild(createPageButton(i, page === i));
            }
            if (end < totalPages) {
                if (end < totalPages - 1) container.appendChild(createEllipsis());
                container.appendChild(createPageButton(totalPages, page === totalPages));
            }

            document.getElementById('prevPage').disabled = page === 1;
            document.getElementById('nextPage').disabled = page === totalPages || totalPages === 0;
        }

        function createPageButton(num, active) {
            const btn = document.createElement('button');
            btn.className = `px-3.5 py-2 text-sm font-medium rounded-lg transition-all ${
                active
                    ? 'bg-green-600 text-white shadow-sm'
                    : 'bg-white border border-gray-300 text-gray-700 hover:bg-green-50 hover:border-green-300 hover:text-green-700'
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

        // Attach click ke setiap card produk
        function attachProductClick() {
            document.querySelectorAll('#produkList .card-hover').forEach(card => {
                card.addEventListener('click', () => {
                    const stok = parseInt(card.dataset.stok) || 0;
                    if (stok <= 0) {
                        Swal.fire({
                            title: 'Stok Habis!',
                            text: 'Produk ini tidak tersedia.',
                            icon: 'warning',
                            confirmButtonColor: '#22C55E'
                        });
                        return;
                    }

                    const existing = keranjang.find(item => item.barcode === card.dataset.barcode);

                    if (existing) {
                        if (existing.qty + 1 > stok) {
                            Swal.fire({
                                title: 'Stok Tidak Cukup!',
                                text: `Hanya tersisa ${stok}`,
                                icon: 'warning',
                                confirmButtonColor: '#22C55E'
                            });
                            return;
                        }
                        existing.qty += 1;
                    } else {
                        keranjang.push({
                            produk_id: card.dataset.produkId,
                            nama: card.dataset.nama,
                            harga: parseInt(card.dataset.harga),
                            satuan: card.dataset.satuan,
                            barcode: card.dataset.barcode,
                            qty: 1,
                            stok: stok
                        });
                    }

                    renderKeranjang();
                });
            });
        }

        // Pagination Prev/Next
        document.getElementById('prevPage').addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                renderProducts(currentPage);
            }
        });

        document.getElementById('nextPage').addEventListener('click', () => {
            const totalPages = Math.ceil(filteredProducts.length / itemsPerPage);
            if (currentPage < totalPages) {
                currentPage++;
                renderProducts(currentPage);
            }
        });

        // Search & Filter
        document.getElementById('searchProduk').addEventListener('input', applyFilters);
        document.getElementById('filterStok').addEventListener('change', applyFilters);

        // KERANJANG
        function renderKeranjang() {
            const container = document.getElementById('keranjangList');
            container.innerHTML = '';

            document.getElementById('jumlahItem').textContent = `(${keranjang.length} item)`;

            if (keranjang.length === 0) {
                container.innerHTML =
                    `<div class="flex items-center justify-center flex-1 py-10 text-center text-gray-500">Belum ada produk di keranjang</div>`;
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
                        <p class="text-sm text-gray-600">Rp ${item.harga.toLocaleString('id-ID')}</p>
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
                    text: `Hanya tersisa ${item.stok}`,
                    icon: 'warning',
                    confirmButtonColor: '#22C55E'
                });
                return;
            }
            item.qty += 1;
            renderKeranjang();
        };

        window.kurangiQty = function(index) {
            if (keranjang[index].qty > 1) {
                keranjang[index].qty -= 1;
            } else {
                keranjang.splice(index, 1);
            }
            renderKeranjang();
        };

        function hitungTotal() {
            const total = keranjang.reduce((sum, item) => sum + item.harga * item.qty, 0);
            document.getElementById('totalHarga').textContent = 'Rp ' + total.toLocaleString('id-ID');

            const bayar = parseInt(document.getElementById('uangBayar').value) || 0;
            const kembalian = bayar - total;

            document.getElementById('kembalian').textContent = kembalian >= 0 ?
                'Rp ' + kembalian.toLocaleString('id-ID') :
                'Rp 0';

            document.getElementById('btnBayar').disabled = (total === 0 || bayar < total);
        }

        document.getElementById('uangBayar').addEventListener('input', hitungTotal);

        // TOMBOL CLEAR
        document.getElementById('btnClear').addEventListener('click', () => {
            Swal.fire({
                title: 'Clear Keranjang?',
                text: 'Semua item akan dihapus. Lanjutkan?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#22C55E',
                confirmButtonText: 'Ya, Clear',
                cancelButtonText: 'Batal'
            }).then(result => {
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

        // TOMBOL BAYAR
        document.getElementById('btnBayar').addEventListener('click', () => {
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

            // Tabel review item
            let itemList = `<table class="w-full mt-4 text-sm text-left border-collapse">
                <thead><tr class="border-b">
                    <th class="pb-1">Produk</th>
                    <th class="pb-1 text-center">Qty</th>
                    <th class="pb-1 text-right">Subtotal</th>
                </tr></thead><tbody>`;
            keranjang.forEach(item => {
                itemList += `<tr>
                    <td class="py-1">${item.nama}</td>
                    <td class="py-1 text-center">${item.qty}</td>
                    <td class="py-1 text-right">Rp ${(item.harga * item.qty).toLocaleString('id-ID')}</td>
                </tr>`;
            });
            itemList += `</tbody></table>`;

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
            }).then(result => {
                if (result.isConfirmed) {
                    fetch("{{ route('kasir.transaksi.proses_bayar') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                keranjang: keranjang,
                                total_harga: total,
                                uang_bayar: bayar,
                                nama_pelanggan: namaPelanggan
                            })
                        })
                        .then(res => res.json())
                        .then(res => {
                            if (res.success) {
                                Swal.fire({
                                    title: 'Transaksi Berhasil!',
                                    text: `Nomor: ${res.nomor_unik}`,
                                    icon: 'success',
                                    timer: 1800,
                                    showConfirmButton: false
                                }).then(() => {
                                    window.location.href =
                                        "{{ route('kasir.struk', ['id' => ':id']) }}"
                                        .replace(':id', res.transaksi_id);
                                });
                            } else {
                                Swal.fire('Gagal', res.message || 'Terjadi kesalahan', 'error');
                            }
                        })
                        .catch(() => {
                            Swal.fire('Gagal', 'Terjadi kesalahan saat menyimpan transaksi', 'error');
                        });
                }
            });
        });

        // INIT
        document.addEventListener('DOMContentLoaded', function() {
            loadProduk();
        });
    </script>
@endpush
