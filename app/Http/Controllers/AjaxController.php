<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Product;
use Conner\Tagging\Model\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

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


    public function tags()
    {
        $output = array(
            'query' => 'Unit',
            'suggestions' => []
        );
        $tags = Tag::where('name', 'like', '%' . Input::get('query') . '%')->select(['name'])->get();
        $tags_array = array();
        $i = 0;
        foreach ($tags as $tag) {
            $tags_array[$i]['value'] = $tag->name;
            $i++;
        }

        $output['suggestions'] = $tags_array;
        return response()->json($output);
    }

}
