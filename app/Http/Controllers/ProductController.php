<?php
/**
 * Created by PhpStorm.
 * User: Ali Ghasemzadeh
 * Date: 12/7/2018
 * Time: 11:45 AM
 */

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductFile;
use App\Models\Record;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $categories = Category::findType('Product');
        $products = Product::enabled()->shop()->top()->collect();
        return view('product.index', ['products' => $products, 'categories' => $categories]);
    }

    public function view($id)
    {
        $product = Product::findWithCache($id);
        return view('product.view', compact('product'));
    }

    public function slug($id)
    {
        $product = Product::findWithCache($id);
        return view('product.view', compact('product'));
    }

    public function category($id)
    {
        $category = Category::findWithCache($id);
        $categories = Category::findType('Product');
        $brands = Category::findType('Brand');
        $products = Product::enabled()->shop()->ofCategory($id)->collect();


        return view('product.category', ['products' => $products, 'categories' => $categories, 'brands' => $brands, 'category' => $category]);
    }


    public function code($id)
    {
        $category = Category::findWithCache($id);
        $categories = Category::findType('Product');
        $brands = Category::findType('Brand');
        $products = Product::enabled()->shop()->ofCategory($id)->collect();
        return view('product.category', ['products' => $products, 'categories' => $categories, 'brands' => $brands, 'category' => $category]);
    }

    public function find()
    {
        $products = Product::enabled()->shop()->collect();
        return view('product.find', ['products' => $products]);
    }

    public function download($id)
    {
        $file = ProductFile::enabled()->with(['product'])->findOrFail($id);
        if($file->public) {
            if($file->free) {
                return Storage::download($file->source, $file->name);
            } else {
                $record = Record::with(['invoice'])->where('invoice.user_id', Auth::user()->id);
                if($record->invoice->status == 'paid' || $record->invoice->status == 'done' || $record->invoice->status == 'approved') {
                    return Storage::download($file->source, $file->name);
                } else {
                    flash('لطفا کالا را خریداری کنید.')->warning();
                    return redirect()->route('product.view',[$file->product_id]);
                }
            }
        } else {
            if(Auth::check()) {
                return Storage::download($file->source, $file->name);
            } else {
                flash('برای دانلود لطفا وارد سیستم شوید.')->warning();
                return redirect()->route('product.view',[$file->product_id]);
            }
        }





    }
}