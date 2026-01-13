@extends('layout')

@section('title', 'Detail Pesanan')

@section('content')
<div style="padding-top: 100px; padding-bottom: 50px;">
  <div style="max-width: 1000px; margin: 0 auto; padding: 0 7%;">
    
    <!-- Header with Back Button -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
      <h1 style="font-size: 2.5rem; font-weight: 700; color: #000; margin: 0;">Detail Pesanan #{{ $order->id }}</h1>
      <a href="{{ route('orders.index') }}" style="background-color: #6c757d; color: white; padding: 0.6rem 1.2rem; border-radius: 0.5rem; font-weight: 600; text-decoration: none; transition: 0.3s;" onmouseover="this.style.backgroundColor='#5a6268'" onmouseout="this.style.backgroundColor='#6c757d'">
        ← Kembali
      </a>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
      
      <!-- Main Content -->
      <div>
        
        <!-- Order Info Card -->
        <div style="background: white; border-radius: 0.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 1.5rem; margin-bottom: 2rem;">
          <h2 style="font-size: 1.5rem; font-weight: 700; margin-top: 0; margin-bottom: 1.5rem; color: #000; border-bottom: 2px solid #f0f0f0; padding-bottom: 1rem;">Informasi Pesanan</h2>
          
          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
            <div>
              <p style="color: #666; font-size: 0.9rem; margin: 0 0 0.3rem 0;">Tanggal Pesanan</p>
              <p style="color: #000; font-weight: 600; margin: 0; font-size: 1rem;">{{ $order->created_at->format('d M Y H:i') }}</p>
            </div>
            <div>
              <p style="color: #666; font-size: 0.9rem; margin: 0 0 0.3rem 0;">Status Pesanan</p>
              <div>
                @if ($order->status === 'pending')
                  <span style="background-color: #fff3cd; color: #856404; padding: 0.4rem 0.8rem; border-radius: 0.3rem; font-size: 0.85rem; font-weight: 600;">Menunggu Konfirmasi</span>
                @elseif ($order->status === 'confirmed')
                  <span style="background-color: #d1ecf1; color: #0c5460; padding: 0.4rem 0.8rem; border-radius: 0.3rem; font-size: 0.85rem; font-weight: 600;">Dikonfirmasi</span>
                @elseif ($order->status === 'shipped')
                  <span style="background-color: #cfe2ff; color: #084298; padding: 0.4rem 0.8rem; border-radius: 0.3rem; font-size: 0.85rem; font-weight: 600;">Sedang Dikirim</span>
                @elseif ($order->status === 'delivered')
                  <span style="background-color: #d1e7dd; color: #0f5132; padding: 0.4rem 0.8rem; border-radius: 0.3rem; font-size: 0.85rem; font-weight: 600;">Telah Terkirim</span>
                @elseif ($order->status === 'cancelled')
                  <span style="background-color: #f8d7da; color: #842029; padding: 0.4rem 0.8rem; border-radius: 0.3rem; font-size: 0.85rem; font-weight: 600;">Dibatalkan</span>
                @endif
              </div>
            </div>
          </div>

          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div>
              <p style="color: #666; font-size: 0.9rem; margin: 0 0 0.3rem 0;">No. Telepon</p>
              <p style="color: #000; font-weight: 600; margin: 0; font-size: 1rem;">{{ $order->phone ?? '-' }}</p>
            </div>
            <div>
              <p style="color: #666; font-size: 0.9rem; margin: 0 0 0.3rem 0;">Nama Pembeli</p>
              <p style="color: #000; font-weight: 600; margin: 0; font-size: 1rem;">{{ $order->user->name ?? '-' }}</p>
            </div>
          </div>
        </div>

        <!-- Shipping Address Card -->
        <div style="background: white; border-radius: 0.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 1.5rem; margin-bottom: 2rem;">
          <h2 style="font-size: 1.5rem; font-weight: 700; margin-top: 0; margin-bottom: 1rem; color: #000; border-bottom: 2px solid #f0f0f0; padding-bottom: 1rem;">Alamat Pengiriman</h2>
          <p style="color: #333; font-size: 1rem; line-height: 1.6; margin: 0;">{{ $order->shipping_address }}</p>
        </div>

        <!-- Order Items Card -->
        <div style="background: white; border-radius: 0.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 1.5rem;">
          <h2 style="font-size: 1.5rem; font-weight: 700; margin-top: 0; margin-bottom: 1.5rem; color: #000; border-bottom: 2px solid #f0f0f0; padding-bottom: 1rem;">Item Pesanan</h2>
          
          @if ($order->items->count() > 0)
            <div style="display: flex; flex-direction: column; gap: 1rem;">
              @foreach ($order->items as $item)
                <div style="display: flex; gap: 1rem; padding: 1rem; background-color: #f8f9fa; border-radius: 0.5rem; border-left: 4px solid #1e09e2;">
                  
                  <!-- Gambar Produk -->
                  <div style="flex-shrink: 0; width: 80px; height: 80px;">
                    @if ($item->product->image)
                      <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 0.3rem;">
                    @else
                      <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #1e09e2 0%, #6c5ce7 100%); display: flex; align-items: center; justify-content: center; color: white; border-radius: 0.3rem;">
                        <i data-feather="image"></i>
                      </div>
                    @endif
                  </div>

                  <!-- Info Produk -->
                  <div style="flex-grow: 1;">
                    <h3 style="font-weight: 600; color: #000; margin: 0 0 0.5rem 0; font-size: 1rem;">{{ $item->product->name }}</h3>
                    <p style="color: #666; font-size: 0.9rem; margin: 0 0 0.5rem 0;">
                      Harga: <span style="color: #1e09e2; font-weight: 600;">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                    </p>
                    <p style="color: #666; font-size: 0.9rem; margin: 0;">
                      Jumlah: <span style="color: #000; font-weight: 600;">{{ $item->quantity }} pcs</span>
                    </p>
                  </div>

                  <!-- Subtotal -->
                  <div style="flex-shrink: 0; text-align: right;">
                    <p style="color: #666; font-size: 0.85rem; margin: 0 0 0.5rem 0;">Subtotal</p>
                    <p style="color: #1e09e2; font-weight: 700; font-size: 1.1rem; margin: 0;">
                      Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                    </p>
                  </div>
                </div>
              @endforeach
            </div>
          @else
            <p style="color: #666; text-align: center; padding: 2rem 0; margin: 0;">Tidak ada item dalam pesanan ini</p>
          @endif
        </div>

      </div>

      <!-- Sidebar -->
      <div>
        
        <!-- Summary Card -->
        <div style="background: white; border-radius: 0.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 1.5rem; position: sticky; top: 120px;">
          <h2 style="font-size: 1.2rem; font-weight: 700; margin-top: 0; margin-bottom: 1.5rem; color: #000; border-bottom: 2px solid #f0f0f0; padding-bottom: 1rem;">Ringkasan</h2>
          
          <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
            <p style="color: #666; margin: 0;">Subtotal</p>
            <p style="color: #000; font-weight: 600; margin: 0;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
          </div>
          
          <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
            <p style="color: #666; margin: 0;">Pajak</p>
            <p style="color: #000; font-weight: 600; margin: 0;">Rp 0</p>
          </div>
          
          <div style="display: flex; justify-content: space-between; padding: 1rem 0; border-top: 2px solid #f0f0f0; border-bottom: 2px solid #f0f0f0;">
            <p style="color: #000; font-weight: 700; font-size: 1.1rem; margin: 0;">Total</p>
            <p style="color: #1e09e2; font-weight: 700; font-size: 1.3rem; margin: 0;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
          </div>

          <!-- Actions -->
          @if (Auth::check())
            <div style="margin-top: 1.5rem; display: flex; flex-direction: column; gap: 0.5rem;">
              <a href="{{ route('orders.edit', $order) }}" style="background-color: #6c757d; color: white; padding: 0.6rem 1rem; border-radius: 0.3rem; font-weight: 600; text-decoration: none; text-align: center; transition: 0.3s;" onmouseover="this.style.backgroundColor='#5a6268'" onmouseout="this.style.backgroundColor='#6c757d'">
                Edit Pesanan
              </a>
              <form action="{{ route('orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pesanan ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" style="width: 100%; background-color: #dc3545; color: white; padding: 0.6rem 1rem; border-radius: 0.3rem; font-weight: 600; border: none; cursor: pointer; transition: 0.3s;" onmouseover="this.style.backgroundColor='#c82333'" onmouseout="this.style.backgroundColor='#dc3545'">
                  Hapus Pesanan
                </button>
              </form>
            </div>
          @endif
        </div>

      </div>

    </div>

  </div>
</div>

<script>
  feather.replace();
</script>
@endsection
