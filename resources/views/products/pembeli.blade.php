@extends('layout')

@section('content')
<div style="max-width: 1200px; margin: 2rem auto; padding: 0 1rem;">
    <h1 style="text-align: center; margin-bottom: 2rem; color: #333;">🛍️ Daftar Produk</h1>

    <!-- Filter by Category -->
    <div style="margin-bottom: 2rem; text-align: center;">
        <a href="{{ route('products.pembeli') }}" style="display: inline-block; padding: 0.5rem 1rem; background-color: #1e09e2; color: white; border-radius: 0.3rem; text-decoration: none; margin-right: 1rem; transition: 0.3s;" 
            onmouseover="this.style.backgroundColor='#1a07b8'" onmouseout="this.style.backgroundColor='#1e09e2'">Semua Produk</a>
        @foreach ($categories as $category)
            <a href="{{ route('products.pembeli', ['category' => $category->id]) }}" style="display: inline-block; padding: 0.5rem 1rem; background-color: #6c757d; color: white; border-radius: 0.3rem; text-decoration: none; margin-right: 0.5rem; transition: 0.3s;"
                onmouseover="this.style.backgroundColor='#5a6268'" onmouseout="this.style.backgroundColor='#6c757d'">{{ $category->name }}</a>
        @endforeach
    </div>

    <!-- Produk Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 2rem;">
        @forelse ($products as $product)
            <div style="background: white; border-radius: 0.5rem; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); transition: 0.3s; cursor: pointer;"
                onmouseover="this.style.boxShadow='0 4px 12px rgba(30,9,226,0.2)'" onmouseout="this.style.boxShadow='0 2px 8px rgba(0,0,0,0.1)'">
                
                <!-- Foto Produk -->
                <div style="width: 100%; height: 200px; overflow: hidden; background: #f0f0f0;">
                    @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                            style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #e9ecef;">
                            <span style="font-size: 3rem; color: #999;">📦</span>
                        </div>
                    @endif
                </div>

                <!-- Info Produk -->
                <div style="padding: 1rem;">
                    <h3 style="margin: 0 0 0.5rem 0; font-size: 1.1rem; color: #333;">{{ $product->name }}</h3>
                    
                    <p style="margin: 0.5rem 0; color: #666; font-size: 0.9rem;">
                        @if ($product->category)
                            <span style="background: #e9ecef; padding: 0.25rem 0.5rem; border-radius: 0.3rem;">
                                {{ $product->category->name }}
                            </span>
                        @endif
                    </p>

                    <p style="margin: 0.5rem 0; color: #666; font-size: 0.9rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                        {{ $product->description }}
                    </p>

                    <div style="margin: 1rem 0; padding-top: 1rem; border-top: 1px solid #eee;">
                        <p style="margin: 0.5rem 0; font-size: 1.25rem; font-weight: bold; color: #1e09e2;">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>
                        <p style="margin: 0.25rem 0; font-size: 0.9rem; color: #666;">
                            Stok: <strong style="color: {{ $product->stock > 0 ? '#28a745' : '#dc3545' }};">
                                {{ $product->stock > 0 ? $product->stock . ' tersedia' : 'Habis' }}
                            </strong>
                        </p>
                    </div>

                    <!-- Buttons -->
                    <div style="display: flex; gap: 0.5rem; margin-top: 1rem;">
                        <a href="{{ route('products.show', $product) }}" style="flex: 1; padding: 0.5rem; background-color: #6c757d; color: white; border: none; border-radius: 0.3rem; text-align: center; text-decoration: none; font-size: 0.9rem; transition: 0.3s; cursor: pointer;"
                            onmouseover="this.style.backgroundColor='#5a6268'" onmouseout="this.style.backgroundColor='#6c757d'">
                            👁️ Detail
                        </a>
                        @if ($product->stock > 0)
                            <form action="{{ route('cart.add', $product) }}" method="POST" style="flex: 1;">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" style="width: 100%; padding: 0.5rem; background-color: #1e09e2; color: white; border: none; border-radius: 0.3rem; font-size: 0.9rem; font-weight: 500; cursor: pointer; transition: 0.3s;"
                                    onmouseover="this.style.backgroundColor='#1a07b8'" onmouseout="this.style.backgroundColor='#1e09e2'">
                                    🛒 Keranjang
                                </button>
                            </form>
                        @else
                            <button disabled style="flex: 1; padding: 0.5rem; background-color: #ccc; color: #666; border: none; border-radius: 0.3rem; font-size: 0.9rem; cursor: not-allowed;">
                                ❌ Habis
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 3rem 0;">
                <p style="font-size: 1.1rem; color: #666;">📦 Tidak ada produk tersedia</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div style="margin-top: 2rem; text-align: center;">
        {{ $products->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
