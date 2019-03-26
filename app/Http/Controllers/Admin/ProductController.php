<?php

namespace App\Http\Controllers\Admin;

use App\Models\Attribute;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductAttribute;
use App\Models\ProductFile;
use App\Models\ProductImage;
use App\Utils\MoneyUtil;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

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
        $brands = Category::findType('Brand');
        return view('admin.product.create', ['categories' => $categories, 'brands' => $brands]);
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::findType('Product');
        $brands = Category::findType('Brand');
        return view('admin.product.edit', ['categories' => $categories, 'brands' => $brands, 'product' => $product]);
    }


    public function factory($id)
    {
        $product = Product::findOrFail($id);
        $className = '\App\Factories\\'.$product->factory;
        $factory = new $className;
        return $factory->productConfig($product);
    }



    public function factoryUpdate(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $className = '\App\Factories\\'.$product->factory;
        $factory = new $className;
        $factory->storeProductConfig($product, $request);
        flash('تنظیمات با موفقیت انجام شد.')->success();
        return redirect()->route('admin.product');
    }


    public function action($id, $action)
    {
        $product = Product::findOrFail($id);
        $className = '\App\Factories\\'.$product->factory;
        $factory = new $className;
        $factory->{$action};
    }



    public function actionUpdate(Request $request, $id, $action)
    {
        $action = $action . 'Update';
        $product = Product::findOrFail($id);
        $className = '\App\Factories\\'.$product->factory;
        $factory = new $className;
        $factory->{$action}($request, $id);
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
        $image->fit(config('platform.card-image-width'), config('platform.card-image-height'), function ($constraint) {
            $constraint->aspectRatio();
        });
        Storage::put($product->image, (string) $image->encode());

        $product->purchase_price = MoneyUtil::database($request->purchase_price);
        $product->sale_price = MoneyUtil::database($request->sale_price);
        $product->period_price = MoneyUtil::database($request->period_price);
        $product->discount_price = MoneyUtil::database($request->discount_price);
        if($request->discount_expire_at) {
            $product->discount_expire_at = \Morilog\Jalali\CalendarUtils::createDatetimeFromFormat('Y/m/d H:i', \App\Utils\TextUtil::convertToEnglish($request->discount_expire_at));
        }
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->model = $request->model;
        $product->user_id = Auth::user()->id;
        $product->initial_balance = $request->initial_balance;
        $product->factory = $request->factory;
        $product->slug = $request->slug;
        $product->code = $request->code;
        $product->description = $request->description;
        $product->text = $request->text;
        $product->enabled = $request->enabled;
        $product->shop = $request->shop;
        $product->asset = $request->asset;
        $product->post = $request->post;
        $product->period = $request->period;
        $product->top = $request->top;
        $product->order = $request->order;
        $product->tax = MoneyUtil::database($request->tax);
        $product->discount = $request->discount;
        $product->call_price = $request->call_price;
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
            $image->fit(config('platform.card-image-width'), config('platform.card-image-height'), function ($constraint) {
                $constraint->aspectRatio();
            });
            Storage::put($product->image, (string) $image->encode());
        }
        $product->sale_price = MoneyUtil::database($request->sale_price);
        $product->purchase_price = MoneyUtil::database($request->purchase_price);
        $product->period_price = MoneyUtil::database($request->period_price);
        $product->discount_price = MoneyUtil::database($request->discount_price);
        if($request->discount_expire_at) {
            $product->discount_expire_at = \Morilog\Jalali\CalendarUtils::createDatetimeFromFormat('Y/m/d H:i', \App\Utils\TextUtil::convertToEnglish($request->discount_expire_at));
        }
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->model = $request->model;
        $product->user_id = Auth::user()->id;
        $product->initial_balance = $request->initial_balance;
        $product->factory = $request->factory;
        $product->slug = $request->slug;
        $product->code = $request->code;
        $product->description = $request->description;
        $product->text = $request->text;
        $product->enabled = $request->enabled;
        $product->shop = $request->shop;
        $product->asset = $request->asset;
        $product->post = $request->post;
        $product->period = $request->period;
        $product->top = $request->top;
        $product->order = $request->order;
        $product->tax = MoneyUtil::database($request->tax);
        $product->discount = $request->discount;
        $product->call_price = $request->call_price;


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
        Storage::delete($product->image);
        $product->delete();
        Cache::forget('product_' . $product->id);
        flash('کالا با موفقیت حذف شد.')->success();
        return redirect()->route('admin.product');
    }


    public function image($id)
    {
        $product = Product::findWithCache($id);
        return view('admin.product.image.index',['product' => $product]);
    }

    public function imageCreate($id)
    {
        $product = Product::findWithCache($id);
        return view('admin.product.image.create',['product' => $product]);
    }

    public function imageInsert($id, Request $request)
    {
        Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'source' => 'required',
        ])->validate();
        $product = Product::findWithCache($id);

        $image = new ProductImage();
        $image->product_id = $product->id;
        $image->title = $request->title;
        $image->source = $request->file('source')->store('public');
        $image->description = $request->description;
        $image->enabled = $request->enabled;
        $image->order = $request->order;
        $image->save();

        Cache::forget('product_' . $product->id);
        flash('تصویر با موفقیت اضافه شد.')->success();
        return redirect()->route('admin.product.image',[$product->id]);

    }

    public function imageEdit($id)
    {
        $image = ProductImage::findOrFail($id);
        $product = Product::findWithCache($image->product_id);
        return view('admin.product.image.edit',['product' => $product, 'image' => $image]);
    }

    public function imageUpdate($id, Request $request)
    {
        Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
        ])->validate();

        $image = ProductImage::with(['product'])->findOrFail($id);
        $image->title = $request->title;
        if($request->source) {
            Storage::delete($image->source);
            $image->source = $request->file('source')->store('public');
        }
        $image->description = $request->description;
        $image->enabled = $request->enabled;
        $image->order = $request->order;
        $image->save();

        Cache::forget('product_' . $image->product_id);
        flash('تصویر با موفقیت اضافه شد.')->success();
        return redirect()->route('admin.product.image',[$image->product_id]);
    }

    public function imageDelete($id, Request $request)
    {
        $image = ProductImage::findOrFail($id);
        $product_id = $image->product_id;
        Storage::delete($image->source);
        $image->delete();
        Cache::forget('product_' . $product_id);
        flash('تصویر با موفقیت اضافه شد.')->success();
        return redirect()->route('admin.product.image',[$product_id]);
    }

    public function file($id)
    {
        $product = Product::findWithCache($id);
        return view('admin.product.file.index',['product' => $product]);
    }

    public function fileCreate($id)
    {
        $product = Product::findWithCache($id);
        return view('admin.product.file.create',['product' => $product]);
    }

    public function fileInsert($id, Request $request)
    {
        Validator::make($request->all(), [
            'title' => 'required',
            'name' => 'required',
            'description' => 'required',
            'source' => 'required',
        ])->validate();
        $product = Product::findWithCache($id);

        $file = new ProductFile();
        $file->product_id = $product->id;
        $file->title = $request->title;
        $file->name = $request->name;
        $file->size = $request->file('source')->getSize();
        $file->source = $request->file('source')->store('file');
        $file->description = $request->description;
        $file->free = $request->free;
        $file->public = $request->public;
        $file->enabled = $request->enabled;
        $file->order = $request->order;
        $file->save();

        Cache::forget('product_' . $product->id);
        flash('فایل با موفقیت اضافه شد.')->success();
        return redirect()->route('admin.product.file',[$product->id]);
    }

    public function fileEdit($id)
    {
        $file = ProductFile::findOrFail($id);
        $product = Product::findWithCache($file->product_id);
        return view('admin.product.file.edit',['product' => $product, 'file' => $file]);
    }

    public function fileUpdate($id, Request $request)
    {
        Validator::make($request->all(), [
            'title' => 'required',
            'name' => 'required',
            'description' => 'required',
        ])->validate();

        $file = ProductFile::with(['product'])->findOrFail($id);
        $file->title = $request->title;
        $file->name = $request->name;
        if($request->source) {
            Storage::delete($file->source);
            $file->size = $request->file('source')->getSize();
            $file->source = $request->file('source')->store('file');
        }

        $file->description = $request->description;
        $file->free = $request->free;
        $file->public = $request->public;
        $file->enabled = $request->enabled;
        $file->order = $request->order;
        $file->save();

        Cache::forget('product_' . $file->product_id);
        flash('فایل با موفقیت اضافه شد.')->success();
        return redirect()->route('admin.product.file',[$file->product_id]);
    }

    public function fileDelete($id)
    {
        $file = ProductFile::findOrFail($id);
        $product_id = $file->product_id;
        Storage::delete($file->source);
        $file->delete();
        Cache::forget('product_' . $product_id);
        flash('فایل با موفقیت اضافه شد.')->success();
        return redirect()->route('admin.product.file',[$product_id]);

    }


    public function attribute($id)
    {
        $product = Product::findWithCache($id);
        return view('admin.product.attribute.index',['product' => $product]);
    }

    public function attributeCreate($id)
    {
        $categories = Category::findType('Attribute');
        $attributes = Attribute::where('category_id', $categories->first()->id)->get();
        $product = Product::findWithCache($id);
        return view('admin.product.attribute.create',['product' => $product,'categories' => $categories, 'attributes' => $attributes]);
    }

    public function attributeInsert($id, Request $request)
    {
        Validator::make($request->all(), [
            'value' => 'required',
            'attribute_id' => 'required'
        ])->validate();

        $product = Product::findWithCache($id);
        $attribute = new ProductAttribute();
        $attribute->product_id = $product->id;
        $attribute->value = $request->value;
        $attribute->attribute_id = $request->attribute_id;
        $attribute->order = $request->order;
        $attribute->enabled = $request->enabled;
        $attribute->save();

        Cache::forget('product_' . $product->id);
        flash('مشخصه با موفقیت اضافه شد.')->success();
        return redirect()->route('admin.product.attribute',[$product->id]);
    }

    public function attributeEdit($id)
    {
        $attribute = ProductAttribute::with('attribute')->findOrFail($id);
        $product = Product::findWithCache($attribute->product_id);
        $categories = Category::findType('Attribute');
        $attributes = Attribute::where('category_id', $attribute->attribute->category_id)->get();
        return view('admin.product.attribute.edit',['product' => $product,'categories' => $categories, 'attributes' => $attributes, 'attribute' => $attribute]);
    }

    public function attributeUpdate($id, Request $request)
    {
        Validator::make($request->all(), [
            'value' => 'required',
            'attribute_id' => 'required'
        ])->validate();

        $attribute = ProductAttribute::findOrFail($id);

        $attribute->value = $request->value;
        $attribute->attribute_id = $request->attribute_id;
        $attribute->order = $request->order;
        $attribute->enabled = $request->enabled;
        $attribute->save();

        Cache::forget('product_' . $attribute->product_id);
        flash('مشخصه با موفقیت ویرایش شد.')->success();
        return redirect()->route('admin.product.attribute',[$attribute->product_id]);
    }

    public function attributeDelete($id)
    {
        $attribute = ProductAttribute::findOrFail($id);
        $product_id = $attribute->product_id;
        $attribute->delete();
        Cache::forget('product_' . $product_id);
        flash('مشخصه با موفقیت حذف شد.')->success();
        return redirect()->route('admin.product.attribute',[$product_id]);

    }



}
