# 📚 DOKUMENTASI LENGKAP ALUR LOGIKA PROYEK

## 📖 Daftar Isi
1. [Ringkasan Proyek](#ringkasan-proyek)
2. [Arsitektur Proyek](#arsitektur-proyek)
3. [Sistem Autentikasi & Role](#sistem-autentikasi--role)
4. [Alur Admin - Manajemen Produk](#alur-admin---manajemen-produk)
5. [Alur Pembeli - Belanja & Checkout](#alur-pembeli---belanja--checkout)
6. [Relasi Database](#relasi-database)
7. [Routes Lengkap](#routes-lengkap)
8. [Fitur Khusus](#fitur-khusus)
9. [Struktur File Penting](#struktur-file-penting)
10. [Flow Diagram Lengkap](#flow-diagram-lengkap)

---

## 🎯 Ringkasan Proyek

Proyek ini adalah **E-Commerce Marketplace** yang dibangun dengan **Laravel 11** dengan fitur lengkap:

✅ Sistem Role (Admin & Pembeli)  
✅ Manajemen Produk dan Kategori  
✅ Shopping Cart dengan manajemen item  
✅ Checkout dengan integrasi WhatsApp  
✅ Order Management  
✅ Upload Foto Produk  
✅ Sistem Session & Autentikasi  

---

## 🏗️ Arsitektur Proyek

```
┌─────────────────────────────────────┐
│   PENGGUNA / USER INTERFACE         │
│   (Views - Blade Templates)         │
└──────────────┬──────────────────────┘
               │
┌──────────────▼──────────────────────┐
│   ROUTES (web.php)                  │
│   Mendefinisikan semua endpoint      │
└──────────────┬──────────────────────┘
               │
┌──────────────▼──────────────────────┐
│   MIDDLEWARE (CheckRole)            │
│   Validasi role user (admin/pembeli)│
└──────────────┬──────────────────────┘
               │
┌──────────────▼──────────────────────┐
│   CONTROLLERS                       │
│   (Logika Bisnis)                   │
│   - AuthController                  │
│   - ProductController               │
│   - CartController                  │
│   - OrderController, dll            │
└──────────────┬──────────────────────┘
               │
┌──────────────▼──────────────────────┐
│   MODELS (Eloquent ORM)             │
│   User, Product, Cart, Order        │
└──────────────┬──────────────────────┘
               │
┌──────────────▼──────────────────────┐
│   DATABASE                          │
│   (MySQL / SQLite)                  │
└─────────────────────────────────────┘
```

---

## 🔐 Sistem Autentikasi & Role

### Flow Login/Register

```
┌─────────────────────────────────────┐
│     USER BARU - REGISTER            │
└────────────┬────────────────────────┘
             │
        /register
             │
             ▼
    AuthController::showRegister()
             │
             ▼
    view('auth.register') ← Tampil form
             │
             ▼
    User isi form & submit:
    - Name
    - Email
    - Password
    - Password Confirmation
             │
             ▼
    AuthController::register()
             │
    ┌────────┴────────┐
    │                 │
  VALIDASI          INPUT VALID
    │
    ▼
  ✗ Error
  → Kembali ke form
     dengan pesan error


                       → ✓ Valid
                         │
                         ▼
                   User::create([
                     'name' => request name
                     'email' => request email
                     'password' => Hash::make()
                     'role' => 'pembeli' ← AUTO
                   ])
                         │
                         ▼
                   Redirect /login
                   "Registrasi berhasil!"
```

```
┌─────────────────────────────────────┐
│     USER EXISTING - LOGIN           │
└────────────┬────────────────────────┘
             │
        /login
             │
             ▼
    AuthController::showLogin()
             │
             ▼
    view('auth.login') ← Tampil form
             │
             ▼
    User isi email & password
             │
             ▼
    AuthController::login()
             │
             ▼
    Auth::attempt($email, $password)
             │
    ┌────────┴────────┐
    │                 │
  GAGAL            BERHASIL
    │                 │
    ▼                 ▼
  Error          Session dibuat
  Message        (Auth::login())
  Kembali ke
  /login         ┌────────┴────────┐
                 │                 │
              Admin           Pembeli
                 │                 │
                 ▼                 ▼
            /admin/dashboard    /home
```

### Middleware CheckRole

```php
// File: app/Http/Middleware/CheckRole.php

// Melindungi route dengan validasi role

Route::middleware(['auth', 'role:admin'])->group(function () {
    // Hanya admin yang bisa akses
});

Route::middleware('role:pembeli')->group(function () {
    // Hanya pembeli yang bisa akses
});
```

**Cara Kerja:**
1. User request ke route yang dilindungi
2. Middleware cek `auth` → Apakah sudah login?
3. Jika sudah login, middleware cek `role:admin` → Apakah role='admin'?
4. JIKA OK → Lanjutkan ke controller
5. JIKA GAGAL → 403 Forbidden atau redirect

### Database User

```
users (Tabel)
├── id              : INT (Primary Key)
├── name            : VARCHAR (Nama pengguna)
├── email           : VARCHAR (Unik, untuk login)
├── email_verified_at : TIMESTAMP (nullable)
├── password        : VARCHAR (Hashed)
├── role            : VARCHAR ('admin' / 'pembeli')
├── remember_token  : VARCHAR (nullable)
├── created_at      : TIMESTAMP
└── updated_at      : TIMESTAMP
```

---

## 🛍️ Alur Admin - Manajemen Produk

### Diagram Flow Admin

```
┌─────────────────────────────────┐
│     ADMIN LOGIN (/login)        │
└────────────┬────────────────────┘
             │
        Email: admin@example.com
        Password: password123
             │
             ▼
    ┌─────────────────────────┐
    │   /admin/dashboard      │
    │   Dashboard Admin       │
    └────┬────────────────────┘
         │
    ┌────┴─────────────────────────┐
    │                              │
    ▼                              ▼
KATEGORI                        PRODUK
    │                              │
    ├─ Create                  ├─ Create
    ├─ Edit                    ├─ Edit
    ├─ Update                  ├─ Update
    └─ Delete                  └─ Delete
```

### Proses Tambah Produk - Lengkap

#### Step 1: Admin Buka Form
```
Admin klik "/products/create"
    │
    ▼
ProductController::create()
    │
    ├─ $categories = Category::all()
    │  └─ Ambil semua kategori dari database
    │
    └─ return view('products.create', compact('categories'))
       └─ Tampil form dengan dropdown kategori
```

#### Step 2: Form Produk
```
┌─────────────────────────────────────┐
│     FORM TAMBAH PRODUK              │
├─────────────────────────────────────┤
│ Nama Produk*:   [____________]      │
│                                     │
│ Deskripsi:      [____________]      │
│                                     │
│ Harga*:         [____________]      │
│                                     │
│ Stock*:         [____________]      │
│                                     │
│ Kategori*:      [ Pilih ▼ ]        │
│                 - Electronics       │
│                 - Clothing          │
│                 - Food              │
│                                     │
│ Foto Produk:    [Upload File]      │
│                 (Max: 2MB)          │
│                                     │
│            [✅ Tambah]              │
└─────────────────────────────────────┘
```

#### Step 3: Validasi & Proses
```
Admin submit form
    │
    ▼
ProductController::store(Request $request)
    │
    ▼
$request->validate([
    'name' => 'required|max:255',
    'description' => 'nullable|string',
    'price' => 'required|numeric|min:0',
    'stock' => 'required|integer|min:0',
    'category_id' => 'required|exists:categories,id',
    'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
])
    │
    ┌─────────────┬───────────────┐
    │             │               │
  GAGAL       BERHASIL        (image ada?)
    │             │               │
    ▼             │           ┌───┴────┐
  Back ke      YES│       NO→ │        │
  form +        │           │        │
  Error msg     │      upload│      skip
    │           │      foto   │        │
    │           │           └────┬────┘
    │           │                │
    │           ▼                ▼
    │      ImageUploadService::upload()
    │           │
    │           ├─ Generate nama file: timestamp_random.jpg
    │           ├─ Simpan ke: storage/app/products/
    │           └─ Return: nama_file.jpg
    │           │
    │           ▼
    │      Product::create([
    │          'name' => 'Laptop Gaming ASUS',
    │          'description' => '...',
    │          'price' => 15000000,
    │          'stock' => 5,
    │          'category_id' => 1,
    │          'image' => 'nama_file.jpg'
    │      ])
    │           │
    │           ▼
    └──→   Redirect /products
          "Produk berhasil ditambahkan"
```

### Database Produk & Kategori

```
categories (Tabel)
├── id           : INT (Primary Key)
├── name         : VARCHAR (Electronics, Clothing, dll)
├── description  : TEXT (nullable)
├── created_at   : TIMESTAMP
└── updated_at   : TIMESTAMP


products (Tabel)
├── id           : INT (Primary Key)
├── name         : VARCHAR (Nama produk)
├── description  : TEXT (nullable)
├── price        : DECIMAL (Harga)
├── stock        : INT (Stok tersedia)
├── category_id  : INT (FK → categories.id)
├── image        : VARCHAR (Nama file foto)
├── created_at   : TIMESTAMP
└── updated_at   : TIMESTAMP
```

---

## 🛒 Alur Pembeli - Belanja & Checkout

### Diagram Flow Pembeli

```
┌─────────────────────────────────┐
│   PEMBELI LOGIN (/login)        │
└────────────┬────────────────────┘
             │
             ▼
┌─────────────────────────────────┐
│   BERANDA (/home)               │
│   Lihat featured products       │
└────────────┬────────────────────┘
             │
         Klik "🛒 Belanja"
             │
             ▼
┌─────────────────────────────────┐
│   /products-pembeli             │
│   Daftar Produk Pembeli         │
├─────────────────────────────────┤
│ Filter Kategori: [ Pilih ▼ ]   │
│                                 │
│ Produk 1: Laptop                │
│ Harga: 15 juta | 🛒             │
│                                 │
│ Produk 2: Mouse                 │
│ Harga: 500k | 🛒                │
└────────┬──────────────────────┘
         │
    Klik "🛒"
         │
         ▼
    Form qty
    [____] 🛒 Tambah
         │
         ▼
    Redirect /cart
    "Produk ditambah!"
```

### Proses Tambah ke Cart - Detail

```
Pembeli di /products-pembeli
    │
    ├─ Lihat produk (foto + harga)
    ├─ Klik "🛒 Masukkan Keranjang"
    │
    ▼
Form Tambah ke Cart:
    │
    Quantity: [2]
    │
    ▼
CartController::add($product)
    │
    ▼
Validasi:
    quantity = required, integer, min:1
    │
    ┌─────────────────┐
    │                 │
  GAGAL           BERHASIL
    │                 │
    ▼                 ▼
  Error              │
  Message       getOrCreateCart()
  Back              │
                    ├─ CEK: Apakah user sudah punya cart?
                    │
                    ┌─────────────────┐
                    │                 │
                  BELUM           SUDAH ADA
                    │                 │
                    ▼                 ▼
                   CREATE          GUNAKAN
                  Cart baru       Cart lama
                    │                 │
                    └─────────────┬───┘
                                  │
                                  ▼
                    CEK: Apakah produk sudah di cart?
                                  │
                        ┌─────────┴──────────┐
                        │                    │
                      BELUM               SUDAH ADA
                        │                    │
                        ▼                    ▼
                    CartItem::create(    CartItem::update(
                      cart_id: ...,      quantity: lama+baru
                      product_id: ...,   )
                      quantity: 2
                    )
                        │                    │
                        └─────────────┬──────┘
                                      │
                                      ▼
                        Redirect /cart
                        "Produk ditambah!"
```

### Proses Lihat Cart

```
Pembeli klik cart icon
    │
    ▼
CartController::index()
    │
    ▼
$cart = $this->getCart()
    ├─ Cari cart milik user
    └─ Return Cart model
    │
    ▼
$cartItems = $cart->items()
              ->with('product')  ← Include product data
              ->get()
    │
    ├─ Ambil semua items di cart
    └─ Include data produk (nama, harga, foto)
    │
    ▼
$totalPrice = $cart->getTotalPrice()
    │
    ├─ Loop semua cartItems
    ├─ Hitung: product.price × quantity
    ├─ Jumlahkan semuanya
    └─ Return total
    │
    ▼
view('cart.index', [
    'cart' => $cart,
    'cartItems' => $cartItems,
    'totalPrice' => $totalPrice,
    'totalItems' => $cart->getTotalItems()
])
    │
    ▼
┌────────────────────────────────┐
│    HALAMAN KERANJANG BELANJA   │
├────────────────────────────────┤
│ Produk       Qty  Harga  Total │
├────────────────────────────────┤
│ Laptop       2    15jt   30jt  │ [qty] [Hapus]
│ Mouse        1    500k   500k  │ [qty] [Hapus]
├────────────────────────────────┤
│ TOTAL: 30.5 juta               │
├────────────────────────────────┤
│ [Lanjutkan] [Kosongkan] [Beli]│
└────────────────────────────────┘
```

### Proses Checkout - WhatsApp

```
Pembeli klik "Checkout"
    │
    ▼
Tampil Form Checkout:
    │
    ├─ Alamat Pengiriman*: [________________]
    ├─ Nomor Telepon*: [________________]
    └─ [Checkout via WhatsApp]
    │
    ▼
Pembeli isi data & submit
    │
    ▼
CartController::checkout()
    │
    ▼
Step 1: Validasi input
    ├─ shipping_address: required
    └─ phone: required
    │
    ▼
Step 2: Create Order baru
    │
    Order::create([
        'user_id' => Auth::id(),
        'shipping_address' => request alamat,
        'phone' => request telepon,
        'status' => 'pending',
        'total_price' => $cart->getTotalPrice()
    ])
    │
    ▼
Step 3: Copy CartItems → OrderItems
    │
    foreach ($cart->items as $item) {
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $item->product_id,
            'quantity' => $item->quantity,
            'price' => $item->product->price
        ])
    }
    │
    ▼
Step 4: Clear Cart
    │
    $cart->items()->delete()
    │
    ▼
Step 5: Generate WhatsApp Link
    │
    Pesan otomatis:
    ──────────────────
    "Halo Admin,
    
    Saya ingin memesan:
    
    Laptop x2 = 30 juta
    Mouse x1 = 500 ribu
    
    TOTAL: 30.5 juta
    
    Alamat: Jl. ABC No 123
    Telepon: 081234567890"
    ──────────────────
    │
    └─ Encode ke URL
       wa.me/62-admin-number
       ?text=<pesan-encoded>
    │
    ▼
Redirect ke link WhatsApp
    │
    ▼
┌────────────────────────────────┐
│  WHATSAPP TERBUKA / WEB        │
├────────────────────────────────┤
│ Admin menerima pesan           │
│ Dapat langsung reply/confirm   │
└────────────────────────────────┘
```

### Database Cart, CartItem, Order, OrderItem

```
carts (Tabel)
├── id           : INT (Primary Key)
├── user_id      : INT (FK → users.id)
├── session_id   : VARCHAR (nullable)
├── created_at   : TIMESTAMP
└── updated_at   : TIMESTAMP


cart_items (Tabel)
├── id           : INT (Primary Key)
├── cart_id      : INT (FK → carts.id)
├── product_id   : INT (FK → products.id)
├── quantity     : INT (Berapa banyak)
├── created_at   : TIMESTAMP
└── updated_at   : TIMESTAMP


orders (Tabel)
├── id                  : INT (Primary Key)
├── user_id             : INT (FK → users.id)
├── status              : VARCHAR (pending/confirmed/shipped/delivered)
├── total_price         : DECIMAL (Total harga order)
├── shipping_address    : TEXT (Alamat pengiriman)
├── phone               : VARCHAR (Nomor pembeli)
├── created_at          : TIMESTAMP
└── updated_at          : TIMESTAMP


order_items (Tabel)
├── id           : INT (Primary Key)
├── order_id     : INT (FK → orders.id)
├── product_id   : INT (FK → products.id)
├── quantity     : INT (Berapa banyak dipesan)
├── price        : DECIMAL (Harga saat order)
├── created_at   : TIMESTAMP
└── updated_at   : TIMESTAMP
```

---

## 🔄 Relasi Database

### Eloquent Relationships

```php
// User Relations
User::hasMany('carts')
User::hasMany('orders')

// Cart Relations
Cart::belongsTo('user')
Cart::hasMany('items')

// CartItem Relations
CartItem::belongsTo('cart')
CartItem::belongsTo('product')

// Category Relations
Category::hasMany('products')

// Product Relations
Product::belongsTo('category')
Product::hasMany('cartItems')
Product::hasMany('orderItems')

// Order Relations
Order::belongsTo('user')
Order::hasMany('items')

// OrderItem Relations
OrderItem::belongsTo('order')
OrderItem::belongsTo('product')
```

### Visual Relationship Diagram

```
        User
       /    \
      /      \
   Cart     Order
    │         │
    │         │
CartItem   OrderItem
   │         │
   └────┬────┘
        │
      Product
        │
        └─── Category
```

---

## 🛣️ Routes Lengkap

### Public Routes (Tanpa Login)

```
GET    /                       → Halaman Utama (Home)
GET    /register               → Tampil Form Register
POST   /register               → Proses Register
GET    /login                  → Tampil Form Login
POST   /login                  → Proses Login
GET    /categories             → Daftar Semua Kategori
GET    /categories/:id         → Detail Kategori
GET    /products               → Daftar Semua Produk
GET    /products/:id           → Detail Produk
```

### Auth Routes (Membutuhkan Login)

```
POST   /logout                 → Logout (require auth)
```

### Admin Routes (Login + role:admin)

```
GET    /admin/dashboard                   → Dashboard Admin
GET    /admin/dashboard                   → Lihat summary admin

KATEGORI:
GET    /categories/create                 → Form Buat Kategori
POST   /categories                        → Simpan Kategori
GET    /categories/:id/edit               → Form Edit Kategori
PUT    /categories/:id                    → Update Kategori
DELETE /categories/:id                    → Hapus Kategori

PRODUK:
GET    /products/create                   → Form Buat Produk
POST   /products                          → Simpan Produk
GET    /products/:id/edit                 → Form Edit Produk
PUT    /products/:id                      → Update Produk
DELETE /products/:id                      → Hapus Produk
```

### Pembeli Routes (Login + role:pembeli)

```
PRODUK:
GET    /products-pembeli                  → Lihat Produk (Pembeli)
└─ Dengan filter kategori optional

KERANJANG:
GET    /cart                              → Lihat Keranjang
POST   /cart/add/:product_id              → Tambah ke Cart
PUT    /cart/update/:cartItem_id          → Update Qty di Cart
DELETE /cart/remove/:cartItem_id          → Hapus dari Cart
POST   /cart/clear                        → Kosongkan Cart
POST   /cart/checkout                     → Checkout (Buat Order)

PESANAN:
GET    /orders                            → Daftar Pesanan Saya
GET    /orders/:id                        → Detail Pesanan
GET    /orders/:id/edit                   → Form Edit Pesanan
PUT    /orders/:id                        → Update Pesanan
```

---

## 📱 Fitur Khusus

### Upload Foto Produk

```
Admin upload foto saat tambah/edit produk
    │
    ▼
$request->file('image') ada?
    │
    ┌─────────────┴──────────────┐
    │                            │
  TIDAK                        YA
    │                            │
    ▼                            ▼
Skip upload            ImageUploadService::upload()
    │                            │
    │                    ┌──────┴──────────┐
    │                    │                 │
    │             Generate Name      Validate Type
    │                    │                 │
    │        timestamp_random.jpg   (jpg/png/gif)
    │                    │                 │
    │            └───────┬─────────────────┘
    │                    │
    │                    ▼
    │        Store ke: storage/app/products/
    │                    │
    │                    ▼
    │        Return: nama_file.jpg
    │                    │
    └────────┬───────────┘
             │
             ▼
    Update/Insert Product:
    'image' => 'nama_file.jpg'
             │
             ▼
    Saat ditampil:
    <img src="{{ asset('storage/products/' . $product->image) }}">
             │
             ▼
    URL: /storage/products/nama_file.jpg
```

**Edit Produk dengan Foto Baru:**
```
Admin upload foto baru
    │
    ▼
Foto lama ada?
    │
    ┌─────────────┴────────────┐
    │                          │
  TIDAK                      YA
    │                          │
    ▼                          ▼
Skip hapus              Hapus foto lama:
    │                  unlink(storage_path(...))
    │                          │
    └────────┬─────────────────┘
             │
             ▼
    Upload foto baru
    (proses sama seperti di atas)
             │
             ▼
    Update product.image
```

### Integrasi WhatsApp Checkout

```
Pembeli klik "Checkout via WhatsApp"
    │
    ▼
Generate Pesan Otomatis:
    │
    ┌────────────────────────────┐
    │ Halo Admin, saya memesan:  │
    │                            │
    │ Laptop x2 = 30 juta        │
    │ Mouse x1 = 500 ribu        │
    │                            │
    │ TOTAL: 30.5 juta           │
    │                            │
    │ Alamat: Jl. ABC No 123     │
    │ Telepon: 081234567890      │
    └────────────────────────────┘
    │
    ▼
Encode URL untuk WhatsApp:
    │
    wa.me/6283844492691?text=<pesan-encoded>
    │
    ▼
Redirect ke Link WhatsApp
    │
    ▼
┌────────────────────────────────┐
│  WHATSAPP APP / WEB TERBUKA    │
├────────────────────────────────┤
│ Pesan sudah di-pre-fill        │
│ User tinggal klik "Kirim"      │
│                                │
│ Admin menerima pesanan         │
│ Bisa langsung confirm via WA   │
└────────────────────────────────┘
```

---

## 📁 Struktur File Penting

### Controllers

```
app/Http/Controllers/
├── AuthController.php
│   ├── showRegister()      → Tampil form register
│   ├── register()          → Proses register user baru
│   ├── showLogin()         → Tampil form login
│   ├── login()             → Proses login
│   └── logout()            → Proses logout
│
├── ProductController.php
│   ├── index()             → List produk (admin)
│   ├── pembeli()           → List produk (pembeli)
│   ├── create()            → Form buat produk
│   ├── store()             → Simpan produk ke DB
│   ├── show()              → Detail produk
│   ├── edit()              → Form edit produk
│   ├── update()            → Update produk
│   └── destroy()           → Hapus produk
│
├── CartController.php
│   ├── index()             → Tampil keranjang
│   ├── add()               → Tambah ke cart
│   ├── update()            → Update qty
│   ├── remove()            → Hapus item
│   ├── clear()             → Kosongkan cart
│   ├── checkout()          → Checkout (buat order)
│   └── getOrCreateCart()   → Helper
│
├── OrderController.php
│   ├── index()             → List semua order
│   ├── create()            → Form buat order
│   ├── store()             → Simpan order
│   ├── show()              → Detail order
│   ├── edit()              → Form edit order
│   └── update()            → Update order
│
├── CategoryController.php
│   ├── index()             → List kategori
│   ├── create()            → Form buat kategori
│   ├── store()             → Simpan kategori
│   ├── show()              → Detail kategori
│   ├── edit()              → Form edit kategori
│   ├── update()            → Update kategori
│   └── destroy()           → Hapus kategori
│
├── AdminDashboardController.php
│   └── index()             → Dashboard admin
│
└── Controller.php
    └── Base controller class
```

### Models

```
app/Models/
├── User.php
│   ├── Fillable: name, email, password, role
│   ├── Relasi: carts(), orders()
│   ├── Helper: isAdmin(), isPembeli()
│   └── Hidden: password, remember_token
│
├── Product.php
│   ├── Fillable: name, description, price, stock, category_id, image
│   └── Relasi: category(), orderItems()
│
├── Category.php
│   ├── Fillable: name, description
│   └── Relasi: products()
│
├── Cart.php
│   ├── Fillable: user_id, session_id
│   ├── Relasi: user(), items()
│   ├── Method: getTotalPrice(), getTotalItems()
│
├── CartItem.php
│   ├── Fillable: cart_id, product_id, quantity
│   └── Relasi: cart(), product()
│
├── Order.php
│   ├── Fillable: user_id, status, total_price, shipping_address, phone
│   └── Relasi: user(), items()
│
└── OrderItem.php
    ├── Fillable: order_id, product_id, quantity, price
    └── Relasi: order(), product()
```

### Services

```
app/Services/
└── ImageUploadService.php
    └── upload($file, $folder)    → Upload & return nama file
```

### Middleware

```
app/Http/Middleware/
└── CheckRole.php              → Validasi role user
```

### Views (Blade Templates)

```
resources/views/
├── home.blade.php             → Halaman utama
│
├── auth/
│   ├── login.blade.php        → Form login
│   └── register.blade.php     → Form register
│
├── products/
│   ├── index.blade.php        → List produk (admin)
│   ├── pembeli.blade.php      → List produk (pembeli)
│   ├── create.blade.php       → Form buat produk
│   ├── edit.blade.php         → Form edit produk
│   └── show.blade.php         → Detail produk
│
├── categories/
│   ├── index.blade.php        → List kategori
│   ├── create.blade.php       → Form buat kategori
│   ├── edit.blade.php         → Form edit kategori
│   └── show.blade.php         → Detail kategori
│
├── cart/
│   └── index.blade.php        → Halaman keranjang
│
├── orders/
│   ├── index.blade.php        → List pesanan
│   ├── create.blade.php       → Form buat pesanan
│   ├── edit.blade.php         → Form edit pesanan
│   └── show.blade.php         → Detail pesanan
│
└── layouts/
    └── app.blade.php          → Layout utama
```

### Routes & Config

```
routes/
└── web.php                    → Semua endpoint

database/
├── migrations/
│   ├── *_create_users_table
│   ├── *_create_categories_table
│   ├── *_create_products_table
│   ├── *_create_carts_table
│   ├── *_create_cart_items_table
│   ├── *_create_orders_table
│   ├── *_create_order_items_table
│   └── *_add_role_to_users_table
│
└── seeders/
    ├── DatabaseSeeder.php
    └── ProductSeeder.php

config/
└── app.php                    → Konfigurasi aplikasi
```

---

## 🔄 Flow Diagram Lengkap

### Alur Keseluruhan Aplikasi

```
                    ┌──────────────────┐
                    │   PENGUNJUNG WEB │
                    └────────┬─────────┘
                             │
            ┌────────────────┼────────────────┐
            │                │                │
        BELUM LOGIN       SUDAH LOGIN      SUDAH LOGIN
            │            (PEMBELI)         (ADMIN)
            │                │                │
            ▼                ▼                ▼
        ┌──────┐        ┌────────┐      ┌──────────┐
        │HOME  │        │PEMBELI │      │  ADMIN   │
        │      │        │PORTAL  │      │ DASHBOARD│
        └──┬───┘        └────┬───┘      └────┬─────┘
           │                 │              │
           ├─Register   ┌─────┴─────┐    ┌──┴──────┐
           ├─Login      │           │    │         │
           │            │           │    │         │
           ▼            ▼           ▼    ▼         ▼
        Categories  Products    Cart  Kategori  Produk
        Products    Detail      Orders Buat/Edit Buat/Edit
                    Checkout    List   Hapus     Hapus
```

### Flow Pembeli Belanja Lengkap

```
STEP 1: LOGIN
┌──────────────────────────────────────────┐
│  1. Pembeli ke /login                   │
│  2. Isi email & password                │
│  3. AuthController::login()             │
│  4. Auth::attempt() validasi            │
│  5. Redirect ke /home (BERHASIL)        │
└──────────────────────────────────────────┘
                   ▼
STEP 2: LIHAT PRODUK
┌──────────────────────────────────────────┐
│  1. Klik "🛒 Belanja" di navbar          │
│  2. Ke /products-pembeli                │
│  3. ProductController::pembeli()        │
│  4. Tampil list produk dengan foto      │
│  5. Bisa filter by kategori (optional)  │
└──────────────────────────────────────────┘
                   ▼
STEP 3: PILIH & TAMBAH KE CART
┌──────────────────────────────────────────┐
│  1. Lihat produk (Laptop, Mouse, dll)    │
│  2. Input quantity: 2                   │
│  3. Klik "🛒 Masukkan Keranjang"        │
│  4. CartController::add()               │
│  5. Buat/cek CartItem                   │
│  6. Redirect /cart dengan success msg   │
└──────────────────────────────────────────┘
                   ▼
STEP 4: LIHAT & EDIT CART
┌──────────────────────────────────────────┐
│  1. Otomatis ke /cart setelah add       │
│  2. CartController::index()             │
│  3. Tampil semua items + total harga    │
│  4. Bisa:                               │
│     - Update qty                        │
│     - Hapus item                        │
│     - Lanjut ke checkout                │
└──────────────────────────────────────────┘
                   ▼
STEP 5: CHECKOUT
┌──────────────────────────────────────────┐
│  1. Klik "Checkout"                     │
│  2. Tampil form:                        │
│     - Alamat pengiriman                 │
│     - Nomor telepon                     │
│  3. Isi data & submit                   │
│  4. CartController::checkout()          │
│  5. Buat Order dari Cart data           │
│  6. Copy CartItems → OrderItems         │
│  7. Kosongkan Cart                      │
│  8. Generate link WhatsApp              │
└──────────────────────────────────────────┘
                   ▼
STEP 6: KIRIM VIA WHATSAPP
┌──────────────────────────────────────────┐
│  1. Link WhatsApp terbuka                │
│  2. Pesan sudah di-pre-fill otomatis    │
│  3. Pembeli klik "Kirim"                │
│  4. Admin menerima pesanan di WA        │
│  5. Admin bisa reply/confirm            │
│  6. Order selesai                       │
└──────────────────────────────────────────┘
```

### Flow Admin Kelola Produk Lengkap

```
STEP 1: LOGIN ADMIN
┌──────────────────────────────────────────┐
│  1. Admin ke /login                     │
│  2. Email: admin@example.com            │
│  3. Password: password123               │
│  4. AuthController::login()             │
│  5. Cek role = 'admin'                  │
│  6. Redirect ke /admin/dashboard        │
└──────────────────────────────────────────┘
                   ▼
STEP 2: BUAT KATEGORI (Optional)
┌──────────────────────────────────────────┐
│  1. Klik "Kelola Kategori"              │
│  2. Ke /categories/create               │
│  3. Form: Nama, Deskripsi               │
│  4. Submit                              │
│  5. CategoryController::store()         │
│  6. Kategori simpan ke DB               │
└──────────────────────────────────────────┘
                   ▼
STEP 3: TAMBAH PRODUK
┌──────────────────────────────────────────┐
│  1. Klik "📦 Kelola Produk"              │
│  2. Ke /products/create                 │
│  3. Form: Nama, Harga, Stock, Kategori  │
│  4. Upload foto produk                  │
│  5. Submit                              │
│  6. ProductController::store()          │
│  7. Validasi input                      │
│  8. Upload foto → storage/app/products/ │
│  9. Simpan produk ke DB                 │
│  10. Redirect /products dengan success  │
└──────────────────────────────────────────┘
                   ▼
STEP 4: EDIT PRODUK
┌──────────────────────────────────────────┐
│  1. Klik tombol "Edit" di daftar        │
│  2. Ke /products/:id/edit               │
│  3. ProductController::edit()           │
│  4. Tampil form pre-filled data         │
│  5. Ubah data &/atau upload foto baru  │
│  6. Submit                              │
│  7. ProductController::update()         │
│  8. Jika foto baru:                     │
│     - Hapus foto lama                   │
│     - Upload foto baru                  │
│  9. Update produk di DB                 │
│  10. Redirect dengan success            │
└──────────────────────────────────────────┘
                   ▼
STEP 5: HAPUS PRODUK
┌──────────────────────────────────────────┐
│  1. Klik tombol "Hapus" di daftar       │
│  2. Confirm dialog                      │
│  3. ProductController::destroy()        │
│  4. Hapus foto dari storage             │
│  5. Hapus produk dari DB                │
│  6. Redirect dengan success             │
└──────────────────────────────────────────┘
```

---

## ✅ Ringkasan Singkat

### Komponen MVC

| Komponen | Fungsi |
|----------|--------|
| **Model** | Representasi data & relasi database |
| **Controller** | Logika bisnis & request handling |
| **View** | Tampilan HTML (Blade template) |
| **Route** | Endpoint URL & method mapping |
| **Middleware** | Filter & validasi request |
| **Migration** | Script buat/ubah struktur tabel |
| **Service** | Helper logic (upload, etc) |

### Request Lifecycle

```
┌─────────────────────────────────────┐
│  1. USER REQUEST                    │
│     Browser / Mobile                │
└────────────┬────────────────────────┘
             │
             ▼
┌─────────────────────────────────────┐
│  2. ROUTE MATCHING                  │
│     Cocokkan URL dengan routes      │
└────────────┬────────────────────────┘
             │
             ▼
┌─────────────────────────────────────┐
│  3. MIDDLEWARE                      │
│     Validasi auth, role, dll        │
└────────────┬────────────────────────┘
             │
             ▼
┌─────────────────────────────────────┐
│  4. CONTROLLER                      │
│     Jalankan logika bisnis          │
└────────────┬────────────────────────┘
             │
             ▼
┌─────────────────────────────────────┐
│  5. MODEL / DATABASE                │
│     Query & manipulasi data         │
└────────────┬────────────────────────┘
             │
             ▼
┌─────────────────────────────────────┐
│  6. RESPONSE                        │
│     Return View / Redirect          │
└────────────┬────────────────────────┘
             │
             ▼
┌─────────────────────────────────────┐
│  7. BROWSER RENDER                  │
│     Tampilkan halaman ke user       │
└─────────────────────────────────────┘
```

---

## 📞 Kontak & Support

Untuk pertanyaan atau troubleshooting, lihat:
- `QUICK_START.md` - Setup cepat
- `ROLE_SYSTEM_GUIDE.md` - Sistem role
- `CART_GUIDE.md` - Panduan cart
- `UPLOAD_FOTO_GUIDE.md` - Upload foto

---

**Dokumentasi dibuat pada: January 28, 2026**
**Untuk Project: E-Commerce Laravel**
