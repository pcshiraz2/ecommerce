<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Support\Facades\Auth;

class MiscController extends Controller
{
    public function setPerPage($limit)
    {
        session(['per-page' => $limit]);
        flash('هم اکنون شما در هر صفحه ' . $limit . ' مورد را مشاهده خواهید کرد.')->info();
        return redirect()->back();
    }

    public function upload(Request $request)
    {
        if(Auth::check()) {
            if (Input::hasFile('source')) {
                $file = Input::file('source');
                if ($file->isValid()) {
                    $image = new Image();
                    $image->source = $request->file('source')->store('public');
                    $image->size = $request->file('source')->getSize();
                    $image->user_id = Auth::user()->id;
                    $image->save();
                    $url = Storage::url($image->source);
                    $data = array();
                    $data['url'] = asset($url);
                    $data['success'] = true;

                } else {
                    $data['success'] = false;
                    $data['message'] = 'خطای در زمان لود تصویر رخ داد.';
                }
            } else {
                $data['success'] = false;
                $data['message'] = 'فایل بارگزاری نشد.';
            }
        } else {
            $data['success'] = false;
            $data['message'] = 'شما باید در سیستم عضو باشید.';
        }
        return response()->json($data);
    }
}
