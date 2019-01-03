@extends('layouts.app')

@section('title', "پرداخت آزاد - ")

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ config('platform.name') }}</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('free-pay') }}">پرداخت آزاد</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">نتیجه پرداخت</li>
                </ol>
            </nav>
        </div>

    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">
                    نتیجه پرداخت
                </div>
                <div class="card-body">
                    <div class="row">
                        <label for="email" class="col-md-4 @lang('platform.input-pull')">شماره پیگیری:</label>

                        <div class="col-md-7">
                            {{$trackingCode}}
                        </div>
                    </div>
                    <div class="row">
                        <label for="email" class="col-md-4 @lang('platform.input-pull')">شماره داخلی تراکنش:</label>

                        <div class="col-md-7">
                            {{$transaction_id}}
                        </div>
                    </div>

                    <div class="row">
                        <label for="email" class="col-md-4 @lang('platform.input-pull')">مبلغ:</label>

                        <div class="col-md-7">
                            {{ number_format(session('amount')) }}
                        </div>
                    </div>

                    <div class="row">
                        <label for="email" class="col-md-4 @lang('platform.input-pull')">نام:</label>

                        <div class="col-md-7">
                            {{session('name')}}
                        </div>
                    </div>

                    <div class="row">
                        <label for="email" class="col-md-4 @lang('platform.input-pull')">ایمیل:</label>

                        <div class="col-md-7">
                            {{session('email')}}
                        </div>
                    </div>

                    <div class="row">
                        <label for="email" class="col-md-4 @lang('platform.input-pull')">شماره همراه:</label>

                        <div class="col-md-7">
                            {{session('mobile')}}
                        </div>
                    </div>

                    <div class="row">
                        <label for="email" class="col-md-4 @lang('platform.input-pull')">توضیحات:</label>

                        <div class="col-md-7">
                            {{session('description')}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection
