<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Article;
use App\Models\File;
use App\Models\Discussion;
use App\Models\Product;
use App\Models\Slide;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //TODO: Need Cache system for more speed.
        $slides = Slide::orderBy('order', 'asc')->get();
        $articles = Article::limit(5)->orderBy('created_at', 'desc')->get();
        $products = Product::top()->limit(4)->orderBy('updated_at', 'desc')->get();
        $discussions = Discussion::limit(5)->orderBy('updated_at', 'desc')->get();
        $page = Page::findWithCache(config('platform.index-page-id'));
        return view('home.index', ['page' => $page, 'products' => $products, 'articles' => $articles, 'discussions' => $discussions, 'slides' => $slides]);
    }

    public function getLastArticles()
    {

    }

    public function getLastFileUpdates()
    {

    }
}
