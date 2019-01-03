@extends('layouts.app')
@section('title', 'تغییر رمز عبور - ')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ config('platform.name') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('password') }}">تغییر رمز
                            عبور</a></li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card-default">
                <div class="card-header">تغییر کلمه عبور</div>
                <div class="card-body">
                    <form action="{{ route('password') }}" method="post">
                        @csrf
                        @method('post')
                        <div class="form-group">
                            <label for="current_password">کلمه عبور فعلی</label>
                            <input type="password" name="current_password" class="form-control" dir="ltr"
                                   id="current_password" aria-describedby="current_passwordHelp"
                                   placeholder="کلمه عبور فعلی" required autofocus>
                            <small id="current_passwordHelp" class="form-text">لطفا کلمه عبور فعلی که با آن وارد سایت
                                شده اید را بنویسید.
                            </small>
                            @if ($errors->has('current_password'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('current_password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="password">کلمه عبور جدید</label>
                            <input type="password" name="password" class="form-control" dir="ltr" id="password"
                                   placeholder="کلمه عبور جدید" required>
                            <small id="password-confirmHelp" class="form-text">کلمه عبور جدید را با رعایت اصول امینی
                                وارد کنید.
                            </small>
                            @if ($errors->has('password'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="password-confirm">تکرار کلمه عبور جدید</label>
                            <input id="password-confirm" type="password" dir="ltr" class="form-control"
                                   aria-describedby="password-confirmHelp" name="password_confirmation"
                                   placeholder="تکرار کلمه عبور جدید" required>
                            <small id="password-confirmHelp" class="form-text">جهت صحت درست وارد شدن کلمه عبور آن را
                                تکرار کنید.
                            </small>
                            @if ($errors->has('password_confirmation'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary btn-mobile"><i class="fa fa-key"></i> تغییر رمز
                            عبور
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
