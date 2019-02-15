<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
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
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        return view('cart.index');
    }

    public function add($id)
    {
        $product = Product::with(['tax'])->findOrFail($id);
        if($product->tax_id) {
            $tax_rate = ($product->tax->rate);
            $tax_name = ($product->tax->name);
        } else {
            $tax_rate = 0;
            $tax_name = "";
        }
        if($product->discount) {
            $price = $product->discount_price;
            $discount = $product->sale_price - $product->discount_price;
            $tax = $price * $tax_rate;
        } else {
            $price = $product->sale_price;
            $discount = 0;
            $tax = $price * $tax_rate;
        }
        Cart::add($product->id, $product->title, 1, $price + $tax, ['description' => $product->description, 'factory' => $product->factory, 'tax_rate' => $tax_rate , 'price' => $price,'discount_price' => $product->discount_price, 'sale_price' => $product->sale_price, 'discount' => $discount, 'tax_name' => $tax_name, 'tax' => $tax]);
        flash($product->title . " به سبد خرید اضافه شد.")->success();
        return redirect()->route('cart');
    }

    public function remove($id)
    {
        $product = Product::with(['tax'])->findOrFail($id);
        if($product->tax_id) {
            $tax_rate = ($product->tax->rate);
            $tax_name = ($product->tax->name);
        } else {
            $tax_rate = 0;
            $tax_name = "";
        }
        if($product->discount) {
            $price = $product->discount_price;
            $discount = $product->sale_price - $product->discount_price;
            $tax = $price * $tax_rate;
        } else {
            $price = $product->sale_price;
            $discount = 0;
            $tax = $price * $tax_rate;
        }
        Cart::add($product->id, $product->title, -1, $price + $tax, ['description' => $product->description, 'factory' => $product->factory, 'tax_rate' => $tax_rate , 'price' => $price,'discount_price' => $product->discount_price, 'sale_price' => $product->sale_price, 'discount' => $discount, 'tax_name' => $tax_name, 'tax' => $tax]);

        foreach (Cart::content() as $productItem) {
            if ($productItem->qty == 0) {
                Cart::remove($productItem->rowId);
            }
        }
        flash("سبد کالا شما بروز رسانی شد.")->success();
        return redirect()->back();
    }

    public function empty()
    {
        Cart::destroy();
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
        if(Cart::count()) {
            $redirectFlag = false;
            $items = Cart::content();
            foreach ($items as $item) {
                if($item->options->factory) {
                    $className = '\App\Factory\\'.$item->options->factory;
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
            if (Cart::total() == 0) {
                flash("سبد خرید شما خالی است لطفا ابتدا کالا مورد نظر خود را انتخاب کنید.")->warning();
                return redirect()->route('shop');
            }
            $invoice = new Invoice();
            $invoice->user_id = Auth::user()->id;
            $invoice->status = 'sent';
            $invoice->total = 0;
            $invoice->tax = 0;
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
                if($product->options->factory) {
                    for($i=0;$i<$product->qty;$i++) {
                        $className = '\App\Factories\\'.$product->options->factory;
                        $factory = new $className;
                        $record = new Record();
                        $record->invoice_id = $invoice->id;
                        $record->title = $product->name;
                        $record->description = $product->description;

                        $record->quantity = abs($product->qty) * -1;
                        $record->price = $product->options->sale_price;
                        $record->discount = $product->options->discount;
                        $record->tax = $product->options->tax;
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
                    $record->price = $product->options->sale_price;
                    $record->discount = $product->options->discount;
                    $record->tax = $product->options->tax;
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