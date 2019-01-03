@extends('layouts.app')
@section('title', 'تایید مشخصات - ')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ config('platform.name') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('verify') }}">تایید
                            مشخصات</a></li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-6 mb-2">
            <div class="card card-default">
                <div class="card-header">تایید ایمیل</div>
                <div class="card-body">
                    <div class="form-group row">
                        <label for="name" class="col-md-4 @lang('platform.input-pull')">کد فعال ساز ایمیل:</label>
                        <div class="col-md-8">
                            <input type="text" name="email_password" dir="ltr" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2"></div>
                        <div class="col-md-10">
                            <button type="submit" class="btn btn-primary">ثبت کد فعال سازی</button>
                            <button type="button" class="btn btn-secondary">ارسال کد فعال سازی</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-2">
            <div class="card card-default">
                <div class="card-header">تایید شماره همراه</div>
                <div class="card-body">
                    <div class="form-group row">
                        <label for="name" class="col-md-4 @lang('platform.input-pull')">کد فعال سازی همراه</label>
                        <div class="col-md-8">
                            <input type="text" name="mobile_password" dir="ltr" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2"></div>
                        <div class="col-md-10">
                            <button type="submit" class="btn btn-primary">ثبت کد فعال سازی</button>
                            <button type="button" class="btn btn-secondary">ارسال کد فعال سازی</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-2">
            <div class="card card-default">
                <div class="card-header">ارسال اسکن کارت ملی</div>
                <div class="card-body">
                    <div class="form-group row">
                        <label for="name" class="col-md-4 @lang('platform.input-pull')">اسکن کارت ملی</label>
                        <div class="col-md-8">
                            <input type="file" name="national_card_file" dir="ltr" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2"></div>
                        <div class="col-md-10">
                            <button type="submit" class="btn btn-primary">ارسال کارت ملی</button>
                            <button type="button" class="btn btn-secondary">دریافت کارت ملی</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-2">
            <div class="card card-default">
                <div class="card-header">ارسال اسکن شناسنامه</div>
                <div class="card-body">
                    <div class="form-group row">
                        <label for="name" class="col-md-4 @lang('platform.input-pull')">اسکن شناسنامه</label>
                        <div class="col-md-8">
                            <input type="file" name="national_card_file" dir="ltr" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2"></div>
                        <div class="col-md-10">
                            <button type="submit" class="btn btn-primary">ارسال کارت ملی</button>
                            <button type="button" class="btn btn-secondary">دریافت کارت ملی</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12 mb-2">
            <div class="card card-default">
                <div class="card-header">اطلاع رسان تلگرامی</div>
                <div class="card-body">
                    <div class="form-group row">
                        <label for="name" class="col-md-4 @lang('platform.input-pull')">کد فعال سازی تلگرام:</label>
                        <div class="col-md-7">
                            {{Auth::user()->telegram_password}}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-md-4 @lang('platform.input-pull')">شماره تلگرام:</label>
                        <div class="col-md-7">
                            {{Auth::user()->telegram_user_id}}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
