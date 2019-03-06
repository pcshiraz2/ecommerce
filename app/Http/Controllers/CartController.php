<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Product;
use App\Models\User;
use App\Notifications\InvoiceCreated;
use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Validator;
use App\Models\City;
use App\Models\Province;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        return view('cart.index');
    }

    public function add($id)
    {
        $product = Product::findOrFail($id);
        if(!$product->shop) {
            flash($product->title . "در حال حاضر این کالا موجود نمی باشد.")->danger();
            return redirect()->route('product.view',[$product->id]);
        }
        if($product->call_price) {
            flash("برای استعلام قیمت " . $product->title .  " از طریق تماس تلفنی اقدام نمایید.")->info();
            return redirect()->route('product.view',[$product->id]);
        }
        if($product->tax > 0) {
            $tax = $product->tax;
        } else {
            $tax = 0;
        }
        if($product->discount) {
            $price = $product->discount_price;
            $discount = $product->sale_price - $product->discount_price;
            $price_tax = $price + $tax;
        } else {
            $price = $product->sale_price;
            $discount = 0;
            $price_tax = $price + $tax;
        }
        \Cart::add($product->id, $product->title, $price_tax, 1, ['description' => $product->description, 'factory' => $product->factory , 'price' => $price,'discount_price' => $product->discount_price, 'sale_price' => $product->sale_price, 'discount' => $discount, 'tax' => $tax]);
        flash($product->title . " به سبد خرید اضافه شد.")->success();
        return redirect()->route('cart');
    }

    public function remove($id)
    {
        $product = Product::findOrFail($id);
        \Cart::update($product->id, ['quantity' => -1]);
        flash("سبد کالا شما بروز رسانی شد.")->success();
        return redirect()->back();
    }

    public function empty()
    {
        \Cart::clear();
        flash("سبد کالا شما بروز رسانی شد.")->success();
        return redirect()->back();
    }

    public function information()
    {
        if (Auth::guest()) {
            flash("برای تکمیل سفارش نیاز است شما در سایت ثبت نام کنید لذا ابتدا فرم زیر را تکمیل کنید، در صورتی که پیش تر در سایت ثبت نام کردید از گزینه ورود استفاده نمایید.")->warning();
            return redirect()->route('register');
        } else {
            $provinces = Province::enabled()->get();
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
        $user->national_code = $request->national_code;
        $user->economical_number = $request->economical_number;
        $user->save();
        return redirect()->route('cart.factory');
    }

    public function factory()
    {
        if (Auth::guest()) {
            flash("برای تکمیل سفارش نیاز است شما در سایت ثبت نام کنید لذا ابتدا فرم زیر را تکمیل کنید، در صورتی که پیش تر در سایت ثبت نام کردید از گزینه ورود استفاده نمایید.")->warning();
            return redirect()->route('register');
        }
        if(\Cart::getContent()->count()) {
            $redirectFlag = false;
            $items = \Cart::getContent();
            foreach ($items as $item) {
                if($item->attributes->factory) {
                    $className = '\App\Factory\\'.$item->attributes->factory;
                    $factory = new $className;
                    if($factory->factoryCartInformation) {
                        $redirectFlag = true;
                        break;
                    }
                }
            }
            if($redirectFlag) {
                return view('cart.factory');
            } else {
                return redirect()->route('cart.checkout');
            }
        } else {
            return redirect()->route('shop');
        }

    }


    public function storeFactory(Request $request)
    {
        Session::put('factory_data', $request->all());
        flash("اطلاعات شما برای محصولات مورد نظر بروز شد.")->success();
        return redirect()->route('cart.checkout');
    }

    public function checkout()
    {
        if (Auth::guest()) {
            flash("برای تکمیل سفارش نیاز است شما در سایت ثبت نام کنید لذا ابتدا فرم زیر را تکمیل کنید، در صورتی که پیش تر در سایت ثبت نام کردید از گزینه ورود استفاده نمایید.")->warning();
            return redirect()->route('register');
        } else {
            $tax = 0;
            $discount = 0;
            $total = 0;
            if (\Cart::getTotal() == 0) {
                flash("سبد خرید شما خالی است لطفا ابتدا کالا مورد نظر خود را انتخاب کنید.")->warning();
                return redirect()->route('shop');
            }
            $invoice = new Invoice();
            $invoice->user_id = Auth::user()->id;
            $invoice->first_name = Auth::user()->first_name;
            $invoice->last_name = Auth::user()->last_name;
            $invoice->status = 'sent';
            $invoice->total = 0;
            $invoice->tax = 0;
            $invoice->type = 'sale';
            $invoice->password = uniqid();
            $invoice->invoice_at = date("Y-m-d H:i:s");
            $invoice->zip_code = Auth::user()->zip_code;
            $invoice->phone = Auth::user()->phone;
            $invoice->address = Auth::user()->address;
            $invoice->city_id = Auth::user()->city_id;
            $invoice->province_id = Auth::user()->province_id;
            $invoice->save();

            foreach (\Cart::getContent() as $product) {
                if($product->attributes->factory) {
                    for($i=0;$i<$product->qty;$i++) {
                        $className = '\App\Factories\\'.$product->attributes->factory;
                        $factory = new $className;
                        $record = new Record();
                        $record->invoice_id = $invoice->id;
                        $record->title = $product->name;
                        $record->description = $product->description;

                        $record->quantity = abs($product->qty) * -1;
                        $record->price = $product->attributes->sale_price;
                        $record->discount = $product->attributes->discount;
                        $record->tax = $product->attributes->tax;
                        $record->total = (($record->price - $record->discount) + $record->tax) * abs($product->qty);

                        $record->product_id = $product->id;
                        $options = [];
                        foreach ($factory->getCartAttribs() as $attrib) {
                            $options[$attrib] = session('factory_data')[$attrib][$i];
                        }
                        $record->options = $options;
                        $record->total = $record->price - $record->discount + $record->tax;
                        $record->save();
                        $tax += $record->tax;
                        $total += $record->total;
                        $discount += $record->discount;
                    }
                } else {
                    $record = new Record();
                    $record->invoice_id = $invoice->id;
                    $record->title = $product->name;
                    $record->description = $product->description;
                    $record->quantity = abs($product->qty) * -1;
                    $record->price = $product->attributes->sale_price;
                    $record->discount = $product->attributes->discount;
                    $record->tax = $product->attributes->tax;
                    $record->total = (($record->price - $record->discount) + $record->tax) * abs($product->qty);

                    $record->product_id = $product->id;
                    $record->save();
                    $tax += $record->tax;
                    $total += $record->total;
                    $discount += $record->discount;
                }
            }

            $invoice->total = $total;
            $invoice->tax = $tax;
            $invoice->discount = $discount;
            $invoice->save();

            \Cart::clear();
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