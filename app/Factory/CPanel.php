<?php
/**
 * Created by PhpStorm.
 * User: Ali Ghasemzadeh
 * Date: 5/24/2018
 * Time: 5:49 PM
 */

namespace App\Factory;

use Illuminate\Http\Request;
use App\Service;

final class CPanel
{
    public $factoryName = 'هاست cPanel';
    public $factoryDescription = 'شما با کمک این سازنده می توانید هاست cPanel ایجاد کنید.';
    public $factoryClass = "CPanel";

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