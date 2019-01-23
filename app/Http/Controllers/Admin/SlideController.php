<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Slide;

class SlideController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $slides = Slide::collect();
        return view('admin.slide.index', ['slides' => $slides]);
    }

    public function create()
    {
        return view('admin.slide.create');
    }


    public function edit($id)
    {
        $slide = Slide::findOrFail($id);
        return view('admin.slide.edit', ['slide' => $slide]);
    }

    public function insert(Request $request)
    {
        Validator::make($request->all(), [
            'title' => 'required|string',
            'image' => 'required|image',
            'enabled' => 'required',
        ])->validate();

        $slide = new Slide();
        $slide->title = $request->title;
        $slide->enabled = $request->enabled;
        $slide->order = $request->order;
        $slide->description = $request->description;

        $file = $request->file('image');
        $slide->image = $file->hashName('public');
        $image = Image::make($file);
        $image->fit(config('platform.slide-image-width'), config('platform.slide-image-height'), function ($constraint) {
            $constraint->aspectRatio();
        });
        Storage::put($slide->image, (string) $image->encode());

        $slide->save();
        flash('اسلاید با موفقیت اضافه شد.')->success();
        return redirect()->route('admin.slide');
    }



    public function update(Request $request, $id)
    {
        $slide = Slide::findOrFail($id);
        Validator::make($request->all(), [
            'title' => 'required|string',
            'image' => 'nullable|image',
            'enabled' => 'required',
        ])->validate();

        $slide->title = $request->title;
        $slide->enabled = $request->enabled;
        $slide->order = $request->order;
        $slide->description = $request->description;
        if ($request->image) {
            Storage::delete($slide->image);
            $file = $request->file('image');
            $slide->image = $file->hashName('public');
            $image = Image::make($file);
            $image->fit(config('platform.slide-image-width'), config('platform.slide-image-height'), function ($constraint) {
                $constraint->aspectRatio();
            });
            Storage::put($slide->image, (string) $image->encode());
        }
        $slide->save();

        flash('اسلاید با موفقیت ویرایش شد.')->success();
        return redirect()->route('admin.slide');
    }

    public function delete($id, Request $request)
    {
        $slide = Page::findOrFail($id);
        $slide->delete();
        flash('اسلاید با موفقیت حذف شد.')->success();
        return redirect()->route('admin.slide');
    }
}
