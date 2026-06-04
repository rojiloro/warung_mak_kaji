<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ config('app.name', 'Warung Mak Kaji') }}</title>
  @vite(['resources/css/app.css'])
</head>

<body class="bg-[#F6F7F2] font-sans antialiased">

  <!-- Navbar -->
  <nav class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
      <!-- Logo -->
      <div class="text-2xl font-bold text-[#5E8B4A] tracking-wide">
        WARUNG MAK KAJI
      </div>

      <!-- Navigasi Kanan -->
      <div class="flex items-center gap-3">
        @auth
          <a href="/dashboard" class="bg-[#5E8B4A] text-white px-5 py-2 rounded-xl font-medium hover:bg-[#4a6e3a] transition">
            Dashboard
          </a>
        @else
          <a href="{{ route('login') }}" class="border border-gray-300 text-gray-700 px-5 py-2 rounded-xl font-medium hover:bg-gray-50 transition">
            Login
          </a>
          <a href="{{ route('register') }}" class="bg-[#5E8B4A] text-white px-5 py-2 rounded-xl font-medium hover:bg-[#4a6e3a] transition">
            Register
          </a>
        @endauth
      </div>
    </div>
  </nav>

<!-- Hero Jumbotron -->
<section class="max-w-6xl mx-auto px-6 py-8">

    <div class="relative rounded-3xl overflow-hidden shadow-lg">

        <!-- Background -->
        <img
            src="https://images.unsplash.com/photo-1542838132-92c53300491e?w=1200"
            alt="Rak Sayur Segar"
            class="w-full h-[260px] md:h-[420px] object-cover"
        >

        <!-- Overlay -->
        <div class="absolute inset-0 bg-black/45"></div>

        <!-- Content -->
        <div class="absolute inset-0 flex items-center justify-center z-20">

            <div class="text-white text-center px-6 md:px-16 max-w-3xl">

                <h1 class="text-3xl md:text-6xl font-bold leading-tight drop-shadow-md">

                    Kelola Warung
                    <br class="hidden sm:inline">
                    Lebih Mudah

                </h1>

                <p class="mt-4 text-sm md:text-lg text-gray-100/90 leading-relaxed drop-shadow">

                    Sistem kasir, transaksi, kontrol stok barang,
                    dan laporan otomatis untuk Warung Mak Kaji.

                </p>

                <a
                    href="{{ route('login') }}"
                    class="inline-block mt-6 bg-[#5E8B4A] hover:bg-[#4a6e3a] text-white font-semibold px-6 py-3 rounded-xl shadow-md transition transform active:scale-95"
                >

                    Masuk ke Aplikasi

                </a>

            </div>

        </div>

    </div>

</section>

      <!-- Indikator Navigasi Bawah (Dots) -->
      <div class="absolute bottom-5 left-1/2 -translate-x-1/2 flex gap-2.5 z-30">
        <button class="dot w-3 h-3 rounded-full bg-white transition duration-300" aria-label="Slide 1"></button>
        <button class="dot w-3 h-3 rounded-full bg-white/50 transition duration-300" aria-label="Slide 2"></button>
        <button class="dot w-3 h-3 rounded-full bg-white/50 transition duration-300" aria-label="Slide 3"></button>
      </div>

    </div>
</section>
  
  <!-- Footer --> 
<footer class="bg-white mt-16 border-t border-gray-100 shadow-sm">
  <div class="max-w-7xl mx-auto px-6 py-10">
    <div class="grid md:grid-cols-3 gap-8">
      
      <!-- Kolom 1: Branding -->
      <div>
        <h3 class="font-bold text-[#5E8B4A] text-xl tracking-wide">
          WARUNG MAK KAJI
        </h3>
        <p class="mt-3 text-gray-500 text-sm leading-relaxed">
          Sistem kasir, inventaris barang, dan manajemen operasional warung sederhana yang efisien.
        </p>
      </div>

      <!-- Kolom 2: Navigasi Cepat -->
      <div>
        <h3 class="font-bold text-gray-800 text-base">
          Navigasi Menu
        </h3>
        <ul class="mt-3 space-y-2.5 text-sm text-gray-500">
          <li>
            <a href="/dashboard" class="hover:text-[#5E8B4A] transition">Dashboard Utama</a>
          </li>
          <li>
            <a href="/kasir" class="hover:text-[#5E8B4A] transition">Transaksi Kasir</a>
          </li>
          <li>
            <a href="/products" class="hover:text-[#5E8B4A] transition">Kelola Barang</a>
          </li>
        </ul>
      </div>

      <!-- Kolom 3: Informasi Kontak -->
      <div>
        <h3 class="font-bold text-gray-800 text-base">
          Kontak & Lokasi
        </h3>
        <p class="mt-3 text-gray-500 text-sm leading-relaxed">
          D.I. Yogyakarta, Indonesia <br>
          <span class="text-xs text-gray-400 mt-1 block">Jam Operasional: 08:00 - 21:00 WIB</span>
        </p>
      </div>

    </div>

    <!-- Garis Pembatas & Hak Cipta -->
    <div class="border-t border-gray-200/60 mt-10 pt-6 text-center text-sm text-gray-400">
      &copy; {{ date('Y') }} Warung Mak Kaji. Hak Cipta Dilindungi.
    </div>
  </div>
</footer>
</body>
</html>
