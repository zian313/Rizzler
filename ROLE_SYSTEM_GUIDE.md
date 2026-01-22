# 📋 Dokumentasi Sistem ROLE

## Daftar Isi
1. [Pengenalan](#pengenalan)
2. [Fitur Utama](#fitur-utama)
3. [Akun Admin](#akun-admin)
4. [User Pembeli](#user-pembeli)
5. [Middleware & Route Protection](#middleware--route-protection)
6. [Cara Membuat Admin Baru](#cara-membuat-admin-baru)

---

## Pengenalan

Sistem Role telah diimplementasikan untuk memisahkan akses dan tampilan antara **Admin** dan **Pembeli**. Setiap pengguna memiliki peran (role) yang menentukan apa yang dapat mereka akses dan lihat di aplikasi.

### Tipe Role yang Tersedia:
- **admin** - Mengelola kategori dan produk
- **pembeli** - Berbelanja dan melakukan pemesanan

---

## Fitur Utama

### 🛡️ Middleware `CheckRole`
File: `app/Http/Middleware/CheckRole.php`

Middleware ini melindungi route berdasarkan role pengguna. Penggunaan:
```php
Route::middleware('role:admin')->group(function () {
    // Routes hanya untuk admin
});

Route::middleware('role:pembeli')->group(function () {
    // Routes hanya untuk pembeli
});
```

### 📊 Helper Methods di User Model
File: `app/Models/User.php`

```php
// Check jika user adalah admin
auth()->user()->isAdmin();

// Check jika user adalah pembeli
auth()->user()->isPembeli();
```

---

## Akun Admin

### Kredensial Admin Default:
- **Email**: `admin@example.com`
- **Password**: `password123`

### Fitur Admin:
✅ Akses Dashboard Admin di `/admin/dashboard`  
✅ Menambah Kategori Produk  
✅ Menambah Produk  
✅ Mengedit Kategori Produk  
✅ Mengedit Produk  
✅ Menghapus Kategori Produk  
✅ Menghapus Produk  
✅ Lihat statistik di dashboard  

### Tampilan Admin:
- Navbar menampilkan link Dashboard Admin (merah)
- Menu tambah kategori dan produk
- Badge `[ADMIN]` di nama pengguna
- Tidak memiliki akses ke keranjang belanja

---

## User Pembeli

### Proses Registrasi:
Saat pengguna mendaftar melalui form registrasi, role mereka **otomatis menjadi "pembeli"**.

### Fitur Pembeli:
✅ Melihat daftar kategori  
✅ Melihat daftar produk  
✅ Menambah produk ke keranjang  
✅ Checkout dan membuat pesanan  
✅ Melihat riwayat pesanan  

### Tampilan Pembeli:
- Badge `[PEMBELI]` di nama pengguna  
- Akses ke keranjang belanja (shopping cart icon)  
- Link "Pesanan Saya" di navbar  
- Dashboard admin **tidak dapat diakses**  

---

## Middleware & Route Protection

### Route Structure:
```
/                                    → Public (semua orang)
/login, /register                   → Public
/categories, /products              → Public (bisa lihat)
/admin/dashboard                    → Admin Only
/categories/create, /edit, /delete  → Admin Only
/products/create, /edit, /delete    → Admin Only
/cart/*                             → Pembeli Only
/orders/*                           → Pembeli Only
```

### Response untuk Unauthorized Access:
Jika pengguna mencoba mengakses route yang tidak sesuai role mereka:
- Status: `403 Forbidden`
- Pesan: "Unauthorized access"

---

## Cara Membuat Admin Baru

### Menggunakan Artisan Command:

**Dengan input interaktif:**
```bash
php artisan app:create-admin
```
Maka akan diminta untuk input:
- Nama Admin
- Email Admin
- Password Admin

**Dengan argument langsung:**
```bash
php artisan app:create-admin "Nama Admin" "email@example.com" "password123"
```

### Contoh:
```bash
php artisan app:create-admin "John Admin" "john@admin.com" "securepassword123"
```

---

## Database Schema

### Table Users (Kolom Role):
```sql
ALTER TABLE users ADD COLUMN role ENUM('admin', 'pembeli') DEFAULT 'pembeli';
```

Migration file: `database/migrations/0001_01_01_000009_add_role_to_users_table.php`

---

## Testing

### Test Login Admin:
1. Buka `/login`
2. Email: `admin@example.com`
3. Password: `password123`
4. Klik Login
5. Akan diredirect ke `/admin/dashboard`

### Test Registrasi Pembeli:
1. Buka `/register`
2. Isi form dengan data baru
3. Klik Register
4. Redirect ke login
5. Login dengan akun baru
6. Akan diredirect ke home (sebagai pembeli)
7. Bisa akses keranjang belanja

---

## Customization

### Mengubah Role:
```php
// Di database, update role user
$user = User::find($id);
$user->update(['role' => 'admin']);
```

### Menambah Role Baru:
1. Update enum di migration
2. Update middleware
3. Tambahkan helper method di User model
4. Update routes

---

## Security Notes

🔒 Password admin sebaiknya diubah setelah instalasi  
🔒 Jangan biarkan perintah `app:create-admin` terekspos ke publik  
🔒 Selalu gunakan HTTPS di production  
🔒 Validasi role di setiap protected endpoint  

---

**Last Updated**: Januari 2026
