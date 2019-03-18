<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use App\Models\Category;
use App\Models\DiscussionPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscussionController extends Controller
{
    public function index()
    {
        $discussions = Discussion::with(['user', 'category'])->orderBy('created_at', 'desc')->paginate(config('platform.file-per-page'));
        $categories = Category::findType('Forum');
        return view('discussion.index', ['categories' => $categories, 'discussions' => $discussions]);
    }

    public function create()
    {
        $categories = Category::findType('Forum');
        return view('discussion.create', ['categories' => $categories]);
    }

    public function view($id)
    {
        $discussion = Discussion::with(['user', 'category'])->findOrFail($id);
        $posts = DiscussionPost::with('user')->where('discussion_id', $id)->paginate(config('platform.file-per-page'));
        $categories = Category::findType('Forum');
        return view('discussion.view', ['discussion' => $discussion, 'categories' => $categories, 'posts' => $posts]);
    }

    public function category($id)
    {
        $category = Category::findWithCache($id);
        $discussions = Discussion::with(['user', 'category'])->where('category_id', $id)->orderBy('created_at', 'desc')->paginate(config('platform.file-per-page'));
        $categories = Category::findType('Forum');
        return view('discussion.category', ['categories' => $categories, 'discussions' => $discussions, 'category' => $category]);
    }

    public function post($id, Request $request)
    {
        $request->validate([
            'text' => 'required|string',
        ]);
        $discussion = Discussion::findOrFail($id);
        $post = new DiscussionPost();
        $post->user_id = Auth::user()->id;
        $post->text = $request->text;
        $post->discussion_id = $id;
        $post->save();

        $discussion->posts = $discussion->posts + 1;
        $discussion->save();
        flash('پاسخ شما با موفقیت ثبت شد.')->success();
        return redirect()->route('discussion.view', ['id' => $discussion->id]);
    }

    public function insert(Request $request)
    {
        $request->validate([
            'title' => 'required|max:191|string',
            'text' => 'required|string',
            'category_id' => 'numeric|required',
        ]);
        $discussion = new Discussion();
        $discussion->category_id = $request->category_id;
        $discussion->text = $request->text;
        $discussion->user_id = Auth::user()->id;
        $discussion->title = $request->title;
        if (Auth::user()->level == 'admin') {
            $discussion->important = $request->important;
            $discussion->type = $request->type;
        }
        $discussion->save();

        if ($request->tags) {
            $discussion->retag($request->tags);
        } else {
            $discussion->untag();
        }
        $discussion->save();

        flash('بحث با موفقیت ایجاد شد.')->success();
        return redirect()->route('discussion.view', ['id' => $discussion->id]);
    }
}
