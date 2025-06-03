<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Informasi;
use App\Models\Riwayat;
use Carbon\Carbon;  

class DashboardController extends Controller

    {
        public function index()
        {
            $products = Product::all();
            return view('admin/dashboard', compact('products'));
            
        }
    
        public function store(Request $request)
    {
    $request->validate([
        'name' => 'required',
        'price' => 'required|numeric',
        'deskripsi' => 'required',
        'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        'stok' => 'required|integer|min:0'
    ]);

    try {
        $path = $request->file('image')->store('fotoproduk', 'public');

        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'deskripsi' => $request->deskripsi,
            'image' =>  'storage/' . $path,
            'stok' => $request->stok,
        ]);

        return redirect()->route('dashboard')->with('success', 'Produk berhasil ditambahkan!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Gagal menambahkan produk: ' . $e->getMessage());
    }
}

    
public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric',
        'deskripsi' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'stok' => 'required|integer|min:0'
    ]);

    try {
        $product = Product::findOrFail($id);

        $product->name = $request->name;
        $product->price = $request->price;
        $product->deskripsi = $request->deskripsi;
        $product->stok = $request->stok;

        if ($request->hasFile('image')) {
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }

            $path = $request->file('image')->store('fotoproduk', 'public');
            $product->image = 'storage/' . $path;
        }

        $product->save();

        return redirect()->route('dashboard')->with('success', 'Produk berhasil diperbarui!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Gagal memperbarui produk: ' . $e->getMessage());
    }
}
public function destroy($id)
{
    try {
        $product = Product::findOrFail($id);

        // Hapus file gambar jika ada
        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }

        $product->delete();

        return redirect()->route('dashboard')->with('success', 'Produk berhasil dihapus!');
    } catch (\Exception $e) {
        return redirect()->route('dashboard')->with('error', 'Gagal menghapus produk: ' . $e->getMessage());
    }
}

        public function create()
        {
              return view('admin.tambah');
        }
        
        public function edit($id)
    {
    $product = Product::findOrFail($id);
    return view('admin.editproduk', compact('product'));
    }   

        public function grafik() {
    $productCount = Product::count();
    $riwayatCount = Riwayat::count();
    $informasiCount = Informasi::count();

    // Filter status 'selesai' untuk semua query income
    $dailyIncome = Riwayat::where('status', 'selesai')
        ->whereDate('created_at', Carbon::today())
        ->sum('harga_total');

    $weeklyIncome = Riwayat::where('status', 'selesai')
        ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
        ->sum('harga_total');

    $monthlyIncome = Riwayat::where('status', 'selesai')
        ->whereMonth('created_at', Carbon::now()->month)
        ->whereYear('created_at', Carbon::now()->year)
        ->sum('harga_total');

    $yearlyIncome = Riwayat::where('status', 'selesai')
        ->whereYear('created_at', Carbon::now()->year)
        ->sum('harga_total');

    return view('admin.grafik', compact(
        'productCount', 
        'informasiCount',
        'riwayatCount', 
        'dailyIncome', 
        'weeklyIncome', 
        'monthlyIncome', 
        'yearlyIncome'
    ));
}


}
