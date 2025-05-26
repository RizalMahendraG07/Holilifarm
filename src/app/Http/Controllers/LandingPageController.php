<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Informasi;

class LandingPageController extends Controller
{
    public function index()
    {
        $products = Product::where('stok', '>', 0)
            ->paginate(3, ['*'], 'product_page')
            ->appends(request()->query())
            ->fragment('produk');

        $articles = Informasi::paginate(3, ['*'], 'article_page')
            ->appends(request()->query())
            ->fragment('informasi');

        return view('landing', compact('products', 'articles'));
    }
}
