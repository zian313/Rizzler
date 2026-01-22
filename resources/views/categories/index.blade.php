@extends('layout')

@section('title', 'Daftar Kategori')

@section('content')
<div style="padding-top: 120px; padding-bottom: 3rem;">
  <div style="max-width: 1000px; margin: 0 auto; padding: 0 1rem;">
    
    <!-- Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
      <h1 style="font-size: 2rem; font-weight: 700; color: #000;">Daftar Kategori</h1>
      @if (Auth::check())
        <a href="{{ route('categories.create') }}" 
           style="background-color: #1e09e2; color: white; padding: 0.75rem 1.5rem; border-radius: 0.3rem; font-weight: 600; text-decoration: none; transition: 0.3s; display: inline-block;"
           onmouseover="this.style.backgroundColor='#1a07b8'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 5px 15px rgba(30, 9, 226, 0.3)'"
           onmouseout="this.style.backgroundColor='#1e09e2'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">
          + Tambah Kategori
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

    <!-- Categories Grid -->
    @if ($categories->count() > 0)
      <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1.5rem;">
        @foreach ($categories as $category)
          <div style="background: white; border-radius: 0.5rem; box-shadow: 0 2px 8px rgba(30, 9, 226, 0.1); overflow: hidden; transition: 0.3s; cursor: pointer;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 5px 20px rgba(30, 9, 226, 0.2)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(30, 9, 226, 0.1)'">
            
            <!-- Header Kategori -->
            <div style="background: linear-gradient(135deg, #1e09e2 0%, #6c5ce7 100%); padding: 1.5rem; color: white;">
              <h3 style="font-size: 1.3rem; font-weight: 700; margin: 0; margin-bottom: 0.5rem;">{{ $category->name }}</h3>
              <p style="margin: 0; font-size: 0.9rem; opacity: 0.9;">
                <i data-feather="package"></i> {{ $category->products->count() }} Produk
              </p>
            </div>

            <!-- Content -->
            <div style="padding: 1.5rem;">
              <p style="color: #666; font-size: 0.95rem; line-height: 1.5; margin-bottom: 1.5rem; min-height: 60px;">
                {{ $category->description ? Str::limit($category->description, 100) : 'Tidak ada deskripsi' }}
              </p>

              <!-- Actions -->
              @if (Auth::check() && Auth::user()->role === 'admin')
                <div style="display: flex; gap: 0.5rem;">
                  <a href="{{ route('categories.edit', $category) }}" 
                     style="flex: 1; background-color: #0dcaf0; color: white; padding: 0.5rem; border-radius: 0.3rem; font-size: 0.85rem; text-decoration: none; text-align: center; font-weight: 600; transition: 0.3s; display: inline-block;"
                     onmouseover="this.style.backgroundColor='#0bb5e3'"
                     onmouseout="this.style.backgroundColor='#0dcaf0'">
                    Edit
                  </a>
                  <form method="POST" action="{{ route('categories.destroy', $category) }}" style="flex: 1;" onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            style="width: 100%; background-color: #dc3545; color: white; padding: 0.5rem; border: none; border-radius: 0.3rem; font-size: 0.85rem; font-weight: 600; cursor: pointer; transition: 0.3s;"
                            onmouseover="this.style.backgroundColor='#c82333'"
                            onmouseout="this.style.backgroundColor='#dc3545'">
                      Hapus
                    </button>
                  </form>
                </div>
              @else
                <a href="{{ route('categories.show', $category) }}" 
                   style="display: block; width: 100%; background-color: #0dcaf0; color: white; padding: 0.5rem; border-radius: 0.3rem; font-size: 0.85rem; text-decoration: none; text-align: center; font-weight: 600; transition: 0.3s;"
                   onmouseover="this.style.backgroundColor='#0bb5e3'"
                   onmouseout="this.style.backgroundColor='#0dcaf0'">
                  Lihat Detail
                </a>
              @endif
            </div>

            <!-- Footer -->
            <div style="background-color: #f8f9fa; padding: 0.75rem 1.5rem; font-size: 0.85rem; color: #999;">
              Dibuat {{ $category->created_at->diffForHumans() }}
            </div>
          </div>
        @endforeach
      </div>
    @else
      <div style="background: white; padding: 3rem; text-align: center; border-radius: 0.5rem; box-shadow: 0 2px 10px rgba(30, 9, 226, 0.1);">
        <div style="font-size: 3rem; margin-bottom: 1rem; color: #1e09e2;">
          <i data-feather="folder-plus"></i>
        </div>
        <p style="font-size: 1.1rem; color: #999; margin-bottom: 1.5rem;">Belum ada kategori.</p>
        @if (Auth::check())
          <a href="{{ route('categories.create') }}" 
             style="background-color: #1e09e2; color: white; padding: 0.85rem 2rem; border-radius: 0.3rem; font-weight: 600; text-decoration: none; display: inline-block; transition: 0.3s;"
             onmouseover="this.style.backgroundColor='#1a07b8'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 5px 15px rgba(30, 9, 226, 0.3)'"
             onmouseout="this.style.backgroundColor='#1e09e2'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">
            Tambah Kategori Pertama
          </a>
        @endif
        </a>
      </div>
    @endif
  </div>
</div>

<script>
  feather.replace();
</script>
@endsection
