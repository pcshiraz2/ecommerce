<?php
/**
 * Created by PhpStorm.
 * User: Ali Ghasemzadeh
 * Date: 5/24/2018
 * Time: 5:49 PM
 */

namespace App\Factories;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Record;
use Illuminate\Support\Facades\Validator;

final class CPanel
{
    public $factoryName = 'هاست cPanel';
    public $factoryDescription = 'شما با کمک این سازنده می توانید هاست cPanel ایجاد کنید.';
    public $factoryClass = "CPanel";
    public $factoryCartInformation = true;

    public function create(Product $product,Record $record)
    {
        $curl = curl_init();
        $url = "https://" . $product->options['server']
            .":2087/json-api/createacct?username=".$record->options['username']
            ."&domain=".$record->options['domain']."&"
            ."&quota=".$record->options['quota']."&"
            ."&password=".$record->options['password']."&"
            ."&maxftp=".$record->options['maxftp']."&"
            ."&maxsql=".$record->options['maxsql']."&"
            ."&maxpop=".$record->options['maxpop']."&"
            ."&maxlst=".$record->options['maxlst']."&"
            ."&maxsub=".$record->options['maxsub']."&"
            ."&maxpark=".$record->options['maxpark']."&"
            ."&maxaddon=".$record->options['maxaddon']."&"
            ."&bwlimit=".$record->options['bwlimit']."&"
            ."&domain=".$record->options['domain']."&"
            ."&domain=".$record->options['domain']."&"
            ."&domain=".$record->options['domain']."&";
        curl_setopt_array($curl, array(
            CURLOPT_PORT => "2087",
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => array(
                "Authorization: whm ". $product->options['username'] .":". $product->options['token']
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }

    public function reCreate(Service $service)
    {

    }

    public function terminate(Service $service)
    {

    }

    public function suspend(Service $service)
    {

    }

    public function modify(Service $service)
    {

    }

    public function control(Service $service)
    {

    }

    public function update(Request $request)
    {

    }


    public function cartInformation()
    {
        return view('factories.cpanel.cart');
    }

    public function cartStoreInformation(Request $request)
    {
        Validator::make($request->all(), [
            'domain.*' => 'required|a_domain',
        ])->validate();
    }

    public function cartAttributes()
    {
        return ['domain'];
    }


    public function productConfig(Product $product)
    {
        $packages = array();
        return view('admin.product.factory', ['product' => $product, 'packages' => $packages]);
    }

    public function storeProductConfig(Product $product, Request $request)
    {
        $product->options = $request->all();
        $product->save();
    }
}