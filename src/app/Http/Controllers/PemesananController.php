<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Riwayat;
use Illuminate\Http\Request;

class PemesananController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pembeli' => 'required|string|max:255',
            'alamat' => 'required|string|max:500',
            'produk_id' => 'required|integer|exists:products,id',
            'jumlah_produk' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($validated['produk_id']);
        
        // Validasi stok
        if ($validated['jumlah_produk'] > $product->stok) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak mencukupi! Stok tersedia: ' . $product->stok . ' Kg'
            ], 422);
        }

        $totalHarga = $product->price * $validated['jumlah_produk'];

        $validated['harga_total'] = $totalHarga;
        $validated['status'] = 'proses';

        try {
            $riwayat = Riwayat::create($validated);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error simpan data: ' . $e->getMessage()
            ], 500);
        }

        $message = "Halo Holili Farm, saya ingin memesan produk dengan data:\n" .
                   "Nama: {$validated['nama_pembeli']}\n" .
                   "Alamat: {$validated['alamat']}\n" .
                   "Produk: {$product->name}\n" .
                   "Jumlah: {$validated['jumlah_produk']}\n" .
                   "Total Harga: Rp " . number_format($totalHarga, 0, ',', '.') . "\n";

        $phone = '6285737134160';

        return response()->json([
            'success' => true,
            'whatsapp_url' => "https://wa.me/{$phone}?text=" . urlencode($message)
        ]);
    }
}