<?php

namespace App\Http\Controllers;

use App\Models\Product;

class SitemapController extends Controller
{
    public function index()
    {
        $product = Product::enabled()->shop()->orderBy('updated_at', 'desc')->first();
        return response()->view('sitemap.index', [
            'product' => $product,
        ])->header('Content-Type', 'text/xml');
    }

    public function products()
    {
        $products = Product::enabled()->shop()->get();
        return response()->view('sitemap.products', [
            'products' => $products,
        ])->header('Content-Type', 'text/xml');
    }
}
