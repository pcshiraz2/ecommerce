<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\File;

class FileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $files = File::paginate(config('platform.file-per-page'));
        return view('admin.file.index', ['files' => $files]);
    }
}
