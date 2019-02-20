@extends('layouts.app')

@section('title', "پرداخت نقدی - ")

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ config('platform.name') }}</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('free-pay') }}">پرداخت نقدی</a></li>
                    <li class="breadcrumb-item active" aria-current="page">نتیجه پرداخت</li>
                </ol>
            </nav>
        </div>

    </div>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card-default">
                <div class="card-header">
                    نتیجه پرداخت
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="trackingCode">شماره پیگیری:</label>
                        <input class="form-control" value="{{$trackingCode}}" id="trackingCode" readonly>
                    </div>
                    <div class="form-group">
                        <label for="transaction_id">شماره داخلی تراکنش:</label>
                        <input class="form-control" value="{{$transaction_id}}" id="transaction_id" readonly>
                    </div>

                    <div class="form-group">
                        <label for="amount">مبلغ:</label>
                        <input class="form-control" value="{{ number_format(session('amount')) }} {{ trans('currency.'.config('platform.currency')) }}" id="amount" readonly>
                    </div>

                    <div class="form-group">
                        <label for="first_name">نام:</label>
                        <input class="form-control" value="{{session('first_name')}}" id="first_name" readonly>
                    </div>

                    <div class="form-group">
                        <label for="last_name">نام خانوادگی:</label>
                        <input class="form-control" value="{{session('last_name')}}" id="last_name" readonly>
                    </div>

                    <div class="form-group">
                        <label for="email">ایمیل:</label>
                        <input class="form-control" value="{{session('email')}}" id="email" readonly>
                    </div>

                    <div class="form-group">
                        <label for="mobile">شماره همراه:</label>
                        <input class="form-control" value="{{session('mobile')}}" id="mobile" readonly>
                    </div>

                    <div class="form-group">
                        <label for="description">توضیحات:</label>
                        <textarea class="form-control" readonly>{{session('description')}}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection
