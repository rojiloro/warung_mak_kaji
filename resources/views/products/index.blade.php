<x-app-layout>
  <div class="bg-[#F6F7F2] min-h-screen">
    <div class="max-w-7xl mx-auto px-6 py-8">

      <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
        <div>
          <h1 class="text-3xl font-bold text-gray-800">
            Daftar Barang
          </h1>
          <p class="text-gray-500 mt-1">
            Kelola stok barang Warung Mak Kaji
          </p>
        </div>

        <a
          href="/products/create"
          class="bg-[#5E8B4A] text-white px-6 py-3 rounded-xl font-semibold hover:bg-[#4a6e3a] transition shadow transform active:scale-95"
        >
          + Tambah Barang
        </a>
      </div>

      <!-- Search -->
      <div class="bg-white rounded-2xl shadow-md p-4 mb-6">
        <form method="GET" action="/products">
          <input 
            type="text" 
            name="search" 
            value="{{ $search ?? request('search') }}" 
            placeholder="Cari nama atau kode barang..." 
            class="w-full rounded-xl border-2 border-[#5E8B4A] focus:border-[#5E8B4A] focus:ring-[#5E8B4A] transition"
          >
          <span
            onclick="clearSearch()"
            class="absolute right-4 top-1/2 -translate-y-1/2 cursor-pointer text-gray-400 hover:text-red-500 text-lg"
          >
              ⨯
          </span>
        </form>
      </div>

      <!-- Table -->
      <div class="bg-white rounded-2xl shadow-md overflow-hidden">
        <div class="overflow-x-auto">

          <table class="w-full border-collapse">

            <!-- Head -->
            <thead class="bg-[#DDE8CF] text-gray-800 font-semibold">
              <tr>

                <th class="p-4 text-left">
                  Aksi
                </th>

                <th class="p-4 text-left">
                  Nama
                </th>

                <th class="p-4 text-left">
                  Kode
                </th>

                <th class="p-4 text-left">
                  Barcode
                </th>

                <th class="p-4 text-left">
                  Harga
                </th>

                <th class="p-4 text-left">
                  Stok
                </th>

              </tr>
            </thead>

            <!-- Body -->
            <tbody class="divide-y divide-gray-100">

              @forelse($products as $product)

              <tr class="hover:bg-[#F6F7F2] transition">

                <!-- AKSI -->
                <td class="p-4">

                  <div class="flex items-center gap-2">

                    <!-- Edit -->
                    <a
                      href="/products/{{ $product->id }}/edit"
                      class="bg-[#5E8B4A] hover:bg-[#4a6e3a] text-white px-4 py-2 rounded-xl text-sm font-semibold transition"
                    >
                      Edit
                    </a>

                    <!-- Hapus -->
                    <div x-data="{ open: false }" class="inline-block">

                      <button
                        @click="open = true"
                        type="button"
                        class="text-red-500 hover:text-red-700 px-2 py-2 text-sm font-semibold transition"
                      >
                        Hapus
                      </button>

                      <!-- Modal -->
                      <div
                        x-show="open"
                        x-transition
                        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
                        style="display: none;"
                      >

                        <div
                          @click.outside="open = false"
                          class="bg-white rounded-3xl shadow-xl p-8 w-full max-w-md"
                        >

                          <div class="text-center">

                            <div class="w-16 h-16 mx-auto rounded-full bg-red-100 flex items-center justify-center mb-4">
                              <span class="text-3xl">
                                🗑️
                              </span>
                            </div>

                            <h2 class="text-2xl font-bold text-red">
                              Hapus Barang?
                            </h2>

                            <p class="mt-2 text-gray-500 text-sm">
                              Barang
                              <span class="font-semibold text-gray-800">
                                "{{ $product->nama_barang }}"
                              </span>
                              akan dihapus permanen.
                            </p>

                          </div>

                          <div class="flex justify-center items-center gap-3 mt-8">

                            <button
                              @click="open = false"
                              type="button"
                              class="px-5 py-3 bg-white border-2 border-gray-200 text-gray-600 font-semibold rounded-xl hover:bg-gray-50 transition"
                            >
                              Batal
                            </button>

                            <form
                              action="/products/{{ $product->id }}"
                              method="POST"
                            >
                              @csrf
                              @method('DELETE')

                              <button
                                type="submit"
                                class="px-5 py-3 bg-red-500 hover:bg-red-600 text-red font-semibold rounded-xl shadow-md transition"
                              >
                                Ya, Hapus
                              </button>

                            </form>

                          </div>

                        </div>

                      </div>

                    </div>

                  </div>

                </td>

                <!-- NAMA -->
                <td class="p-4 font-medium text-gray-800">
                  {{ $product->nama_barang }}
                </td>

                <!-- KODE -->
                <td class="p-4 text-gray-600 font-mono text-sm">
                  {{ $product->kode_barang }}
                </td>

                <td class="p-4 text-center font-mono text-sm text-gray-600">
                  {{ $product->barcode ?? '-' }}
                </td>

                <!-- HARGA -->
                <td class="p-4 font-semibold text-gray-800">
                  Rp {{ number_format($product->harga, 0, ',', '.') }}
                </td>

                <!-- STOK -->
                <td class="p-4">
                  <span class="px-2.5 py-1 rounded-md text-sm font-semibold {{ $product->stok <= 5 ? 'bg-red-50 text-red-600' : 'text-gray-700' }}">
                    {{ $product->stok }}
                  </span>
                </td>

              </tr>

              @empty

              <tr>
                <td colspan="5" class="text-center py-12 text-gray-400 font-medium">
                  Belum ada data barang atau hasil pencarian tidak ditemukan.
                </td>
              </tr>

              @endforelse

            </tbody>

          </table>

        </div>
        <!-- Pagination -->
        <div class="p-4 border-t border-gray-100">
            {{ $products->links() }}
        </div>
      </div>

    </div>
  </div>

  <script>
    function clearSearch()
    {
        window.location.href='/products';
    }
  </script>

</x-app-layout>