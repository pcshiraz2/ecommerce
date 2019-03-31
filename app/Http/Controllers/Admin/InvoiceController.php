<?php

namespace App\Http\Controllers\Admin;

use App\Models\Account;
use App\Models\Item;
use App\Models\Record;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Support\Facades\Input;
use Morilog\Jalali\Jalalian;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;
use App\Notifications\InvoiceCreated;
use App\Models\Transaction;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $invoices = Invoice::with(['user'])->orderBy('created_at', 'desc')->paginate(config('platform.file-per-page'));
        return view('admin.invoice.index', ['invoices' => $invoices]);
    }

    public function createSale()
    {
        $users = User::all();
        $type = 'sale';
        return view('admin.invoice.create', ['type' => $type, 'users' => $users]);
    }

    public function createPurchase()
    {
        $users = User::all();
        $type = 'purchase';
        return view('admin.invoice.create', ['type' => $type, 'users' => $users]);
    }

    public function createUserInvoice($id)
    {
        $users = User::all();
        $type = 'sale';
        $user = User::findOrFail($id);
        return view('admin.invoice.user', ['type' => $type, 'select_user' => $user, 'users' => $users]);
    }

    public function insert(Request $request)
    {
        Validator::make($request->all(), [
            'invoice_at' => 'required',
            'user_id' => 'required',
            'total' => 'required|numeric|min:1',
            'tax' => 'required|numeric|min:0',
            'discount' => 'required|numeric|min:0',
            'record.*.price' => 'required|numeric|min:1',
            'record.*.quantity' => 'required|numeric|min:1',
            'record.*.tax' => 'required|numeric|min:1',
            'record.*.description' => 'required|string',
        ])->validate();

        $invoice = new Invoice();
        $invoice->user_id = $request->user_id;
        $invoice->total = $request->total;
        $invoice->tax = $request->tax;
        $invoice->note = $request->note;
        $invoice->discount = $request->discount;
        $invoice->type = $request->type;
        $invoice->password = uniqid();
        $invoice->invoice_at = jDateTime::createDatetimeFromFormat('Y/m/d', en_numbers($request->invoice_at));
        if ($request->due_at) {
            $invoice->due_at = jDateTime::createDatetimeFromFormat('Y/m/d', en_numbers($request->due_at));
        }
        if ($request->period) {
            $invoice->period = $request->period;
            $dut_at = new Carbon($invoice->due_at);
            $invoice->next_at = $dut_at->addDays($request->period);
        }
        $invoice->save();
        foreach ($request->record as $record_request) {
            $record = new Record();
            $record->invoice_id = $invoice->id;
            $record->description = $record_request['description'];
            $record->price = $record_request['price'];
            if ($request->type == 'sale') {
                $record->quantity = abs($record_request['quantity']) * -1;
            } else if ($request->type == 'purchase') {
                $record->quantity = abs($record_request['quantity']);
            }
            if (isset($record_request['item_id'])) {
                $record->item_id = $record_request['item_id'];
            }
            $record->total = $record_request['price'] * $record_request['quantity'];
            $record->save();
        }
        $user = User::findOrFail($request->user_id);
        try {
            if ($invoice->type == 'sale') {
                Notification::send($user, new InvoiceCreated($invoice, $user));
            }
        } catch (\Exception $e) {
        }
        flash('فاکتور با موفقیت ثبت شد.')->success();
        return redirect()->route('admin.invoice');
    }

    public function edit($id)
    {
        $invoice = Invoice::with('records')->findOrFail($id);
        $users = User::all();
        return view('admin.invoice.edit', ['invoice' => $invoice, 'users' => $users]);
    }

    public function delete($id, Request $request)
    {
        $invoice = Invoice::with('records')->findOrFail($id);
        foreach ($invoice->records as $record) {
            $record->delete();
        }
        $invoice->delete();
        flash('فاکتور حذف شد.')->success();
        return redirect()->route('admin.invoice');
    }

    public function deleteRecord(Request $request)
    {
        $record = Record::findOrFail($request->id);
        $record->delete();
        $invoice = Invoice::with('records')->findOrFail($request->invoice_id);
        $total = 0;
        foreach ($invoice->records as $record) {
            $total += $record->total;
        }
        if ($total == 0) {
            $invoice->tax = 0;
            $invoice->discount = 0;
        }
        $invoice->total = $total;
        $invoice->save();
        return "Ok";
    }

    public function update($id, Request $request)
    {
        Validator::make($request->all(), [
            'invoice_at' => 'required',
            'user_id' => 'required',
            'total' => 'required|numeric|min:1',
            'tax' => 'required|numeric|min:0',
            'discount' => 'required|numeric|min:0',
            'record.*.price' => 'required|numeric|min:1',
            'record.*.quantity' => 'required|numeric|min:1',
            'record.*.description' => 'required|string',
        ])->validate();
        $invoice = Invoice::with('records')->findOrFail($id);
        $invoice->user_id = $request->user_id;
        $invoice->total = $request->total;
        $invoice->tax = $request->tax;
        $invoice->note = $request->note;
        $invoice->type = $request->type;
        $invoice->discount = $request->discount;
        $invoice->invoice_at = jDateTime::createDatetimeFromFormat('Y/m/d', en_numbers($request->invoice_at));
        if ($request->due_at) {
            $invoice->due_at = jDateTime::createDatetimeFromFormat('Y/m/d', en_numbers($request->due_at));
        }
        if ($request->period) {
            $invoice->period = $request->period;
            $dut_at = new Carbon($invoice->due_at);
            $invoice->next_at = $dut_at->addDays($request->period);
        }
        $invoice->save();
        foreach ($request->record as $record_request) {
            if (isset($record_request['record_id'])) {
                $record = Record::findOrFail($record_request['record_id']);
                $record->invoice_id = $invoice->id;
                $record->description = $record_request['description'];
                $record->price = $record_request['price'];
                if ($request->type == 'sale') {
                    $record->quantity = abs($record_request['quantity']) * -1;
                } else if ($request->type == 'purchase') {
                    $record->quantity = abs($record_request['quantity']);
                }
                if ($record_request['item_id']) {
                    $record->item_id = $record_request['item_id'];
                }
                $record->total = $record_request['price'] * $record_request['quantity'];
                $record->save();
            } else {
                $record = new Record();
                $record->invoice_id = $invoice->id;
                $record->description = $record_request['description'];
                $record->price = $record_request['price'];
                if ($request->type == 'sale') {
                    $record->quantity = abs($record_request['quantity']) * -1;
                } else if ($request->type == 'purchase') {
                    $record->quantity = abs($record_request['quantity']);
                }
                if (isset($record_request['item_id'])) {
                    $record->item_id = $record_request['item_id'];
                }
                $record->total = $record_request['price'] * $record_request['quantity'];
                $record->save();
            }
        }
        flash('فاکتور با موفقیت ثبت شد.')->success();
        return redirect()->route('admin.invoice');

    }

    public function sendInvoice($id)
    {
        $invoice = Invoice::with('records')->findOrFail($id);
        $user = User::findOrFail($invoice->user_id);
        try {
            Notification::send($user, new InvoiceCreated($invoice, $user));
        } catch (\Exception $e) {
        }
        $invoice->status = 'sent';
        $invoice->save();
        flash('فاکتور جهت مشتری ارسال شد.')->success();
        return redirect()->route('admin.invoice');
    }

    public function view($id)
    {
        $accounts = Account::all();
        $invoice = Invoice::with('records', 'user')->findOrFail($id);
        return view('admin.invoice.view', ['invoice' => $invoice, 'accounts' => $accounts]);
    }

    public function pay(Request $request)
    {
        Validator::make($request->all(), [
            'invoice_id' => 'required',
            'account_id' => 'required',
            'amount' => 'required',
            'type' => 'required'
        ])->validate();
        $invoice = Invoice::with('records', 'user')->findOrFail($request->invoice_id);
        $transaction = new Transaction();
        $transaction->account_id = $request->account_id;
        $transaction->user_id = $request->user_id;
        $transaction->category_id = 13;
        $transaction->invoice_id = $invoice->id;
        $transaction->description = "پرداخت فاکتور شماره:" . $invoice->id;
        if ($invoice->type == 'sale') {
            $transaction->amount = abs($invoice->total) * 1;
        } else {
            $transaction->amount = abs($invoice->total) * -1;
        }
        $transaction->transaction_at = date("Y-m-d H:i:s");
        $transaction->save();

        $invoice->paid_at = date("Y-m-d H:i:s");
        $invoice->status = 'paid';
        $invoice->save();

        if ($invoice->type == 'sale') {
            foreach ($invoice->records as $record) {
                if ($record->item_id) {
                    $product = Item::findOrFail($record->item_id);
                    if ($product->factory) {
                        $factory = $product->factory;
                        $factory = new $factory();
                        $factory->create($product, $invoice->user);
                    }
                }
            }
        }


        flash('فاکتور با موفقیت پرداخت شد.')->success();
        return redirect()->route('admin.invoice.view', [$invoice->id]);
    }

    public function calculateTotal(Request $request)
    {
        if ($request->record) {
            $sub_total = 0;
            $record_total = array();
            $tax_percent = en_numbers($request->tax_percent);
            $discount_percent = en_numbers($request->discount_percent);
            $tax = en_numbers($request->tax);
            $discount = en_numbers($request->discount);
            foreach ($request->record as $record) {
                $record_total[$record['id']] = en_numbers($record['price']) * en_numbers($record['quantity']);
                $sub_total += $record_total[$record['id']];
            }
            if ($tax_percent > 0) {
                $tax = $sub_total * ($tax_percent / 100);
            }
            if ($discount_percent > 0) {
                $discount = $sub_total * ($discount_percent / 100);
            }
            $total = $sub_total + $tax - $discount;
            $total_letters = number_to_letters($total);
            return response()->json([
                'record_total' => $record_total,
                'total' => $total,
                'sub_total' => $sub_total,
                'discount' => $discount,
                'tax' => $tax,
                'discount_percent' => $discount_percent,
                'tax_percent' => $tax_percent,
                'total_letters' => $total_letters . " تومان"
            ]);
        } else {
            return response()->json([
                'record_total' => 0,
                'total' => 0,
                'sub_total' => 0,
                'discount' => 0,
                'tax' => 0,
                'discount_percent' => 0,
                'tax_percent' => 0,
                'total_letters' => ""
            ]);
        }

    }

    public function items()
    {
        $products = Item::Where('title', 'like', '%' . Input::get('term') . '%')->select(['id', 'title', 'sale_price'])->get();
        $products_array = array();
        $i = 0;
        foreach ($products as $product) {
            $products_array[$i]['value'] = $product->title;
            $products_array[$i]['id'] = $product->id;
            $products_array[$i]['sale_price'] = $product->sale_price;
            $i++;
        }
        return response()->json($products_array);
    }

}
