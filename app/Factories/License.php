<?php
/**
 * Created by PhpStorm.
 * User: Ali Ghasemzadeh
 * Date: 5/24/2018
 * Time: 5:49 PM
 */

namespace App\Factories;

use Illuminate\Http\Request;
use App\Service;

final class License
{
    public $factoryName = 'نرم افزار و لاینسس';
    public $factoryDescription = 'شما با کمک این سازنده می توانید لاینسس یا نرم افزار بفروشید.';
    public $factoryClass = "License";

    public function create($data)
    {

    }

    public function terminate($data)
    {

    }

    public function suspend($data)
    {

    }

    public function modify($data)
    {

    }

    public function control(Service $service)
    {

    }

    public function update(Request $request)
    {

    }
}