<?php

namespace App\Http\Controllers\Admin;

use App\Models\Attribute;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AttributeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $attributes = Attribute::with('category')->paginate(config('platform.file-per-page'));
        return view('admin.attribute.index', ['attributes' => $attributes]);
    }

    public function create()
    {
        $categories = Category::findType('Attribute');
        return view('admin.attribute.create', ['categories' => $categories]);
    }

    public function insert(Request $request)
    {
        Validator::make($request->all(), [
            'title' => 'required',
            'category_id' => 'required'
        ])->validate();

        $attribute = new Attribute();
        $attribute->title = $request->title;
        $attribute->category_id = $request->category_id;
        $attribute->enabled = $request->enabled;
        $attribute->save();

        flash('مشخصه با موفقیت اضافه شد.')->success();
        return redirect()->route('admin.attribute');
    }

    public function edit($id)
    {
        $attribute = Attribute::findOrFail($id);
        $categories = Category::findType('Attribute');
        return view('admin.attribute.edit', ['categories' => $categories, 'attribute' => $attribute]);
    }

    public function update($id, Request $request)
    {
        Validator::make($request->all(), [
            'title' => 'required',
            'category_id' => 'required'
        ])->validate();

        $attribute = Attribute::findOrFail($id);
        $attribute->title = $request->title;
        $attribute->category_id = $request->category_id;
        $attribute->enabled = $request->enabled;
        $attribute->save();

        flash('مشخصه با موفقیت ویرایش شد.')->success();
        return redirect()->route('admin.attribute');
    }

    public function delete($id, Request $request)
    {
        $attribute = Attribute::findOrFail($id);
        $attribute->delete();
        flash('ویژگی با موفقیت ویرایش شد.')->success();
        return redirect()->route('admin.attribute');
    }
}
