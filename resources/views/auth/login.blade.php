@extends('layout')

@section('title', 'Login')

@section('content')
<div style="padding-top: 120px; min-height: 100vh; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa;">
  <div style="background: white; padding: 2rem; border-radius: 0.5rem; box-shadow: 0 2px 10px rgba(30, 9, 226, 0.1); width: 100%; max-width: 400px;">
    <h2 style="margin-bottom: 1.5rem; text-align: center; color: #000; font-size: 1.8rem; font-weight: 600;">Login</h2>

    @if ($errors->any())
      <div style="background-color: #f8d7da; color: #721c24; padding: 0.75rem; border-radius: 0.3rem; margin-bottom: 1rem; border: 1px solid #f5c6cb;">
        @foreach ($errors->all() as $error)
          <p style="margin: 0; font-size: 0.9rem;">{{ $error }}</p>
        @endforeach
      </div>
    @endif

    @if (session('success'))
      <div style="background-color: #d4edda; color: #155724; padding: 0.75rem; border-radius: 0.3rem; margin-bottom: 1rem; border: 1px solid #c3e6cb;">
        <p style="margin: 0; font-size: 0.9rem;">{{ session('success') }}</p>
      </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
      @csrf

      <div style="margin-bottom: 1.5rem;">
        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: #000;">Email</label>
        <input type="email" name="email" class="form-control" 
               style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 0.3rem; font-size: 1rem; font-family: 'Poppins', sans-serif;"
               value="{{ old('email') }}" required>
      </div>

      <div style="margin-bottom: 2rem;">
        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: #000;">Password</label>
        <input type="password" name="password" class="form-control" 
               style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 0.3rem; font-size: 1rem; font-family: 'Poppins', sans-serif;"
               required>
      </div>

      <button type="submit" 
              style="width: 100%; padding: 0.75rem; background-color: #1e09e2; color: white; border: none; border-radius: 0.3rem; font-size: 1rem; font-weight: 600; cursor: pointer; transition: 0.3s; font-family: 'Poppins', sans-serif;"
              onmouseover="this.style.backgroundColor='#1a07b8'"
              onmouseout="this.style.backgroundColor='#1e09e2'">
        Login
      </button>
    </form>

    <p style="margin-top: 1.5rem; text-align: center; color: #666; font-size: 0.95rem;">
      Belum punya akun? <a href="{{ route('register') }}" style="color: #1e09e2; font-weight: 600; text-decoration: none;">Daftar di sini</a>
    </p>
  </div>
</div>
@endsection
