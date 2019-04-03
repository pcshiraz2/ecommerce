<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Item;
use App\Models\User;
use App\Utils\MoneyUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Parsisolution\Gateway\Facades\Gateway;
use Parsisolution\Gateway\Transactions\RequestTransaction;
use Parsisolution\Gateway\Transactions\Amount;
use Parsisolution\Gateway\Exceptions\RetryException;
use Illuminate\Support\Facades\Notification;
use App\Notifications\InvoiceCreated;
use App\Models\Transaction;

class InvoiceController extends Controller
{
    public function index()
    {
        $this->middleware(['auth']);
        $invoices = Invoice::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(config('platform.invoice-per-page'));
        return view('invoice.index', ['invoices' => $invoices]);
    }

    public function installment($id)
    {
        $transaction = Transaction::findOrFail($id);
        try {
            $gateway = Gateway::of(config('platform.default-gateway'));
            $gateway->callbackUrl(url('invoice/installment-callback', ['id' => $transaction->id]));
            $gateway->stateless();
            $gatewayTransaction = new RequestTransaction(new Amount($transaction->amount, config('platform.currency')));
            $gatewayTransaction->setExtraField('description', $transaction->description);
            $authorizedTransaction = $gateway->authorize($gatewayTransaction);
            return $gateway->redirect($authorizedTransaction);
        } catch (Exception $e) {
            flash($e->getMessage())->error();
        }
        redirect()->route('invoice.view', ['id' => $transaction->invoice_id]);
    }


    public function installmentCallback($id)
    {
        $transaction = Transaction::findOrFail($id);
        try {
            $settledTransaction = Gateway::settle();

            $trackingCode = $settledTransaction->getTrackingCode();
            $refId = $settledTransaction->getReferenceId();
            $cardNumber = $settledTransaction->getCardNumber();

            $options = [
                'trackingCode' => $trackingCode,
                'refId' => $refId,
                'cardNumber' => $cardNumber,
            ];


            $transaction->gateway_transaction_id = $settledTransaction->getId();
            $transaction->gateway = config('platform.default-gateway');
            $transaction->account_id = config('gateways.' . config('platform.default-gateway') . '.account-id');
            $transaction->options = $options;
            $transaction->paid_at = date("Y-m-d H:i:s");
            $transaction->save();


            flash('قسط مورد نظر با موفقیت پرداخت شد.')->success();
        } catch (RetryException $e) {
            flash($e->getMessage())->error();
        } catch (\Exception $e) {
            flash($e->getMessage())->error();
        }

        return redirect()->route('invoice.view', ['id' => $transaction->invoice_id]);
    }

    public function pay(Request $request)
    {
        $this->middleware(['auth']);
        session(['gateway' => $request->gateway]);
        $invoice = Invoice::findOrFail($request->invoice_id);
        if ($invoice->user_id != Auth::user()->id) {
            abort(404);
        } else {
            try {
                $gateway = Gateway::of($request->gateway);
                $gateway->callbackUrl(url('invoice/callback', ['id' => $request->invoice_id]));
                $gateway->stateless();
                $transaction = new RequestTransaction(new Amount($invoice->total, config('platform.currency')));
                $transaction->setExtraField('description', "پرداخت فاکتور شماره:" . $request->invoice_id);
                $authorizedTransaction = $gateway->authorize($transaction);
                return $gateway->redirect($authorizedTransaction);
            } catch (Exception $e) {
                flash($e->getMessage())->error();
            }
            redirect()->route('invoice.view', ['id' => $request->invoice_id]);
        }
    }

    public function view($id)
    {
        $this->middleware(['auth']);
        $invoice = Invoice::with('records', 'user')->findOrFail($id);
        if ($invoice->user_id != Auth::user()->id) {
            abort(404);
        } else {
            return view('invoice.view', ['invoice' => $invoice]);
        }
    }

    public function callback(Request $request, $id)
    {
        $this->middleware(['auth']);
        $invoice = Invoice::with('records', 'user')->findOrFail($id);

        if ($invoice->user_id != Auth::user()->id) {
            abort(404);
        } else {
            try {
                $settledTransaction = Gateway::settle();
                /* ***
                $transaction = new Transaction();
                $transaction->invoice_id = $invoice->id;
                $transaction->user_id = Auth::user()->id;
                $transaction->currency_code = config('platform.currency');
                $transaction->amount = -1 * MoneyUtil::database($invoice->total);
                $transaction->type = 'invoice';
                $transaction->description = "هزینه فاکتور شماره:" . $invoice->id;
                $transaction->transaction_at = date("Y-m-d H:i:s");
                $transaction->paid_at = date("Y-m-d H:i:s");
                $transaction->save();
                 * **/

                $trackingCode = $settledTransaction->getTrackingCode();
                $refId = $settledTransaction->getReferenceId();
                $cardNumber = $settledTransaction->getCardNumber();

                $options = [
                    'trackingCode' => $trackingCode,
                    'refId' => $refId,
                    'cardNumber' => $cardNumber,
                ];

                $transaction = new Transaction();
                $transaction->gateway_transaction_id = $settledTransaction->getId();
                $transaction->gateway = session('gateway');
                $transaction->invoice_id = $invoice->id;
                $transaction->account_id = config('gateways.' . session('gateway') . '.account-id');
                $transaction->user_id = Auth::user()->id;
                $transaction->currency_code = config('platform.currency');
                $transaction->category_id = config('platform.income-sale-category-id');
                $transaction->amount = MoneyUtil::database($invoice->total);
                $transaction->first_name = Auth::user()->first_name;
                $transaction->last_name = Auth::user()->last_name;
                $transaction->email = Auth::user()->email;
                $transaction->mobile = Auth::user()->mobile;
                $transaction->type = 'income';
                $transaction->description = "پرداخت فاکتور شماره:" . $invoice->id;
                $transaction->options = $options;
                $transaction->transaction_at = date("Y-m-d H:i:s");
                $transaction->paid_at = date("Y-m-d H:i:s");
                $transaction->save();


                $invoice->paid_at = date("Y-m-d H:i:s");
                $invoice->status = 'paid';
                $invoice->save();

                $user = User::find($invoice->user_id);
                try {
                    Notification::send($user, new InvoiceCreated($invoice, $user));
                } catch (\Exception $e) {
                }

                flash('فاکتور با موفقیت پرداخت شد.')->success();
            } catch (RetryException $e) {
                flash($e->getMessage())->error();
            } catch (\Exception $e) {
                flash($e->getMessage())->error();
            }
            return redirect()->route('invoice.view', ['id' => $id]);
        }
    }

}
