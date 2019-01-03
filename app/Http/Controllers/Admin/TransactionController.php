<?php

namespace App\Http\Controllers\Admin;

use App\Models\Account;
use App\Models\Transaction;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Morilog\Jalali\Jalalian;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function data()
    {
        return DataTables::eloquent(Transaction::with(['account', 'category'])->select(['id', 'description', 'account_id', 'amount', 'category_id', 'transaction_at']))
            ->addColumn('action', 'admin.transaction.action')
            ->make(true);
    }

    public function index()
    {
        $transactions = Transaction::with(['category', 'account'])->orderBy('transaction_at', 'desc')->paginate(config('platform.file-per-page'));
        return view('admin.transaction.index', ['transactions' => $transactions]);
    }

    public function createIncome()
    {
        $users = User::all();
        $accounts = Account::all();
        $categories = Category::findType('Income');
        return view('admin.transaction.create', ['categories' => $categories, 'accounts' => $accounts, 'users' => $users]);

    }

    public function createExpense()
    {
        $users = User::all();
        $accounts = Account::all();
        $categories = Category::findType('Expense');
        return view('admin.transaction.create', ['categories' => $categories, 'accounts' => $accounts, 'users' => $users]);

    }

    public function editIncome($id)
    {
        $users = User::all();
        $transaction = Transaction::findOrFail($id);
        $accounts = Account::all();
        $categories = Category::findType('Income');
        return view('admin.transaction.edit', ['categories' => $categories, 'accounts' => $accounts, 'transaction' => $transaction, 'users' => $users]);

    }

    public function editExpense($id)
    {

        $users = User::all();
        $transaction = Transaction::findOrFail($id);
        $accounts = Account::all();
        $categories = Category::findType('Expense');
        return view('admin.transaction.edit', ['categories' => $categories, 'accounts' => $accounts, 'transaction' => $transaction, 'users' => $users]);
    }


    public function update($id, Request $request)
    {
        $transaction = Transaction::findOrFail($id);
        Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1',
            'description' => 'required|string',
            'category_id' => 'required',
            'account_id' => 'required',
            'transaction_at' => 'required',
        ])->validate();
        if ($request->type == 'income') {
            $transaction->amount = abs($request->amount);
        } else if ($request->type == 'expense') {
            $transaction->amount = -1 * abs($request->amount);
        }
        $transaction->description = $request->description;
        $transaction->category_id = $request->category_id;
        $transaction->account_id = $request->account_id;
        $transaction->user_id = $request->user_id;
        $transaction->transaction_at = jDateTime::createDatetimeFromFormat('Y/m/d', en_numbers($request->transaction_at));
        $transaction->save();
        flash('تراکنش با موفقیت ویرایش شد.')->success();
        return redirect()->route('admin.transaction');
    }


    public function insert(Request $request)
    {
        Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1',
            'description' => 'required|string',
            'category_id' => 'required',
            'account_id' => 'required',
            'transaction_at' => 'required',
        ])->validate();
        $transaction = new Transaction();
        if ($request->type == 'income') {
            $transaction->amount = abs($request->amount);
        } else if ($request->type == 'expense') {
            $transaction->amount = -1 * abs($request->amount);
        }

        $transaction->description = $request->description;
        $transaction->category_id = $request->category_id;
        $transaction->account_id = $request->account_id;
        $transaction->user_id = $request->user_id;
        $transaction->transaction_at = jDateTime::createDatetimeFromFormat('Y/m/d', en_numbers($request->transaction_at));
        $transaction->save();
        flash('تراکنش با موفقیت اضافه شد.')->success();
        return redirect()->route('admin.transaction');
    }

    public function delete($id, Request $request)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();
        flash('تراکنش با موفقیت حذف شد.')->success();
        return redirect()->route('admin.transaction');
    }

}
