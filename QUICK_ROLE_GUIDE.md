# 🎯 Panduan Singkat Sistem ROLE

## Ringkas & Cepat

### ✅ Apa yang Sudah Selesai?

1. **Database Migration** ✓
   - Tambah kolom `role` (enum: 'admin', 'pembeli') ke tabel users
   - Default untuk user baru adalah 'pembeli'

2. **User Model** ✓
   - Tambah fillable: `'role'`
   - Tambah helper methods: `isAdmin()`, `isPembeli()`

3. **Authentication** ✓
   - Register otomatis assign role 'pembeli'
   - Login admin redirect ke dashboard admin
   - Login pembeli redirect ke home

4. **Middleware** ✓
   - File: `app/Http/Middleware/CheckRole.php`
   - Syntax: `middleware('role:admin')` atau `middleware('role:pembeli')`

5. **Routes Protection** ✓
   - Admin routes: kategori create/edit/delete, produk create/edit/delete
   - Pembeli routes: cart, orders

6. **UI Differentiation** ✓
   - Navbar berbeda untuk admin dan pembeli
   - Badge role di navbar
   - Menu berbeda sesuai role

7. **Admin Dashboard** ✓
   - Routes: `/admin/dashboard`
   - Tampilkan statistik: total produk, kategori, pesanan, pembeli
   - Quick actions untuk manage produk & kategori

8. **Admin Account** ✓
   - Email: `admin@example.com`
   - Password: `password123`
   - Command: `php artisan app:create-admin`

---

## 🚀 Cara Mencoba

### Login sebagai Admin:
```
URL: http://localhost:8000/login
Email: admin@example.com
Password: password123
```

Klik tombol Login → akan redirect ke `/admin/dashboard`

**Akses admin:**
- Dashboard statistik
- Tambah/Edit/Hapus Kategori
- Tambah/Edit/Hapus Produk

---

### Register sebagai Pembeli:
```
URL: http://localhost:8000/register
```

Isi form → Klik Register → Akan redirect ke login

Login dengan akun baru → akan redirect ke home

**Akses pembeli:**
- Lihat produk
- Tambah ke keranjang
- Checkout
- Lihat pesanan

---

## 📁 File-file yang Dibuat/Dimodifikasi

### Baru Dibuat:
- ✅ `app/Http/Middleware/CheckRole.php` - Middleware untuk check role
- ✅ `app/Console/Commands/CreateAdminUser.php` - Command buat admin
- ✅ `app/Http/Controllers/AdminDashboardController.php` - Controller dashboard admin
- ✅ `resources/views/admin/dashboard.blade.php` - View dashboard admin
- ✅ `database/migrations/0001_01_01_000009_add_role_to_users_table.php` - Migration tambah role

### Dimodifikasi:
- ✅ `app/Models/User.php` - Tambah fillable dan helper methods
- ✅ `app/Http/Controllers/AuthController.php` - Assign role di register & redirect di login
- ✅ `bootstrap/app.php` - Register middleware
- ✅ `routes/web.php` - Pisahkan routes berdasarkan role
- ✅ `resources/views/navbar.blade.php` - Tampilan berbeda per role

---

## 🔑 Key Features

| Fitur | Admin | Pembeli |
|-------|-------|---------|
| Lihat Produk | ✅ | ✅ |
| Tambah Produk | ✅ | ❌ |
| Edit Produk | ✅ | ❌ |
| Hapus Produk | ✅ | ❌ |
| Kelola Kategori | ✅ | ❌ |
| Akses Keranjang | ❌ | ✅ |
| Akses Pesanan | ❌ | ✅ |
| Dashboard Admin | ✅ | ❌ |
| Badge di Navbar | [ADMIN] | [PEMBELI] |

---

## 💡 Tips & Tricks

### Membuat Admin Baru via Terminal:
```bash
php artisan app:create-admin "Nama" "email@example.com" "password"
```

### Testing Access Denied:
Sebagai pembeli, coba akses `/admin/dashboard` → akan dapat error 403

Sebagai admin, coba akses `/cart` → akan dapat error 403

### Debugging Role:
Di Blade template:
```blade
@if (auth()->user()->isAdmin())
    <!-- Admin hanya -->
@endif

@if (auth()->user()->isPembeli())
    <!-- Pembeli hanya -->
@endif
```

---

## 📞 Troubleshooting

**Q: Admin tidak bisa login**
A: Pastikan sudah run `php artisan migrate` dan admin user sudah dibuat

**Q: Pembeli tidak bisa akses cart**
A: Pastikan role pembeli sudah di database (otomatis saat register)

**Q: Error 403 saat akses admin dashboard**
A: Check apakah Anda login dengan role admin, bukan pembeli

---

**Status**: ✅ SELESAI - Ready to use!
