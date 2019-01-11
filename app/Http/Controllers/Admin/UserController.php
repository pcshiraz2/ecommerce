<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserWelcome;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $users = User::collect();
        return view('admin.user.index', ['users' => $users]);
    }

    public function balance($id)
    {
        $user = User::findOrFail($id);
        return $user->getBalance();
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit', ['user' => $user]);
    }

    public function insert(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'mobile' => 'required|numeric|digits:11|unique:users,mobile',
            'password' => 'required|string|min:6|confirmed',
            'level' => 'required',
        ])->validate();
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->note = $request->note;
        $user->title = $request->title;
        $user->level = $request->level;
        $user->password = Hash::make($request->password);
        $user->save();

        try {
            Notification::send($user, new UserWelcome($user, $request->password));
        } catch (\Exception $e) {
        }

        flash('کاربر با موفقیت اضافه شد.')->success();
        return redirect()->route('admin.user');
    }

    public function update($id, Request $request)
    {
        if ($id == config('platform.main-admin-user-id') && Auth::user()->id != config('platform.main-admin-user-id')) {
            flash('شما نمی توانید مدیر اصلی سیستم را ویرایش کنید.')->error();
            return redirect()->route('admin.user');
        }
        $user = User::findOrFail($id);
        Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'mobile' => 'required|numeric|digits:11|unique:users,mobile,' . $user->id,
            'password' => 'confirmed',
            'level' => 'required',
        ])->validate();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->note = $request->note;
        $user->title = $request->title;
        $user->level = $request->level;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        flash('کاربر با موفقیت ویرایش شد.')->success();
        return redirect()->route('admin.user.edit', ['id' => $user->id]);
    }

    public function delete($id, Request $request)
    {
        if ($id == Auth::user()->id) {
            flash('شما نمی توانید خودتان را حذف کنید.')->error();
            return redirect()->route('admin.user');
        } else if ($id == config('platform.main-admin-user-id')) {
            flash('شما نمی توانید مدیر اصلی سیستم را حذف کنید.')->error();
            return redirect()->route('admin.user');
        }
        $user = User::findOrFail($id);
        $user->delete();
        flash('حذف کاربر با موفقیت انجام شد.')->success();
        return redirect()->route('admin.user');
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function invoice($id)
    {

    }

    public function transaction($id)
    {

    }

    public function ticket($id)
    {

    }
}
