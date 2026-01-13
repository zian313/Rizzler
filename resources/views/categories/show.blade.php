@extends('layout')

@section('title', $category->name)

@section('content')
<div style="padding-top: 120px; padding-bottom: 3rem;">
  <div style="max-width: 1000px; margin: 0 auto; padding: 0 1rem;">
    
    <!-- Breadcrumb -->
    <nav style="margin-bottom: 2rem;">
      <a href="{{ route('home') }}" style="color: #1e09e2; text-decoration: none; font-weight: 500;">Beranda</a>
      <span style="margin: 0 0.5rem; color: #999;">/</span>
      <a href="{{ route('categories.index') }}" style="color: #1e09e2; text-decoration: none; font-weight: 500;">Kategori</a>
      <span style="margin: 0 0.5rem; color: #999;">/</span>
      <span style="color: #666;">{{ $category->name }}</span>
    </nav>

    <div style="background: white; border-radius: 0.5rem; box-shadow: 0 2px 10px rgba(30, 9, 226, 0.1); padding: 2rem; margin-bottom: 2rem;">
      
      <!-- Header -->
      <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 2.5rem; font-weight: 700; color: #000; margin-bottom: 0.5rem;">{{ $category->name }}</h1>
        <p style="color: #999; font-size: 0.95rem;">{{ $category->products->count() }} Produk</p>
      </div>

      <!-- Deskripsi -->
      @if ($category->description)
        <div style="margin-bottom: 2rem; padding-bottom: 2rem; border-bottom: 1px solid #eee;">
          <h3 style="font-weight: 600; color: #000; margin-bottom: 0.5rem;">Deskripsi</h3>
          <p style="color: #666; line-height: 1.8; white-space: pre-wrap;">{{ $category->description }}</p>
        </div>
      @endif

      <!-- Info -->
      <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin-bottom: 2rem; padding-bottom: 2rem; border-bottom: 1px solid #eee;">
        <div>
          <p style="font-weight: 600; color: #000; margin-bottom: 0.25rem;">Total Produk</p>
          <p style="font-size: 1.5rem; font-weight: 700; color: #1e09e2;">{{ $category->products->count() }}</p>
        </div>
        <div>
          <p style="font-weight: 600; color: #000; margin-bottom: 0.25rem;">Dibuat Tanggal</p>
          <p style="color: #666;">{{ $category->created_at->format('d/m/Y H:i') }}</p>
        </div>
      </div>

      <!-- Actions -->
      <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
        <a href="{{ route('categories.edit', $category) }}" 
           style="background-color: #0dcaf0; color: white; padding: 0.75rem 1.5rem; border-radius: 0.3rem; font-weight: 600; text-decoration: none; transition: 0.3s; display: inline-block;"
           onmouseover="this.style.backgroundColor='#0bb5e3'"
           onmouseout="this.style.backgroundColor='#0dcaf0'">
          Edit Kategori
        </a>
        <form method="POST" action="{{ route('categories.destroy', $category) }}" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
          @csrf
          @method('DELETE')
          <button type="submit" 
                  style="background-color: #dc3545; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 0.3rem; font-weight: 600; cursor: pointer; transition: 0.3s;"
                  onmouseover="this.style.backgroundColor='#c82333'"
                  onmouseout="this.style.backgroundColor='#dc3545'">
            Hapus Kategori
          </button>
        </form>
      </div>
    </div>

    <!-- Produk dalam Kategori -->
    <div>
      <h2 style="font-size: 1.8rem; font-weight: 700; color: #000; margin-bottom: 1.5rem;">Produk dalam Kategori</h2>
      
      @if ($category->products->count() > 0)
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1.5rem;">
          @foreach ($category->products as $product)
            <div style="background: white; border-radius: 0.5rem; box-shadow: 0 2px 8px rgba(30, 9, 226, 0.1); overflow: hidden; transition: 0.3s;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 5px 20px rgba(30, 9, 226, 0.2)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(30, 9, 226, 0.1)'">
              
              <!-- Image -->
              @if ($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100%; height: 180px; object-fit: cover;">
              @else
                <div style="width: 100%; height: 180px; background-color: #f8f9fa; display: flex; align-items: center; justify-content: center; color: #999;">
                  No image
                </div>
              @endif

              <!-- Content -->
              <div style="padding: 1rem;">
                <h3 style="font-weight: 600; color: #000; margin: 0 0 0.5rem 0; font-size: 1rem;">{{ $product->name }}</h3>
                <p style="color: #1e09e2; font-weight: 700; margin: 0 0 0.5rem 0;">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                <p style="color: #666; font-size: 0.85rem; margin: 0;">Stok: {{ $product->stock }} pcs</p>
              </div>

              <!-- Actions -->
              <div style="padding: 0.75rem 1rem; background-color: #f8f9fa; border-top: 1px solid #eee;">
                <a href="{{ route('products.show', $product) }}" style="color: #1e09e2; text-decoration: none; font-size: 0.9rem; font-weight: 600;">Lihat Detail →</a>
              </div>
            </div>
          @endforeach
        </div>
      @else
        <div style="background: white; padding: 2rem; text-align: center; border-radius: 0.5rem; box-shadow: 0 2px 10px rgba(30, 9, 226, 0.1);">
          <p style="color: #999;">Belum ada produk dalam kategori ini</p>
        </div>
      @endif
    </div>

    <!-- Back Button -->
    <div style="margin-top: 2rem;">
      <a href="{{ route('categories.index') }}" 
         style="color: #1e09e2; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: 0.3s;"
         onmouseover="this.style.transform='translateX(-5px)'"
         onmouseout="this.style.transform='translateX(0)'">
        ← Kembali ke Daftar Kategori
      </a>
    </div>
  </div>
</div>

<script>
  feather.replace();
</script>
@endsection
