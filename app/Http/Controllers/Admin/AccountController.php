<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Account;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $accounts = Account::paginate(config('platform.default-per-page'));
        return view('admin.account.index', ['accounts' => $accounts]);
    }

    public function create()
    {
        return view('admin.account.create');
    }

    public function edit($id)
    {
        $account = Account::findOrFail($id);
        return view('admin.account.edit', ['account' => $account]);
    }

    public function insert(Request $request)
    {
        Validator::make($request->all(), [
            'title' => 'required|string',
            'order' => 'required|numeric',
        ])->validate();
        $account = new Account();
        $account->title = $request->title;
        $account->order = $request->order;
        $account->initial_balance = $request->initial_balance;
        $account->enabled = $request->enabled;
        $account->note = $request->note;
        $account->save();
        flash('حساب با موفقیت اضافه شد.')->success();
        return redirect()->route('admin.account');
    }

    public function update($id, Request $request)
    {
        $account = account::findOrFail($id);
        Validator::make($request->all(), [
            'title' => 'required|string',
        ])->validate();
        $account->title = $request->title;
        $account->order = $request->order;
        $account->initial_balance = $request->initial_balance;
        $account->enabled = $request->enabled;
        $account->note = $request->note;
        $account->save();
        flash('حساب  با موفقیت ویرایش شد.')->success();
        return redirect()->route('admin.account.edit', ['id' => $account->id]);
    }

    public function delete($id, Request $request)
    {
        $account = Account::findOrFail($id);
        $account->delete();
        flash('حساب با موفقیت حذف شد.')->success();
        return redirect()->route('admin.account');
    }
}
