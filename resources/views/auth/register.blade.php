@extends('layouts.app')
@section('title')
    ثبت نام -
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">ثبت نام</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        @method('post')
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label @lang('platform.input-pull')">نام و نام
                                خانوادگی</label>

                            <div class="col-md-7">
                                <input id="name" type="text"
                                       class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name"
                                       value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label @lang('platform.input-pull')">آدرس
                                ایمیل</label>

                            <div class="col-md-7">
                                <input id="email" type="email" dir="ltr"
                                       class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                                       value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="mobile" class="col-md-4 col-form-label @lang('platform.input-pull')">شماره
                                همراه</label>

                            <div class="col-md-7">
                                <input id="mobile" type="text" dir="ltr"
                                       class="form-control{{ $errors->has('mobile') ? ' is-invalid' : '' }}"
                                       name="mobile" value="{{ old('mobile') }}" required>

                                @if ($errors->has('mobile'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('mobile') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label @lang('platform.input-pull')">کلمه
                                عبور</label>

                            <div class="col-md-7">
                                <input id="password" type="password" dir="ltr"
                                       class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                       name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label @lang('platform.input-pull')">تکرار
                                کلمه عبور</label>

                            <div class="col-md-7">
                                <input id="password-confirm" dir="ltr" type="password" class="form-control"
                                       name="password_confirmation" required>
                            </div>
                        </div>
                        @if(config('platform.captcha-enable') == 'yes')
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label @lang('platform.input-pull')" for="captcha">عبارت
                                    امنیتی</label>
                                <div class="col-md-7">
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
                            </div>
                        @endif

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary btn-mobile">
                                    <i class="fa fa-user-plus"></i>
                                    ثبت نام
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
