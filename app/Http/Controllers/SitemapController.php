<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Product;

class SitemapController extends Controller
{
    public function index()
    {
        $product = Product::enabled()->shop()->orderBy('updated_at', 'desc')->first();
        $article = Article::enabled()->orderBy('updated_at', 'desc')->first();
        return response()->view('sitemap.index', [
            'product' => $product,
            'article' => $article,
        ])->header('Content-Type', 'text/xml');
    }

    public function products()
    {
        $products = Product::enabled()->shop()->get();
        return response()->view('sitemap.products', [
            'products' => $products,
        ])->header('Content-Type', 'text/xml');
    }

    public function articles()
    {
        $articles = Article::enabled()->get();
        return response()->view('sitemap.articles', [
            'articles' => $articles,
        ])->header('Content-Type', 'text/xml');
    }
}
