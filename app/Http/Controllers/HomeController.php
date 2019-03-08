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
        if (Cache::has('slides')) {
            $slides = Cache::get('slides');
        } else {
            $slides = Slide::enabled()->orderBy('order', 'asc')->get();
            Cache::put('slides', $slides);
        }

        if (Cache::has('topProducts')) {
            $topProducts = Cache::get('topProducts');
        } else {
            $topProducts = Product::enabled()->shop()->top()->limit(4)->get();
            Cache::put('topProducts', $topProducts);
        }


        if (Cache::has('newProducts')) {
            $newProducts = Cache::get('newProducts');
        } else {
            $newProducts = Product::enabled()->shop()->new()->limit(4)->get();
            Cache::put('newProducts', $newProducts);
        }

        if (Cache::has('discountProducts')) {
            $discountProducts = Cache::get('discountProducts');
        } else {
            $discountProducts = Product::enabled()->shop()->discount()->limit(4)->orderBy('updated_at', 'desc')->get();
            Cache::put('discountProducts', $discountProducts);
        }

        if (Cache::has('articles')) {
            $articles = Cache::get('articles');
        } else {
            $articles = Article::enabled()->limit(5)->orderBy('created_at', 'desc')->get();
            Cache::put('articles', $articles);
        }


        if (Cache::has('discussions')) {
            $discussions = Cache::get('discussions');
        } else {
            $discussions = Discussion::enabled()->limit(5)->orderBy('updated_at', 'desc')->get();
            Cache::put('discussions', $discussions);
        }

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
