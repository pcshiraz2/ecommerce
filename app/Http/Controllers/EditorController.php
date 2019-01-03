<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;

class EditorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function upload(Request $request)
    {
        $url = '';
        if (Input::hasFile('source')) {
            $file = Input::file('source');
            if ($file->isValid()) {
                $image = new Image();
                $image->source = $request->file('source')->store('public');
                $image->size = $request->file('source')->getSize();
                $image->user_id = Auth::user()->id;
                $image->save();
                $url = Storage::url($image->source);
            } else {
                $message = 'خطای در زمان لود تصویر رخ داد.';
            }
        } else {
            $message = 'فایل بارگزاری نشد.';
        }
        $data = array();
        $data['url'] = asset($url);
        $data['success'] = true;
        return response()->json($data);

    }
}
