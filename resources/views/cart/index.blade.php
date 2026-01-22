@extends('layout')

@section('title', 'Keranjang Belanja')

@section('content')
<div style="padding-top: 100px; padding-bottom: 50px;">
  <div style="max-width: 1200px; margin: 0 auto; padding: 0 7%;">
    
    <!-- Header -->
    <h1 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 2rem; color: #000;">Keranjang Belanja</h1>

    <!-- Alert Messages -->
    @if ($errors->any())
      <div style="background-color: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 1rem; border-radius: 0.5rem; margin-bottom: 2rem;">
        <strong>Error!</strong>
        <ul style="margin: 0.5rem 0 0 1.5rem; padding: 0;">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    @if (session('success'))
      <div style="background-color: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 1rem; border-radius: 0.5rem; margin-bottom: 2rem;">
        {{ session('success') }}
      </div>
    @endif

    @if (session('error'))
      <div style="background-color: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 1rem; border-radius: 0.5rem; margin-bottom: 2rem;">
        {{ session('error') }}
      </div>
    @endif

    <!-- Main Content -->
    @if ($cartItems->count() > 0)
      <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
        
        <!-- Cart Items -->
        <div>
          <div style="background: white; border-radius: 0.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 1.5rem;">
            <h2 style="font-size: 1.3rem; font-weight: 700; margin-top: 0; margin-bottom: 1.5rem; color: #000;">Item Keranjang ({{ $totalItems }})</h2>
            
            <div style="display: flex; flex-direction: column; gap: 1rem;">
              @foreach ($cartItems as $item)
                <div style="display: flex; gap: 1rem; padding: 1rem; background-color: #f8f9fa; border-radius: 0.5rem; border-left: 4px solid #1e09e2;">
                  
                  <!-- Gambar Produk -->
                  <div style="flex-shrink: 0; width: 100px; height: 100px;">
                    @if ($item->product->image)
                      <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 0.3rem;">
                    @else
                      <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #1e09e2 0%, #6c5ce7 100%); display: flex; align-items: center; justify-content: center; color: white; border-radius: 0.3rem;">
                        <i data-feather="image" style="width: 40px; height: 40px;"></i>
                      </div>
                    @endif
                  </div>

                  <!-- Info Produk -->
                  <div style="flex-grow: 1;">
                    <h3 style="font-weight: 600; color: #000; margin: 0 0 0.5rem 0; font-size: 1rem;">{{ $item->product->name }}</h3>
                    <p style="color: #666; font-size: 0.9rem; margin: 0 0 0.5rem 0;">Kategori: <span style="color: #1e09e2; font-weight: 600;">{{ $item->product->category->name }}</span></p>
                    <p style="color: #1e09e2; font-weight: 700; font-size: 1.1rem; margin: 0;">Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
                  </div>

                  <!-- Quantity & Actions -->
                  <div style="flex-shrink: 0; text-align: right;">
                    <form action="{{ route('cart.update', $item) }}" method="POST" style="margin-bottom: 0.5rem;">
                      @csrf
                      @method('PUT')
                      <div style="display: flex; gap: 0.3rem; margin-bottom: 0.5rem;">
                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" style="width: 60px; padding: 0.4rem; border: 1px solid #ddd; border-radius: 0.3rem; text-align: center; font-size: 0.9rem;">
                        <button type="submit" style="background-color: #6c757d; color: white; padding: 0.4rem 0.6rem; border-radius: 0.3rem; font-weight: 600; border: none; cursor: pointer; font-size: 0.85rem; transition: 0.3s;" onmouseover="this.style.backgroundColor='#5a6268'" onmouseout="this.style.backgroundColor='#6c757d'">
                          Update
                        </button>
                      </div>
                    </form>
                    
                    <form action="{{ route('cart.remove', $item) }}" method="POST" style="display: inline;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" style="background-color: #dc3545; color: white; padding: 0.4rem 0.8rem; border-radius: 0.3rem; font-weight: 600; border: none; cursor: pointer; font-size: 0.85rem; width: 100%; transition: 0.3s;" onmouseover="this.style.backgroundColor='#c82333'" onmouseout="this.style.backgroundColor='#dc3545'">
                        Hapus
                      </button>
                    </form>
                    
                    <p style="color: #666; font-size: 0.85rem; margin: 0.5rem 0 0 0;">Subtotal: <span style="color: #000; font-weight: 700;">Rp {{ number_format($item->quantity * $item->product->price, 0, ',', '.') }}</span></p>
                  </div>

                </div>
              @endforeach
            </div>

            <!-- Clear Cart -->
            <form action="{{ route('cart.clear') }}" method="POST" style="margin-top: 1.5rem; text-align: center;" onsubmit="return confirm('Yakin ingin mengosongkan keranjang?');">
              @csrf
              <button type="submit" style="background-color: #6c757d; color: white; padding: 0.6rem 1.5rem; border-radius: 0.5rem; font-weight: 600; border: none; cursor: pointer; transition: 0.3s;" onmouseover="this.style.backgroundColor='#5a6268'" onmouseout="this.style.backgroundColor='#6c757d'">
                Kosongkan Keranjang
              </button>
            </form>
          </div>
        </div>

        <!-- Summary & Checkout -->
        <div>
          <div style="background: white; border-radius: 0.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 1.5rem; position: sticky; top: 120px;">
            <h2 style="font-size: 1.3rem; font-weight: 700; margin-top: 0; margin-bottom: 1.5rem; color: #000; border-bottom: 2px solid #f0f0f0; padding-bottom: 1rem;">Ringkasan</h2>
            
            <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
              <p style="color: #666; margin: 0;">Subtotal</p>
              <p style="color: #000; font-weight: 600; margin: 0;">Rp {{ number_format($totalPrice, 0, ',', '.') }}</p>
            </div>
            
            <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
              <p style="color: #666; margin: 0;">Ongkos Kirim</p>
              <p style="color: #000; font-weight: 600; margin: 0;">Gratis</p>
            </div>

            <div style="display: flex; justify-content: space-between; padding: 1rem 0; border-top: 2px solid #f0f0f0; border-bottom: 2px solid #f0f0f0; margin-bottom: 1.5rem;">
              <p style="color: #000; font-weight: 700; font-size: 1.1rem; margin: 0;">Total</p>
              <p style="color: #1e09e2; font-weight: 700; font-size: 1.3rem; margin: 0;">Rp {{ number_format($totalPrice, 0, ',', '.') }}</p>
            </div>

            <!-- Checkout Form -->
            <form action="{{ route('cart.checkout') }}" method="POST">
              @csrf
              
              <div style="margin-bottom: 1rem;">
                <label for="shipping_address" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #000; font-size: 0.9rem;">Alamat Pengiriman <span style="color: #dc3545;">*</span></label>
                <textarea name="shipping_address" id="shipping_address" placeholder="Masukkan alamat pengiriman lengkap" rows="3" style="width: 100%; padding: 0.7rem; border: 1px solid #ddd; border-radius: 0.3rem; font-size: 0.9rem; font-family: inherit; box-sizing: border-box;" required></textarea>
                @error('shipping_address')
                  <p style="color: #dc3545; font-size: 0.85rem; margin: 0.3rem 0 0 0;">{{ $message }}</p>
                @enderror
              </div>

              <div style="margin-bottom: 1.5rem;">
                <label for="phone" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #000; font-size: 0.9rem;">No. Telepon <span style="color: #dc3545;">*</span></label>
                <input type="text" name="phone" id="phone" placeholder="Contoh: 083844492691" style="width: 100%; padding: 0.7rem; border: 1px solid #ddd; border-radius: 0.3rem; font-size: 0.9rem; box-sizing: border-box;" required>
                @error('phone')
                  <p style="color: #dc3545; font-size: 0.85rem; margin: 0.3rem 0 0 0;">{{ $message }}</p>
                @enderror
              </div>

              <button type="submit" style="width: 100%; background-color: #1e09e2; color: white; padding: 0.8rem; border-radius: 0.5rem; font-weight: 700; font-size: 1rem; border: none; cursor: pointer; transition: 0.3s;" onmouseover="this.style.backgroundColor='#1a07b8'" onmouseout="this.style.backgroundColor='#1e09e2'">
                💬 Checkout via WhatsApp
              </button>
            </form>

            <p style="color: #666; font-size: 0.85rem; text-align: center; margin-top: 1rem;">
              <a href="{{ route('products.index') }}" style="color: #1e09e2; text-decoration: none; font-weight: 600;">← Lanjut Belanja</a>
            </p>
          </div>
        </div>

      </div>
    @else
      <!-- Empty Cart -->
      <div style="background: white; border-radius: 0.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 4rem 2rem; text-align: center;">
        <div style="font-size: 4rem; margin-bottom: 1rem; color: #1e09e2;">
          <i data-feather="shopping-cart"></i>
        </div>
        <h2 style="font-size: 1.5rem; font-weight: 700; color: #000; margin-bottom: 0.5rem;">Keranjang Kosong</h2>
        <p style="color: #666; font-size: 1.1rem; margin-bottom: 2rem;">Belum ada produk di keranjang Anda. Mulai belanja sekarang!</p>
        <a href="{{ route('products.index') }}" style="background-color: #1e09e2; color: white; padding: 0.8rem 2rem; border-radius: 0.5rem; font-weight: 600; font-size: 1rem; text-decoration: none; display: inline-block; transition: 0.3s;" onmouseover="this.style.backgroundColor='#1a07b8'" onmouseout="this.style.backgroundColor='#1e09e2'">
          Mulai Belanja
        </a>
      </div>
    @endif

  </div>
</div>

<script>
  feather.replace();
</script>
@endsection
