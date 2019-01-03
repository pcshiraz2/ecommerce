<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use App\Models\FileVersion;

class FileVersionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create($id)
    {
        $file = File::findOrFail($id);
        return view('file-version.create', ['file' => $file]);
    }


    public function insert($id, Request $request)
    {
        $request->validate([
            'source' => 'required|file',
            'learn_link' => 'url',
            'support_link' => 'url',
        ]);
        $file = File::findOrFail($id);
        $version = new FileVersion();
        $version->file_id = $file->id;
        $version->name = $request->name;
        $version->title = $request->title;
        $version->description = $request->description;
        $version->source = $request->file('source')->store('file');
        $version->size = $request->file('source')->getSize();
        $version->save();

        $file->version_id = $version->id;
        $file->save();

        flash('نسخه فایل با موفقیت اضافه شد.')->success();
        return redirect()->route('file.view', ['id' => $file->id]);
    }

    public function uploadFile($id, Request $request)
    {

    }
}
