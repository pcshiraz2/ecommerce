<?php
/**
 * Created by PhpStorm.
 * User: Ali Ghasemzadeh
 * Date: 1/4/2019
 * Time: 12:36 AM
 */

namespace App\Utils;


final class UrlUtil
{
    public static function downloadExcel($route)
    {
        $parameters = request()->input();
        return route($route, $parameters);
    }
}