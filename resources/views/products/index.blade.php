@extends('layout')

@section('title', 'Daftar Produk')

@section('content')
<div style="padding-top: 100px; padding-bottom: 3rem; background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: calc(100vh - 100px);">
  <div style="max-width: 1200px; margin: 0 auto; padding: 0 1rem;">
    
    <!-- Header Card -->
    <div style="background: white; padding: 2rem; border-radius: 0.8rem; box-shadow: 0 4px 15px rgba(30, 9, 226, 0.1); margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
      <div style="display: flex; align-items: center; gap: 1.5rem;">
        <span style="font-size: 2.5rem;">📦</span>
        <div>
          <h1 style="margin: 0; font-size: 2rem; font-weight: 700; color: #000;">Daftar Produk</h1>
          <p style="margin: 0.25rem 0 0 0; color: #666; font-size: 0.95rem;">Total: <strong style="color: #1e09e2;">{{ $products->count() }} produk</strong></p>
        </div>
      </div>
      <a href="{{ route('products.create') }}" 
         style="padding: 0.8rem 1.5rem; background: linear-gradient(135deg, #1e09e2 0%, #1a07b8 100%); color: white; border: none; border-radius: 0.6rem; font-size: 0.95rem; font-weight: 700; cursor: pointer; text-decoration: none; transition: 0.3s; display: inline-flex; align-items: center; gap: 0.5rem; font-family: 'Poppins', sans-serif; box-shadow: 0 4px 15px rgba(30, 9, 226, 0.3);"
         onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 6px 20px rgba(30, 9, 226, 0.4)'"
         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(30, 9, 226, 0.3)'">
        ➕ Tambah Produk
      </a>
    </div>

    <!-- Alert Success -->
    @if (session('success'))
      <div style="background-color: #d4edda; border-left: 4px solid #28a745; color: #155724; padding: 1.5rem; border-radius: 0.5rem; margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
        <div>
          <p style="font-weight: 600; margin: 0 0 0.25rem 0; font-size: 1rem;">✅ Berhasil!</p>
          <p style="margin: 0; color: #155724; font-size: 0.95rem;">{{ session('success') }}</p>
        </div>
        <button onclick="this.parentElement.style.display='none'" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #155724;">×</button>
      </div>
    @endif

    <!-- Products Table/Grid -->
    @if ($products->count() > 0)
      <!-- Desktop Table View -->
      <div style="background: white; border-radius: 0.8rem; box-shadow: 0 4px 15px rgba(30, 9, 226, 0.1); overflow: hidden; display: none; display: block;">
        <div style="overflow-x: auto;">
          <table style="width: 100%; border-collapse: collapse;">
            <thead>
              <tr style="background: linear-gradient(135deg, #f8f9fa 0%, #f0f1f3 100%); border-bottom: 2px solid #e0e0e0;">
                <th style="padding: 1.5rem; text-align: left; font-weight: 700; color: #333; font-size: 0.95rem;">ID</th>
                <th style="padding: 1.5rem; text-align: left; font-weight: 700; color: #333; font-size: 0.95rem;">Nama Produk</th>
                <th style="padding: 1.5rem; text-align: left; font-weight: 700; color: #333; font-size: 0.95rem;">Kategori</th>
                <th style="padding: 1.5rem; text-align: center; font-weight: 700; color: #333; font-size: 0.95rem;">Harga</th>
                <th style="padding: 1.5rem; text-align: center; font-weight: 700; color: #333; font-size: 0.95rem;">Stok</th>
                <th style="padding: 1.5rem; text-align: center; font-weight: 700; color: #333; font-size: 0.95rem;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($products as $product)
                <tr style="border-bottom: 1px solid #f0f0f0; transition: 0.3s;" onmouseover="this.style.backgroundColor='#f8f9fa'" onmouseout="this.style.backgroundColor='white'">
                  <td style="padding: 1.25rem 1.5rem; color: #666; font-size: 0.9rem;">{{ $product->id }}</td>
                  <td style="padding: 1.25rem 1.5rem;">
                    <div style="display: flex; gap: 1rem; align-items: center;">
                      @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 0.4rem; border: 2px solid #e0e0e0;">
                      @else
                        <div style="width: 50px; height: 50px; background-color: #f0f0f0; border-radius: 0.4rem; display: flex; align-items: center; justify-content: center; color: #999; font-size: 0.8rem;">No Image</div>
                      @endif
                      <div>
                        <p style="margin: 0; font-weight: 600; color: #333; font-size: 0.95rem;">{{ $product->name }}</p>
                        @if ($product->description)
                          <small style="color: #999; display: block; margin-top: 0.2rem;">{{ Str::limit($product->description, 50) }}</small>
                        @endif
                      </div>
                    </div>
                  </td>
                  <td style="padding: 1.25rem 1.5rem; color: #666; font-size: 0.9rem;">
                    <span style="background: #e3f2fd; color: #1565c0; padding: 0.4rem 0.8rem; border-radius: 0.3rem; font-size: 0.85rem; font-weight: 600;">
                      {{ $product->category->name ?? 'N/A' }}
                    </span>
                  </td>
                  <td style="padding: 1.25rem 1.5rem; text-align: center; color: #1e09e2; font-weight: 700; font-size: 0.95rem;">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                  </td>
                  <td style="padding: 1.25rem 1.5rem; text-align: center; color: #333; font-weight: 600; font-size: 0.9rem;">
                    <span style="background: {{ $product->stock > 10 ? '#d4edda' : ($product->stock > 0 ? '#fff3cd' : '#f8d7da') }}; color: {{ $product->stock > 10 ? '#155724' : ($product->stock > 0 ? '#856404' : '#721c24') }}; padding: 0.4rem 0.8rem; border-radius: 0.3rem; font-size: 0.85rem; font-weight: 600;">
                      {{ $product->stock }} unit
                    </span>
                  </td>
                  <td style="padding: 1.25rem 1.5rem; text-align: center;">
                    <div style="display: flex; gap: 0.5rem; justify-content: center;">
                      <a href="{{ route('products.edit', $product->id) }}" 
                         style="padding: 0.5rem 1rem; background-color: #1e09e2; color: white; border: none; border-radius: 0.4rem; font-size: 0.85rem; font-weight: 600; cursor: pointer; text-decoration: none; transition: 0.3s; font-family: 'Poppins', sans-serif;"
                         onmouseover="this.style.backgroundColor='#1a07b8'; this.style.transform='scale(1.05)'"
                         onmouseout="this.style.backgroundColor='#1e09e2'; this.style.transform='scale(1)'">
                        ✏️ Edit
                      </a>
                      <form method="POST" action="{{ route('products.destroy', $product->id) }}" style="display: inline; margin: 0;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                style="padding: 0.5rem 1rem; background-color: #dc3545; color: white; border: none; border-radius: 0.4rem; font-size: 0.85rem; font-weight: 600; cursor: pointer; transition: 0.3s; font-family: 'Poppins', sans-serif;"
                                onmouseover="this.style.backgroundColor='#c82333'; this.style.transform='scale(1.05)'"
                                onmouseout="this.style.backgroundColor='#dc3545'; this.style.transform='scale(1)'"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                          🗑️ Hapus
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

      <!-- Mobile Card View -->
      <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 2rem;">
        @foreach ($products as $product)
          <div style="background: white; border-radius: 0.8rem; box-shadow: 0 4px 15px rgba(30, 9, 226, 0.1); overflow: hidden; transition: 0.3s; display: none; display: block;"
               onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 25px rgba(30, 9, 226, 0.2)'"
               onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(30, 9, 226, 0.1)'">
            
            <!-- Product Image -->
            @if ($product->image)
              <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                   style="width: 100%; height: 200px; object-fit: cover;">
            @else
              <div style="width: 100%; height: 200px; background-color: #f0f0f0; display: flex; align-items: center; justify-content: center; color: #999; font-size: 3rem;">📦</div>
            @endif

            <!-- Product Info -->
            <div style="padding: 1.5rem;">
              <h3 style="margin: 0 0 0.5rem 0; font-size: 1.1rem; font-weight: 700; color: #333;">{{ $product->name }}</h3>
              
              <p style="margin: 0 0 1rem 0; color: #666; font-size: 0.9rem; line-height: 1.4;">
                @if ($product->description)
                  {{ Str::limit($product->description, 80) }}
                @else
                  Tidak ada deskripsi
                @endif
              </p>

              <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 2px solid #f0f0f0;">
                <div>
                  <small style="color: #999; display: block; font-size: 0.8rem;">Harga</small>
                  <strong style="color: #1e09e2; font-size: 1.1rem; display: block;">Rp {{ number_format($product->price, 0, ',', '.') }}</strong>
                </div>
                <div>
                  <small style="color: #999; display: block; font-size: 0.8rem;">Stok</small>
                  <strong style="color: {{ $product->stock > 10 ? '#28a745' : ($product->stock > 0 ? '#ffc107' : '#dc3545') }}; font-size: 1.1rem; display: block;">{{ $product->stock }} unit</strong>
                </div>
              </div>

              <div style="margin-bottom: 1rem;">
                <small style="color: #999; font-size: 0.8rem;">Kategori</small>
                <p style="margin: 0.25rem 0 0 0; color: #1565c0; font-weight: 600;">{{ $product->category->name ?? 'N/A' }}</p>
              </div>

              <!-- Action Buttons -->
              <div style="display: flex; gap: 0.75rem;">
                <a href="{{ route('products.edit', $product->id) }}" 
                   style="flex: 1; padding: 0.75rem; background-color: #1e09e2; color: white; border: none; border-radius: 0.4rem; font-size: 0.85rem; font-weight: 700; cursor: pointer; text-align: center; text-decoration: none; transition: 0.3s; font-family: 'Poppins', sans-serif;"
                   onmouseover="this.style.backgroundColor='#1a07b8'; this.style.transform='translateY(-2px)'"
                   onmouseout="this.style.backgroundColor='#1e09e2'; this.style.transform='translateY(0)'">
                  ✏️ Edit
                </a>
                <form method="POST" action="{{ route('products.destroy', $product->id) }}" style="flex: 1; margin: 0;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" 
                          style="width: 100%; padding: 0.75rem; background-color: #dc3545; color: white; border: none; border-radius: 0.4rem; font-size: 0.85rem; font-weight: 700; cursor: pointer; transition: 0.3s; font-family: 'Poppins', sans-serif;"
                          onmouseover="this.style.backgroundColor='#c82333'; this.style.transform='translateY(-2px)'"
                          onmouseout="this.style.backgroundColor='#dc3545'; this.style.transform='translateY(0)'"
                          onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                    🗑️ Hapus
                  </button>
                </form>
              </div>
            </div>
          </div>
        @endforeach
      </div>

    @else
      <!-- Empty State -->
      <div style="background: white; padding: 4rem 2rem; border-radius: 0.8rem; box-shadow: 0 4px 15px rgba(30, 9, 226, 0.1); text-align: center;">
        <div style="font-size: 5rem; margin-bottom: 1rem;">📭</div>
        <h2 style="margin: 0 0 0.75rem 0; font-size: 1.5rem; font-weight: 700; color: #333;">Tidak Ada Produk</h2>
        <p style="margin: 0 0 2rem 0; color: #999; font-size: 1rem;">Belum ada produk di katalog Anda. Mulai dengan menambahkan produk baru.</p>
        <a href="{{ route('products.create') }}" 
           style="padding: 0.8rem 1.5rem; background: linear-gradient(135deg, #1e09e2 0%, #1a07b8 100%); color: white; border: none; border-radius: 0.6rem; font-size: 0.95rem; font-weight: 700; cursor: pointer; text-decoration: none; transition: 0.3s; display: inline-flex; align-items: center; gap: 0.5rem; font-family: 'Poppins', sans-serif; box-shadow: 0 4px 15px rgba(30, 9, 226, 0.3);"
           onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 6px 20px rgba(30, 9, 226, 0.4)'"
           onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(30, 9, 226, 0.3)'">
          ➕ Tambah Produk Pertama
        </a>
      </div>
    @endif

  </div>
</div>

<style>
  @media (max-width: 768px) {
    table { display: none !important; }
  }

  @media (min-width: 769px) {
    [style*="display: grid; grid-template-columns"] {
      display: none !important;
    }
  }
</style>

<script>
  feather.replace();
</script>

@endsection