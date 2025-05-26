<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Riwayat;
use App\Models\Product;
use Illuminate\Support\Carbon;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $query = Riwayat::with('product');

    // Filter berdasarkan waktu
    switch ($request->filter) {
        case 'harian':
            $query->whereDate('created_at', Carbon::today());
            break;
        case 'mingguan':
            $query->whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ]);
            break;
        case 'bulanan':
            $query->whereMonth('created_at', Carbon::now()->month)
                  ->whereYear('created_at', Carbon::now()->year);
            break;
        case 'tahunan':
            $query->whereYear('created_at', Carbon::now()->year);
            break;
    }

    // ✅ Filter berdasarkan status jika ada
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $riwayat = $query->orderBy('created_at', 'desc')->get();

    return view('admin.riwayat', compact('riwayat'));
    }

    public function create()
    {
        $products = Product::all();
        return view('admin.tambahRiwayat', compact('products'));
    }

    public function store(Request $request)
    {
    $request->validate([
        'nama_pembeli'   => 'required|string',
        'alamat'         => 'required|string',
        'produk_id'      => 'required|exists:products,id',
        'jumlah_produk'  => 'required|integer|min:1',
        'status'         => 'required|in:Selesai,Proses,Cancel'
    ]);

    $product = Product::findOrFail($request->produk_id);
    $total   = $product->price * $request->jumlah_produk;

    // Buat riwayat
    $riwayat = Riwayat::create([
        'nama_pembeli'  => $request->nama_pembeli,
        'alamat'        => $request->alamat,
        'produk_id'     => $product->id,
        'jumlah_produk' => $request->jumlah_produk,
        'harga_total'   => $total,
        'status'        => $request->status
    ]);

    // Kurangi stok jika status selesai
    if ($request->status === 'Selesai') {
        if ($product->stok >= $request->jumlah_produk) {
            $product->stok -= $request->jumlah_produk;
            $product->save();
        } else {
            // Optional: rollback riwayat jika stok tidak cukup
            $riwayat->delete();
            return redirect()->back()->with('error', 'Stok produk tidak mencukupi.');
        }
    }

    return redirect()->route('riwayat.index')->with('success', 'Riwayat berhasil ditambahkan');
}  

    public function edit($id)
    {
        $riwayat  = Riwayat::findOrFail($id);
        $products = Product::all();
        return view('admin.editRiwayat', compact('riwayat', 'products'));
    }

    public function update(Request $request, $id)
    
{
    $request->validate([
        'nama_pembeli'   => 'required|string',
        'alamat'         => 'required|string',
        'produk_id'      => 'required|exists:products,id',
        'jumlah_produk'  => 'required|integer',
        'harga_total'    => 'required|numeric',
        'status'         => 'required|in:Selesai,Proses,Cancel'
    ]);

    $riwayat = Riwayat::findOrFail($id);
    $product = Product::findOrFail($request->produk_id);

    // Hitung selisih stok jika terjadi perubahan jumlah atau status
    $stokLamaDikurangi = 0;

    // Jika sebelumnya status Selesai, kembalikan stok lama dulu
    if ($riwayat->status === 'Selesai') {
        $product->stok += $riwayat->jumlah_produk;
        $stokLamaDikurangi = $riwayat->jumlah_produk;
    }

    // Cek jika status baru adalah Selesai
    if ($request->status === 'Selesai') {
        if ($product->stok < $request->jumlah_produk) {
            // Batalkan pengembalian stok jika tidak cukup
            $product->stok -= $stokLamaDikurangi;
            return redirect()->back()->with('error', 'Stok produk tidak mencukupi untuk update.');
        }
        // Kurangi stok dengan jumlah baru
        $product->stok -= $request->jumlah_produk;
    }

    // Simpan update stok
    $product->save();

    // Simpan perubahan riwayat
    $riwayat->update([
        'nama_pembeli'  => $request->nama_pembeli,
        'alamat'        => $request->alamat,
        'produk_id'     => $product->id,
        'jumlah_produk' => $request->jumlah_produk,
        'harga_total'   => $request->harga_total,
        'status'        => $request->status
    ]);

    return redirect()->route('riwayat.index')->with('success', 'Riwayat berhasil diupdate');
}



    public function destroy($id)
    {
        $riwayat = Riwayat::findOrFail($id);
        $riwayat->delete();

        return redirect()->route('riwayat.index')->with('success', 'Riwayat berhasil dihapus');
    }
}