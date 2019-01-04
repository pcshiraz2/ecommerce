@extends('layouts.app')
@section('title')
    ثبت نام -
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card-default">
                <div class="card-header">ثبت نام</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        @method('post')
                        <div class="form-group">
                            <label for="first_name">نام</label>
                                <input id="first_name" type="text"
                                       class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="first_name"
                                       value="{{ old('first_name') }}" required autofocus>

                                @if ($errors->has('first_name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group">
                            <label for="last_name">نام خانوادگی</label>
                            <input id="last_name" type="text"
                                   class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name"
                                   value="{{ old('last_name') }}" required>
                            @if ($errors->has('last_name'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="title">نام حقوقی
                                <span class="font-weight-light font-italic"> - اختیاری</span>
                            </label>
                            <input id="title" type="text"
                                   class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title"
                                   value="{{ old('title') }}">
                            @if ($errors->has('title'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="email">آدرس
                                ایمیل</label>
                                <input id="email" type="email" dir="ltr"
                                       class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                                       value="{{ old('email') }}" required>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group">
                            <label for="mobile">شماره
                                همراه</label>


                                <input id="mobile" type="text" dir="ltr"
                                       class="form-control{{ $errors->has('mobile') ? ' is-invalid' : '' }}"
                                       name="mobile" value="{{ old('mobile') }}" required>

                                @if ($errors->has('mobile'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('mobile') }}</strong>
                                    </span>
                                @endif

                        </div>

                        <div class="form-group">
                            <label for="password">کلمه
                                عبور</label>


                                <input id="password" type="password" dir="ltr"
                                       class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                       name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif

                        </div>

                        <div class="form-group">
                            <label for="password-confirm">تکرار
                                کلمه عبور</label>
                                <input id="password-confirm" dir="ltr" type="password" class="form-control"
                                       name="password_confirmation" required>
                        </div>
                        @if(config('platform.captcha-enabled'))
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
                                <button type="submit" class="btn btn-primary btn-mobile">
                                    <i class="fa fa-user-plus"></i>
                                    ثبت نام
                                </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
