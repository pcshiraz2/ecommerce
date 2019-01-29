<?php
/**
 * Created by PhpStorm.
 * User: Ali Ghasemzadeh
 * Date: 12/7/2018
 * Time: 11:45 AM
 */

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $categories = Category::findType('Product');
        $products = $products = Product::top()->orderBy('updated_at', 'desc')->paginate(config('platform.product-per-page'));
        return view('product.index', ['products' => $products, 'categories' => $categories]);
    }

    public function view($id)
    {
        $product = Product::findOrFail($id);
        return view('product.view', compact('product'));
    }

    public function category($id)
    {
        $category = Category::findWithCache($id);
        $categories = Category::findType('Product');
        $products = $products = Product::where('category_id', $id)->orderBy('updated_at', 'desc')->paginate(config('platform.product-per-page'));
        return view('product.category', ['products' => $products, 'categories' => $categories, 'category' => $category]);
    }

    public function find()
    {
        $products = Product::enabled()->collect();
        return view('product.find', ['products' => $products]);
    }
}