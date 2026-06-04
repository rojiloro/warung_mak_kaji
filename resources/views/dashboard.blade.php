<x-app-layout>
  <div class="bg-[#F6F7F2] min-h-screen">
    <div class="max-w-7xl mx-auto px-6 py-8">

      <!-- Bagian Jumbotron / Sambutan -->
      <div class="bg-[#DDE8CF] rounded-3xl p-8 shadow-md">
        <h1 class="text-4xl font-bold text-gray-800">
          Halo, {{ auth()->user()->name }} 👋
        </h1>
        <p class="mt-3 text-gray-600">
          Selamat datang di sistem Warung Mak Kaji. Kelola produk, transaksi, dan kasir dengan lebih mudah.
        </p>
        <div class="mt-6 flex flex-wrap gap-4">
          <a href="/products" class="bg-[#5E8B4A] text-white px-6 py-3 rounded-xl font-medium shadow-sm hover:bg-[#4a6e3a] transition transform active:scale-95">
            Kelola Barang
          </a>
          <a href="/cashier" class="bg-white px-6 py-3 rounded-xl border border-[#5E8B4A] text-[#5E8B4A] font-medium shadow-sm hover:bg-[#5E8B4A] hover:text-white transition transform active:scale-95">
            Buka Kasir
          </a>
        </div>
      </div>

      <!-- Ringkasan Statistik Data -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
        
        <!-- Kartu 1: Total Barang -->
        <div class="bg-white rounded-3xl shadow-md p-6 transform hover:-translate-y-1 transition duration-200">
          <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">
            Total Barang
          </p>
          <h2 class="text-3xl font-bold mt-2 text-gray-800">
            {{ $totalProducts ?? 0 }} <span class="text-base font-normal text-gray-400">Item</span>
          </h2>
        </div>

        <!-- Kartu 2: Transaksi -->
        <div class="bg-white rounded-3xl shadow-md p-6 transform hover:-translate-y-1 transition duration-200">
          <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">
            Transaksi Hari Ini
          </p>
          <h2 class="text-3xl font-bold mt-2 text-gray-800">
            {{ $todayTransactions ?? 0 }} <span class="text-base font-normal text-gray-400">Nota</span>
          </h2>
        </div>

        <!-- Kartu 3: Pendapatan -->
        <div class="bg-white rounded-3xl shadow-md p-6 transform hover:-translate-y-1 transition duration-200">
          <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">
            Pendapatan Hari Ini
          </p>
          <h2 class="text-3xl font-bold mt-2 text-[#5E8B4A]">
            Rp {{ number_format($todayIncome ?? 0, 0, ',', '.') }}
          </h2>
        </div>

      </div>

    </div>
  </div>
</x-app-layout>
