<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Shirazsoft\Gateway\Gateway;
use Shirazsoft\Gateway\Irankish\IrankishException;
use Shirazsoft\Gateway\Payir\PayirSendException;
use Shirazsoft\Gateway\Saderat\SaderatException;
use Shirazsoft\Gateway\Sadad\SadadException;
use Shirazsoft\Gateway\Mellat\MellatException;
use Shirazsoft\Gateway\Saman\SamanException;
use Shirazsoft\Gateway\Zarinpal\ZarinpalException;
use Shirazsoft\Gateway\Pasargad\PasargadErrorException;
use Shirazsoft\Gateway\Parsian\ParsianErrorException;
use Shirazsoft\Gateway\Paypal\PaypalException;
use Shirazsoft\Gateway\Payir\PayirReceiveException;
use Shirazsoft\Gateway\JahanPay\JahanPayException;
use Shirazsoft\Gateway\Exceptions\RetryException;
use Shirazsoft\Gateway\Exceptions\PortNotFoundException;
use Shirazsoft\Gateway\Exceptions\InvalidRequestException;
use Shirazsoft\Gateway\Exceptions\NotFoundTransactionException;
use App\Notifications\FreePaid;
use Illuminate\Support\Facades\Notification;

class FreePayController extends Controller
{

    public function index()
    {
        return view('free-pay.index');
    }

    public function remote($id, $amount)
    {
        $user = User::findOrFail($id);
        try {
            $request_gateway = config('platform.default-gateway');;
            $gateway = Gateway::{$request_gateway}();
            $gateway->setCallback(url('free-pay/callback'));
            $gateway->price($amount * 10)->ready();
            $refId = $gateway->refId();
            $transID = $gateway->transactionId();
            session(['name' => $user->name]);
            session(['email' => '']);
            session(['mobile' => $user->mobile]);
            session(['amount' => $amount]);
            session(['description' => '']);
            session(['gateway' => $request_gateway]);
            session(['user_id' => $id]);
            return $gateway->redirect();
        } catch (Exception $e) {
            flash($e->getMessage())->error();
        } catch (IrankishException $e) {
            flash($e->getMessage())->error();
        } catch (SaderatException $e) {
            flash($e->getMessage())->error();
        } catch (PayirSendException $e) {
            flash($e->getMessage())->error();
        } catch (SadadException $e) {
            flash($e->getMessage())->error();
        } catch (MellatException $e) {
            flash($e->getMessage())->error();
        } catch (SamanException $e) {
            flash($e->getMessage())->error();
        } catch (ZarinpalException $e) {
            flash($e->getMessage())->error();
        } catch (PasargadErrorException $e) {
            flash($e->getMessage())->error();
        } catch (ParsianErrorException $e) {
            flash($e->getMessage())->error();
        } catch (PaypalException $e) {
            flash($e->getMessage())->error();
        } catch (JahanPayException $e) {
            flash($e->getMessage())->error();
        }
        return redirect()->route('free-pay');
    }

    public function start(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'mobile' => 'required|digits:11|numeric',
            'amount' => 'required|numeric|min:' . config('platform.min-payment-price'),
            'description' => 'required',
            'gateway' => 'required',
        ]);
        try {
            $request_gateway = $request->gateway;
            $gateway = Gateway::{$request_gateway}();
            $gateway->setCallback(url('free-pay/callback'));
            $gateway->price($request->amount * 10)->ready();
            $refId = $gateway->refId();
            $transID = $gateway->transactionId();

            session(['name' => $request->name]);
            session(['email' => $request->email]);
            session(['mobile' => $request->mobile]);
            session(['amount' => $request->amount]);
            session(['description' => $request->description]);
            session(['gateway' => $request->gateway]);
            session(['user_id' => $request->user_id]);

            return $gateway->redirect();
        } catch (Exception $e) {
            flash($e->getMessage())->error();
        } catch (IrankishException $e) {
            flash($e->getMessage())->error();
        } catch (SaderatException $e) {
            flash($e->getMessage())->error();
        } catch (PayirSendException $e) {
            flash($e->getMessage())->error();
        } catch (SadadException $e) {
            flash($e->getMessage())->error();
        } catch (MellatException $e) {
            flash($e->getMessage())->error();
        } catch (SamanException $e) {
            flash($e->getMessage())->error();
        } catch (ZarinpalException $e) {
            flash($e->getMessage())->error();
        } catch (PasargadErrorException $e) {
            flash($e->getMessage())->error();
        } catch (ParsianErrorException $e) {
            flash($e->getMessage())->error();
        } catch (PaypalException $e) {
            flash($e->getMessage())->error();
        } catch (JahanPayException $e) {
            flash($e->getMessage())->error();
        }
        return redirect()->route('free-pay');
    }

    public function callback(Request $request)
    {
        try {

            $gateway = \Gateway::verify();
            $trackingCode = $gateway->trackingCode();
            $transaction = new Transaction();
            $transaction->account_id = config('gateway.' . session('gateway') . '.account_id');
            $transaction->name = session('name');
            $transaction->email = session('email');
            $transaction->mobile = session('mobile');
            $transaction->gateway = session('gateway');
            $transaction->user_id = session('user_id');
            $transaction->description = session('description');
            $transaction->amount = session('amount');
            $transaction->name = session('name');
            $transaction->category_id = config('platform.free-pay-category-id');
            $transaction->transaction_at = date("Y-m-d H:i:s");
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
        } catch (Exception $e) {
            flash($e->getMessage())->error();
        } catch (IrankishException $e) {
            flash($e->getMessage())->error();
        } catch (SaderatException $e) {
            flash($e->getMessage())->error();
        } catch (PayirReceiveException $e) {
            flash($e->getMessage())->error();
        } catch (SadadException $e) {
            flash($e->getMessage())->error();
        } catch (MellatException $e) {
            flash($e->getMessage())->error();
        } catch (SamanException $e) {
            flash($e->getMessage())->error();
        } catch (ZarinpalException $e) {
            flash($e->getMessage())->error();
        } catch (PasargadErrorException $e) {
            flash($e->getMessage())->error();
        } catch (ParsianErrorException $e) {
            flash($e->getMessage())->error();
        } catch (PaypalException $e) {
            flash($e->getMessage())->error();
        } catch (JahanPayException $e) {
            flash($e->getMessage())->error();
        } catch (RetryException $e) {
            flash($e->getMessage())->error();
        } catch (PortNotFoundException $e) {
            flash($e->getMessage())->error();
        } catch (InvalidRequestException $e) {
            flash($e->getMessage())->error();
        } catch (NotFoundTransactionException $e) {
            flash($e->getMessage())->error();
        }
        return redirect()->route('free-pay');
    }

}
