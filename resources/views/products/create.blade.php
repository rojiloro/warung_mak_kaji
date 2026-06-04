<script src="https://unpkg.com/html5-qrcode"></script>
<x-app-layout>
  <div class="bg-[#F6F7F2] min-h-screen">
    <div class="max-w-2xl mx-auto px-6 py-8">
      <div class="bg-white p-8 rounded-3xl shadow-md">
        
        <h1 class="text-3xl font-bold text-gray-800 mb-6">
          Tambah Barang
        </h1>
        
        @if ($errors->any())
        <div class="mb-5 bg-red-50 border-2 border-red-200 text-red-600 px-4 py-3 rounded-2xl font-medium shadow-sm">
          {{ $errors->first() }}
        </div>
        @endif

        <form action="/products" method="POST">
          @csrf

          <div class="mb-5">
            <label for="kode_barang" class="block mb-2 text-sm font-medium text-gray-700">
              Kode Barang
            </label>
            <input 
              id="kode_barang"
              type="text" 
              name="kode_barang" 
              value="{{ old('kode_barang', $formatKode) }}"
              class="w-full rounded-xl border-2 border-[#5E8B4A] bg-gray-100 cursor-not-allowed text-gray-500 focus:border-[#5E8B4A] focus:ring-[#5E8B4A] transition"
              required
              readonly
            >
            <x-input-error :messages="$errors->get('kode_barang')" class="mt-1.5" />
          </div>

          <div class="mb-5">
            <label for="nama_barang" class="block mb-2 text-sm font-medium text-gray-700">
              Nama Barang
            </label>
            <input 
              id="nama_barang"
              type="text" 
              name="nama_barang" 
              value="{{ old('nama_barang') }}"
              class="w-full rounded-xl border-2 border-[#5E8B4A] focus:border-[#5E8B4A] focus:ring-[#5E8B4A] transition"
              required
              autofocus
            >
            <x-input-error :messages="$errors->get('nama_barang')" class="mt-1.5" />
          </div>

          <div class="mb-5">
            <label for="harga" class="block mb-2 text-sm font-medium text-gray-700">
              Harga (Rp)
            </label>
            <input 
              id="harga"
              type="number" 
              name="harga" 
              value="{{ old('harga') }}"
              min="0"
              class="w-full rounded-xl border-2 border-[#5E8B4A] focus:border-[#5E8B4A] focus:ring-[#5E8B4A] transition"
              required
            >
            <x-input-error :messages="$errors->get('harga')" class="mt-1.5" />
          </div>

          <div class="mb-6">
            <label for="stok" class="block mb-2 text-sm font-medium text-gray-700">
              Stok Awal
            </label>
            <input 
              id="stok"
              type="number" 
              name="stok" 
              value="{{ old('stok', 0) }}"
              min="0"
              class="w-full rounded-xl border-2 border-[#5E8B4A] focus:border-[#5E8B4A] focus:ring-[#5E8B4A] transition"
              required
            >
            <x-input-error :messages="$errors->get('stok')" class="mt-1.5" />
          </div>

          <div class="mb-4">

          <label class="block mb-2">
              Barcode
          </label>

              <div class="flex gap-2">
                <input
                  id="barcode"
                  type="text"
                  name="barcode"
                  class="flex-1 border-2 border-[#5E8B4A] rounded-xl p-3"
                  placeholder="Scan atau isi barcode"
                >

                <button
                  type="button"
                  onclick="startScanner()"
                  class="bg-[#5E8B4A] text-white px-4 rounded-xl flex items-center justify-center"
                >
                  📷
                </button>
              </div>
              <div id="reader" class="mt-4"></div>
          </div>
          
          <div class="flex flex-wrap gap-3">
            <button 
              type="submit" 
              name="action" 
              value="save" 
              class="px-6 py-3 bg-[#5E8B4A] hover:bg-[#4a6e3a] text-white font-semibold rounded-xl shadow-sm transition transform active:scale-95"
            >
              Simpan
            </button>

            <button 
              type="submit" 
              name="action" 
              value="save_next" 
              class="px-6 py-3 bg-white border-2 border-[#5E8B4A] text-[#5E8B4A] font-semibold rounded-xl shadow-sm hover:bg-[#5E8B4A] hover:text-white transition transform active:scale-95"
            >
              Simpan & Tambah Lagi
            </button>
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