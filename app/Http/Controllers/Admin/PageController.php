<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $pages = Page::collect();
        return view('admin.page.index',['pages' => $pages]);
    }


    public function create()
    {
        return view('admin.page.create');
    }

    public function edit($id)
    {
        $page = Page::findOrFail($id);
        return view('admin.page.edit', ['page' => $page]);
    }

    public function insert(Request $request)
    {
        Validator::make($request->all(), [
            'title' => 'required|string',
            'text' => 'required|string',
            'access' => 'required',
            'enabled' => 'required',
        ])->validate();
        $page = new Page();
        $page->title = $request->title;
        $page->description = $request->description;
        $page->slug = $request->slug;
        $page->text = $request->text;
        $page->access = $request->access;
        $page->enabled = $request->enabled;
        $page->save();
        flash('صفحه با موفقیت ایجاد شد.')->success();
        return redirect()->route('admin.page');
    }

    public function update($id, Request $request)
    {
        $page = Page::findOrFail($id);
        Validator::make($request->all(), [
            'title' => 'required|string',
            'text' => 'required|string',
            'access' => 'required',
            'enabled' => 'required',
        ])->validate();
        $page->title = $request->title;
        $page->description = $request->description;
        $page->text = $request->text;
        $page->access = $request->access;
        $page->slug = $request->slug;
        $page->enabled = $request->enabled;
        $page->save();
        Cache::forget('page_' . $page->id);
        flash('صفحه با موفقیت ویرایش شد.')->success();
        return redirect()->route('admin.page.edit', ['id' => $page->id]);
    }

    public function delete($id, Request $request)
    {
        $page = Page::findOrFail($id);
        Cache::forget('page_' . $page->id);
        $page->delete();
        flash('صفحه با موفقیت حذف شد.')->success();
        return redirect()->route('admin.page');
    }
}
