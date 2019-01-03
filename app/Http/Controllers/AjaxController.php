<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Product;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function cities(Request $request)
    {
        $cities = City::where('province_id', $request->province_id)->get();
        return response()->json($cities);
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $products = Product::where('title', 'like', '%' . $keyword . '%')->get();
        return view('ajax.search', ['products' => $products]);
    }

}
