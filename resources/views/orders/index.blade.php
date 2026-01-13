@extends('layout')

@section('title', 'Pesanan Saya')

@section('content')
<div style="padding-top: 100px; padding-bottom: 50px;">
  <div style="max-width: 1200px; margin: 0 auto; padding: 0 7%;">
    
    <!-- Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
      <h1 style="font-size: 2.5rem; font-weight: 700; color: #000; margin: 0;">Pesanan Saya</h1>
    </div>

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

    <!-- Orders Table -->
    @if ($orders->count() > 0)
      <div style="background: white; border-radius: 0.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.1); overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
          <thead>
            <tr style="background-color: #f8f9fa; border-bottom: 2px solid #dee2e6;">
              <th style="padding: 1rem; text-align: left; font-weight: 600; color: #000;">ID Pesanan</th>
              <th style="padding: 1rem; text-align: left; font-weight: 600; color: #000;">Tanggal</th>
              <th style="padding: 1rem; text-align: left; font-weight: 600; color: #000;">Total</th>
              <th style="padding: 1rem; text-align: left; font-weight: 600; color: #000;">Status</th>
              <th style="padding: 1rem; text-align: left; font-weight: 600; color: #000;">Alamat Pengiriman</th>
              <th style="padding: 1rem; text-align: center; font-weight: 600; color: #000;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($orders as $order)
              <tr style="border-bottom: 1px solid #dee2e6;">
                <td style="padding: 1rem; color: #333;">#{{ $order->id }}</td>
                <td style="padding: 1rem; color: #333;">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                <td style="padding: 1rem; color: #1e09e2; font-weight: 600;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                <td style="padding: 1rem;">
                  @if ($order->status === 'pending')
                    <span style="background-color: #fff3cd; color: #856404; padding: 0.4rem 0.8rem; border-radius: 0.3rem; font-size: 0.85rem; font-weight: 600;">Menunggu</span>
                  @elseif ($order->status === 'confirmed')
                    <span style="background-color: #d1ecf1; color: #0c5460; padding: 0.4rem 0.8rem; border-radius: 0.3rem; font-size: 0.85rem; font-weight: 600;">Dikonfirmasi</span>
                  @elseif ($order->status === 'shipped')
                    <span style="background-color: #cfe2ff; color: #084298; padding: 0.4rem 0.8rem; border-radius: 0.3rem; font-size: 0.85rem; font-weight: 600;">Dikirim</span>
                  @elseif ($order->status === 'delivered')
                    <span style="background-color: #d1e7dd; color: #0f5132; padding: 0.4rem 0.8rem; border-radius: 0.3rem; font-size: 0.85rem; font-weight: 600;">Terkirim</span>
                  @elseif ($order->status === 'cancelled')
                    <span style="background-color: #f8d7da; color: #842029; padding: 0.4rem 0.8rem; border-radius: 0.3rem; font-size: 0.85rem; font-weight: 600;">Dibatalkan</span>
                  @endif
                </td>
                <td style="padding: 1rem; color: #333; font-size: 0.9rem;">{{ Str::limit($order->shipping_address, 30) }}</td>
                <td style="padding: 1rem; text-align: center;">
                  <a href="{{ route('orders.show', $order) }}" style="background-color: #1e09e2; color: white; padding: 0.4rem 0.8rem; border-radius: 0.3rem; font-size: 0.85rem; font-weight: 600; text-decoration: none; display: inline-block; transition: 0.3s;" onmouseover="this.style.backgroundColor='#1a07b8'" onmouseout="this.style.backgroundColor='#1e09e2'">
                    Lihat Detail
                  </a>
                  @if (Auth::check())
                    <a href="{{ route('orders.edit', $order) }}" style="background-color: #6c757d; color: white; padding: 0.4rem 0.8rem; border-radius: 0.3rem; font-size: 0.85rem; font-weight: 600; text-decoration: none; display: inline-block; margin-left: 0.3rem; transition: 0.3s;" onmouseover="this.style.backgroundColor='#5a6268'" onmouseout="this.style.backgroundColor='#6c757d'">
                      Edit
                    </a>
                    <form action="{{ route('orders.destroy', $order) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus pesanan ini?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" style="background-color: #dc3545; color: white; padding: 0.4rem 0.8rem; border-radius: 0.3rem; font-size: 0.85rem; font-weight: 600; border: none; cursor: pointer; margin-left: 0.3rem; transition: 0.3s;" onmouseover="this.style.backgroundColor='#c82333'" onmouseout="this.style.backgroundColor='#dc3545'">
                        Hapus
                      </button>
                    </form>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div style="margin-top: 2rem; display: flex; justify-content: center;">
        {{ $orders->links() }}
      </div>
    @else
      <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 0.5rem; padding: 2rem; text-align: center;">
        <p style="color: #666; font-size: 1.1rem; margin: 0;">Belum ada pesanan. <a href="{{ route('products.index') }}" style="color: #1e09e2; font-weight: 600; text-decoration: none;">Mulai belanja sekarang</a></p>
      </div>
    @endif

  </div>
</div>
@endsection
