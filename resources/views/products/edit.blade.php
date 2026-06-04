<script src="https://unpkg.com/html5-qrcode"></script>
<x-app-layout>
  <div class="bg-[#F6F7F2] min-h-screen">
    <div class="max-w-2xl mx-auto px-6 py-8">
      <div class="bg-white p-8 rounded-3xl shadow-md">
        
        <!-- Judul Halaman -->
        <h1 class="text-3xl font-bold text-gray-800 mb-6">
          Edit Barang
        </h1>

        <form action="/products/{{ $product->id }}" method="POST">
          @csrf
          @method('PUT')

          <!-- Blok Input: Kode Barang -->
          <div class="mb-5">
            <label for="kode_barang" class="block mb-2 text-sm font-medium text-gray-700">
              Kode Barang
            </label>
            <input 
              id="kode_barang"
              type="text" 
              name="kode_barang" 
              value="{{ old('kode_barang', $product->kode_barang) }}"
              class="w-full rounded-xl border-2 border-[#5E8B4A] focus:border-[#5E8B4A] focus:ring-[#5E8B4A] transition"
              required
            >
            <x-input-error :messages="$errors->get('kode_barang')" class="mt-1.5" />
          </div>

          <!-- Blok Input: Nama Barang -->
          <div class="mb-5">
            <label for="nama_barang" class="block mb-2 text-sm font-medium text-gray-700">
              Nama Barang
            </label>
            <input 
              id="nama_barang"
              type="text" 
              name="nama_barang" 
              value="{{ old('nama_barang', $product->nama_barang) }}"
              class="w-full rounded-xl border-2 border-[#5E8B4A] focus:border-[#5E8B4A] focus:ring-[#5E8B4A] transition"
              required
            >
            <x-input-error :messages="$errors->get('nama_barang')" class="mt-1.5" />
          </div>

          <!-- Blok Input: Harga -->
          <div class="mb-5">
            <label for="harga" class="block mb-2 text-sm font-medium text-gray-700">
              Harga (Rp)
            </label>
            <input 
              id="harga"
              type="number" 
              name="harga" 
              value="{{ old('harga', $product->harga) }}"
              min="0"
              class="w-full rounded-xl border-2 border-[#5E8B4A] focus:border-[#5E8B4A] focus:ring-[#5E8B4A] transition"
              required
            >
            <x-input-error :messages="$errors->get('harga')" class="mt-1.5" />
          </div>

          <!-- Blok Input: Stok -->
          <div class="mb-6">
            <label for="stok" class="block mb-2 text-sm font-medium text-gray-700">
              Stok
            </label>
            <input 
              id="stok"
              type="number" 
              name="stok" 
              value="{{ old('stok', $product->stok) }}"
              min="0"
              class="w-full rounded-xl border-2 border-[#5E8B4A] focus:border-[#5E8B4A] focus:ring-[#5E8B4A] transition"
              required
            >
            <x-input-error :messages="$errors->get('stok')" class="mt-1.5" />
          </div>

          <div>
          <label class="block font-semibold mb-2">
              Barcode
          </label>

          <div class="flex gap-2">
              <input
                  id="barcode"
                  type="text"
                  name="barcode"
                  value="{{ old('barcode', $product->barcode) }}"
                  class="flex-1 border-2 border-[#5E8B4A] rounded-xl p-3"
                  placeholder="Scan atau isi barcode"
              >

              <button
                  type="button"
                  onclick="startScanner()"
                  class="bg-[#5E8B4A] text-white px-4 rounded-xl"
              >
                  📷
              </button>
            </div>

            <div id="reader" class="mt-3"></div>
          </div>

          <!-- Baris Tombol Aksi -->
          <div class="flex items-center gap-3">
            <button 
              type="submit" 
              class="px-6 py-3 bg-[#5E8B4A] hover:bg-[#4a6e3a] text-white font-semibold rounded-xl shadow-sm transition transform active:scale-95"
            >
              Perbarui
            </button>

            <a 
              href="/products" 
              class="px-6 py-3 bg-white border-2 border-[#5E8B4A] text-[#5E8B4A] font-semibold rounded-xl shadow-sm hover:bg-[#5E8B4A] hover:text-white transition text-center transform active:scale-95"
            >
              Kembali
            </a>
          </div>

        </form>
      </div>
    </div>
  </div>

  
  <script>

  function startScanner()
  {
      const scanner =
      new Html5Qrcode(
          "reader"
      );

      scanner.start(
          {
              facingMode:
              "environment"
          },
          {
              fps:10,
              qrbox:250
          },
          (decodedText)=>
          {
              document
              .getElementById(
                  'barcode'
              )
              .value=
              decodedText;

              scanner.stop();

              document
              .getElementById(
                  'reader'
              )
              .innerHTML='';
          }
      );
  }

  </script>
</x-app-layout>
