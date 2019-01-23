<?php
/**
 * Created by PhpStorm.
 * User: Ali Ghasemzadeh
 * Date: 1/21/2019
 * Time: 5:58 AM
 */

namespace App\Factory;


final class BaseFactory
{
    public $factoryName = '';
    public $factoryDescription = '';
    public $factoryClass = "CPanel";
    public $factoryCartInformation = true;

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


    public function cartInformation()
    {

    }

    public function cartStoreInformation(Request $request)
    {

    }

    public function getCartAttribs()
    {
        return [];
    }
}