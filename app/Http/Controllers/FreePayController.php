<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Parsisolution\Gateway\Transactions\Amount;
use Parsisolution\Gateway\Transactions\RequestTransaction;
use Parsisolution\Gateway\Exceptions\RetryException;
use Parsisolution\Gateway\Facades\Gateway;
use App\Notifications\FreePaid;
use Illuminate\Support\Facades\Notification;

class FreePayController extends Controller
{

    public function index()
    {
        return view('free-pay.index');
    }


    public function start(Request $request)
    {
        $request->validate([
            'first_name' => 'required|max:191',
            'last_name' => 'required|max:191',
            'email' => 'required|email',
            'mobile' => 'required|digits:11|numeric',
            'amount' => 'required|numeric|min:' . config('platform.min-payment-price'),
            'description' => 'required',
            'gateway' => 'required',
        ]);

        try {
            $request_gateway = $request->gateway;
            $gateway = Gateway::of($request_gateway);
            $gateway->callbackUrl(route('free-pay.callback'));
            $gateway->stateless();

            $transaction = new RequestTransaction(new Amount($request->amount, config('platform.currency')));
            $transaction->setExtra([
                'mobile' => $request->mobile,
                'email'  => $request->email,
            ]);
            $transaction->setExtraField('description', $request->description);
            $authorizedTransaction = $gateway->authorize($transaction);

            session(['last_name' => $request->last_name]);
            session(['first_name' => $request->first_name]);
            session(['email' => $request->email]);
            session(['mobile' => $request->mobile]);
            session(['amount' => $request->amount]);
            session(['description' => $request->description]);
            session(['gateway' => $request->gateway]);
            session(['user_id' => $request->user_id]);

            return $gateway->redirect($authorizedTransaction);
        } catch (\Exception $e) {
            flash($e->getMessage())->error();
        }
        return redirect()->route('free-pay');
    }

    public function callback(Request $request)
    {
        try {

            $settledTransaction = Gateway::settle(true);

            $trackingCode = $settledTransaction->getTrackingCode();
            $refId = $settledTransaction->getReferenceId();
            $cardNumber = $settledTransaction->getCardNumber();

            $options = [
                'trackingCode' => $trackingCode,
                'refId' => $refId,
                'cardNumber' => $cardNumber,
            ];

            $transaction = new Transaction();
            $transaction->account_id = config('gateways.' . session('gateway') . '.account-id');
            $transaction->first_name = session('first_name');
            $transaction->last_name = session('last_name');
            $transaction->email = session('email');
            $transaction->mobile = session('mobile');
            $transaction->gateway = session('gateway');
            $transaction->currency_code = config('platform.currency');
            $transaction->type = 'income';
            $transaction->gateway_transaction_id = $settledTransaction->getId();
            $transaction->user_id = session('user_id');
            $transaction->description = session('description');
            $transaction->amount = session('amount');
            $transaction->category_id = config('platform.free-pay-category-id');
            $transaction->transaction_at = date("Y-m-d H:i:s");
            $transaction->paid_at = date("Y-m-d H:i:s");
            $transaction->options = $options;
            $transaction->save();

            if (Auth::check()) {
                $user = Auth::user();
                try {
                    Notification::send($user, new FreePaid($transaction, $user));
                } catch (\Exception $e) {
                }
            }

            flash('پرداخت با موفقیت انجام شد.')->success();
            return view('free-pay.callback', ['trackingCode' => $trackingCode, 'transaction_id' => $transaction->id]);
        }  catch (RetryException $e) {
            flash($e->getMessage())->error();

        } catch (\Exception $e) {
            flash($e->getMessage())->error();
        }
        return redirect()->route('free-pay');
    }

}
