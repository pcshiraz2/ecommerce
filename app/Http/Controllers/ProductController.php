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
        $product = Product::findOrFail($id);
        return view('product.view', compact('product'));
    }

    public function slug($id)
    {
        $product = Product::findOrFail($id);
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
}