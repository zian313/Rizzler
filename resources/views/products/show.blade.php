@extends('layout')

@section('title', $product->name)

@section('content')
<div style="padding-top: 120px; padding-bottom: 3rem;">
  <div style="max-width: 1000px; margin: 0 auto; padding: 0 1rem;">
    
    <!-- Breadcrumb -->
    <nav style="margin-bottom: 2rem;">
      <a href="{{ route('home') }}" style="color: #1e09e2; text-decoration: none; font-weight: 500;">Beranda</a>
      <span style="margin: 0 0.5rem; color: #999;">/</span>
      <a href="{{ route('products.index') }}" style="color: #1e09e2; text-decoration: none; font-weight: 500;">Produk</a>
      <span style="margin: 0 0.5rem; color: #999;">/</span>
      <span style="color: #666;">{{ $product->name }}</span>
    </nav>

    <div style="background: white; border-radius: 0.5rem; box-shadow: 0 2px 10px rgba(30, 9, 226, 0.1); padding: 2rem;">
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
        
        <!-- Gambar Produk -->
        <div>
          @if ($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100%; border-radius: 0.5rem; object-fit: cover; max-height: 400px;">
          @else
            <div style="width: 100%; height: 400px; background-color: #f8f9fa; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; color: #999; font-size: 1rem;">
              Tidak ada gambar
            </div>
          @endif
        </div>

        <!-- Info Produk -->
        <div>
          <div style="margin-bottom: 1.5rem;">
            <span style="background-color: #e7f3ff; color: #1e09e2; padding: 0.5rem 1rem; border-radius: 0.3rem; font-size: 0.9rem; font-weight: 600; display: inline-block;">
              {{ $product->category->name }}
            </span>
          </div>

          <h1 style="font-size: 2rem; font-weight: 700; color: #000; margin-bottom: 1rem; line-height: 1.3;">
            {{ $product->name }}
          </h1>

          <div style="margin-bottom: 2rem; padding-bottom: 2rem; border-bottom: 1px solid #eee;">
            <p style="font-size: 2.5rem; font-weight: 700; color: #1e09e2; margin: 0;">
              Rp {{ number_format($product->price, 0, ',', '.') }}
            </p>
            <p style="color: #999; font-size: 0.9rem; margin-top: 0.5rem;">Harga terakhir diperbarui</p>
          </div>

          <div style="margin-bottom: 2rem;">
            <h3 style="font-weight: 600; color: #000; margin-bottom: 0.5rem;">Stok Tersedia:</h3>
            <p style="font-size: 1.3rem; font-weight: 600; color: {{ $product->stock > 0 ? '#28a745' : '#dc3545' }};">
              {{ $product->stock > 0 ? $product->stock . ' pcs' : 'Stok Habis' }}
            </p>
          </div>

          @if ($product->stock > 0)
            <form method="POST" action="{{ route('cart.add', $product) }}" style="margin-bottom: 1.5rem;">
              @csrf
              <div style="display: flex; gap: 1rem; margin-bottom: 1rem;">
                <input type="number" name="quantity" min="1" max="{{ $product->stock }}" value="1"
                       style="width: 80px; padding: 0.75rem; border: 1px solid #ddd; border-radius: 0.3rem; font-size: 1rem; font-family: 'Poppins', sans-serif;">
                <button type="submit" 
                        style="flex: 1; padding: 0.75rem; background-color: #1e09e2; color: white; border: none; border-radius: 0.3rem; font-weight: 600; cursor: pointer; transition: 0.3s; font-family: 'Poppins', sans-serif;"
                        onmouseover="this.style.backgroundColor='#1a07b8'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 5px 15px rgba(30, 9, 226, 0.3)'"
                        onmouseout="this.style.backgroundColor='#1e09e2'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                  Tambah ke Keranjang
                </button>
              </div>
            </form>
          @endif

          <div style="display: flex; gap: 1rem;">
            
            </form>
          </div>
        </div>
      </div>

      <!-- Deskripsi Produk -->
      @if ($product->description)
        <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #eee;">
          <h2 style="font-size: 1.5rem; font-weight: 700; color: #000; margin-bottom: 1rem;">Deskripsi Produk</h2>
          <p style="color: #666; line-height: 1.8; white-space: pre-wrap;">{{ $product->description }}</p>
        </div>
      @endif

      <!-- Info Tambahan -->
      <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #eee;">
        <h2 style="font-size: 1.5rem; font-weight: 700; color: #000; margin-bottom: 1rem;">Informasi Produk</h2>
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem;">
          <div>
            <p style="font-weight: 600; color: #000; margin-bottom: 0.25rem;">Kategori</p>
            <p style="color: #666;">{{ $product->category->name }}</p>
          </div>
          <div>
            <p style="font-weight: 600; color: #000; margin-bottom: 0.25rem;">Status</p>
            <p style="color: #666;">{{ $product->stock > 0 ? 'Tersedia' : 'Tidak Tersedia' }}</p>
          </div>
          <div>
            <p style="font-weight: 600; color: #000; margin-bottom: 0.25rem;">Ditambahkan</p>
            <p style="color: #666;">{{ $product->created_at->format('d/m/Y H:i') }}</p>
          </div>
          <div>
            <p style="font-weight: 600; color: #000; margin-bottom: 0.25rem;">Terakhir Diperbarui</p>
            <p style="color: #666;">{{ $product->updated_at->format('d/m/Y H:i') }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Back Button -->
    <div style="margin-top: 2rem;">
      <a href="{{ route('products.index') }}" 
         style="color: #1e09e2; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: 0.3s;"
         onmouseover="this.style.transform='translateX(-5px)'"
         onmouseout="this.style.transform='translateX(0)'">
        ← Kembali ke Daftar Produk
      </a>
    </div>
  </div>
</div>

<script>
  feather.replace();
</script>
@endsection
