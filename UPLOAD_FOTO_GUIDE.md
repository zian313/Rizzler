# 📸 Panduan Upload Foto Produk di Laravel 12

## ✅ Yang Sudah Dilakukan:

### 1. **Direktori Storage**
- ✓ Dibuat: `storage/app/public/products/`
- Untuk menyimpan foto produk yang diupload

### 2. **ImageUploadService** 
File: [app/Services/ImageUploadService.php](app/Services/ImageUploadService.php)

```php
// Fitur:
- upload() : Upload dan simpan file
- delete() : Hapus file dari storage
- getUrl() : Dapatkan URL gambar
```

### 3. **ProductController**
File: [app/Http/Controllers/ProductController.php](app/Http/Controllers/ProductController.php)

```php
// store() : Upload foto saat create
// update() : Update + hapus foto lama + upload foto baru
// destroy() : Hapus produk + hapus foto
```

---

## 🚀 Langkah Setup (Jalankan di Terminal)

### **Step 1: Buat Symlink Storage**
```bash
php artisan storage:link
```

**Penjelasan:** Membuat shortcut dari `storage/app/public` ke `public/storage` agar gambar bisa diakses dari web.

**Output yang diharapkan:**
```
The [public/storage] directory has been linked to [storage/app/public].
```

### **Step 2: Set Permission (Opsional, jika di Linux)**
```bash
chmod -R 755 storage/app/public
chmod -R 755 storage/app/public/products
```

### **Step 3: Clear Cache (Pastikan Konfigurasi ter-update)**
```bash
php artisan config:clear
php artisan cache:clear
```

---

## 📋 Cara Menggunakan

### **Upload Foto Baru (Create)**
1. Buka: `http://localhost:8000/products/create`
2. Isi form produk
3. Pilih file gambar di field "Gambar Produk"
4. Klik "Simpan"

**Format yang diizinkan:**
- JPEG, PNG, JPG, GIF
- Max size: 2MB

### **Update/Edit Foto**
1. Buka: `http://localhost:8000/products/{id}/edit`
2. Ubah data produk
3. (Opsional) Upload gambar baru
4. Klik "Simpan Perubahan"

**Catatan:** Jika upload gambar baru, gambar lama otomatis dihapus

### **Hapus Produk (Beserta Foto)**
1. Klik tombol "Hapus" di halaman produk
2. Confirm
3. Produk dan foto otomatis dihapus

---

## 🗂️ Struktur File Upload

```
storage/
└── app/
    └── public/
        └── products/
            ├── 1736872345_abc123.jpg
            ├── 1736872456_def456.png
            └── ...
```

**Di Web:**
```
public/
└── storage/
    └── products/
        ├── 1736872345_abc123.jpg  ← Bisa diakses via URL
        └── ...
```

---

## 📝 Validasi Upload

```php
'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'

// Penjelasan:
// - nullable : File opsional (boleh tidak ada)
// - image : Harus file gambar
// - mimes:jpeg,png,jpg,gif : Format yang diizinkan
// - max:2048 : Ukuran max 2MB
```

---

## 🔧 Troubleshooting

### **❌ Error: "The image field must be an image"**
- **Solusi:** Pastikan file yang di-upload adalah gambar valid

### **❌ Error: "The image must not be greater than 2048 kilobytes"**
- **Solusi:** Kompres gambar atau upload gambar yang lebih kecil

### **❌ Gambar tidak muncul**
- **Solusi 1:** Jalankan `php artisan storage:link`
- **Solusi 2:** Check apakah file ada di `storage/app/public/products/`
- **Solusi 3:** Clear cache: `php artisan config:clear`

### **❌ Permission Denied di Linux**
- **Solusi:** 
```bash
sudo chown -R www-data:www-data storage/
sudo chmod -R 775 storage/app/public
```

---

## 💾 Kode di View

```blade
<!-- Form Create/Edit Produk -->
<form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <!-- Input File -->
    <div class="mb-3">
        <label for="image" class="form-label">Gambar Produk</label>
        <input type="file" class="form-control @error('image') is-invalid @enderror" 
               id="image" name="image" accept="image/*">
        <small>Format: JPEG, PNG, JPG, GIF (Max 2MB)</small>
    </div>
    
    <!-- Tampilkan Error -->
    @error('image')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    
    <button type="submit" class="btn btn-primary">Simpan</button>
</form>

<!-- Tampilkan Gambar di View -->
@if($product->image)
    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="300">
@else
    <img src="https://via.placeholder.com/300" alt="No Image">
@endif
```

---

## 📚 Referensi Kode

### **Upload Service:**
[app/Services/ImageUploadService.php](app/Services/ImageUploadService.php)

### **Controller:**
[app/Http/Controllers/ProductController.php](app/Http/Controllers/ProductController.php)

### **View Create:**
[resources/views/products/create.blade.php](resources/views/products/create.blade.php)

### **View Edit:**
[resources/views/products/edit.blade.php](resources/views/products/edit.blade.php)

### **View Show:**
[resources/views/products/show.blade.php](resources/views/products/show.blade.php)

---

## ✨ Fitur Tambahan

### **Preview Gambar Sebelum Upload (Opsional)**

```html
<input type="file" id="imageInput" accept="image/*">
<img id="imagePreview" src="" alt="Preview">

<script>
document.getElementById('imageInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const reader = new FileReader();
    
    reader.onload = function(event) {
        document.getElementById('imagePreview').src = event.target.result;
    }
    
    reader.readAsDataURL(file);
});
</script>
```

### **Compress Gambar Sebelum Upload (Opsional)**
```bash
composer require intervention/image
```

---

**Selesai! Fitur upload foto sudah siap digunakan!** 🎉
