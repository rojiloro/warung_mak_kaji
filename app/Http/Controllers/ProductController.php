<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
    
        $products = Product::where('nama_barang', 'like', "%{$search}%")
            ->orWhere('kode_barang', 'like', "%{$search}%")
            ->paginate(20)
            ->withQueryString();
    
        return view('products.index', compact('products', 'search'));
    }

    public function create()
    {
        // 1. Ambil produk terakhir berdasarkan ID
        $lastProduct = Product::latest('id')->first();
        $nextNumber = 17; // Default langsung ke 17 jika data kosong/mulai baru

        if ($lastProduct) {
            // Karena di database berbentuk string '016', langsung kita ubah ke integer murni (menjadi 16)
            $lastNumber = (int) $lastProduct->kode_barang;
            $nextNumber = $lastNumber + 1;
        }

        // 2. Format angka menjadi 3 digit (misal: 17 menjadi '017')
        $formatKode = sprintf('%03d', $nextNumber);

        return view('products.create', compact('formatKode'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required',
            'nama_barang' => 'required|unique:products,nama_barang',
            'harga' => 'required|numeric',
            'barcode' => 'nullable|unique:products,barcode',
        ], [

            'kode_barang.required' => 'Kode barang wajib diisi',

            'nama_barang.required' => 'Nama barang wajib diisi',

            'nama_barang.unique' => 'Nama barang sudah ditambahkan',

            'harga.required' => 'Harga wajib diisi',

            'harga.numeric' => 'Harga harus berupa angka',

            'barcode.unique' => 'Barcode sudah digunakan',

        ]);

        // NORMALISASI NAMA BARANG
        $namaBarang =
        strtolower(
            str_replace(
                ' ',
                '',
                $request->nama_barang
            )
        );

        // CEK NAMA MIRIP
        $cek =
        Product::all()->first(function ($product) use ($namaBarang) {

            return strtolower(
                str_replace(
                    ' ',
                    '',
                    $product->nama_barang
                )
            ) == $namaBarang;

        });

        // JIKA SUDAH ADA
        if($cek)
        {
            return back()
            ->withErrors([
                'nama_barang' =>
                'Nama barang sudah ditambahkan'
            ])
            ->withInput();
        }

        Product::create($request->all());

        if ($request->action == 'save_next') {

            return redirect('/products/create')
            ->with('success', 'Barang berhasil ditambahkan');

        }

        return redirect('/products');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $product->update([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'barcode' => $request->barcode,
            'harga' => $request->harga,
            'stok' => $request->stok,
        ]);
    
        return redirect('/products');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect('/products');
    }
}