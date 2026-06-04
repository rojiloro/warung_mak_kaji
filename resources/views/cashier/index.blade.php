<script src="https://unpkg.com/html5-qrcode"></script>
<x-app-layout>
    <div class="bg-[#F6F7F2] min-h-screen">
        <div class="max-w-5xl mx-auto px-6 py-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">
                Kasir Transaksi
            </h1>

            <div class="relative mb-4">

            <div class="flex gap-2">

                <input
                    id="barcode"
                    type="text"
                    name="barcode"
                    class="flex-1 border-2 border-[#5E8B4A] rounded-xl p-3"
                    placeholder="Scan atau Cari Barang"
                    autocomplete="off"
                >

                <button
                    type="button"
                    onclick="startScanner()"
                    class="bg-[#5E8B4A] text-white px-4 rounded-xl flex items-center justify-center"
                >
                    📷
                </button>

            </div>

            <div
                id="searchResult"
                class="absolute top-full left-0 right-0 bg-white shadow-lg rounded-xl mt-1 z-50 hidden max-h-72 overflow-y-auto"
            ></div>

        </div>

        <div id="reader" class="mt-4"></div>

            <div class="bg-white rounded-3xl shadow-md p-6">
                <h2 class="font-bold text-xl mb-6 text-gray-800">
                    Keranjang Belanja
                </h2>

                @if(session('cart') && count(session('cart')) > 0)
                <div x-data="{ openClear:false }" class="mb-6">
                <button
                    @click="openClear = true"
                    type="button"
                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl text-sm shadow"
                >
                    🗑️ Hapus Semua Belanjaan
                </button>

                <!-- Modal -->
                <div
                    x-show="openClear"
                    x-transition
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
                    style="display:none;"
                >

                    <div
                        @click.outside="openClear = false"
                        class="bg-white rounded-3xl shadow-xl p-8 w-full max-w-md"
                    >

                        <div class="text-center">

                            <div class="w-16 h-16 mx-auto rounded-full bg-red-100 flex items-center justify-center mb-4">
                                <span class="text-3xl">🗑️</span>
                            </div>

                            <h2 class="text-2xl font-bold text-gray-800">
                                Hapus Semua Belanjaan?
                            </h2>

                            <p class="mt-2 text-gray-500 text-sm">
                                Semua item di keranjang akan dihapus permanen.
                            </p>

                        </div>

                        <div class="flex justify-center gap-3 mt-8">

                            <button
                                @click="openClear = false"
                                type="button"
                                class="px-5 py-3 bg-white border-2 border-gray-200 text-gray-600 font-semibold rounded-xl hover:bg-gray-50 transition"
                            >
                                Batal
                            </button>

                            <form action="/cart/clear" method="POST">
                                @csrf

                                <button
                                    type="submit"
                                    class="px-5 py-3 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-xl shadow-md transition"
                                >
                                    Ya, Hapus Semua
                                </button>

                            </form>

                        </div>

                    </div>

                </div>

                </div>
                @endif

                @php
                    $total = 0;
                @endphp

                @forelse(session('cart', []) as $id => $item)
                    @php
                        $subtotal = $item['harga'] * $item['qty'];
                        $total += $subtotal;
                    @endphp

                    <div class="border-b border-gray-100 py-5">
                        <div class="flex justify-between items-center">
                            <div>
                                <div class="font-semibold text-lg text-gray-800">
                                    {{ $item['nama'] }}
                                </div>
                                <div class="text-gray-500 text-sm mt-1">
                                    Rp {{ number_format($item['harga'], 0, ',', '.') }}
                                </div>
                            </div>

                            <div id="subtotal-{{ $id }}" class="font-bold text-lg text-gray-800">
                                Rp {{ number_format($subtotal, 0, ',', '.') }}
                            </div>
                        </div>

                        <div class="flex items-center gap-4 mt-4">
                            <button onclick="updateQty({{ $id }}, 'decrease')" type="button" class="flex items-center justify-center w-14 h-14 border-2 border-[#5E8B4A] rounded-2xl text-[#5E8B4A] text-3xl font-bold">
                                −
                            </button>

                            <input
                                id="qty-input-{{ $id }}"
                                type="number"
                                min="1"
                                value="{{ $item['qty'] }}"
                                onchange="updateQtyManual({{ $id }}, this.value)"
                                class="w-14 text-center border rounded-xl font-bold text-lg px-1"
                            />

                            <button onclick="updateQty({{ $id }}, 'increase')" type="button" class="flex items-center justify-center w-14 h-14 bg-[#5E8B4A] text-white rounded-2xl text-3xl font-bold">
                                +
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 text-gray-400 font-medium">
                        Keranjang belanja masih kosong
                    </div>
                @endforelse

                <div class="mt-8 border-t border-gray-200 pt-6">
                    <div class="flex justify-between text-2xl font-bold text-gray-900">
                        <span>Total Akhir</span>
                        <span id="totalBelanja" class="text-[#5E8B4A]">
                            Rp {{ number_format($total, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <div class="mt-8">
                    <h3 class="font-semibold text-gray-700 mb-4">
                        Uang Diterima (Customer)
                    </h3>

                    <div class="grid grid-cols-2 md:grid-cols-6 gap-3">
                        <button type="button" onclick="setUang(5000)" class="bg-[#5E8B4A] text-white rounded-xl p-3">
                            +5rb
                        </button>
                        <button type="button" onclick="setUang(10000)" class="bg-[#5E8B4A] text-white rounded-xl p-3">
                            +10rb
                        </button>
                        <button type="button" onclick="setUang(20000)" class="bg-[#5E8B4A] text-white rounded-xl p-3">
                            +20rb
                        </button>
                        <button type="button" onclick="setUang(50000)" class="bg-[#5E8B4A] text-white rounded-xl p-3">
                            +50rb
                        </button>
                        <button type="button" onclick="setUang(100000)" class="bg-[#5E8B4A] text-white rounded-xl p-3">
                            +100rb
                        </button>
                        <button type="button" onclick="resetUang()" class="text-red-500 bg-red-50 rounded-xl p-3">
                            Reset
                        </button>
                    </div>

                    <input id="uang" type="number" class="w-full mt-5 rounded-xl border-2 border-[#5E8B4A]" placeholder="Masukkan uang customer..." onkeyup="hitungKembalian()">

                    <div class="mt-6 p-4 bg-[#F6F7F2] rounded-2xl">
                        <div class="text-sm text-gray-600">
                            Uang Kembalian
                        </div>
                        <div id="kembalian" class="text-2xl font-bold text-[#5E8B4A] mt-2">
                            Rp 0
                        </div>
                    </div>
                </div>

                <form action="/checkout" method="POST" class="mt-8">
                    @csrf
                    <input type="hidden" name="bayar" id="bayarInput">
                    <button id="btnBayar" disabled class="w-full py-4 bg-[#5E8B4A] text-white rounded-xl opacity-50">
                        Bayar & Cetak Nota
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        let total = {{ $total }};

        async function updateQty(id, action) {
        try {
            let response = await fetch('/cart/' + action + '/' + id, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            });

            // Jika server mengembalikan error (misal 404 atau 500)
            if (!response.ok) {
                let errorData = await response.json();
                alert(errorData.message || 'Terjadi kesalahan pada server');
                return;
            }

            let data = await response.json();

            // Jika item dihapus (qty menjadi 0), langsung refresh halaman agar tampilan keranjang update
            if (data.qty === 0 || data.removed) {
                location.reload();
                return;
            }

            // Update nilai qty di element HTML
            let qtyBox =document.getElementById('qty-input-' + id);
            if (qtyBox) {
                qtyBox.value = data.qty;
            }

            // Update nilai subtotal di element HTML
            let subtotalBox = document.getElementById('subtotal-' + id);
            if (subtotalBox) {
                subtotalBox.innerText = 'Rp ' + data.subtotal.toLocaleString('id-ID');
            }

            // Update total belanja
            let totalBox = document.getElementById('totalBelanja');
            if (totalBox) {
                totalBox.innerText = 'Rp ' + data.total.toLocaleString('id-ID');
            }

            total = data.total;
            hitungKembalian();

        } catch (error) {
            console.error("Gagal memperbarui:", error);
        }
    }

        function setUang(nominal) {
            let input = document.getElementById('uang');
            let current = parseInt(input.value) || 0;
            input.value = current + nominal;
            hitungKembalian();
        }

        function resetUang() {
            document.getElementById('uang').value = '';
            hitungKembalian();
        }

        function hitungKembalian() {
            let uang = parseInt(document.getElementById('uang').value) || 0;
            let kembali = uang - total;
            let tombol = document.getElementById('btnBayar');

            document.getElementById('bayarInput').value = uang;

            if (uang < total) {
                document.getElementById('kembalian').innerHTML = '<span class="text-red-500 text-sm">Uang kurang dari total</span>';
                tombol.disabled = true;
                return;
            }

            tombol.disabled = false;
            document.getElementById('kembalian').innerHTML = 'Rp ' + kembali.toLocaleString('id-ID');
        }

        async function startScanner()
        {
            const scanner =
            new Html5Qrcode(
                "reader"
            );

            await scanner.start(
                {
                    facingMode:
                    "environment"
                },
                {
                    fps:10,
                    qrbox:250
                },
                async(decodedText)=>
                {
                    try
                    {
                        let response =
                        await fetch(
                            '/cart/barcode',
                            {
                                method:'POST',

                                headers:{
                                    'Content-Type':'application/json',

                                    'Accept':'application/json',

                                    'X-CSRF-TOKEN':
                                    '{{ csrf_token() }}'
                                },

                                body:JSON.stringify({
                                    barcode:decodedText
                                })
                            }
                        );

                        let data =
                        await response.json();

                        if(data.success)
                        {
                            scanner.stop();

                            document
                            .getElementById(
                                'reader'
                            )
                            .innerHTML='';

                            alert(
                                '✓ '+
                                data.message
                            );

                            location.reload();
                        }
                        else
                        {
                            alert(
                                data.message
                            );
                        }
                    }
                    catch(error)
                    {
                        console.log(error);

                        alert(
                            'Gagal scan barcode'
                        );
                    }
                }
            );
        }

        const searchInput =
        document.getElementById('barcode');

        const searchResult =
        document.getElementById('searchResult');

        searchInput.addEventListener(
        'keyup',
        async function()
        {
            let keyword =
            this.value.trim();

            if(keyword.length < 2)
            {
                searchResult.classList.add(
                    'hidden'
                );

                return;
            }

            let response =
            await fetch(
                '/cashier/search?keyword='+
                encodeURIComponent(keyword)
            );

            let products =
            await response.json();

            let html = '';

            products.forEach(product =>
            {
                html += `
                <button
                    type="button"
                    class="w-full text-left px-4 py-3 hover:bg-gray-100 border-b"
                    onclick="addProductToCart(${product.id})"
                >
                    <div class="font-semibold">
                        ${product.nama_barang}
                    </div>

                    <div class="text-sm text-gray-500">
                        Rp ${Number(product.harga).toLocaleString('id-ID')}
                    </div>
                </button>
                `;
            });

            searchResult.innerHTML =
            html;

            searchResult.classList.remove(
                'hidden'
            );
        });

        async function addProductToCart(id)
        {
            let response =
            await fetch(
                '/products/add-to-cart/'+id,
                {
                    method:'POST',

                    headers:{
                        'X-CSRF-TOKEN':
                        '{{ csrf_token() }}',

                        'Accept':
                        'application/json'
                    }
                }
            );

            let data =
            await response.json();

            if(data.success)
            {
                location.reload();
            }
        }

        async function updateQtyManual(id, qty)
        {
            let response =
            await fetch(
                '/cart/update-qty/' + id,
                {
                    method:'POST',
                    headers:{
                        'Content-Type':'application/json',
                        'Accept':'application/json',
                        'X-CSRF-TOKEN':'{{ csrf_token() }}'
                    },
                    body:JSON.stringify({
                        qty:qty
                    })
                }
            );

            let data = await response.json();

            document.getElementById(
                'subtotal-' + id
            ).innerText =
            'Rp ' +
            data.subtotal.toLocaleString('id-ID');

            document.getElementById(
                'totalBelanja'
            ).innerText =
            'Rp ' +
            data.total.toLocaleString('id-ID');

            total = data.total;

            hitungKembalian();
        }
    </script>
</x-app-layout>