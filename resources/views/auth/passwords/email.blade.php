@extends('layouts.app')
@section('title')
    فراموشی رمز عبور -
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">روش اول: از طریق شماره همراه</div>

                <div class="card-body">
                    شما می توانید با ارسال عدد 99 به
                    {{ config('textmessage.gateway') }}
                    رمز عبور جدید را دریافت کنید.
                </div>
            </div>
        </div>
        <div class="col-md-8 mt-2">
            <div class="card card-default">
                <div class="card-header">روش دوم:از طریق ایمیل</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label @lang('platform.input-pull')">آدرس
                                ایمیل</label>

                            <div class="col-md-7">
                                <input id="email" dir="ltr" type="email"
                                       class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                                       value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary btn-mobile">
                                    <i class="fa fa-key"></i>
                                    فراموشی رمز عبور
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
