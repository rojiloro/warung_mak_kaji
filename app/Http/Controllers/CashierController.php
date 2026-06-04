<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;

class CashierController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return view('cashier.index', compact('products'));
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;

        $products = Product::where(
            'nama_barang',
            'like',
            "%{$keyword}%"
        )
        ->orWhere(
            'kode_barang',
            'like',
            "%{$keyword}%"
        )
        ->limit(10)
        ->get();

        return response()->json($products);
    }

    public function addToCart($id)
    {
        $product = Product::findOrFail($id);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['qty']++;
        } else {
            $cart[$id] = [
                'nama' => $product->nama_barang,
                'harga' => $product->harga,
                'qty' => 1
            ];
        }

        session()->put('cart', $cart);

        // Jika request datang dari AJAX / Fetch API (Daftar Barang)
        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => '✓ ' . $product->nama_barang . ' berhasil ditambahkan ke kasir!'
            ]);
        }

        // Jika request datang dari klik tombol di halaman kasir biasa
        return redirect('/cashier');
    }

    public function scanBarcode(Request $request)
    {
        $product = Product::where(
            'barcode',
            $request->barcode
        )->first();

        if(!$product)
        {
            return response()->json([
                'success' => false,
                'message' => 'Barcode tidak ditemukan'
            ]);
        }

        $cart = session()->get('cart', []);

        if(isset($cart[$product->id]))
        {
            $cart[$product->id]['qty']++;
        }
        else
        {
            $cart[$product->id] = [
                'nama'  => $product->nama_barang,
                'harga' => $product->harga,
                'qty'   => 1
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => $product->nama_barang.' ditambahkan'
        ]);
    }

    public function updateQty(Request $request, $id)
    {
        $cart = session()->get('cart', []);
    
        if (!isset($cart[$id])) {
            return response()->json([
                'success' => false
            ], 404);
        }
    
        $cart[$id]['qty'] = max(1, (int) $request->qty);
    
        session()->put('cart', $cart);
    
        $subtotal =
            $cart[$id]['harga'] *
            $cart[$id]['qty'];
    
        $total = 0;
    
        foreach ($cart as $item) {
            $total +=
                $item['harga'] *
                $item['qty'];
        }
    
        return response()->json([
            'success' => true,
            'qty' => $cart[$id]['qty'],
            'subtotal' => $subtotal,
            'total' => $total
        ]);
    }

    public function removeCart($id)
    {
        $cart = session()->get('cart');

        if (isset($cart[$id])) {
            unset($cart[$id]);
        }

        session()->put('cart', $cart);

        return redirect()->back();
    }

    public function increaseQty($id)
    {
        // Mengambil data cart dari session, jika tidak ada default-nya array kosong []
        $cart = session()->get('cart', []);

        if (!isset($cart[$id])) {
            return response()->json([
                'message' => 'Barang tidak ditemukan di keranjang'
            ], 404);
        }

        // Tambah quantity
        $cart[$id]['qty']++;

        // Simpan kembali ke session menggunakan method put() yang benar
        session()->put('cart', $cart);

        // Hitung subtotal dan total akhir
        $subtotal = $cart[$id]['harga'] * $cart[$id]['qty'];
        
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['harga'] * $item['qty'];
        }

        return response()->json([
            'qty' => $cart[$id]['qty'],
            'subtotal' => $subtotal,
            'total' => $total
        ]);
    }

    public function decreaseQty($id)
    {
        $cart = session()->get('cart', []);

        if (!isset($cart[$id])) {
            return response()->json([
                'message' => 'Barang tidak ditemukan di keranjang'
            ], 404);
        }

        $cart[$id]['qty']--;
        $isRemoved = false;
        $subtotal = 0;

        // Jika qty kurang dari atau sama dengan 0, hapus item dari array
        if ($cart[$id]['qty'] <= 0) {
            unset($cart[$id]);
            $isRemoved = true;
        } else {
            $subtotal = $cart[$id]['harga'] * $cart[$id]['qty'];
        }

        // Simpan perubahan ke session
        session()->put('cart', $cart);

        // Hitung total akhir
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['harga'] * $item['qty'];
        }

        return response()->json([
            'qty' => $isRemoved ? 0 : $cart[$id]['qty'],
            'subtotal' => $subtotal,
            'total' => $total,
            'removed' => $isRemoved
        ]);
    }

    public function checkout(Request $request)
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return back();
        }

        $total = 0;

        foreach ($cart as $item) {
            $total += $item['harga'] * $item['qty'];
        }

        $bayar = $request->bayar;

        if ($bayar < $total) {
            return back();
        }

        $transaction = Transaction::create([
            'total' => $total,
            'bayar' => $bayar,
            'kembalian' => $bayar - $total
        ]);

        foreach ($cart as $id => $item) {
            TransactionItem::create([
                'transaction_id' => $transaction->id,
                'product_id' => $id,
                'qty' => $item['qty'],
                'subtotal' => $item['harga'] * $item['qty']
            ]);

            Product::where('id', $id)->decrement('stok', $item['qty']);
        }

        session()->forget('cart');

        return redirect('/receipt/' . $transaction->id);
    }

    public function receipt($id)
    {
        $transaction = Transaction::findOrFail($id);

        $items = TransactionItem::where('transaction_id', $id)
            ->with('product')
            ->get();

        return view('cashier.receipt', compact('transaction', 'items'));
    }

    public function clearCart()
    {
        // Menghapus seluruh data keranjang dari session
        session()->forget('cart');

        return redirect()->back()->with('success', 'Semua belanjaan berhasil dihapus!');
    }
}