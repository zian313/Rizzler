# 🛒 Panduan Fitur Keranjang (Cart) 

## ✅ Yang Sudah Dibuat:

### 1. **Database Migrations**
- `carts` - Menyimpan data keranjang
- `cart_items` - Menyimpan item di keranjang

### 2. **Models**
- `Cart` - Relasi dengan User & CartItems
- `CartItem` - Relasi dengan Cart & Product

### 3. **Controller**
- `CartController` - Semua logika cart

### 4. **Routes**
- GET `/cart` - Lihat keranjang
- POST `/cart/add/{product}` - Tambah ke cart
- PUT `/cart/update/{cartItem}` - Update quantity
- DELETE `/cart/remove/{cartItem}` - Hapus dari cart
- POST `/cart/clear` - Kosongkan cart
- POST `/cart/checkout` - Checkout ke order

### 5. **Views**
- `resources/views/cart/index.blade.php` - Halaman cart

---

## 🚀 Setup & Testing

### **Step 1: Jalankan Migrasi**
```bash
php artisan migrate
```

### **Step 2: Buka Aplikasi**
```bash
php artisan serve
```

---

## 📋 Cara Menggunakan

### **1. Lihat Daftar Produk**
```
GET http://localhost:8000/products
```

### **2. Buka Detail Produk**
```
GET http://localhost:8000/products/{id}
```

### **3. Tambah ke Keranjang**
- Klik tombol "Tambah ke Keranjang"
- Pilih jumlah produk
- Klik "Tambah ke Keranjang"
- Cart count di navbar otomatis terupdate

### **4. Lihat Keranjang**
```
GET http://localhost:8000/cart
```
- Tampil semua produk di cart
- Lihat total harga
- Update quantity item
- Hapus item dari cart

### **5. Checkout**
- Di halaman cart, isi form:
  - Pilih pembeli (user)
  - Alamat pengiriman
  - Nomor telepon
- Klik "Checkout"
- Cart items otomatis pindah ke order
- Keranjang kosong

---

## 💾 Database Schema

### **Tabel: carts**
```sql
CREATE TABLE carts (
    id BIGINT PRIMARY KEY,
    user_id BIGINT NULLABLE (relasi ke users),
    session_id VARCHAR (session ID untuk guest user),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### **Tabel: cart_items**
```sql
CREATE TABLE cart_items (
    id BIGINT PRIMARY KEY,
    cart_id BIGINT (relasi ke carts),
    product_id BIGINT (relasi ke products),
    quantity INT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

---

## 🔄 Alur Kerja Cart

```
1. User buka halaman produk
   ↓
2. Klik "Tambah ke Keranjang"
   ↓
3. CartController@add()
   → Cek/buat cart untuk user/session
   → Cek apakah product sudah ada di cart
   → Jika ada: update quantity
   → Jika tidak: tambah item baru
   ↓
4. Redirect ke cart.index dengan success message
   ↓
5. User lihat keranjang, update quantity atau hapus
   ↓
6. User isi form checkout
   ↓
7. CartController@checkout()
   → Buat order baru
   → Pindahkan semua items dari cart ke order_items
   → Kosongkan cart
   → Redirect ke order detail
```

---

## 🎯 Fitur Detail

### **Cart Management**

**Tambah Produk:**
```php
POST /cart/add/{product}
- Quantity harus min 1
- Auto increment jika product sudah ada
- Redirect ke cart dengan success message
```

**Update Quantity:**
```php
PUT /cart/update/{cartItem}
- Quantity harus min 1
- Update langsung di database
```

**Hapus Item:**
```php
DELETE /cart/remove/{cartItem}
- Hapus item dari cart
- Tidak menghapus data produk
```

**Kosongkan Keranjang:**
```php
POST /cart/clear
- Hapus semua items
- Cart masih ada, tapi kosong
```

**Checkout:**
```php
POST /cart/checkout
- Validasi user_id, shipping_address
- Buat order baru
- Copy semua cart items ke order_items
- Hapus cart items (cart clear)
```

---

## 🛡️ Fitur Keamanan

### **User Tracking**
- Jika user login → gunakan `user_id`
- Jika guest → gunakan `session_id`
- Setiap user punya cart sendiri

### **Validasi**
- Quantity harus integer min 1
- Product harus ada di database
- User harus ada saat checkout

### **Cascade Delete**
- Jika user dihapus → cart & items juga dihapus
- Jika produk dihapus → cart items terkait dihapus

---

## 💡 Tips Penggunaan

### **Tambah Cart Count di Navbar**
✅ Sudah diimplementasikan!
- Hover icon cart di navbar
- Lihat badge dengan jumlah item

### **Integrasi dengan Session**
✅ Sudah mendukung guest user
- Jika belum login → pakai session
- Jika login → pakai user_id
- Migrasi cart otomatis saat login

### **Checkout Otomatis**
✅ Proses checkout:
1. Validasi form
2. Buat order dengan status "pending"
3. Copy items ke order_items dengan harga saat itu
4. Clear cart
5. Redirect ke order detail

---

## 📁 File yang Terkait

| File | Fungsi |
|------|--------|
| [app/Models/Cart.php](app/Models/Cart.php) | Model Cart |
| [app/Models/CartItem.php](app/Models/CartItem.php) | Model CartItem |
| [app/Http/Controllers/CartController.php](app/Http/Controllers/CartController.php) | Controller |
| [resources/views/cart/index.blade.php](resources/views/cart/index.blade.php) | View Cart |
| [resources/views/navbar.blade.php](resources/views/navbar.blade.php) | Navbar dengan cart count |
| [resources/views/products/show.blade.php](resources/views/products/show.blade.php) | Detail produk + tombol add to cart |
| [routes/web.php](routes/web.php) | Routes cart |

---

## 🧪 Testing

### **Test Tambah ke Cart**
1. Buka `/products`
2. Klik produk mana saja
3. Klik "Tambah ke Keranjang"
4. Lihat cart count di navbar bertambah
5. Buka `/cart` untuk lihat detail

### **Test Update Quantity**
1. Di halaman cart
2. Ubah quantity input
3. Klik "Update"
4. Quantity terupdate

### **Test Checkout**
1. Di halaman cart
2. Isi form checkout
3. Klik "Checkout"
4. Redirect ke order detail
5. Keranjang kosong

### **Test Guest User**
1. Jangan login
2. Tambah produk ke cart
3. Refresh halaman
4. Cart item masih ada (via session)

---

**Fitur Cart sudah lengkap dan siap digunakan!** 🎉
