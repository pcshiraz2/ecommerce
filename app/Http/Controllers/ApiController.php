<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserPassword;

class ApiController extends Controller
{
    public function textMessageHook($password, Request $request)
    {
        $result = json_decode(file_get_contents("php://input"), true);
        $gateway = $result['gateway'];
        $text = $result['text'];
        $from = $result['from'];

        if ($password == config('platform.api-password')) {

            if ($gateway == config('textmessage.gateway')) {
                $user = User::where('mobile', "0" . $from)->get();
                if ($user = $user->first()) {
                    if (en_numbers($text) == '99') {
                        $new_password = rand(100000, 999999);
                        $user->password = Hash::make($new_password);
                        $user->save();
                        Notification::send($user, new UserPassword($user, $new_password));
                        return "1";
                    }
                } else {
                    return "0";
                }
            } else {
                return "0";
            }
        } else {
            return "0";
        }
    }
}

