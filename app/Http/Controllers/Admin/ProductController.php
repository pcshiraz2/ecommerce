<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use App\Utils\MoneyUtil;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $products = Product::with('category')->orderBy('created_at', 'desc')->paginate(config('platform.file-per-page'));
        return view('admin.product.index', ['products' => $products]);
    }

    public function create()
    {
        $categories = Category::findType('Product');
        return view('admin.product.create', ['categories' => $categories]);
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::findType('Product');
        return view('admin.product.edit', ['categories' => $categories, 'product' => $product]);
    }

    public function inventory($id)
    {
        $product = Product::findOrFail($id);
        if ($product->asset == 'yes') {
            return $product->getInventory();
        } else {
            return "فاقد انبار داری";
        }

    }

    public function insert(Request $request)
    {
        Validator::make($request->all(), [
            'title' => 'required',
            'image' => 'required|image',
            'purchase_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'category_id' => 'required',
        ])->validate();

        $product = new Product();
        $product->title = $request->title;
        $product->image = $request->file('image')->store('public');
        $product->purchase_price = MoneyUtil::database($request->purchase_price);
        $product->sale_price = MoneyUtil::database($request->sale_price);

        $product->category_id = $request->category_id;
        $product->user_id = Auth::user()->id;
        $product->initial_balance = $request->initial_balance;
        $product->factory = $request->factory;
        $product->slug = $request->slug;
        $product->description = $request->description;
        $product->text = $request->text;
        $product->enabled = $request->enabled;
        $product->shop = $request->shop;
        $product->asset = $request->asset;
        $product->post = $request->post;
        $product->renewal = $request->renewal;
        $product->period = $request->period;
        $product->top = $request->top;
        $product->order = $request->order;
        $product->save();

        if ($request->tags) {
            $product->retag($request->tags);
        } else {
            $product->untag();
        }
        $product->save();


        flash('کالا با موفقیت اضافه شد.')->success();
        return redirect()->route('admin.product');
    }

    public function update($id, Request $request)
    {
        $product = Product::findOrFail($id);
        Validator::make($request->all(), [
            'title' => 'required',
            'purchase_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'category_id' => 'required',
        ])->validate();
        $product->title = $request->title;
        if ($request->image) {
            Storage::delete($product->image);
            $product->image = $request->file('image')->store('public');
        }
        $product->sale_price = MoneyUtil::database($request->sale_price);
        $product->purchase_price = MoneyUtil::database($request->purchase_price);
        $product->category_id = $request->category_id;
        $product->user_id = Auth::user()->id;
        $product->initial_balance = $request->initial_balance;
        $product->factory = $request->factory;
        $product->slug = $request->slug;
        $product->description = $request->description;
        $product->text = $request->text;
        $product->enabled = $request->enabled;
        $product->shop = $request->shop;
        $product->asset = $request->asset;
        $product->post = $request->post;
        $product->renewal = $request->renewal;
        $product->period = $request->period;
        $product->order = $request->order;
        $product->top = $request->top;
        if ($request->tags) {
            $product->retag($request->tags);
        } else {
            $product->untag();
        }
        $product->save();
        Cache::forget('product_' . $product->id);
        flash('کالا با موفقیت ویرایش شد.')->success();
        return redirect()->route('admin.product');
    }

    public function delete($id, Request $request)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        Cache::forget('product_' . $product->id);
        flash('کالا با موفقیت حذف شد.')->success();
        return redirect()->route('admin.product');
    }
}
