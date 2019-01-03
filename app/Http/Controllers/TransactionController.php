<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $transactions = Transaction::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(config('platform.file-per-page'));
        return view('transaction.index', ['transactions' => $transactions]);
    }

    public function view($id)
    {
        $transaction = Transaction::findOrFail($id);
        if (Auth::user()->level != 'admin' && Auth::user()->id != $transaction->user_id) {
            abort(404);
        }
        return view('transaction.view', ['transaction' => $transaction]);
    }
}
