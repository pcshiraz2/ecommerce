<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function username()
    {
        return 'login';
    }

    protected function credentials(Request $request)
    {
        $field = filter_var($request->input($this->username()), FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';
        $request->merge([$field => $request->input($this->username())]);
        return $request->only($field, 'password');
    }

    protected function redirectTo()
    {
        return Config('platform.redirectTo');
    }

    protected function validateLogin(Request $request)
    {
        if (config('platform.captcha-enable') == 'yes') {
            $this->validate($request, [
                $this->username() => 'required',
                'password' => 'required',
                'captcha' => 'required|captcha'
            ]);
        } else {
            $this->validate($request, [
                $this->username() => 'required',
                'password' => 'required'
            ]);
        }
    }
}
