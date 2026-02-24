@extends('kasir.layouts.app')
@section('title', $title ?? 'Dashboard Kasir')

@section('content')
<h1 class="text-2xl font-bold text-gray-800">Dashboard Kasir</h1>
<p class="text-gray-600">Selamat datang, {{ Auth::user()->nama ?? 'Kasir' }}! Anda sedang berada di halaman dashboard kasir.</p>
@endsection
