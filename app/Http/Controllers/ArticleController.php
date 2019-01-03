<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;

class ArticleController extends Controller
{
    public function view($id)
    {

        $article = Article::findWithCache($id);
        return view('article.view', ['article' => $article]);
    }

    public function slug($id, $slug)
    {
        $article = Article::findWithCache($id);
        return view('article.view', ['article' => $article]);
    }

    public function json()
    {
        $articles = Article::select(['title', 'id'])->limit(5)->orderBy('created_at', 'desc')->get();
        $articles_array = array();
        $i = 0;
        foreach ($articles as $article) {
            $articles_array[$i]['title'] = $article->title;
            $articles_array[$i]['id'] = $article->id;
            $articles_array[$i]['url'] = route('article.view', [$article->id]);
            $i++;
        }
        return response()->json($articles_array);
    }

    public function index()
    {
        $articles = Article::with(['user', 'category'])->orderBy('created_at', 'desc')->paginate(config('platform.file-per-page'));
        $categories = Category::findType('Article');
        return view('article.index', ['categories' => $categories, 'articles' => $articles]);
    }

    public function category($id)
    {
        $category = Category::findWithCache($id);
        $articles = Article::with(['user', 'category'])->where('category_id', $id)->orderBy('created_at', 'desc')->paginate(config('platform.file-per-page'));
        $categories = Category::findType('Article');
        return view('article.category', ['categories' => $categories, 'articles' => $articles, 'category' => $category]);
    }
}
