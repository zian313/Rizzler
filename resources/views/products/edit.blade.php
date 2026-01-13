@extends('layout')

@section('title', 'Edit Produk')

@section('content')
<div style="padding-top: 120px; padding-bottom: 3rem;">
  <div style="max-width: 600px; margin: 0 auto; background: white; padding: 2rem; border-radius: 0.5rem; box-shadow: 0 2px 10px rgba(30, 9, 226, 0.1);">
    
    <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 2rem; color: #000;">Edit Produk</h1>

    @if ($errors->any())
      <div style="background-color: #f8d7da; color: #721c24; padding: 1rem; border-radius: 0.3rem; margin-bottom: 1.5rem; border: 1px solid #f5c6cb;">
        <p style="font-weight: 600; margin-bottom: 0.5rem;">Terjadi kesalahan:</p>
        @foreach ($errors->all() as $error)
          <p style="margin: 0.25rem 0; font-size: 0.9rem;">• {{ $error }}</p>
        @endforeach
      </div>
    @endif

    <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <!-- Nama Produk -->
      <div style="margin-bottom: 1.5rem;">
        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #000; font-size: 1rem;">Nama Produk <span style="color: #dc3545;">*</span></label>
        <input type="text" name="name" 
               style="width: 100%; padding: 0.75rem; border: 1px solid {{ $errors->has('name') ? '#dc3545' : '#ddd' }}; border-radius: 0.3rem; font-size: 0.95rem; font-family: 'Poppins', sans-serif; transition: 0.3s;"
               value="{{ old('name', $product->name) }}" 
               placeholder="Masukkan nama produk"
               onmouseover="this.style.borderColor='#1e09e2'"
               onmouseout="this.style.borderColor='{{ $errors->has('name') ? '#dc3545' : '#ddd' }}'"
               required>
        @error('name')
          <small style="color: #dc3545; display: block; margin-top: 0.25rem;">{{ $message }}</small>
        @enderror
      </div>

      <!-- Deskripsi -->
      <div style="margin-bottom: 1.5rem;">
        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #000; font-size: 1rem;">Deskripsi</label>
        <textarea name="description" 
                  style="width: 100%; padding: 0.75rem; border: 1px solid {{ $errors->has('description') ? '#dc3545' : '#ddd' }}; border-radius: 0.3rem; font-size: 0.95rem; font-family: 'Poppins', sans-serif; resize: vertical; min-height: 100px; transition: 0.3s;"
                  placeholder="Masukkan deskripsi produk (opsional)"
                  onmouseover="this.style.borderColor='#1e09e2'"
                  onmouseout="this.style.borderColor='{{ $errors->has('description') ? '#dc3545' : '#ddd' }}'">{{ old('description', $product->description) }}</textarea>
        @error('description')
          <small style="color: #dc3545; display: block; margin-top: 0.25rem;">{{ $message }}</small>
        @enderror
      </div>

      <!-- Harga -->
      <div style="margin-bottom: 1.5rem;">
        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #000; font-size: 1rem;">Harga (Rp) <span style="color: #dc3545;">*</span></label>
        <input type="number" name="price" step="0.01" 
               style="width: 100%; padding: 0.75rem; border: 1px solid {{ $errors->has('price') ? '#dc3545' : '#ddd' }}; border-radius: 0.3rem; font-size: 0.95rem; font-family: 'Poppins', sans-serif; transition: 0.3s;"
               value="{{ old('price', $product->price) }}" 
               placeholder="0"
               onmouseover="this.style.borderColor='#1e09e2'"
               onmouseout="this.style.borderColor='{{ $errors->has('price') ? '#dc3545' : '#ddd' }}'"
               required>
        @error('price')
          <small style="color: #dc3545; display: block; margin-top: 0.25rem;">{{ $message }}</small>
        @enderror
      </div>

      <!-- Stok -->
      <div style="margin-bottom: 1.5rem;">
        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #000; font-size: 1rem;">Stok <span style="color: #dc3545;">*</span></label>
        <input type="number" name="stock" 
               style="width: 100%; padding: 0.75rem; border: 1px solid {{ $errors->has('stock') ? '#dc3545' : '#ddd' }}; border-radius: 0.3rem; font-size: 0.95rem; font-family: 'Poppins', sans-serif; transition: 0.3s;"
               value="{{ old('stock', $product->stock) }}" 
               placeholder="0"
               onmouseover="this.style.borderColor='#1e09e2'"
               onmouseout="this.style.borderColor='{{ $errors->has('stock') ? '#dc3545' : '#ddd' }}'"
               required>
        @error('stock')
          <small style="color: #dc3545; display: block; margin-top: 0.25rem;">{{ $message }}</small>
        @enderror
      </div>

      <!-- Kategori -->
      <div style="margin-bottom: 1.5rem;">
        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #000; font-size: 1rem;">Kategori <span style="color: #dc3545;">*</span></label>
        <div style="position: relative;">
          <select name="category_id" 
                  style="width: 100%; padding: 0.75rem 2.5rem 0.75rem 0.75rem; border: 1px solid {{ $errors->has('category_id') ? '#dc3545' : '#ddd' }}; border-radius: 0.3rem; font-size: 0.95rem; font-family: 'Poppins', sans-serif; background-color: white; appearance: none; -webkit-appearance: none; -moz-appearance: none; cursor: pointer; transition: 0.3s;"
                  onmouseover="this.style.borderColor='#1e09e2'"
                  onmouseout="this.style.borderColor='{{ $errors->has('category_id') ? '#dc3545' : '#ddd' }}'"
                  required>
            <option value="">-- Pilih Kategori --</option>
            @foreach ($categories as $category)
              <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
              </option>
            @endforeach
          </select>
          <span style="position: absolute; right: 0.75rem; top: 50%; transform: translateY(-50%); pointer-events: none; font-size: 0.8rem; color: #666;">▼</span>
        </div>
        @error('category_id')
          <small style="color: #dc3545; display: block; margin-top: 0.25rem;">{{ $message }}</small>
        @enderror
      </div>

      <!-- Gambar Produk -->
      <div style="margin-bottom: 2rem;">
        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #000; font-size: 1rem;">Gambar Produk</label>
        
        @if ($product->image)
          <div style="margin-bottom: 1rem;">
            <p style="font-size: 0.9rem; color: #666; margin-bottom: 0.5rem;">Gambar saat ini:</p>
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="max-width: 150px; border-radius: 0.3rem; border: 1px solid #ddd;">
          </div>
        @endif

        <div style="position: relative;">
          <input type="file" name="image" accept="image/*" 
                 style="width: 100%; padding: 0.75rem; border: 2px dashed {{ $errors->has('image') ? '#dc3545' : '#ddd' }}; border-radius: 0.3rem; font-size: 0.95rem; font-family: 'Poppins', sans-serif; cursor: pointer; transition: 0.3s;"
                 id="image-input"
                 onchange="previewImage(event)">
          <small style="display: block; margin-top: 0.5rem; color: #666;">Format: JPEG, PNG, JPG, GIF | Max: 2MB (Kosongkan jika tidak ingin mengubah)</small>
        </div>

        <div id="preview-container" style="margin-top: 1rem; display: none;">
          <p style="font-weight: 600; margin-bottom: 0.5rem; color: #000;">Preview Baru:</p>
          <img id="preview-image" style="max-width: 200px; border-radius: 0.3rem; border: 1px solid #ddd;">
        </div>

        @error('image')
          <small style="color: #dc3545; display: block; margin-top: 0.25rem;">{{ $message }}</small>
        @enderror
      </div>

      <!-- Tombol -->
      <div style="display: flex; gap: 1rem;">
        <button type="submit" 
                style="flex: 1; padding: 0.85rem; background-color: #1e09e2; color: white; border: none; border-radius: 0.3rem; font-size: 1rem; font-weight: 600; cursor: pointer; transition: 0.3s; font-family: 'Poppins', sans-serif;"
                onmouseover="this.style.backgroundColor='#1a07b8'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 5px 15px rgba(30, 9, 226, 0.3)'"
                onmouseout="this.style.backgroundColor='#1e09e2'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">
          Update Produk
        </button>
        <a href="{{ route('products.index') }}" 
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
  function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        document.getElementById('preview-image').src = e.target.result;
        document.getElementById('preview-container').style.display = 'block';
      }
      reader.readAsDataURL(file);
    }
  }

  feather.replace();
</script>
@endsection
