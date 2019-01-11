<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $categories = Category::where('type', 'Setting')->get();
        $first = $categories->first();
        $settings = Setting::with('category')->where('category_id', $first->id)->get();
        return view('admin.setting.index', ['settings' => $settings, 'categories' => $categories, 'id' => $first->id]);
    }

    public function category($id)
    {
        $settings = Setting::with('category')->where('category_id', $id)->get();
        $categories = Category::where('type', 'Setting')->get();
        return view('admin.setting.index', ['settings' => $settings, 'categories' => $categories, 'id' => $id]);
    }

    public function update(Request $request)
    {

    }

    public function updateCategory($id, Request $request)
    {
        $settings = Setting::where('category_id', $id)->get();
        foreach ($settings as $setting) {
            $key = 'setting_' . $setting->id;
            if ($setting->type == 'file') {
                if ($request->{$key}) {
                    if (File::exists(config($setting->key))) {
                        File::delete(config($setting->key));
                    }
                    $file = $request->file($key)->store('/config');
                    try {
                        Config::write($setting->key, storage_path('app/' . $file));
                    } catch (\Exception $e) {
                        Log::error($e);
                    }
                }
            } else {
                try {
                    Config::write($setting->key, $request->{$key});
                } catch (\Exception $e) {
                    Log::error($e);
                }
            }
        }
        flash('تغییرات با موفقیت ذخیره شد.')->success();
        return redirect()->route('admin.setting.category', ['id' => $id]);
    }
}
