<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        if (config('platform.captcha-enabled')) {
            return Validator::make($data, [
                'last_name' => 'required|string|max:191',
                'email' => 'required|string|email|max:191|unique:users,email',
                'mobile' => 'required|numeric|digits:11|unique:users,mobile',
                'password' => 'required|string|min:6|confirmed',
                'captcha' => 'required|captcha'
            ]);
        } else {
            return Validator::make($data, [
                'last_name' => 'required|string|max:191',
                'email' => 'required|string|email|max:191|unique:users,email',
                'mobile' => 'required|numeric|digits:11|unique:users,mobile',
                'password' => 'required|string|min:6|confirmed',
            ]);
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'last_name' => $data['last_name'],
            'mobile' => $data['mobile'],
            'password' => Hash::make($data['password']),
        ]);

        $user->first_name = $data['first_name'];
        $user->title = $data['title'];
        $user->email = $data['email'];
        $user->register_ip = request()->ip();
        $user->login_ip = request()->ip();
        $user->save();

        return $user;
    }

    protected function redirectTo()
    {
        return config('platform.redirectTo');
    }

    public function showRegistrationForm()
    {
        if (config('platform.register-enabled')) {
            return view('auth.register');
        } else {
            return redirect()->back();
        }
    }
}
