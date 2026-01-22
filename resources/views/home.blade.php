@extends('layout')

@section('title', 'Beranda')

@section('content')
<div style="padding-top: 100px;">
  <!-- Hero Section -->
  <section style="background-image: linear-gradient(135deg, rgba(30, 9, 226, 0.8) 0%, rgba(108, 92, 231, 0.8) 100%), url('{{ asset("images/home.jpg") }}'); background-size: cover; background-position: center; background-attachment: fixed; color: white; padding: 4rem 7%; text-align: center; min-height: 60vh; display: flex; flex-direction: column; justify-content: center; align-items: center; position: relative;">
    <h1 style="font-size: 3.5rem; font-weight: 700; margin-bottom: 1rem; line-height: 1.2; position: relative; z-index: 2;">Selamat Datang di E-Commerce</h1>
    <p style="font-size: 1.3rem; margin-bottom: 2rem; max-width: 600px; line-height: 1.6; position: relative; z-index: 2;">Temukan produk pilihan berkualitas dengan harga terbaik. Belanja mudah, aman, dan terpercaya bersama kami.</p>
    <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; position: relative; z-index: 2;">
      @auth
        @if (Auth::user()->isPembeli())
          <a href="{{ route('products.pembeli') }}" style="background-color: white; color: #1e09e2; padding: 1rem 2rem; border-radius: 0.5rem; font-weight: 600; font-size: 1.1rem; text-decoration: none; transition: 0.3s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 5px 15px rgba(0,0,0,0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
            🛒 Belanja Sekarang
          </a>
        @else
          <a href="{{ route('products.index') }}" style="background-color: white; color: #1e09e2; padding: 1rem 2rem; border-radius: 0.5rem; font-weight: 600; font-size: 1.1rem; text-decoration: none; transition: 0.3s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 5px 15px rgba(0,0,0,0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
            📦 Kelola Produk
          </a>
        @endif
      @else
        <a href="{{ route('login') }}" style="background-color: white; color: #1e09e2; padding: 1rem 2rem; border-radius: 0.5rem; font-weight: 600; font-size: 1.1rem; text-decoration: none; transition: 0.3s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 5px 15px rgba(0,0,0,0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
          🛒 Belanja Sekarang
        </a>
      @endauth
      <a href="#about" style="background-color: rgba(255,255,255,0.2); color: white; padding: 1rem 2rem; border-radius: 0.5rem; font-weight: 600; font-size: 1.1rem; text-decoration: none; border: 2px solid white; transition: 0.3s;" onmouseover="this.style.backgroundColor='rgba(255,255,255,0.3)'" onmouseout="this.style.backgroundColor='rgba(255,255,255,0.2)'">
        Pelajari Lebih Lanjut
      </a>
    </div>
  </section>

  <!-- About Section -->
  <section id="about" style="padding: 4rem 7%; background-color: #f8f9fa;">
    <h2 style="font-size: 2.5rem; font-weight: 700; text-align: center; margin-bottom: 3rem; color: #000;">Tentang Kami</h2>
    <div style="max-width: 1000px; margin: 0 auto;">
      <p style="font-size: 1.1rem; line-height: 1.8; margin-bottom: 1.5rem; color: #333;">
        E-Commerce kami adalah platform belanja online terpadu yang menyediakan berbagai macam produk berkualitas. Kami berkomitmen untuk memberikan pengalaman berbelanja yang terbaik dengan layanan pelanggan yang responsif dan pengiriman yang cepat.
      </p>
      <p style="font-size: 1.1rem; line-height: 1.8; color: #333;">
        Dengan koleksi produk yang terus diperbarui dan harga yang kompetitif, kami siap memenuhi kebutuhan belanja Anda dengan kepuasan 100%.
      </p>
    </div>
  </section>

  <!-- Features Section -->
  <section style="padding: 4rem 7%; background-color: white;">
    <h2 style="font-size: 2.5rem; font-weight: 700; text-align: center; margin-bottom: 3rem; color: #000;">Keunggulan Kami</h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; max-width: 1200px; margin: 0 auto;">
      
      <div style="background-color: #f8f9fa; padding: 2rem; border-radius: 0.8rem; text-align: center; box-shadow: 0 2px 8px rgba(30, 9, 226, 0.1); transition: 0.3s;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 5px 20px rgba(30, 9, 226, 0.2)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(30, 9, 226, 0.1)'">
        <div style="font-size: 3rem; margin-bottom: 1rem; color: #1e09e2;">
          <i data-feather="truck"></i>
        </div>
        <h3 style="font-size: 1.3rem; margin-bottom: 0.5rem; color: #000;">Pengiriman Cepat</h3>
        <p style="color: #666; font-size: 0.95rem;">Pengiriman ke seluruh Indonesia dengan jaminan barang sampai dengan selamat.</p>
      </div>

      <div style="background-color: #f8f9fa; padding: 2rem; border-radius: 0.8rem; text-align: center; box-shadow: 0 2px 8px rgba(30, 9, 226, 0.1); transition: 0.3s;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 5px 20px rgba(30, 9, 226, 0.2)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(30, 9, 226, 0.1)'">
        <div style="font-size: 3rem; margin-bottom: 1rem; color: #1e09e2;">
          <i data-feather="shield"></i>
        </div>
        <h3 style="font-size: 1.3rem; margin-bottom: 0.5rem; color: #000;">Belanja Aman</h3>
        <p style="color: #666; font-size: 0.95rem;">Sistem pembayaran terenkripsi dan terpercaya untuk keamanan transaksi Anda.</p>
      </div>

      <div style="background-color: #f8f9fa; padding: 2rem; border-radius: 0.8rem; text-align: center; box-shadow: 0 2px 8px rgba(30, 9, 226, 0.1); transition: 0.3s;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 5px 20px rgba(30, 9, 226, 0.2)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(30, 9, 226, 0.1)'">
        <div style="font-size: 3rem; margin-bottom: 1rem; color: #1e09e2;">
          <i data-feather="headphones"></i>
        </div>
        <h3 style="font-size: 1.3rem; margin-bottom: 0.5rem; color: #000;">Dukungan 24/7</h3>
        <p style="color: #666; font-size: 0.95rem;">Tim customer service siap membantu Anda kapan saja untuk setiap pertanyaan.</p>
      </div>

    </div>
  </section>

  <!-- Products Preview Section -->
  <section style="padding: 4rem 7%; background-color: #f8f9fa;">
    <h2 style="font-size: 2.5rem; font-weight: 700; text-align: center; margin-bottom: 1rem; color: #000;">Produk Terbaru</h2>
    <p style="text-align: center; color: #666; margin-bottom: 3rem; font-size: 1.1rem;">Lihat koleksi produk terbaru dan terlengkap kami</p>
    
    @if ($products->count() > 0)
      <div style="max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        @foreach ($products as $product)
          <div style="background: white; border-radius: 0.5rem; box-shadow: 0 2px 8px rgba(30, 9, 226, 0.1); overflow: hidden; transition: 0.3s;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 5px 20px rgba(30, 9, 226, 0.2)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(30, 9, 226, 0.1)'">
            
            <!-- Gambar Produk -->
            <div style="position: relative; overflow: hidden; height: 200px;">
              @if ($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover; transition: 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
              @else
                <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #1e09e2 0%, #6c5ce7 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                  <i data-feather="image"></i>
                </div>
              @endif
              <span style="position: absolute; top: 10px; right: 10px; background-color: #1e09e2; color: white; padding: 0.3rem 0.8rem; border-radius: 0.3rem; font-size: 0.8rem; font-weight: 600;">{{ $product->category->name }}</span>
            </div>

            <!-- Info Produk -->
            <div style="padding: 1rem;">
              <h3 style="font-weight: 600; color: #000; margin: 0 0 0.5rem 0; font-size: 1rem; min-height: 2.2rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $product->name }}</h3>
              
              <p style="color: #1e09e2; font-weight: 700; font-size: 1.2rem; margin: 0.5rem 0;">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
              
              <p style="color: #666; font-size: 0.85rem; margin: 0.5rem 0;">
                <i data-feather="package" style="width: 14px; height: 14px; display: inline; margin-right: 0.25rem;"></i>
                Stok: {{ $product->stock }} pcs
              </p>
            </div>

            <!-- Action Button -->
            <div style="padding: 0 1rem 1rem 1rem;">
              <a href="{{ route('products.show', $product) }}" style="width: 100%; display: block; text-align: center; background-color: #1e09e2; color: white; padding: 0.6rem; border-radius: 0.3rem; font-weight: 600; font-size: 0.9rem; text-decoration: none; transition: 0.3s;" onmouseover="this.style.backgroundColor='#1a07b8'" onmouseout="this.style.backgroundColor='#1e09e2'">
                Lihat Detail
              </a>
            </div>
          </div>
        @endforeach
      </div>
    @endif

    <div style="text-align: center;">
      <a href="{{ route('products.index') }}" style="background-color: #1e09e2; color: white; padding: 0.8rem 2rem; border-radius: 0.5rem; font-weight: 600; font-size: 1rem; text-decoration: none; display: inline-block; transition: 0.3s;" onmouseover="this.style.backgroundColor='#1a07b8'" onmouseout="this.style.backgroundColor='#1e09e2'">
        Lihat Semua Produk
      </a>
    </div>
  </section>

  <!-- CTA Section -->
  <section style="background: linear-gradient(135deg, #1e09e2 0%, #6c5ce7 100%); color: white; padding: 4rem 7%; text-align: center;">
    <h2 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 1rem;">Siap untuk Berbelanja?</h2>
    <p style="font-size: 1.1rem; margin-bottom: 2rem;">Bergabunglah dengan ribuan pelanggan puas kami dan nikmati pengalaman belanja terbaik.</p>
    @if (Auth::check())
      <a href="{{ route('products.index') }}" style="background-color: white; color: #1e09e2; padding: 1rem 2rem; border-radius: 0.5rem; font-weight: 600; font-size: 1.1rem; text-decoration: none; display: inline-block; transition: 0.3s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 5px 15px rgba(0,0,0,0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
        Mulai Belanja
      </a>
    @else
      <a href="{{ route('register') }}" style="background-color: white; color: #1e09e2; padding: 1rem 2rem; border-radius: 0.5rem; font-weight: 600; font-size: 1.1rem; text-decoration: none; display: inline-block; transition: 0.3s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 5px 15px rgba(0,0,0,0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
        Daftar Sekarang
      </a>
    @endif
  </section>
</div>

<script>
  feather.replace();
</script>
@endsection