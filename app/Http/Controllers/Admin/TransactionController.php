<?php

namespace App\Http\Controllers\Admin;

use App\Models\Account;
use App\Models\Transaction;
use App\Models\Category;
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

    public function index()
    {
        $transactions = Transaction::with(['category', 'account'])->orderBy('transaction_at', 'desc')->paginate(config('platform.file-per-page'));
        return view('admin.transaction.index', ['transactions' => $transactions]);
    }

    public function createIncome()
    {
        $accounts = Account::all();
        $categories = Category::findType('Income');
        return view('admin.transaction.create', ['categories' => $categories, 'accounts' => $accounts]);

    }

    public function createExpense()
    {
        $accounts = Account::all();
        $categories = Category::findType('Expense');
        return view('admin.transaction.create', ['categories' => $categories, 'accounts' => $accounts]);
    }

    public function createTransfer()
    {
        $accounts = Account::all();
        return view('admin.transaction.transfer', ['accounts' => $accounts]);
    }


    public function edit($id)
    {
        $transaction = Transaction::with('user')->findOrFail($id);
        $accounts = Account::all();
        if($transaction->type == 'expense') {
            $categories = Category::findType('Expense');
        } else if($transaction->type == 'income') {
            $categories = Category::findType('Income');
        } else if($transaction->type == 'invoice') {
            flash("این تراکنش فقط از طریق ویرایش فاکتور فروش قابل تغییر است.")->success();
            return redirect()->route('admin.invoice.view',['id' => $transaction->invoice_id]);
        }


        return view('admin.transaction.edit', ['categories' => $categories, 'accounts' => $accounts, 'transaction' => $transaction]);
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
        $transaction->transaction_at = \Morilog\Jalali\CalendarUtils::createDatetimeFromFormat('Y/m/d', \App\Utils\TextUtil::convertToEnglish($request->transaction_at));
        if ($request->paid_at) {
            $transaction->paid_at = \Morilog\Jalali\CalendarUtils::createDatetimeFromFormat('Y/m/d', \App\Utils\TextUtil::convertToEnglish($request->paid_at));
        } else {
            $transaction->paid_at = null;
        }
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
        $transaction->type = $request->type;
        $transaction->transaction_at = \Morilog\Jalali\CalendarUtils::createDatetimeFromFormat('Y/m/d', \App\Utils\TextUtil::convertToEnglish($request->transaction_at));
        if($request->paid_at) {
            $transaction->paid_at = \Morilog\Jalali\CalendarUtils::createDatetimeFromFormat('Y/m/d', \App\Utils\TextUtil::convertToEnglish($request->paid_at));
        } else {
            $transaction->paid_at = null;
        }

        $transaction->save();
        flash('تراکنش با موفقیت اضافه شد.')->success();
        return redirect()->route('admin.transaction');
    }

    public function insertTransfer(Request $request)
    {
        Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1',
            'description' => 'required|string',
            'source_account_id' => 'required',
            'destination_account_id' => 'required',
            'transaction_at' => 'required',
        ])->validate();


        $transaction = new Transaction();
        $transaction->type = 'transfer';
        $transaction->amount = -1 * abs($request->amount);
        $transaction->description = $request->description;
        $transaction->category_id = config('platform.expense-transfer-category-id');
        $transaction->account_id = $request->source_account_id;
        $transaction->transaction_at = \Morilog\Jalali\CalendarUtils::createDatetimeFromFormat('Y/m/d', \App\Utils\TextUtil::convertToEnglish($request->transaction_at));
        $transaction->paid_at = \Morilog\Jalali\CalendarUtils::createDatetimeFromFormat('Y/m/d', \App\Utils\TextUtil::convertToEnglish($request->transaction_at));
        $transaction->save();


        $transaction = new Transaction();
        $transaction->type = 'transfer';
        $transaction->amount = abs($request->amount);
        $transaction->description = $request->description;
        $transaction->category_id = config('platform.income-transfer-category-id');
        $transaction->account_id = $request->destination_account_id;
        $transaction->transaction_at = \Morilog\Jalali\CalendarUtils::createDatetimeFromFormat('Y/m/d', \App\Utils\TextUtil::convertToEnglish($request->transaction_at));
        $transaction->paid_at = \Morilog\Jalali\CalendarUtils::createDatetimeFromFormat('Y/m/d', \App\Utils\TextUtil::convertToEnglish($request->transaction_at));
        $transaction->save();


        flash('انتقال وجه با موفقیت انجام شد.')->success();
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
