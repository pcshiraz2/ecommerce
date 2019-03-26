<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\User;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function users()
    {
        $users = User::collect();
        return response()->json($users);
    }

    public function attributes(Request $request)
    {
        $attributes = Attribute::where('category_id', $request->category_id)->get();
        return response()->json($attributes);
    }
}
