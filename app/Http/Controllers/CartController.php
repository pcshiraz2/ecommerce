<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Invoice;
use App\Models\Item;
use App\Models\Product;
use App\Models\User;
use App\Notifications\InvoiceCreated;
use App\Models\Record;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Validator;
use App\Models\City;
use App\Models\Province;

class CartController extends Controller
{
    public function index()
    {
        return view('cart.index');
    }

    public function add($id)
    {
        $product = Product::findOrFail($id);
        Cart::add($product->id, $product->title, 1, $product->sale_price, ['description' => $product->description, 'factory' => $product->factory]);
        flash($product->title . " به سبد خرید اضافه شد.")->success();
        return redirect()->route('cart');
    }

    public function remove($id)
    {
        $product = Product::findOrFail($id);
        Cart::add($product->id, $product->title, -1, $product->sale_price, ['description' => $product->description, 'factory' => $product->factory]);
        foreach (Cart::content() as $productItem) {
            if ($productItem->qty == 0) {
                Cart::remove($productItem->rowId);
            }
        }
        flash("سبد کالا شما بروز رسانی شد.")->success();
        return redirect()->back();
    }

    public function information()
    {
        if (Auth::guest()) {
            flash("برای تکمیل سفارش نیاز است شما در سایت ثبت نام کنید لذا ابتدا فرم زیر را تکمیل کنید، در صورتی که پیش تر در سایت ثبت نام کردید از گزینه ورود استفاده نمایید.")->warning();
            return redirect()->route('register');
        } else {
            $provinces = Province::all();
            if (Auth::user()->province_id) {
                $cities = City::where('province_id', Auth::user()->province_id)->get();
            } else {
                $cities = City::where('province_id', $provinces->first()->id)->get();
            }
            return view('cart.information', ['provinces' => $provinces, 'cities' => $cities]);
        }
    }

    public function storeInformation(Request $request)
    {
        Validator::make($request->all(), [
            'national_code' => 'required||numeric|unique:users,national_code,' . Auth::user()->id,
            'phone' => 'required|numeric',
            'zip_code' => 'required|numeric',
            'address' => 'required|string',
            'city_id' => 'required|numeric',
            'province_id' => 'required|numeric',
        ])->validate();
        $user = User::findOrFail(Auth::user()->id);
        session(['name' => $request->name]);
        $user->gender = $request->gender;
        $user->phone = $request->phone;
        $user->zip_code = $request->zip_code;
        $user->address = $request->address;
        $user->city_id = $request->city_id;
        $user->province_id = $request->province_id;
        $user->save();
        return redirect()->route('cart.factory');
    }

    public function factory()
    {

    }


    public function storeFactory(Request $request)
    {

    }

    public function checkout()
    {
        if (Auth::guest()) {
            flash("برای تکمیل سفارش نیاز است شما در سایت ثبت نام کنید لذا ابتدا فرم زیر را تکمیل کنید، در صورتی که پیش تر در سایت ثبت نام کردید از گزینه ورود استفاده نمایید.")->warning();
            return redirect()->route('register');
        } else {
            if (Cart::total() == 0) {
                flash("سبد خرید شما خالی است لطفا ابتدا کالا مورد نظر خود را انتخاب کنید.")->warning();
                return redirect()->route('file');
            }
            $invoice = new Invoice();
            $invoice->user_id = Auth::user()->id;
            $invoice->status = 'sent';
            $invoice->total = Cart::total();
            $invoice->tax = Cart::tax();
            $invoice->type = 'sale';
            $invoice->password = uniqid();
            $invoice->invoice_at = date("Y-m-d H:i:s");
            if (session('name') == Auth::user()->name) {
                $invoice->name = session('name');
            }
            $invoice->zip_code = Auth::user()->zip_code;
            $invoice->phone = Auth::user()->phone;
            $invoice->address = Auth::user()->address;
            $invoice->city_id = Auth::user()->city_id;
            $invoice->province_id = Auth::user()->province_id;
            $invoice->save();

            foreach (Cart::content() as $product) {
                $record = new Record();
                $record->invoice_id = $invoice->id;
                $record->title = $product->name;
                $record->description = $product->description;
                $record->quantity = abs($product->qty) * -1;
                $record->price = $product->price;
                $record->discount = $product->discount;
                $record->tax = $product->tax;
                $record->total = $product->qty * $product->price;
                $record->product_id = $product->id;
                $record->save();
            }
            Cart::destroy();
            if (Auth::check()) {
                $user = Auth::user();
                try {
                    Notification::send($user, new InvoiceCreated($invoice, $user));
                } catch (\Exception $e) {
                }

            }
            return redirect()->route('invoice.view', ['id' => $invoice->id]);
        }

    }
}