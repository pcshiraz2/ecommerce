<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Article;
use App\Models\File;
use App\Models\Discussion;
use App\Models\Product;
use App\Models\Slide;
use Illuminate\Support\Facades\Cache;
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

        $slides = Slide::enabled()->orderBy('order', 'asc')->get();
        $articles = Article::enabled()->limit(5)->orderBy('created_at', 'desc')->get();
        $topProducts = Product::enabled()->shop()->top()->limit(4)->get();
        $newProducts = Product::enabled()->shop()->new()->limit(4)->get();
        $discountProducts = Product::enabled()->shop()->discount()->limit(4)->orderBy('updated_at', 'desc')->get();
        $discussions = Discussion::enabled()->limit(5)->orderBy('updated_at', 'desc')->get();
        $page = Page::findWithCache(config('platform.index-page-id'));
        return view('home.index', [
            'page' => $page,
            'newProducts' => $newProducts,
            'topProducts' => $topProducts,
            'discountProducts' => $discountProducts,
            'articles' => $articles,
            'discussions' => $discussions,
            'slides' => $slides]);
    }

    public function getLastArticles()
    {

    }

    public function getLastFileUpdates()
    {

    }
}
