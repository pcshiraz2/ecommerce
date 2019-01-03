<?php
/**
 * Created by PhpStorm.
 * User: Ali Ghasemzadeh
 * Date: 11/7/2018
 * Time: 7:31 AM
 */

namespace App\Utils;


final class MoneyUtil
{
    public static function format($money)
    {
        return number_format($money);
    }

    public static function exchange($money, $fromCurrency, $toCurrency)
    {

    }

    public static function database($value)
    {
        if (config('platform.currency') == 'IRR') {
            return $value;
        } else {
            return $value * 10;
        }
    }

    public static function display($value)
    {
        if (config('platform.currency') == 'IRR') {
            return $value;
        } else {
            return $value / 10;
        }
    }

    public static function baseLetters($money)
    {
        $one = array(
            'صفر',
            'یک',
            'دو',
            'سه',
            'چهار',
            'پنج',
            'شش',
            'هفت',
            'هشت',
            'نه');
        $ten = array(
            '',
            'ده',
            'بیست',
            'سی',
            'چهل',
            'پنجاه',
            'شصت',
            'هفتاد',
            'هشتاد',
            'نود',
        );
        $hundred = array(
            '',
            'یکصد',
            'دویست',
            'سیصد',
            'چهارصد',
            'پانصد',
            'ششصد',
            'هفتصد',
            'هشتصد',
            'نهصد',
        );
        $categories = array(
            '',
            'هزار',
            'میلیون',
            'میلیارد',
        );
        $exceptions = array(
            '',
            'یازده',
            'دوازده',
            'سیزده',
            'چهارده',
            'پانزده',
            'شانزده',
            'هفده',
            'هجده',
            'نوزده',
        );

        if (strlen($money) > count($categories) * 3) {
            throw new Exception('number is longger!');
        }

        $letters_separator = ' و ';
        $money = (string)(int)$money;
        $money_len = strlen($money);
        $persian_letters = '';

        for ($i = $money_len - 1; $i >= 0; $i -= 3) {
            $i_one = (int)isset($money[$i]) ? $money[$i] : -1;
            $i_ten = (int)isset($money[$i - 1]) ? $money[$i - 1] : -1;
            $i_hundred = (int)isset($money[$i - 2]) ? $money[$i - 2] : -1;

            $isset_one = false;
            $isset_ten = false;
            $isset_hundred = false;

            $letters = '';

            // zero
            if ($i_one == 0 && $i_ten < 0 && $i_hundred < 0) {
                $letters = $one[$i_one];
            }

            // one
            if (($i >= 0) && $i_one > 0 && $i_ten != 1 && isset($one[$i_one])) {
                $letters = $one[$i_one];
                $isset_one = true;
            }

            // ten
            if (($i - 1 >= 0) && $i_ten > 0 && isset($ten[$i_ten])) {
                if ($isset_one) {
                    $letters = $letters_separator . $letters;
                }

                if ($i_one == 0) {
                    $letters = $ten[$i_ten];
                } elseif ($i_ten == 1 && $i_one > 0) {
                    $letters = $exceptions[$i_one];
                } else {
                    $letters = $ten[$i_ten] . $letters;
                }

                $isset_ten = true;
            }

            // hundred
            if (($i - 2 >= 0) && $i_hundred > 0 && isset($hundred[$i_hundred])) {
                if ($isset_ten || $isset_one) {
                    $letters = $letters_separator . $letters;
                }

                $letters = $hundred[$i_hundred] . $letters;
                $isset_hundred = true;
            }

            if ($i_one < 1 && $i_ten < 1 && $i_hundred < 1) {
                $letters = '';
            } else {
                $letters .= ' ' . $categories[($money_len - $i - 1) / 3];
            }

            if (!empty($letters) && $i >= 3) {
                $letters = $letters_separator . $letters;
            }

            $persian_letters = $letters . $persian_letters;
        }

        return $persian_letters;
    }

    public static function letters($money)
    {
        $categories = array(
            'سکستیلیون',
            'کوانتینیارد',
            'کوانتینیوم',
            'کادریلیارد',
            'کادریلیون',
            'تریلیارد',
            'تریلیون',
            'بیلیارد',
            'بیلیون',
            'میلیارد',
            'میلیون',
            'هزار',
            '',
        );
        $Num3 = "";
        $Num2 = explode(',', number_format($money));
        for ($i = 0; $i < count($Num2); $i++) {
            if ($Num2[$i] != 0) {
                $Num3 .= self::baseLetters($Num2[$i]);
                $Num3 .= " " . $categories[count($categories) - count($Num2) + $i] . " ";
            }
            if ((($i < count($Num2) - 1) && ($Num2[$i + 1]) != "000")) $Num3 .= " و ";

        }
        return $Num3;
    }


}