<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Holili Farm')</title>
  <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
  <link rel="stylesheet" href="{{ asset('css/produk.css') }}">
  <link rel="stylesheet" href="{{ asset('css/form.css') }}">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  @stack('styles') <!-- Untuk stylesheet tambahan jika ada -->
</head>
<body>
  <div class="container">
    <aside class="sidebar">
  <nav class="bg_sidebar">
    <h2 class="judul_sidebar">Holili Farm</h2>

    <ul class="menu_list">
      <li class="{{ request()->routeIs('grafik.*') ? 'active' : '' }}">
  <a href="{{ route('grafik.index') }}">
    <img src="{{ asset('images/dashboardputih.svg') }}" alt="Dashboard" class="icon_sidebar icon_default" />
    <img src="{{ asset('images/dashboardhijau.svg') }}" alt="Dashboard" class="icon_sidebar icon_hover" />
    Dashboard
  </a>
</li>

      <li class="{{ request()->routeIs('products.*') ? 'active' : '' }}">
  <a href="{{ route('products.index') }}">
    <img src="{{ asset('images/produkputih.svg') }}" alt="Produk" class="icon_sidebar icon_default" />
    <img src="{{ asset('images/produkhijau.svg') }}" alt="Produk" class="icon_sidebar icon_hover" />
    Produk
  </a>
</li>

<li class="{{ request()->routeIs('informasi.*') ? 'active' : '' }}">
  <a href="{{ route('informasi.index') }}">
    <img src="{{ asset('images/informasiputih.svg') }}" alt="Dashboard" class="icon_sidebar icon_default" />
    <img src="{{ asset('images/informasihijau.svg') }}" alt="Dashboard" class="icon_sidebar icon_hover" />
    Informasi
  </a>
</li>

      <li class="{{ request()->routeIs('riwayat.*') ? 'active' : '' }}">
  <a href="{{ route('riwayat.index') }}">
    <img src="{{ asset('images/riwayatpenjualanputih.svg') }}" alt="Produk" class="icon_sidebar icon_default" />
    <img src="{{ asset('images/riwayatpenjualanhijau.svg') }}" alt="Produk" class="icon_sidebar icon_hover" />
    Riwayat
  </a>
</li>
  
    </ul>

    <div class="logout_container">
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="logout_button">Log Out</button>
      </form>
    </div>
  </nav>
</aside>

    <main class="main-content">
      @yield('content')
    </main>
  </div>
  @stack('scripts')


</body>
</html>
