@extends('layout')

@section('title', 'Daftar Akun')

@section('content')
<div style="padding-top: 120px; min-height: 100vh; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa;">
  <div style="background: white; padding: 2rem; border-radius: 0.5rem; box-shadow: 0 2px 10px rgba(30, 9, 226, 0.1); width: 100%; max-width: 400px;">
    <h2 style="margin-bottom: 1.5rem; text-align: center; color: #000; font-size: 1.8rem; font-weight: 600;">Daftar Akun</h2>

    @if ($errors->any())
      <div style="background-color: #f8d7da; color: #721c24; padding: 0.75rem; border-radius: 0.3rem; margin-bottom: 1rem; border: 1px solid #f5c6cb;">
        @foreach ($errors->all() as $error)
          <p style="margin: 0; font-size: 0.9rem;">{{ $error }}</p>
        @endforeach
      </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
      @csrf

      <div style="margin-bottom: 1.5rem;">
        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: #000;">Nama Lengkap</label>
        <input type="text" name="name" class="form-control" 
               style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 0.3rem; font-size: 1rem; font-family: 'Poppins', sans-serif;"
               value="{{ old('name') }}" required>
      </div>

      <div style="margin-bottom: 1.5rem;">
        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: #000;">Email</label>
        <input type="email" name="email" class="form-control" 
               style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 0.3rem; font-size: 1rem; font-family: 'Poppins', sans-serif;"
               value="{{ old('email') }}" required>
      </div>

      <div style="margin-bottom: 1.5rem;">
        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: #000;">Password</label>
        <input type="password" name="password" class="form-control" 
               style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 0.3rem; font-size: 1rem; font-family: 'Poppins', sans-serif;"
               required>
        <small style="display: block; margin-top: 0.3rem; color: #666;">Minimal 8 karakter</small>
      </div>

      <div style="margin-bottom: 2rem;">
        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: #000;">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="form-control" 
               style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 0.3rem; font-size: 1rem; font-family: 'Poppins', sans-serif;"
               required>
      </div>

      <button type="submit" 
              style="width: 100%; padding: 0.75rem; background-color: #1e09e2; color: white; border: none; border-radius: 0.3rem; font-size: 1rem; font-weight: 600; cursor: pointer; transition: 0.3s; font-family: 'Poppins', sans-serif;"
              onmouseover="this.style.backgroundColor='#1a07b8'"
              onmouseout="this.style.backgroundColor='#1e09e2'">
        Daftar
      </button>
    </form>

    <p style="margin-top: 1.5rem; text-align: center; color: #666; font-size: 0.95rem;">
      Sudah punya akun? <a href="{{ route('login') }}" style="color: #1e09e2; font-weight: 600; text-decoration: none;">Login di sini</a>
    </p>
  </div>
</div>
@endsection
