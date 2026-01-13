<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title') - E-Commerce Store</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;500;700&display=swap"
    rel="stylesheet"
  />

  <!-- Feather Icons -->
  <script src="https://unpkg.com/feather-icons"></script>

  <style>
    :root {
      --primary: #1e09e2;
      --bg: #ffffff;
      --text: #000000;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      outline: none;
      border: none;
      text-decoration: none;
    }

    body {
      font-family: "Poppins", sans-serif;
      background-color: var(--bg);
      color: var(--text);
      line-height: 1.6;
    }

    /* Navbar */
    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 1.4rem 7%;
      background-color: rgba(255, 255, 255, 0.95);
      border-bottom: 2px solid var(--primary);
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 9999;
      box-shadow: 0 2px 8px rgba(30, 9, 226, 0.1);
    }

    .navbar .navbar-logo {
      font-size: 2rem;
      font-weight: bold;
      color: var(--text);
      font-style: italic;
    }

    .navbar .navbar-logo span {
      color: var(--primary);
    }

    .navbar .navbar-nav a {
      color: var(--text);
      display: inline-block;
      font-size: 1.1rem;
      margin: 0 1.5rem;
      transition: 0.3s;
      position: relative;
    }

    .navbar .navbar-nav a:hover {
      color: var(--primary);
    }

    .navbar .navbar-nav a::after {
      content: "";
      display: block;
      width: 0;
      height: 2px;
      background-color: var(--primary);
      position: absolute;
      bottom: -5px;
      left: 0;
      transition: 0.3s;
    }

    .navbar .navbar-nav a:hover::after {
      width: 100%;
    }

    .navbar .navbar-extra a {
      color: var(--text);
      margin: 0 1rem;
      font-size: 1.3rem;
      cursor: pointer;
      transition: 0.3s;
    }

    .navbar .navbar-extra a:hover {
      color: var(--primary);
    }

    #hamburger-menu {
      display: none;
    }

    /* Container Main */
    .container-main {
      margin-top: 100px;
      padding: 2rem 7%;
      min-height: calc(100vh - 200px);
    }

    /* Alert */
    .alert-custom {
      padding: 1rem 1.5rem;
      border-radius: 8px;
      margin-bottom: 2rem;
      border-left: 4px solid;
    }

    .alert-success {
      background-color: #d4edda;
      border-color: #28a745;
      color: #155724;
    }

    .alert-danger {
      background-color: #f8d7da;
      border-color: #dc3545;
      color: #721c24;
    }

    .alert-info {
      background-color: #d1ecf1;
      border-color: #17a2b8;
      color: #0c5460;
    }

    .alert-custom button {
      float: right;
      background: none;
      font-size: 1.5rem;
      cursor: pointer;
      opacity: 0.7;
      transition: 0.3s;
    }

    .alert-custom button:hover {
      opacity: 1;
    }

    /* Card */
    .card {
      background-color: white;
      border: none;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      transition: 0.3s;
      margin-bottom: 2rem;
    }

    .card:hover {
      box-shadow: 0 4px 16px rgba(30, 9, 226, 0.15);
    }

    .card-header {
      background: linear-gradient(135deg, var(--primary) 0%, #4c0ae0 100%);
      color: white;
      padding: 1.5rem;
      border-bottom: none;
    }

    .card-body {
      padding: 1.5rem;
    }

    .card-footer {
      padding: 1.5rem;
      background-color: #f8f9fa;
      border-top: 1px solid #dee2e6;
    }

    /* Form */
    .form-label {
      font-weight: 600;
      margin-bottom: 0.5rem;
      color: var(--primary);
    }

    .form-control,
    .form-select {
      padding: 0.75rem 1rem;
      border: 1px solid #dee2e6;
      border-radius: 6px;
      font-family: "Poppins", sans-serif;
      transition: 0.3s;
    }

    .form-control:focus,
    .form-select:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 0.2rem rgba(30, 9, 226, 0.25);
    }

    .form-control.is-invalid,
    .form-select.is-invalid {
      border-color: #dc3545;
    }

    .invalid-feedback {
      color: #dc3545;
      font-size: 0.875rem;
      margin-top: 0.25rem;
      display: block;
    }

    /* Button */
    .btn {
      padding: 0.75rem 1.5rem;
      border-radius: 6px;
      font-family: "Poppins", sans-serif;
      font-weight: 600;
      cursor: pointer;
      transition: 0.3s;
      border: none;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
    }

    .btn-primary {
      background-color: var(--primary);
      color: white;
    }

    .btn-primary:hover {
      background-color: #1500b8;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(30, 9, 226, 0.3);
    }

    .btn-secondary {
      background-color: #6c757d;
      color: white;
    }

    .btn-secondary:hover {
      background-color: #5a6268;
    }

    .btn-warning {
      background-color: #ffc107;
      color: black;
    }

    .btn-warning:hover {
      background-color: #e0a800;
    }

    .btn-danger {
      background-color: #dc3545;
      color: white;
    }

    .btn-danger:hover {
      background-color: #c82333;
    }

    .btn-info {
      background-color: #17a2b8;
      color: white;
    }

    .btn-info:hover {
      background-color: #138496;
    }

    .btn-sm {
      padding: 0.5rem 1rem;
      font-size: 0.875rem;
    }

    .btn-lg {
      padding: 1rem 2rem;
      font-size: 1.1rem;
    }

    /* Table */
    .table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 2rem;
    }

    .table thead {
      background-color: #343a40;
      color: white;
    }

    .table thead th {
      padding: 1rem;
      text-align: left;
      font-weight: 600;
    }

    .table tbody td {
      padding: 1rem;
      border-bottom: 1px solid #dee2e6;
    }

    .table tbody tr:hover {
      background-color: #f8f9fa;
    }

    /* Page Title */
    .page-title {
      color: var(--primary);
      font-weight: bold;
      font-size: 2rem;
      margin-bottom: 2rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    /* Badge */
    .badge {
      padding: 0.5rem 1rem;
      border-radius: 20px;
      font-size: 0.875rem;
      font-weight: 600;
      display: inline-block;
    }

    .bg-primary {
      background-color: var(--primary) !important;
      color: white;
    }

    .bg-success {
      background-color: #28a745 !important;
      color: white;
    }

    .bg-danger {
      background-color: #dc3545 !important;
      color: white;
    }

    .bg-warning {
      background-color: #ffc107 !important;
      color: black;
    }

    .bg-info {
      background-color: #17a2b8 !important;
      color: white;
    }

    /* Footer */
    footer {
      background: linear-gradient(135deg, var(--primary) 0%, #4c0ae0 100%);
      color: white;
      margin-top: 50px;
      padding: 30px 7%;
      text-align: center;
    }

    footer h5 {
      margin-bottom: 1rem;
      font-weight: bold;
    }

    footer p {
      margin-bottom: 0.5rem;
    }

    footer a {
      color: #fff;
      text-decoration: none;
      transition: 0.3s;
    }

    footer a:hover {
      text-decoration: underline;
    }

    /* Image */
    .product-image {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-radius: 8px;
    }

    /* Utilities */
    .d-flex {
      display: flex;
    }

    .gap-2 {
      gap: 1rem;
    }

    .text-end {
      text-align: right;
    }

    .text-center {
      text-align: center;
    }

    .mt-4 {
      margin-top: 2rem;
    }

    .mt-5 {
      margin-top: 3rem;
    }

    .mb-3 {
      margin-bottom: 1rem;
    }

    .mb-4 {
      margin-bottom: 1.5rem;
    }

    .d-inline {
      display: inline;
    }

    .text-muted {
      color: #6c757d;
    }

    /* Pagination */
    .pagination {
      display: flex;
      justify-content: center;
      gap: 0.5rem;
      margin-bottom: 2rem;
    }

    .pagination a,
    .pagination span {
      padding: 0.5rem 0.75rem;
      border: 1px solid #dee2e6;
      border-radius: 4px;
      color: var(--primary);
      text-decoration: none;
      transition: 0.3s;
    }

    .pagination a:hover {
      background-color: var(--primary);
      color: white;
    }

    .pagination .active span {
      background-color: var(--primary);
      color: white;
      border-color: var(--primary);
    }

    /* Media Queries */
    @media (max-width: 1366px) {
      html {
        font-size: 75%;
      }
    }

    @media (max-width: 768px) {
      html {
        font-size: 62.5%;
      }

      .navbar {
        padding: 1rem 3%;
      }

      #hamburger-menu {
        display: inline-block;
        cursor: pointer;
      }

      .navbar .navbar-nav {
        position: absolute;
        top: 100%;
        right: -100%;
        background-color: rgba(0, 0, 0, 0.95);
        width: 30rem;
        height: 100vh;
        transition: 0.3s;
      }

      .navbar .navbar-nav.active {
        right: 0;
      }

      .navbar .navbar-nav a {
        color: white;
        display: block;
        margin: 1.5rem;
        padding: 0.5rem;
        font-size: 1.5rem;
      }

      .navbar .navbar-nav a::after {
        transform-origin: 0 0;
      }

      .navbar .navbar-nav a:hover::after {
        width: 50%;
      }

      .container-main {
        padding: 1rem 3%;
        margin-top: 80px;
      }

      .page-title {
        font-size: 1.5rem;
      }
    }

    @media (max-width: 450px) {
      html {
        font-size: 55%;
      }

      .navbar .navbar-nav {
        width: 100%;
      }

      .d-flex {
        flex-direction: column;
      }

      .gap-2 {
        gap: 0.5rem;
      }

      .btn {
        width: 100%;
        justify-content: center;
      }
    }
  </style>
  @yield('extra-css')
</head>
<body>
  @include('navbar')

  <div class="container-main">
    @if ($errors->any())
      <div class="alert-custom alert-danger">
        <strong>Error!</strong>
        <ul style="margin-top: 0.5rem;">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
        <button onclick="this.parentElement.style.display='none';">&times;</button>
      </div>
    @endif

    @if (session('success'))
      <div class="alert-custom alert-success">
        {{ session('success') }}
        <button onclick="this.parentElement.style.display='none';">&times;</button>
      </div>
    @endif

    @yield('content')
  </div>

  <footer>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin-bottom: 2rem;">
      <div>
        <h5>Tentang Kami</h5>
        <p>Toko online terpercaya dengan berbagai pilihan produk berkualitas tinggi dan harga terjangkau.</p>
      </div>
      <div>
        <h5>Link Cepat</h5>
        <ul style="list-style: none;">
          <li><a href="{{ route('products.index') }}">Produk</a></li>
          <li><a href="{{ route('categories.index') }}">Kategori</a></li>
          <li><a href="{{ route('orders.index') }}">Pesanan</a></li>
        </ul>
      </div>
      <div>
        <h5>Kontak</h5>
        <p>Email: info@ecommerce.com<br>Phone: +62 123 456 7890<br>Alamat: Jl. E-Commerce No. 123, Jakarta</p>
      </div>
    </div>
    <hr style="border: 1px solid rgba(255,255,255,0.3); margin: 2rem 0;">
    <p>&copy; 2026 E-Commerce Store. All rights reserved.</p>
  </footer>

  <!-- Feather Icons -->
  <script>
    feather.replace();

    // Hamburger Menu
    const hamburger = document.querySelector('#hamburger-menu');
    const navbarNav = document.querySelector('.navbar-nav');

    if (hamburger) {
      hamburger.addEventListener('click', (e) => {
        e.preventDefault();
        navbarNav.classList.toggle('active');
      });
    }

    // Close menu when clicking on links
    const navLinks = document.querySelectorAll('.navbar-nav a');
    navLinks.forEach(link => {
      link.addEventListener('click', () => {
        navbarNav.classList.remove('active');
      });
    });
  </script>

  @yield('extra-js')
</body>
</html>
