<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $articles = Article::collect();
        return view('admin.article.index', ['articles' => $articles]);
    }


    public function create()
    {
        $categories = Category::where('type', 'Article')->get();
        return view('admin.article.create', ['categories' => $categories]);
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);
        $categories = Category::where('type', 'Article')->get();
        return view('admin.article.edit', ['article' => $article, 'categories' => $categories]);
    }

    public function insert(Request $request)
    {
        Validator::make($request->all(), [
            'title' => 'required|string',
            'text' => 'required|string',
            'category_id' => 'required'
        ])->validate();
        $article = new Article();
        $article->title = $request->title;
        $article->description = $request->description;
        $article->text = $request->text;
        $article->slug = $request->slug;
        $article->category_id = $request->category_id;
        $article->enabled = $request->enabled;
        $article->user_id = Auth::user()->id;
        $article->save();


        if ($request->tags) {
            $article->retag($request->tags);
        } else {
            $article->untag();
        }
        $article->save();

        Cache::forget('article_' . $article->id);
        flash('مقاله با موفقیت ایجاد شد.')->success();
        return redirect()->route('admin.article');
    }

    public function update($id, Request $request)
    {
        $article = Article::findOrFail($id);
        Validator::make($request->all(), [
            'title' => 'required|string',
            'text' => 'required|string',
            'category_id' => 'required'
        ])->validate();
        $article->title = $request->title;
        $article->description = $request->description;
        $article->text = $request->text;
        $article->category_id = $request->category_id;
        $article->slug = $request->slug;
        $article->enabled = $request->enabled;
        $article->save();

        if ($request->tags) {
            $article->retag($request->tags);
        } else {
            $article->untag();
        }
        $article->save();

        Cache::forget('article_' . $article->id);
        flash('صفحه با موفقیت ویرایش شد.')->success();
        return redirect()->route('admin.article.edit', ['id' => $article->id]);
    }

    public function delete($id, Request $request)
    {
        $article = Article::findOrFail($id);
        $article->delete();
        flash('مقاله با موفقیت حذف شد.')->success();
        Cache::forget('article_' . $article->id);
        return redirect()->route('admin.article');
    }
}
