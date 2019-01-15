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
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Input;

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

        $file = $request->file('image');
        $product->image = $file->hashName('public');
        $image = Image::make($file);
        $image->fit(300, 300, function ($constraint) {
            $constraint->aspectRatio();
        });
        Storage::put($product->image, (string) $image->encode());

        $product->purchase_price = MoneyUtil::database($request->purchase_price);
        $product->sale_price = MoneyUtil::database($request->sale_price);
        $product->renewal_price = MoneyUtil::database($request->renewal_price);
        if($request->off_expire_at) {
            $product->off_expire_at = \Morilog\Jalali\CalendarUtils::createDatetimeFromFormat('Y/m/d H:i', \App\Utils\TextUtil::convertToEnglish($request->off_expire_at));
        }
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
        $product->tax = $request->tax;
        $product->marketing = $request->marketing;
        $product->off = $request->off;
        $product->tax_percent = $request->tax_percent;
        $product->marketing_percent = $request->marketing_percent;

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
            $file = $request->file('image');
            $product->image = $file->hashName('public');
            $image = Image::make($file);
            $image->fit(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            });
            Storage::put($product->image, (string) $image->encode());
        }
        $product->sale_price = MoneyUtil::database($request->sale_price);
        $product->purchase_price = MoneyUtil::database($request->purchase_price);
        $product->renewal_price = MoneyUtil::database($request->renewal_price);
        $product->off_price = MoneyUtil::database($request->off_price);
        if($request->off_expire_at) {
            $product->off_expire_at = \Morilog\Jalali\CalendarUtils::createDatetimeFromFormat('Y/m/d H:i', \App\Utils\TextUtil::convertToEnglish($request->off_expire_at));
        }
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
        $product->tax = $request->tax;
        $product->marketing = $request->marketing;
        $product->off = $request->off;
        $product->tax_percent = $request->tax_percent;
        $product->marketing_percent = $request->marketing_percent;

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
