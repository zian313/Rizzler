@extends('layout')

@section('title', 'Edit Kategori')

@section('content')
<div style="padding-top: 120px; padding-bottom: 3rem;">
  <div style="max-width: 500px; margin: 0 auto; background: white; padding: 2rem; border-radius: 0.5rem; box-shadow: 0 2px 10px rgba(30, 9, 226, 0.1);">
    
    <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 2rem; color: #000;">Edit Kategori</h1>

    @if ($errors->any())
      <div style="background-color: #f8d7da; color: #721c24; padding: 1rem; border-radius: 0.3rem; margin-bottom: 1.5rem; border: 1px solid #f5c6cb;">
        <p style="font-weight: 600; margin-bottom: 0.5rem;">Terjadi kesalahan:</p>
        @foreach ($errors->all() as $error)
          <p style="margin: 0.25rem 0; font-size: 0.9rem;">• {{ $error }}</p>
        @endforeach
      </div>
    @endif

    <form method="POST" action="{{ route('categories.update', $category) }}">
      @csrf
      @method('PUT')

      <!-- Nama Kategori -->
      <div style="margin-bottom: 1.5rem;">
        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #000; font-size: 1rem;">Nama Kategori <span style="color: #dc3545;">*</span></label>
        <input type="text" name="name" 
               style="width: 100%; padding: 0.75rem; border: 1px solid {{ $errors->has('name') ? '#dc3545' : '#ddd' }}; border-radius: 0.3rem; font-size: 0.95rem; font-family: 'Poppins', sans-serif; transition: 0.3s;"
               value="{{ old('name', $category->name) }}" 
               placeholder="Masukkan nama kategori"
               onmouseover="this.style.borderColor='#1e09e2'"
               onmouseout="this.style.borderColor='{{ $errors->has('name') ? '#dc3545' : '#ddd' }}'"
               required>
        @error('name')
          <small style="color: #dc3545; display: block; margin-top: 0.25rem;">{{ $message }}</small>
        @enderror
      </div>

      <!-- Deskripsi -->
      <div style="margin-bottom: 2rem;">
        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #000; font-size: 1rem;">Deskripsi</label>
        <textarea name="description" 
                  style="width: 100%; padding: 0.75rem; border: 1px solid {{ $errors->has('description') ? '#dc3545' : '#ddd' }}; border-radius: 0.3rem; font-size: 0.95rem; font-family: 'Poppins', sans-serif; resize: vertical; min-height: 100px; transition: 0.3s;"
                  placeholder="Masukkan deskripsi kategori (opsional)"
                  onmouseover="this.style.borderColor='#1e09e2'"
                  onmouseout="this.style.borderColor='{{ $errors->has('description') ? '#dc3545' : '#ddd' }}'">{{ old('description', $category->description) }}</textarea>
        @error('description')
          <small style="color: #dc3545; display: block; margin-top: 0.25rem;">{{ $message }}</small>
        @enderror
      </div>

      <!-- Info -->
      <div style="background-color: #f8f9fa; padding: 1rem; border-radius: 0.3rem; margin-bottom: 1.5rem; font-size: 0.9rem; color: #666;">
        <p style="margin: 0 0 0.5rem 0;"><strong>Produk dalam kategori:</strong> {{ $category->products->count() }}</p>
        <p style="margin: 0;">Dibuat {{ $category->created_at->format('d/m/Y H:i') }}</p>
      </div>

      <!-- Tombol -->
      <div style="display: flex; gap: 1rem;">
        <button type="submit" 
                style="flex: 1; padding: 0.85rem; background-color: #1e09e2; color: white; border: none; border-radius: 0.3rem; font-size: 1rem; font-weight: 600; cursor: pointer; transition: 0.3s; font-family: 'Poppins', sans-serif;"
                onmouseover="this.style.backgroundColor='#1a07b8'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 5px 15px rgba(30, 9, 226, 0.3)'"
                onmouseout="this.style.backgroundColor='#1e09e2'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">
          Update Kategori
        </button>
        <a href="{{ route('categories.index') }}" 
           style="flex: 1; padding: 0.85rem; background-color: #6c757d; color: white; border: none; border-radius: 0.3rem; font-size: 1rem; font-weight: 600; cursor: pointer; text-align: center; text-decoration: none; transition: 0.3s; display: inline-block; font-family: 'Poppins', sans-serif;"
           onmouseover="this.style.backgroundColor='#5a6268'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 5px 15px rgba(0, 0, 0, 0.1)'"
           onmouseout="this.style.backgroundColor='#6c757d'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">
          Batal
        </a>
      </div>
    </form>
  </div>
</div>

<script>
  feather.replace();
</script>
@endsection
