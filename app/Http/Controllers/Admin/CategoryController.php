<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        return view('admin.category.index');
    }

    public function data()
    {
        return DataTables::eloquent(Category::select(['id', 'title', 'type']))
            ->editColumn('type', '{{ trans("category.".$type) }}')
            ->addColumn('action', 'admin.category.action')
            ->make(true);
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.edit', ['category' => $category]);
    }

    public function insert(Request $request)
    {
        Validator::make($request->all(), [
            'title' => 'required|string',
            'type' => 'required|string',
        ])->validate();
        $category = new Category();
        $category->title = $request->title;
        $category->type = $request->type;
        $category->color = $request->color;
        $category->icon = $request->icon;
        $category->save();
        Cache::forget('categories_' . $category->type);
        flash('دسته با موفقیت اضافه شد.')->success();
        return redirect()->route('admin.category');
    }

    public function update($id, Request $request)
    {
        $category = Category::findOrFail($id);
        Validator::make($request->all(), [
            'title' => 'required|string',
            'type' => 'required|string',
        ])->validate();
        $category->title = $request->title;
        $category->type = $request->type;
        $category->color = $request->color;
        $category->icon = $request->icon;
        $category->save();
        Cache::forget('categories_' . $category->type);
        flash('دسته با موفقیت ویرایش شد.')->success();
        return redirect()->route('admin.category.edit', ['id' => $category->id]);
    }


    public function delete($id, Request $request)
    {
        $category = Category::findOrFail($id);
        Cache::forget('categories_' . $category->type);
        $category->delete();
        flash('دسته با موفقیت حذف شد.')->success();
        return redirect()->route('admin.category');
    }
}
