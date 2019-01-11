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
        $product = Product::findOrFail($id);
        $tax = 0;
        if($product->tax) {
            $tax = ($product->tax_percent / 100) * $product->sale_price;
        }
        if($product->off) {
            if($product->tax) {
                $tax = ($product->tax_percent / 100) * $product->off_price;
            }
            Cart::add($product->id, $product->title, 1, $product->off_price + $tax, ['description' => $product->description, 'factory' => $product->factory, 'tax_percent' => $product->tax_percent / 100, 'off_price' => $product->off_price, 'sale_price' => $product->sale_price, 'off' => $product->off, 'tax' => $product->tax]);
        } else {
            Cart::add($product->id, $product->title, 1, $product->sale_price + $tax, ['description' => $product->description, 'factory' => $product->factory, 'tax_percent' => $product->tax_percent / 100, 'off_price' => $product->off_price, 'sale_price' => $product->sale_price, 'off' => $product->off, 'tax' => $product->tax]);
        }
        flash($product->title . " به سبد خرید اضافه شد.")->success();
        return redirect()->route('cart');
    }

    public function remove($id)
    {
        $product = Product::findOrFail($id);
        $tax = 0;
        if($product->tax) {
            $tax = ($product->tax_percent / 100) * $product->sale_price;
        }
        if($product->off) {
            if($product->tax) {
                $tax = ($product->tax_percent / 100) * $product->off_price;
            }
            Cart::add($product->id, $product->title, -1, $product->off_price + $tax, ['description' => $product->description, 'factory' => $product->factory, 'tax_percent' => $product->tax_percent / 100, 'off_price' => $product->off_price, 'sale_price' => $product->sale_price, 'off' => $product->off, 'tax' => $product->tax]);
        } else {
            Cart::add($product->id, $product->title, -1, $product->sale_price + $tax, ['description' => $product->description, 'factory' => $product->factory, 'tax_percent' => $product->tax_percent / 100, 'off_price' => $product->off_price, 'sale_price' => $product->sale_price, 'off' => $product->off, 'tax' => $product->tax]);
        }
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
            $off = 0;
            $total = 0;
            if (Cart::total() == 0) {
                flash("سبد خرید شما خالی است لطفا ابتدا کالا مورد نظر خود را انتخاب کنید.")->warning();
                return redirect()->route('shop');
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
                if($product->options->factory) {
                    for($i=0;$i<$product->qty;$i++) {
                        $className = '\App\Factory\\'.$product->options->factory;
                        $factory = new $className;
                        $record = new Record();
                        $record->invoice_id = $invoice->id;
                        $record->title = $product->name;
                        $record->description = $product->description;
                        $record->quantity = -1;
                        $record->price = $product->options->sale_price;
                        if($product->options->off) {
                            $record->discount = ($product->options->sale_price - $product->options->off_price);
                        } else {
                            $record->discount = 0;
                        }
                        if($product->options->tax) {
                            $record->tax = ($product->options->sale_price - $record->discount) * $product->options->tax_percent;
                        } else {
                            $record->tax = 0;
                        }
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
                        $off += $record->discount;
                    }
                } else {
                    $record = new Record();
                    $record->invoice_id = $invoice->id;
                    $record->title = $product->name;
                    $record->description = $product->description;
                    $record->quantity = abs($product->qty) * -1;
                    $record->price = $product->options->sale_price;
                    if($product->options->off) {
                        $record->discount = ($product->options->sale_price - $product->options->off_price);
                    } else {
                        $record->discount = 0;
                    }
                    if($product->options->tax) {
                        $record->tax = ($product->options->sale_price - $record->discount) * $product->options->tax_percent;
                    } else {
                        $record->tax = 0;
                    }

                    $record->total = $record->price - $record->discount + $record->tax;

                    $record->product_id = $product->id;
                    $record->save();
                    $tax += $record->tax;
                    $total += $record->total;
                    $off += $record->discount;
                }
            }

            $invoice->total = $total;
            $invoice->tax = $tax;
            $invoice->discount = $off;
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