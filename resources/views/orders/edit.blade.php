@extends('layout')

@section('title', 'Edit Pesanan')

@section('content')
<div style="padding-top: 100px; padding-bottom: 50px;">
  <div style="max-width: 800px; margin: 0 auto; padding: 0 7%;">
    
    <!-- Header -->
    <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 2rem; color: #000;">Edit Pesanan #{{ $order->id }}</h1>

    <!-- Error Messages -->
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

    <!-- Form Card -->
    <div style="background: white; border-radius: 0.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 2rem;">
      
      <form action="{{ route('orders.update', $order) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- User Selection -->
        <div style="margin-bottom: 1.5rem;">
          <label for="user_id" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #000;">Pengguna</label>
          <select name="user_id" id="user_id" style="width: 100%; padding: 0.7rem; border: 1px solid #ddd; border-radius: 0.3rem; font-size: 1rem; background-color: white; appearance: none; padding-right: 2rem; background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%221e09e2%22 stroke-width=%222%22%3e%3cpolyline points=%226 9 12 15 18 9%3e%3c/polyline%3e%3c/svg%3e'); background-repeat: no-repeat; background-position: right 0.7rem center; background-size: 1.2em 1.2em;" required>
            <option value="">-- Pilih Pengguna --</option>
            @foreach ($users as $user)
              <option value="{{ $user->id }}" {{ $order->user_id == $user->id ? 'selected' : '' }}>
                {{ $user->name }} ({{ $user->email }})
              </option>
            @endforeach
          </select>
          @error('user_id')
            <p style="color: #dc3545; font-size: 0.9rem; margin: 0.5rem 0 0 0;">{{ $message }}</p>
          @enderror
        </div>

        <!-- Status Selection -->
        <div style="margin-bottom: 1.5rem;">
          <label for="status" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #000;">Status Pesanan</label>
          <select name="status" id="status" style="width: 100%; padding: 0.7rem; border: 1px solid #ddd; border-radius: 0.3rem; font-size: 1rem; background-color: white; appearance: none; padding-right: 2rem; background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%221e09e2%22 stroke-width=%222%22%3e%3cpolyline points=%226 9 12 15 18 9%3e%3c/polyline%3e%3c/svg%3e'); background-repeat: no-repeat; background-position: right 0.7rem center; background-size: 1.2em 1.2em;" required>
            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
            <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Sedang Dikirim</option>
            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Telah Terkirim</option>
            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
          </select>
          @error('status')
            <p style="color: #dc3545; font-size: 0.9rem; margin: 0.5rem 0 0 0;">{{ $message }}</p>
          @enderror
        </div>

        <!-- Total Price -->
        <div style="margin-bottom: 1.5rem;">
          <label for="total_price" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #000;">Total Harga</label>
          <input type="number" name="total_price" id="total_price" placeholder="Masukkan total harga" step="0.01" value="{{ old('total_price', $order->total_price) }}" style="width: 100%; padding: 0.7rem; border: 1px solid #ddd; border-radius: 0.3rem; font-size: 1rem; box-sizing: border-box;" required>
          @error('total_price')
            <p style="color: #dc3545; font-size: 0.9rem; margin: 0.5rem 0 0 0;">{{ $message }}</p>
          @enderror
        </div>

        <!-- Shipping Address -->
        <div style="margin-bottom: 1.5rem;">
          <label for="shipping_address" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #000;">Alamat Pengiriman</label>
          <textarea name="shipping_address" id="shipping_address" placeholder="Masukkan alamat pengiriman lengkap" rows="4" style="width: 100%; padding: 0.7rem; border: 1px solid #ddd; border-radius: 0.3rem; font-size: 1rem; font-family: inherit; box-sizing: border-box;" required>{{ old('shipping_address', $order->shipping_address) }}</textarea>
          @error('shipping_address')
            <p style="color: #dc3545; font-size: 0.9rem; margin: 0.5rem 0 0 0;">{{ $message }}</p>
          @enderror
        </div>

        <!-- Phone -->
        <div style="margin-bottom: 2rem;">
          <label for="phone" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #000;">No. Telepon</label>
          <input type="text" name="phone" id="phone" placeholder="Masukkan no. telepon (opsional)" value="{{ old('phone', $order->phone) }}" style="width: 100%; padding: 0.7rem; border: 1px solid #ddd; border-radius: 0.3rem; font-size: 1rem; box-sizing: border-box;">
          @error('phone')
            <p style="color: #dc3545; font-size: 0.9rem; margin: 0.5rem 0 0 0;">{{ $message }}</p>
          @enderror
        </div>

        <!-- Form Actions -->
        <div style="display: flex; gap: 1rem; justify-content: space-between;">
          <a href="{{ route('orders.show', $order) }}" style="background-color: #6c757d; color: white; padding: 0.7rem 1.5rem; border-radius: 0.5rem; font-weight: 600; text-decoration: none; text-align: center; transition: 0.3s;" onmouseover="this.style.backgroundColor='#5a6268'" onmouseout="this.style.backgroundColor='#6c757d'">
            Batal
          </a>
          <button type="submit" style="background-color: #1e09e2; color: white; padding: 0.7rem 2rem; border-radius: 0.5rem; font-weight: 600; border: none; cursor: pointer; transition: 0.3s;" onmouseover="this.style.backgroundColor='#1a07b8'" onmouseout="this.style.backgroundColor='#1e09e2'">
            Simpan Perubahan
          </button>
        </div>
      </form>

    </div>

  </div>
</div>
@endsection
