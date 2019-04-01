<?php

namespace App\Http\Controllers\Admin;

use App\Models\Account;
use App\Models\Item;
use App\Models\Product;
use App\Models\Record;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;
use App\Notifications\InvoiceCreated;
use Illuminate\Support\Facades\Storage;
use App\Models\Transaction;

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
        $type = 'sale';
        return view('admin.invoice.create', ['type' => $type]);
    }

    public function createPurchase()
    {
        $type = 'purchase';
        return view('admin.invoice.create', ['type' => $type]);
    }

    public function createUserInvoice($id)
    {
        $type = 'sale';
        $user = User::findOrFail($id);
        return view('admin.invoice.user', ['type' => $type, 'user' => $user]);
    }

    public function insert(Request $request)
    {
        Validator::make($request->all(), [
            'invoice_at' => 'required',
            'user_id' => 'required',
            'record.*.price' => 'required|numeric|min:1',
            'record.*.tax' => 'numeric|nullable',
            'record.*.discount' => 'numeric|nullable',
            'record.*.quantity' => 'required|numeric|min:1',
            'record.*.title' => 'required|string',
        ])->validate();

        $invoice = new Invoice();
        $invoice->user_id = $request->user_id;
        $invoice->total = $request->total;
        $invoice->tax = $request->tax;
        $invoice->note = $request->note;
        $invoice->discount = $request->discount;
        $invoice->quantity = $request->quantity;
        $invoice->type = $request->type;
        $invoice->password = uniqid();
        $invoice->attachment = $request->file('attachment')->store('invoice');
        $invoice->invoice_at = \Morilog\Jalali\CalendarUtils::createDatetimeFromFormat('Y/m/d', \App\Utils\TextUtil::convertToEnglish($request->invoice_at));
        if ($request->due_at) {
            $invoice->due_at = \Morilog\Jalali\CalendarUtils::createDatetimeFromFormat('Y/m/d', \App\Utils\TextUtil::convertToEnglish($request->due_at));
        } else {
            $invoice->due_at = NULL;
        }
        $invoice->save();
        foreach ($request->record as $record_request) {
            $record = new Record();
            $record->invoice_id = $invoice->id;
            $record->title = $record_request['title'];
            $record->price = $record_request['price'];
            $record->discount = $record_request['discount'];
            $record->tax = $record_request['tax'];
            if ($request->type == 'sale') {
                $record->quantity = abs($record_request['quantity']) * -1;
            } else if ($request->type == 'purchase') {
                $record->quantity = abs($record_request['quantity']);
            }
            if (isset($record_request['product_id'])) {
                $record->product_id = $record_request['product_id'];
            }
            $record->total = ($record_request['price'] - $record_request['discount'] + $record_request['tax']) * $record_request['quantity'];
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
        $invoice = Invoice::with(['records', 'user'])->findOrFail($id);
        return view('admin.invoice.edit', ['invoice' => $invoice]);
    }

    public function delete($id, Request $request)
    {
        $invoice = Invoice::with('records')->findOrFail($id);
        foreach ($invoice->records as $record) {
            $record->delete();
        }
        if($request->attachment) {
            Storage::delete($invoice->attachment);
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
        $tax = 0;
        $discount = 0;
        $quantity = 0;

        foreach ($invoice->records as $record) {
            $discount += ($record->discount * $record->quantity);
            $tax += ($record->tax * $record->quantity);
            $quantity += $record->quantity;
            $total += ($record->price - $record->discount + $record->tax) * $record->quantity;
        }

        $invoice->quantity = $quantity;
        $invoice->discount = $discount;
        $invoice->tax = $tax;
        $invoice->total = $total;
        $invoice->save();

        return "Ok";
    }

    public function download($id)
    {
        $invoice = Invoice::findOrFail($id);
        return Storage::download($invoice->attachment);
    }

    public function update($id, Request $request)
    {
        Validator::make($request->all(), [
            'invoice_at' => 'required',
            'user_id' => 'required',
            'record.*.price' => 'required|numeric|min:1',
            'record.*.tax' => 'numeric|nullable',
            'record.*.discount' => 'numeric|nullable',
            'record.*.quantity' => 'required|numeric|min:1',
            'record.*.title' => 'required|string',
        ])->validate();
        $invoice = Invoice::with('records')->findOrFail($id);
        $invoice->user_id = $request->user_id;
        $invoice->total = $request->total;
        $invoice->tax = $request->tax;
        $invoice->note = $request->note;
        $invoice->type = $request->type;
        $invoice->discount = $request->discount;
        if($request->attachment) {
            Storage::delete($invoice->attachment);
            $invoice->attachment = $request->file('attachment')->store('invoice');
        }
        $invoice->invoice_at = \Morilog\Jalali\CalendarUtils::createDatetimeFromFormat('Y/m/d', \App\Utils\TextUtil::convertToEnglish($request->invoice_at));
        if ($request->due_at) {
            $invoice->due_at = \Morilog\Jalali\CalendarUtils::createDatetimeFromFormat('Y/m/d', \App\Utils\TextUtil::convertToEnglish($request->due_at));
        } else {
            $invoice->due_at = NULL;
        }
        $invoice->save();
        foreach ($request->record as $record_request) {
            if (isset($record_request['id'])) {
                $record = Record::findOrFail($record_request['id']);
                $record->invoice_id = $invoice->id;
                $record->price = $record_request['price'];
                $record->discount = $record_request['discount'];
                $record->tax = $record_request['tax'];
                if ($request->type == 'sale') {
                    $record->quantity = abs($record_request['quantity']) * -1;
                } else if ($request->type == 'purchase') {
                    $record->quantity = abs($record_request['quantity']);
                }
                if ($record_request['product_id']) {
                    $record->product_id = $record_request['product_id'];
                }
                $record->total = ($record_request['price'] - $record_request['discount'] + $record_request['tax']) * $record_request['quantity'];
                $record->save();
            } else {
                $record = new Record();
                $record->invoice_id = $invoice->id;
                $record->title = $record_request['title'];
                $record->price = $record_request['price'];
                $record->discount = $record_request['discount'];
                $record->tax = $record_request['tax'];
                if ($request->type == 'sale') {
                    $record->quantity = abs($record_request['quantity']) * -1;
                } else if ($request->type == 'purchase') {
                    $record->quantity = abs($record_request['quantity']);
                }
                if (isset($record_request['product_id'])) {
                    $record->product_id = $record_request['product_id'];
                }
                $record->total = ($record_request['price'] - $record_request['discount'] + $record_request['tax']) * $record_request['quantity'];
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
        $accounts = Account::enabled()->get();
        $invoice = Invoice::with('records', 'user','transactions', 'transactions.account')->findOrFail($id);
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

        $transaction->invoice_id = $invoice->id;
        $transaction->description = "پرداخت فاکتور شماره:" . $invoice->id;
        if ($invoice->type == 'sale') {
            $transaction->amount = abs($invoice->total) * 1;
            $transaction->category_id = config('platform.income-sale-category-id');
        } else {
            $transaction->amount = abs($invoice->total) * -1;
            $transaction->category_id = config('platform.expense-purchase-category-id');
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
            $record_total = array();
            $tax = 0;
            $total = 0;
            $discount = 0;
            $quantity = 0;

            foreach ($request->record as $record) {
                if($record['price']) {
                    $record_price = \App\Utils\MoneyUtil::removeMask($record['price']);
                } else {
                    $record_price = 0;
                }

                if($record['tax']) {
                    $record_tax = \App\Utils\MoneyUtil::removeMask($record['tax']);
                } else {
                    $record_tax = 0;
                }

                if($record['discount']) {
                    $record_discount = \App\Utils\MoneyUtil::removeMask($record['discount']);
                } else {
                    $record_discount = 0;
                }

                if($record['quantity']) {
                    $record_quantity = \App\Utils\MoneyUtil::removeMask($record['quantity']);
                } else {
                    $record_quantity = 0;
                }
                $quantity += $record_quantity;
                $discount += ($record_discount * $record_quantity);
                $tax +=  ($record_tax * $record_quantity);
                $record_total[$record['record_row']] = ( ($record_price - $record_discount + $record_tax)  * $record_quantity );
                $total += $record_total[$record['record_row']];
                $record_total[$record['record_row']] =  \App\Utils\MoneyUtil::format($record_total[$record['record_row']]);
            }

            $total_letters = \App\Utils\MoneyUtil::letters($total);
            return response()->json([
                'record_total' => $record_total,
                'total_format' => \App\Utils\MoneyUtil::format($total),
                'total_value' => $total,
                'discount_format' => \App\Utils\MoneyUtil::format($discount),
                'discount_value' => $discount,
                'tax_format' => \App\Utils\MoneyUtil::format($tax),
                'tax_value' => $tax,
                'quantity_format' => \App\Utils\MoneyUtil::format($quantity),
                'quantity_value' => $quantity,
                'total_letters_format' => $total_letters . " " . trans('currency.'.config('platform.currency'))
            ]);
        } else {
            return response()->json([
                'record_total' => 0,
                'total_format' => 0,
                'total_value' => 0,
                'discount_format' => 0,
                'discount_value' => 0,
                'tax_format' => 0,
                'tax_value' => 0,
                'quantity_format' => 0,
                'quantity_value' => 0,
                'total_letters_format' => ""
            ]);
        }

    }

    public function items()
    {
        $output = array(
            'query' => 'Unit',
            'suggestions' => []
        );
        $products = Product::enabled()->shop()->Where('title', 'like', '%' . Input::get('query') . '%')->select(['id', 'title', 'sale_price', 'tax', 'discount'])->get();
        $products_array = array();
        $i = 0;
        foreach ($products as $product) {
            $products_array[$i]['value'] = $product->title;
            $products_array[$i]['id'] = $product->id;
            $products_array[$i]['price'] = \App\Utils\MoneyUtil::display($product->sale_price);
            $products_array[$i]['tax'] = \App\Utils\MoneyUtil::display($product->tax);
            $products_array[$i]['discount'] = \App\Utils\MoneyUtil::display($product->discount);
            $i++;
        }
        $output['suggestions'] = $products_array;
        return response()->json($output);
    }

}
