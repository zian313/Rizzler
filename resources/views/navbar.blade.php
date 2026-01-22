<nav class="navbar">
  <a href="/" class="navbar-logo">E <span>Commerce</span></a>
  

  <div class="navbar-nav">
    <a href="{{ route('categories.index') }}">Kategori</a>
    @auth
      @if (Auth::user()->isAdmin())
        <a href="{{ route('products.index') }}" style="color: #dc3545; font-weight: 600;">📦 Kelola Produk</a>
      @else
        <a href="{{ route('products.pembeli') }}" style="color: #28a745; font-weight: 600;">🛒 Belanja</a>
      @endif
    @endauth
    @guest
      <a href="{{ route('products.index') }}">Produk</a>
    @endguest
    @auth
      @if (Auth::user()->isAdmin())
        <a href="{{ route('admin.dashboard') }}" style="color: #dc3545; font-weight: 600;">📊 Dashboard</a>
        <a href="{{ route('categories.create') }}" style="color: #dc3545;">+ Kategori</a>
        <a href="{{ route('products.create') }}" style="color: #dc3545;">+ Produk</a>
      @else
        <a href="{{ route('orders.index') }}">Pesanan Saya</a>
      @endif
    @endauth
  </div>

  <div class="navbar-extra">
    <a href="{{ route('products.index') }}" id="search" title="Cari Produk">
      <i data-feather="search"></i>
    </a>
    @auth
      @if (Auth::user()->isPembeli())
        <a href="{{ route('cart.index') }}" id="shopping-cart" title="Keranjang" style="position: relative;">
          <i data-feather="shopping-cart"></i>
          @php
            $cart = \App\Models\Cart::where('user_id', auth()->id())->first();
            $cartCount = $cart ? $cart->getTotalItems() : 0;
          @endphp
          @if ($cartCount > 0)
            <span style="position: absolute; top: -8px; right: -8px; background-color: #dc3545; color: white; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: bold;">
              {{ $cartCount }}
            </span>
          @endif
        </a>
      @endif
    @endauth

    @if (Auth::check())
      <div style="display: flex; align-items: center; margin-left: 1.5rem; gap: 1rem;">
        <span style="font-weight: 500; color: #000;">
          Halo, {{ Auth::user()->name }}
          @if (Auth::user()->isAdmin())
            <span style="background-color: #dc3545; color: white; padding: 0.2rem 0.6rem; border-radius: 0.3rem; font-size: 0.75rem; margin-left: 0.5rem;">[ADMIN]</span>
          @else
            <span style="background-color: #28a745; color: white; padding: 0.2rem 0.6rem; border-radius: 0.3rem; font-size: 0.75rem; margin-left: 0.5rem;">[PEMBELI]</span>
          @endif
        </span>
        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
          @csrf
          <button type="submit" style="background: none; border: none; cursor: pointer; color: #000; font-size: 1.1rem; padding: 0; display: flex; align-items: center;" title="Logout">
            <i data-feather="log-out"></i>
          </button>
        </form>
      </div>
    @else
      <a href="{{ route('login') }}" style="color: #000; margin: 0 0.5rem; font-weight: 500; transition: 0.3s;" onmouseover="this.style.color='#1e09e2'" onmouseout="this.style.color='#000'">Login</a>
      <a href="{{ route('register') }}" style="color: white; background-color: #1e09e2; padding: 0.5rem 1rem; border-radius: 0.3rem; font-weight: 500; margin-left: 0.5rem; transition: 0.3s;" onmouseover="this.style.backgroundColor='#1a07b8'" onmouseout="this.style.backgroundColor='#1e09e2'">Daftar</a>
    @endif

    <a href="#" id="hamburger-menu">
      <i data-feather="menu"></i>
    </a>
  </div>
</nav>