@extends('layout')

@section('title', 'Daftar Produk')

@section('content')
<div style="padding-top: 120px; padding-bottom: 3rem;">
  <div style="max-width: 1200px; margin: 0 auto; padding: 0 1rem;">
    
    <!-- Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
      <h1 style="font-size: 2rem; font-weight: 700; color: #000;">Daftar Produk</h1>
      @if (Auth::check())
        <a href="{{ route('products.create') }}" 
           style="background-color: #1e09e2; color: white; padding: 0.75rem 1.5rem; border-radius: 0.3rem; font-weight: 600; text-decoration: none; transition: 0.3s; display: inline-block;"
           onmouseover="this.style.backgroundColor='#1a07b8'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 5px 15px rgba(30, 9, 226, 0.3)'"
           onmouseout="this.style.backgroundColor='#1e09e2'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">
          + Tambah Produk
        </a>
      @endif
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
      <div style="background-color: #d4edda; color: #155724; padding: 1rem; border-radius: 0.3rem; margin-bottom: 1.5rem; border: 1px solid #c3e6cb; display: flex; justify-content: space-between; align-items: center;">
        <p style="margin: 0;">✓ {{ session('success') }}</p>
        <button onclick="this.parentElement.style.display='none'" style="background: none; border: none; color: #155724; cursor: pointer; font-size: 1.2rem;">×</button>
      </div>
    @endif

    <!-- Products Table -->
    @if ($products->count() > 0)
      <div style="background: white; border-radius: 0.5rem; box-shadow: 0 2px 10px rgba(30, 9, 226, 0.1); overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse;">
          <thead>
            <tr style="background-color: #f8f9fa; border-bottom: 2px solid #1e09e2;">
              <th style="padding: 1rem; text-align: left; font-weight: 600; color: #000;">Nama Produk</th>
              <th style="padding: 1rem; text-align: left; font-weight: 600; color: #000;">Kategori</th>
              <th style="padding: 1rem; text-align: right; font-weight: 600; color: #000;">Harga</th>
              <th style="padding: 1rem; text-align: center; font-weight: 600; color: #000;">Stok</th>
              <th style="padding: 1rem; text-align: center; font-weight: 600; color: #000;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($products as $product)
              <tr style="border-bottom: 1px solid #eee; transition: 0.3s;" onmouseover="this.style.backgroundColor='#f8f9fa'" onmouseout="this.style.backgroundColor='white'">
                <td style="padding: 1rem; color: #333;">
                  <div style="display: flex; align-items: center; gap: 0.75rem;">
                    @if ($product->image)
                      <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 40px; height: 40px; border-radius: 0.3rem; object-fit: cover;">
                    @else
                      <div style="width: 40px; height: 40px; background-color: #ddd; border-radius: 0.3rem; display: flex; align-items: center; justify-content: center; color: #999;">
                        No img
                      </div>
                    @endif
                    <div>
                      <p style="margin: 0; font-weight: 500;">{{ $product->name }}</p>
                      <p style="margin: 0; font-size: 0.85rem; color: #999;">{{ Str::limit($product->description, 30) }}</p>
                    </div>
                  </div>
                </td>
                <td style="padding: 1rem; color: #333;">
                  <span style="background-color: #e7f3ff; color: #1e09e2; padding: 0.3rem 0.8rem; border-radius: 0.2rem; font-size: 0.85rem; font-weight: 500;">
                    {{ $product->category->name }}
                  </span>
                </td>
                <td style="padding: 1rem; text-align: right; color: #333; font-weight: 600;">
                  Rp {{ number_format($product->price, 0, ',', '.') }}
                </td>
                <td style="padding: 1rem; text-align: center; color: #333;">
                  <span style="background-color: {{ $product->stock > 0 ? '#d4edda' : '#f8d7da' }}; color: {{ $product->stock > 0 ? '#155724' : '#721c24' }}; padding: 0.3rem 0.8rem; border-radius: 0.2rem; font-size: 0.85rem; font-weight: 500;">
                    {{ $product->stock }} pcs
                  </span>
                </td>
                <td style="padding: 1rem; text-align: center;">
                  <div style="display: flex; gap: 0.5rem; justify-content: center;">
                    <a href="{{ route('products.show', $product) }}" 
                       style="background-color: #0dcaf0; color: white; padding: 0.4rem 0.8rem; border-radius: 0.2rem; font-size: 0.85rem; text-decoration: none; transition: 0.3s; display: inline-block;"
                       onmouseover="this.style.backgroundColor='#0bb5e3'"
                       onmouseout="this.style.backgroundColor='#0dcaf0'">
                      Lihat
                    </a>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div style="margin-top: 2rem;">
        {{ $products->links() }}
      </div>
    @else
      <div style="background: white; padding: 3rem; text-align: center; border-radius: 0.5rem; box-shadow: 0 2px 10px rgba(30, 9, 226, 0.1);">
        <p style="font-size: 1.1rem; color: #999; margin-bottom: 1.5rem;">Belum ada produk. Mari tambahkan produk baru!</p>
        <a href="{{ route('products.create') }}" 
           style="background-color: #1e09e2; color: white; padding: 0.85rem 2rem; border-radius: 0.3rem; font-weight: 600; text-decoration: none; display: inline-block; transition: 0.3s;"
           onmouseover="this.style.backgroundColor='#1a07b8'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 5px 15px rgba(30, 9, 226, 0.3)'"
           onmouseout="this.style.backgroundColor='#1e09e2'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">
          Tambah Produk Pertama
        </a>
      </div>
    @endif
  </div>
</div></p>
        @if (Auth::check())
          <a href="{{ route('products.create') }}" 
             style="background-color: #1e09e2; color: white; padding: 0.85rem 2rem; border-radius: 0.3rem; font-weight: 600; text-decoration: none; display: inline-block; transition: 0.3s;"
             onmouseover="this.style.backgroundColor='#1a07b8'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 5px 15px rgba(30, 9, 226, 0.3)'"
             onmouseout="this.style.backgroundColor='#1e09e2'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">
            Tambah Produk Pertama
          </a>
        @endif