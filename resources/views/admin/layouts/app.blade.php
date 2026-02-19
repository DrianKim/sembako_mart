<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Dashboard Admin') - Sembako Mart</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo_toko_sembako.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts - Source Sans Pro -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600;700;800&display=swap"
        rel="stylesheet">

    @vite('resources/css/app.css')

    <style>
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #22C55E 0%, #10B981 100%);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #16A34A 0%, #059669 100%);
        }

        /* Gradient Text */
        .gradient-text {
            background: linear-gradient(90deg, #EB661B 0%, #22C55E 20%, #10B981 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Sidebar Transition */
        .sidebar-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Active Nav Item */
        .nav-item-active {
            background: linear-gradient(90deg, rgba(34, 197, 94, 0.1) 0%, rgba(16, 185, 129, 0.1) 100%);
            border-left: 4px solid #22C55E;
        }

        /* Hover Effect */
        .nav-item {
            transition: all 0.2s ease;
        }

        .nav-item:hover {
            background: linear-gradient(90deg, rgba(34, 197, 94, 0.05) 0%, rgba(16, 185, 129, 0.05) 100%);
            transform: translateX(4px);
        }

        /* Dropdown Animation */
        .dropdown-menu {
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Card Hover Effect */
        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Loading Spinner */
        .spinner {
            border: 3px solid #f3f4f6;
            border-top: 3px solid #22C55E;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Badge Pulse */
        .badge-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: .7;
            }
        }
    </style>

    @stack('styles')
</head>

<body class="font-sans bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside id="sidebar"
            class="fixed inset-y-0 left-0 z-50 flex flex-col w-64 transform -translate-x-full bg-white border-r border-gray-200 shadow-lg sidebar-transition lg:translate-x-0 lg:static lg:inset-0">
            <!-- Logo Section - Fixed at top -->
            <div
                class="flex items-center justify-between flex-shrink-0 h-20 px-6 border-b border-gray-200 bg-gradient-to-r from-green-50 to-white">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('img/logo_toko_sembako.png') }}" alt="Logo Sembako Mart"
                        class="w-12 h-12 rounded-lg shadow-md">
                    <div>
                        <h1 class="text-xl font-bold">
                            <span style="color: #EB661B;">S</span><span class="gradient-text">Mart</span>
                        </h1>
                        <p class="text-xs text-gray-600">Admin Panel</p>
                    </div>
                </div>
                <!-- Mobile Close Button -->
                <button id="close-sidebar" class="text-gray-500 lg:hidden hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Navigation Menu - Scrollable -->
            <nav class="flex-1 px-4 py-6 overflow-x-hidden overflow-y-auto">
                <div class="space-y-2">
                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center px-4 py-3 text-gray-700 rounded-lg nav-item {{ request()->routeIs('admin.dashboard') ? 'nav-item-active' : '' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.dashboard') ? 'text-green-600' : 'text-gray-500' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span class="font-semibold">Dashboard</span>
                    </a>

                    <!-- Divider -->
                    <div class="pt-4 pb-2">
                        <p class="px-4 text-xs font-semibold tracking-wider text-gray-400 uppercase">Manajemen Produk
                        </p>
                    </div>

                    <!-- Kategori Produk -->
                    <a href="{{ route('admin.kategori') }}"
                        class="flex items-center px-4 py-3 text-gray-700 rounded-lg nav-item {{ request()->routeIs('admin.kategori*') ? 'nav-item-active' : '' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.kategori*') ? 'text-green-600' : 'text-gray-500' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        <span class="font-semibold">Kategori Produk</span>
                    </a>

                    <!-- Data Produk -->
                    <a href="{{ route('admin.produk') }}"
                        class="flex items-center px-4 py-3 text-gray-700 rounded-lg nav-item {{ request()->routeIs('admin.produk*') ? 'nav-item-active' : '' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.produk*') ? 'text-green-600' : 'text-gray-500' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        <span class="font-semibold">Data Produk</span>
                    </a>

                    <!-- Stok Produk -->
                    <a href="{{ route('admin.stok') }}"
                        class="flex items-center px-4 py-3 text-gray-700 rounded-lg nav-item {{ request()->routeIs('admin.stok*') ? 'nav-item-active' : '' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.stok*') ? 'text-green-600' : 'text-gray-500' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        <span class="font-semibold">Stok Produk</span>
                    </a>

                    <!-- Divider -->
                    <div class="pt-4 pb-2">
                        <p class="px-4 text-xs font-semibold tracking-wider text-gray-400 uppercase">Transaksi</p>
                    </div>

                    <!-- Penjualan -->
                    <a href="#" class="flex items-center px-4 py-3 text-gray-700 rounded-lg nav-item">
                        <svg class="w-5 h-5 mr-3 text-gray-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span class="font-semibold">Penjualan</span>
                    </a>

                    <!-- Riwayat Transaksi -->
                    <a href="#" class="flex items-center px-4 py-3 text-gray-700 rounded-lg nav-item">
                        <svg class="w-5 h-5 mr-3 text-gray-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                        <span class="font-semibold">Riwayat Transaksi</span>
                    </a>

                    <!-- Divider -->
                    <div class="pt-4 pb-2">
                        <p class="px-4 text-xs font-semibold tracking-wider text-gray-400 uppercase">Keuangan</p>
                    </div>

                    <!-- Laporan Keuangan -->
                    <a href="#" class="flex items-center px-4 py-3 text-gray-700 rounded-lg nav-item">
                        <svg class="w-5 h-5 mr-3 text-gray-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        <span class="font-semibold">Laporan Keuangan</span>
                    </a>

                    <!-- Pengeluaran -->
                    <a href="#" class="flex items-center px-4 py-3 text-gray-700 rounded-lg nav-item">
                        <svg class="w-5 h-5 mr-3 text-gray-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-semibold">Pengeluaran</span>
                    </a>

                    <!-- Divider -->
                    <div class="pt-4 pb-2">
                        <p class="px-4 text-xs font-semibold tracking-wider text-gray-400 uppercase">Pelanggan</p>
                    </div>

                    <!-- Data Pelanggan -->
                    <a href="#" class="flex items-center px-4 py-3 text-gray-700 rounded-lg nav-item">
                        <svg class="w-5 h-5 mr-3 text-gray-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span class="font-semibold">Data Pelanggan</span>
                    </a>

                    <!-- Divider -->
                    <div class="pt-4 pb-2">
                        <p class="px-4 text-xs font-semibold tracking-wider text-gray-400 uppercase">Pengaturan</p>
                    </div>

                    <!-- User & Akses -->
                    <a href="#" class="flex items-center px-4 py-3 text-gray-700 rounded-lg nav-item">
                        <svg class="w-5 h-5 mr-3 text-gray-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span class="font-semibold">User & Akses</span>
                    </a>

                    <!-- Profil Toko -->
                    <a href="#" class="flex items-center px-4 py-3 text-gray-700 rounded-lg nav-item">
                        <svg class="w-5 h-5 mr-3 text-gray-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <span class="font-semibold">Profil Toko</span>
                    </a>
                </div>

                <!-- Logout Button -->
                <div class="pt-6 mt-6 border-t border-gray-200">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="flex items-center w-full px-4 py-3 text-red-600 transition-all duration-200 rounded-lg nav-item hover:bg-red-50">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span class="font-semibold">Logout</span>
                        </button>
                    </form>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Top Navbar -->
            <header class="bg-white border-b border-gray-200 shadow-sm">
                <div class="flex items-center justify-between h-20 px-6">
                    <!-- Left Section -->
                    <div class="flex items-center space-x-4">
                        <!-- Mobile Menu Button -->
                        <button id="mobile-menu-btn"
                            class="text-gray-500 lg:hidden hover:text-gray-700 focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>

                        <!-- Breadcrumb -->
                        <div class="hidden md:block">
                            <h2 class="text-2xl font-bold text-gray-800">@yield('title', 'Dashboard')</h2>
                            <p class="text-sm text-gray-600">@yield('page-description', 'Selamat datang di panel admin Sembako Mart')</p>
                        </div>
                    </div>

                    <!-- Right Section -->
                    <div class="flex items-center space-x-4">
                        <!-- Notifications -->
                        <div class="relative">
                            <button id="notification-btn"
                                class="relative p-2 text-gray-500 transition-colors rounded-lg hover:bg-gray-100 hover:text-gray-700">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                <span
                                    class="absolute top-0 right-0 flex w-3 h-3 bg-red-500 rounded-full badge-pulse"></span>
                            </button>

                            <!-- Notification Dropdown -->
                            <div id="notification-dropdown"
                                class="absolute right-0 z-50 hidden mt-2 bg-white border border-gray-200 rounded-lg shadow-xl w-80 dropdown-menu">
                                <div class="p-4 border-b border-gray-200">
                                    <h3 class="font-semibold text-gray-800">Notifikasi</h3>
                                </div>
                                <div class="overflow-y-auto max-h-96">
                                    <!-- Notification Items -->
                                    <a href="#" class="flex items-start p-4 transition-colors hover:bg-gray-50">
                                        <div
                                            class="flex items-center justify-center flex-shrink-0 w-10 h-10 mr-3 bg-green-100 rounded-full">
                                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-semibold text-gray-800">Stok Produk Menipis</p>
                                            <p class="text-xs text-gray-600">Beras Premium stok tinggal 5 karung</p>
                                            <p class="mt-1 text-xs text-gray-400">5 menit yang lalu</p>
                                        </div>
                                    </a>
                                    <a href="#" class="flex items-start p-4 transition-colors hover:bg-gray-50">
                                        <div
                                            class="flex items-center justify-center flex-shrink-0 w-10 h-10 mr-3 bg-orange-100 rounded-full">
                                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-semibold text-gray-800">Transaksi Pending</p>
                                            <p class="text-xs text-gray-600">Ada 3 transaksi menunggu konfirmasi</p>
                                            <p class="mt-1 text-xs text-gray-400">1 jam yang lalu</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="p-3 text-center border-t border-gray-200">
                                    <a href="#"
                                        class="text-sm font-semibold text-green-600 hover:text-green-700">Lihat
                                        Semua</a>
                                </div>
                            </div>
                        </div>

                        <!-- User Profile -->
                        <div class="relative">
                            <button id="profile-btn"
                                class="flex items-center p-2 space-x-3 transition-all rounded-lg hover:bg-gray-100">
                                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'Admin' }}&background=22C55E&color=fff&bold=true"
                                    alt="Profile" class="w-10 h-10 border-2 border-green-500 rounded-full">
                                <div class="hidden text-left md:block">
                                    <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name ?? 'Admin' }}
                                    </p>
                                    <p class="text-xs text-gray-600">Administrator</p>
                                </div>
                                <svg class="hidden w-4 h-4 text-gray-500 md:block" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Profile Dropdown -->
                            <div id="profile-dropdown"
                                class="absolute right-0 z-50 hidden w-56 mt-2 bg-white border border-gray-200 rounded-lg shadow-xl dropdown-menu">
                                <div class="p-4 border-b border-gray-200">
                                    <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name ?? 'Admin' }}
                                    </p>
                                    <p class="text-xs text-gray-600">
                                        {{ Auth::user()->email ?? 'admin@sembakomart.com' }}</p>
                                </div>
                                <div class="py-2">
                                    <a href="#"
                                        class="flex items-center px-4 py-2 text-sm text-gray-700 transition-colors hover:bg-gray-100">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Profil Saya
                                    </a>
                                    <a href="#"
                                        class="flex items-center px-4 py-2 text-sm text-gray-700 transition-colors hover:bg-gray-100">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Pengaturan
                                    </a>
                                </div>
                                <div class="border-t border-gray-200">
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="flex items-center w-full px-4 py-2 text-sm text-red-600 transition-colors hover:bg-red-50">
                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50">
                <div class="container px-6 py-8 mx-auto">
                    @yield('content')
                </div>
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200">
                <div class="px-6 py-4">
                    <div class="flex flex-col items-center justify-between space-y-2 md:flex-row md:space-y-0">
                        <p class="text-gray-600 text-l">
                            Made with <i class="text-red-500 fas fa-heart"></i> by <span
                                class="font-semibold">𝓟</span>
                        </p>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Overlay for Mobile -->
    <div id="sidebar-overlay" class="fixed inset-0 z-40 hidden bg-black bg-opacity-50 lg:hidden"></div>

    <!-- Scripts -->
    <script>
        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');
        const closeSidebar = document.getElementById('close-sidebar');

        mobileMenuBtn?.addEventListener('click', () => {
            sidebar.classList.remove('-translate-x-full');
            sidebarOverlay.classList.remove('hidden');
        });

        closeSidebar?.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
        });

        sidebarOverlay?.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
        });

        // Notification Dropdown
        const notificationBtn = document.getElementById('notification-btn');
        const notificationDropdown = document.getElementById('notification-dropdown');

        // Profile Dropdown
        const profileBtn = document.getElementById('profile-btn');
        const profileDropdown = document.getElementById('profile-dropdown');

        notificationBtn?.addEventListener('click', (e) => {
            e.stopPropagation();
            notificationDropdown.classList.toggle('hidden');
            profileDropdown.classList.add('hidden');
        });

        profileBtn?.addEventListener('click', (e) => {
            e.stopPropagation();
            profileDropdown.classList.toggle('hidden');
            notificationDropdown.classList.add('hidden');
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', () => {
            notificationDropdown?.classList.add('hidden');
            profileDropdown?.classList.add('hidden');
        });
    </script>

    @stack('scripts')
</body>

</html>
