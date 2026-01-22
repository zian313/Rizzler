@extends('layout')

@section('content')
<div style="max-width: 1200px; margin: 2rem auto; padding: 0 1rem;">
    <h1 style="text-align: center; margin-bottom: 2rem; color: #333;">📊 Dashboard Admin</h1>

    <!-- Stats Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        <!-- Total Products -->
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 1.5rem; border-radius: 0.5rem; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <div style="font-size: 0.875rem; opacity: 0.9; margin-bottom: 0.5rem;">Total Produk</div>
            <div style="font-size: 2rem; font-weight: bold;">{{ $totalProducts }}</div>
            <div style="font-size: 0.875rem; margin-top: 0.5rem; opacity: 0.8;">Produk aktif di sistem</div>
        </div>

        <!-- Total Categories -->
        <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; padding: 1.5rem; border-radius: 0.5rem; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <div style="font-size: 0.875rem; opacity: 0.9; margin-bottom: 0.5rem;">Total Kategori</div>
            <div style="font-size: 2rem; font-weight: bold;">{{ $totalCategories }}</div>
            <div style="font-size: 0.875rem; margin-top: 0.5rem; opacity: 0.8;">Kategori tersedia</div>
        </div>

        <!-- Total Orders -->
        <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 1.5rem; border-radius: 0.5rem; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <div style="font-size: 0.875rem; opacity: 0.9; margin-bottom: 0.5rem;">Total Pesanan</div>
            <div style="font-size: 2rem; font-weight: bold;">{{ $totalOrders }}</div>
            <div style="font-size: 0.875rem; margin-top: 0.5rem; opacity: 0.8;">Pesanan dari pembeli</div>
        </div>

        <!-- Total Users (Pembeli) -->
        <div style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; padding: 1.5rem; border-radius: 0.5rem; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <div style="font-size: 0.875rem; opacity: 0.9; margin-bottom: 0.5rem;">Total Pembeli</div>
            <div style="font-size: 2rem; font-weight: bold;">{{ $totalUsers }}</div>
            <div style="font-size: 0.875rem; margin-top: 0.5rem; opacity: 0.8;">User terdaftar</div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div style="background: white; padding: 1.5rem; border-radius: 0.5rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <h2 style="margin-top: 0; margin-bottom: 1.5rem; color: #333;">🚀 Aksi Cepat</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
            <a href="{{ route('categories.create') }}" style="display: inline-block; padding: 1rem; background-color: #f093fb; color: white; text-align: center; border-radius: 0.5rem; text-decoration: none; transition: 0.3s; cursor: pointer;" onmouseover="this.style.backgroundColor='#f5576c'" onmouseout="this.style.backgroundColor='#f093fb'">
                ➕ Tambah Kategori
            </a>
            <a href="{{ route('products.create') }}" style="display: inline-block; padding: 1rem; background-color: #667eea; color: white; text-align: center; border-radius: 0.5rem; text-decoration: none; transition: 0.3s; cursor: pointer;" onmouseover="this.style.backgroundColor='#764ba2'" onmouseout="this.style.backgroundColor='#667eea'">
                ➕ Tambah Produk
            </a>
            <a href="{{ route('categories.index') }}" style="display: inline-block; padding: 1rem; background-color: #4facfe; color: white; text-align: center; border-radius: 0.5rem; text-decoration: none; transition: 0.3s; cursor: pointer;" onmouseover="this.style.backgroundColor='#00f2fe'" onmouseout="this.style.backgroundColor='#4facfe'">
                📂 Kelola Kategori
            </a>
            <a href="{{ route('products.index') }}" style="display: inline-block; padding: 1rem; background-color: #43e97b; color: white; text-align: center; border-radius: 0.5rem; text-decoration: none; transition: 0.3s; cursor: pointer;" onmouseover="this.style.backgroundColor='#38f9d7'" onmouseout="this.style.backgroundColor='#43e97b'">
                📦 Kelola Produk
            </a>
        </div>
    </div>

    <!-- Info Section -->
    <div style="background: #f0f4ff; padding: 1.5rem; border-radius: 0.5rem; margin-top: 2rem; border-left: 4px solid #667eea;">
        <h3 style="margin-top: 0; color: #667eea;">ℹ️ Informasi</h3>
        <ul style="margin: 0; padding-left: 1.5rem; color: #555; line-height: 1.8;">
            <li>Anda saat ini login sebagai <strong>ADMIN</strong></li>
            <li>Hanya admin yang dapat mengelola kategori dan produk</li>
            <li>Pembeli dapat melakukan pembelian melalui keranjang belanja</li>
            <li>Dashboard ini hanya dapat diakses oleh admin</li>
        </ul>
    </div>
</div>
@endsection
