@extends('layouts.app')

@section('title')
    ورود به سیستم -
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card-default">
                <div class="card-header">ورود</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        @method('post')
                        <div class="form-group">
                            <label for="login">ایمیل/شماره
                                همراه</label>

                                <input id="text" type="text" dir="ltr"
                                       class="form-control{{ $errors->has('login') ? ' is-invalid' : '' }}" name="login"
                                       value="{{ old('login') }}" required autofocus>

                                @if ($errors->has('login'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('login') }}</strong>
                                    </span>
                                @endif

                        </div>

                        <div class="form-group">
                            <label for="password">کلمه
                                عبور</label>
                                <input id="password" dir="ltr" type="password"
                                       class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                       name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                        </div>
                        @if(config('platform.captcha-login-enabled'))
                            <div class="form-group">
                                <label for="captcha">عبارت
                                    امنیتی</label>

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <img data-refresh-config="default" class="img-fluid" id="captcha_image"
                                                 src="{{ captcha_src(config('captcha.default-name')) }}"/>
                                        </div>
                                        <input dir="ltr" autocomplete="off"
                                               class="form-control{{ $errors->has('captcha') ? ' is-invalid' : '' }}"
                                               name="captcha" type="tel" placeholder="_ _ _" required>
                                        <div class="input-group-append">
                                            <button onclick="$('#captcha_image').attr('src', $('#captcha_image').attr('src')+'?'+Math.random());"
                                                    class="btn btn-primary" type="button"><i class="fa fa-refresh"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @if ($errors->has('captcha'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('captcha') }}</strong>
                                        </span>
                                    @endif

                            </div>
                        @endif
                        <div class="form-group">

                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="remember"
                                           {{ old('remember') ? 'checked' : '' }} class="custom-control-input"
                                           id="remember">
                                    <label class="custom-control-label" for="remember"> ذخیره اطلاعات ورود من</label>
                                </div>

                        </div>
                        <div class="form-group">

                                <button type="submit" class="btn btn-primary btn-mobile">
                                    <i class="fa fa-sign-in"></i>
                                    ورود
                                </button>

                                <a class="btn btn-link btn-mobile" href="{{ route('password.request') }}">
                                    <i class="fa fa-key"></i>
                                    فراموشی رمز عبور
                                </a>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
