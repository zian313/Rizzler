@extends('layout')

@section('title', 'Tambah Produk')

@section('content')
<div style="padding-top: 100px; padding-bottom: 3rem; background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: calc(100vh - 100px);">
  <div style="max-width: 800px; margin: 0 auto; padding: 0 1rem;">
    
    <!-- Header Card -->
    <div style="background: white; padding: 2rem; border-radius: 0.8rem; box-shadow: 0 4px 15px rgba(30, 9, 226, 0.1); margin-bottom: 2rem;">
      <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
        <span style="font-size: 2.5rem;">➕</span>
        <div>
          <h1 style="margin: 0; font-size: 2rem; font-weight: 700; color: #000;">Tambah Produk Baru</h1>
          <p style="margin: 0.25rem 0 0 0; color: #666; font-size: 0.95rem;">Tambahkan produk baru ke katalog toko Anda</p>
        </div>
      </div>
    </div>

    <!-- Alert Error -->
    @if ($errors->any())
      <div style="background-color: #f8d7da; border-left: 4px solid #dc3545; color: #721c24; padding: 1.5rem; border-radius: 0.5rem; margin-bottom: 2rem;">
        <p style="font-weight: 600; margin: 0 0 0.75rem 0; font-size: 1rem;">⚠️ Ada Kesalahan dalam Form:</p>
        <ul style="margin: 0; padding-left: 1.5rem;">
          @foreach ($errors->all() as $error)
            <li style="margin: 0.25rem 0;">{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <!-- Form Card -->
    <div style="background: white; padding: 2.5rem; border-radius: 0.8rem; box-shadow: 0 4px 15px rgba(30, 9, 226, 0.1);">
      <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
        @csrf

        <!-- Nama Produk -->
        <div style="margin-bottom: 2rem;">
          <label style="display: block; margin-bottom: 0.75rem; font-weight: 600; color: #000; font-size: 1rem;">
            📝 Nama Produk
            <span style="color: #dc3545; font-weight: bold;">*</span>
          </label>
          <input type="text" name="name" 
                 style="width: 100%; padding: 0.85rem 1rem; border: 2px solid {{ $errors->has('name') ? '#dc3545' : '#e0e0e0' }}; border-radius: 0.5rem; font-size: 1rem; font-family: 'Poppins', sans-serif; transition: 0.3s; box-sizing: border-box;"
                 value="{{ old('name') }}" 
                 placeholder="Contoh: Laptop Gaming ASUS ROG"
                 onmouseover="this.style.borderColor='#1e09e2'; this.style.boxShadow='0 0 0 3px rgba(30, 9, 226, 0.1)'"
                 onmouseout="this.style.borderColor='{{ $errors->has('name') ? '#dc3545' : '#e0e0e0' }}'; this.style.boxShadow='none'"
                 required>
          @error('name')
            <small style="color: #dc3545; display: block; margin-top: 0.5rem; font-size: 0.85rem;">{{ $message }}</small>
          @enderror
        </div>

        <!-- Deskripsi -->
        <div style="margin-bottom: 2rem;">
          <label style="display: block; margin-bottom: 0.75rem; font-weight: 600; color: #000; font-size: 1rem;">
            📄 Deskripsi Produk
          </label>
          <textarea name="description" rows="4"
                    style="width: 100%; padding: 0.85rem 1rem; border: 2px solid {{ $errors->has('description') ? '#dc3545' : '#e0e0e0' }}; border-radius: 0.5rem; font-size: 1rem; font-family: 'Poppins', sans-serif; resize: vertical; min-height: 120px; transition: 0.3s; box-sizing: border-box;"
                    placeholder="Jelaskan detail produk seperti spesifikasi, fitur, dan keunggulannya..."
                    onmouseover="this.style.borderColor='#1e09e2'; this.style.boxShadow='0 0 0 3px rgba(30, 9, 226, 0.1)'"
                    onmouseout="this.style.borderColor='{{ $errors->has('description') ? '#dc3545' : '#e0e0e0' }}'; this.style.boxShadow='none'">{{ old('description') }}</textarea>
          @error('description')
            <small style="color: #dc3545; display: block; margin-top: 0.5rem; font-size: 0.85rem;">{{ $message }}</small>
          @enderror
        </div>

        <!-- Harga dan Stok -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
          <!-- Harga -->
          <div>
            <label style="display: block; margin-bottom: 0.75rem; font-weight: 600; color: #000; font-size: 1rem;">
              💰 Harga (Rp)
              <span style="color: #dc3545; font-weight: bold;">*</span>
            </label>
            <input type="number" name="price" step="0.01" 
                   style="width: 100%; padding: 0.85rem 1rem; border: 2px solid {{ $errors->has('price') ? '#dc3545' : '#e0e0e0' }}; border-radius: 0.5rem; font-size: 1rem; font-family: 'Poppins', sans-serif; transition: 0.3s; box-sizing: border-box;"
                   value="{{ old('price') }}" 
                   placeholder="Contoh: 5000000"
                   onmouseover="this.style.borderColor='#1e09e2'; this.style.boxShadow='0 0 0 3px rgba(30, 9, 226, 0.1)'"
                   onmouseout="this.style.borderColor='{{ $errors->has('price') ? '#dc3545' : '#e0e0e0' }}'; this.style.boxShadow='none'"
                   required>
            @error('price')
              <small style="color: #dc3545; display: block; margin-top: 0.5rem; font-size: 0.85rem;">{{ $message }}</small>
            @enderror
          </div>

          <!-- Stok -->
          <div>
            <label style="display: block; margin-bottom: 0.75rem; font-weight: 600; color: #000; font-size: 1rem;">
              📦 Stok Produk
              <span style="color: #dc3545; font-weight: bold;">*</span>
            </label>
            <input type="number" name="stock" 
                   style="width: 100%; padding: 0.85rem 1rem; border: 2px solid {{ $errors->has('stock') ? '#dc3545' : '#e0e0e0' }}; border-radius: 0.5rem; font-size: 1rem; font-family: 'Poppins', sans-serif; transition: 0.3s; box-sizing: border-box;"
                   value="{{ old('stock') }}" 
                   placeholder="Contoh: 10"
                   onmouseover="this.style.borderColor='#1e09e2'; this.style.boxShadow='0 0 0 3px rgba(30, 9, 226, 0.1)'"
                   onmouseout="this.style.borderColor='{{ $errors->has('stock') ? '#dc3545' : '#e0e0e0' }}'; this.style.boxShadow='none'"
                   required>
            @error('stock')
              <small style="color: #dc3545; display: block; margin-top: 0.5rem; font-size: 0.85rem;">{{ $message }}</small>
            @enderror
          </div>
        </div>

        <!-- Kategori -->
        <div style="margin-bottom: 2rem;">
          <label style="display: block; margin-bottom: 0.75rem; font-weight: 600; color: #000; font-size: 1rem;">
            🏷️ Kategori Produk
            <span style="color: #dc3545; font-weight: bold;">*</span>
          </label>
          <div style="position: relative;">
            <select name="category_id" 
                    style="width: 100%; padding: 0.85rem 2.5rem 0.85rem 1rem; border: 2px solid {{ $errors->has('category_id') ? '#dc3545' : '#e0e0e0' }}; border-radius: 0.5rem; font-size: 1rem; font-family: 'Poppins', sans-serif; background-color: white; appearance: none; -webkit-appearance: none; -moz-appearance: none; cursor: pointer; transition: 0.3s; box-sizing: border-box;"
                    onchange="this.style.borderColor=this.value ? '#1e09e2' : '#e0e0e0'"
                    onmouseover="this.style.borderColor='#1e09e2'; this.style.boxShadow='0 0 0 3px rgba(30, 9, 226, 0.1)'"
                    onmouseout="this.style.borderColor='{{ $errors->has('category_id') ? '#dc3545' : '#e0e0e0' }}'; this.style.boxShadow='none'"
                    required>
              <option value="">-- Pilih Kategori --</option>
              @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                  {{ $category->name }}
                </option>
              @endforeach
            </select>
            <span style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); pointer-events: none; color: #999; font-size: 0.8rem;">▼</span>
          </div>
          @error('category_id')
            <small style="color: #dc3545; display: block; margin-top: 0.5rem; font-size: 0.85rem;">{{ $message }}</small>
          @enderror
        </div>

        <!-- Upload Gambar -->
        <div style="margin-bottom: 2.5rem;">
          <label style="display: block; margin-bottom: 0.75rem; font-weight: 600; color: #000; font-size: 1rem;">
            📸 Foto Produk
          </label>
          
          <div style="border: 2px dashed #1e09e2; border-radius: 0.8rem; padding: 2.5rem; text-align: center; cursor: pointer; transition: 0.3s; background: linear-gradient(135deg, rgba(30, 9, 226, 0.05) 0%, rgba(30, 9, 226, 0.02) 100%);"
               onclick="document.getElementById('image-input').click()"
               onmouseover="this.style.borderColor='#1a07b8'; this.style.backgroundColor='rgba(30, 9, 226, 0.1)'"
               onmouseout="this.style.borderColor='#1e09e2'; this.style.backgroundColor='linear-gradient(135deg, rgba(30, 9, 226, 0.05) 0%, rgba(30, 9, 226, 0.02) 100%)'">
            
            <input type="file" name="image" accept="image/*" 
                   style="display: none;"
                   id="image-input"
                   onchange="previewImage(event)">
            
            <div id="upload-prompt">
              <div style="font-size: 3rem; margin-bottom: 1rem;">📸</div>
              <p style="margin: 0 0 0.5rem 0; font-weight: 600; color: #333; font-size: 1.05rem;">Klik atau Drag Foto Produk</p>
              <p style="margin: 0; color: #999; font-size: 0.9rem;">Format: JPEG, PNG, GIF | Max: 2MB</p>
            </div>

            <div id="preview-container" style="display: none;">
              <img id="preview-image" style="max-width: 300px; max-height: 300px; border-radius: 0.5rem; border: 2px solid #1e09e2; box-shadow: 0 4px 10px rgba(30, 9, 226, 0.2);">
              <p style="margin: 1rem 0 0 0; color: #666; font-size: 0.9rem;">
                <strong id="filename"></strong><br>
                <small style="color: #999;">Klik atau drag untuk mengubah foto</small>
              </p>
            </div>
          </div>

          @error('image')
            <small style="color: #dc3545; display: block; margin-top: 0.75rem; font-size: 0.85rem;">{{ $message }}</small>
          @enderror
        </div>

        <!-- Buttons -->
        <div style="display: flex; gap: 1.5rem; padding-top: 1.5rem; border-top: 2px solid #f0f0f0;">
          <button type="submit" 
                  style="flex: 1; padding: 1rem 2rem; background: linear-gradient(135deg, #1e09e2 0%, #1a07b8 100%); color: white; border: none; border-radius: 0.6rem; font-size: 1.05rem; font-weight: 700; cursor: pointer; transition: 0.3s; font-family: 'Poppins', sans-serif; box-shadow: 0 4px 15px rgba(30, 9, 226, 0.3);"
                  onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 6px 20px rgba(30, 9, 226, 0.4)'"
                  onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(30, 9, 226, 0.3)'">
            ✅ Simpan Produk
          </button>
          <a href="{{ route('products.index') }}" 
             style="flex: 1; padding: 1rem 2rem; background-color: #e0e0e0; color: #333; border: none; border-radius: 0.6rem; font-size: 1.05rem; font-weight: 700; cursor: pointer; text-align: center; text-decoration: none; transition: 0.3s; display: inline-flex; align-items: center; justify-content: center; font-family: 'Poppins', sans-serif;"
             onmouseover="this.style.backgroundColor='#d0d0d0'; this.style.transform='translateY(-3px)'"
             onmouseout="this.style.backgroundColor='#e0e0e0'; this.style.transform='translateY(0)'">
            ❌ Batal
          </a>
        </div>
      </form>
    </div>

    <!-- Info Box -->
    <div style="background: #e3f2fd; border-left: 4px solid #1e09e2; padding: 1.5rem; border-radius: 0.5rem; margin-top: 2rem;">
      <p style="margin: 0; color: #1565c0; font-size: 0.95rem;">
        <strong>💡 Tips:</strong> Pastikan semua field wajib diisi dengan benar. Foto produk akan ditampilkan di halaman belanja pembeli.
      </p>
    </div>
  </div>
</div>

<script>
  function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
      // Validasi ukuran file
      if (file.size > 2 * 1024 * 1024) {
        alert('Ukuran file terlalu besar! Max 2MB');
        event.target.value = '';
        return;
      }

      // Validasi tipe file
      if (!['image/jpeg', 'image/png', 'image/gif', 'image/jpg'].includes(file.type)) {
        alert('Format file tidak didukung! Gunakan JPEG, PNG, atau GIF');
        event.target.value = '';
        return;
      }

      const reader = new FileReader();
      reader.onload = function(e) {
        document.getElementById('upload-prompt').style.display = 'none';
        document.getElementById('preview-container').style.display = 'block';
        document.getElementById('preview-image').src = e.target.result;
        document.getElementById('filename').textContent = file.name + ' (' + (file.size / 1024 / 1024).toFixed(2) + ' MB)';
      }
      reader.readAsDataURL(file);
    }
  }

  feather.replace();
</script>
@endsection

