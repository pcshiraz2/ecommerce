<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function view($id)
    {
        $product = Item::findOrFail($id);
        $factory = $product->factory;
        $factory = new $factory();
        return $factory->view($product);
    }


}
