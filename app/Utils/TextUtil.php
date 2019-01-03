<?php
/**
 * Created by PhpStorm.
 * User: Ali Ghasemzadeh
 * Date: 11/7/2018
 * Time: 7:31 AM
 */

namespace App\Utils;


final class TextUtil
{
    public static function convertToEnglish($text)
    {
        return strtr($text, [
                '۰' => '0',
                '۱' => '1',
                '۲' => '2',
                '۳' => '3',
                '۴' => '4',
                '۵' => '5',
                '۶' => '6',
                '۷' => '7',
                '۸' => '8',
                '۹' => '9',
                '٠' => '0',
                '١' => '1',
                '٢' => '2',
                '٣' => '3',
                '٤' => '4',
                '٥' => '5',
                '٦' => '6',
                '٧' => '7',
                '٨' => '8',
                '٩' => '9']
        );
    }
}