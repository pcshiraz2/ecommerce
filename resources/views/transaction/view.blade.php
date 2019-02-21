@extends('layouts.app')

@section('title', "تراکنش شماره:" . $transaction->id ." - ")

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ config('platform.name') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('transaction') }}">تراکنش ها</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a
                                href="{{ route('transaction.view', ['id'=>$transaction->id]) }}">تراکنش
                            شماره:{{$transaction->id}}</a></li>
                </ol>
            </nav>
        </div>
        <div class="col-md-12">
            <h1>تراکنش شماره:{{$transaction->id}}</h1>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-{{ config('platform.sidebar-size') }}">
            @include('sidebar')
        </div>
        <div class="col-md-{{ config('platform.content-size') }}">
            <div class="card card-default">
                <div class="card-header">
                    مشاهده اطلاعات تراکنش
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>شماره تراکنش:</label>
                        <input class="form-control" value="{{$transaction->id}}" readonly>
                    </div>
                    <div class="form-group">
                        <label>تاریخ تراکنش:</label>

                        <input class="form-control" value="{{ jdate($transaction->transaction_at)->format('Y/m/d H:i:s') }}" readonly>

                    </div>
                    <div class="form-group">
                        <label>تاریخ ایجاد:</label>
                        <input class="form-control" value="{{ jdate($transaction->created_at)->format('Y/m/d H:i:s') }}" readonly>
                    </div>
                    <div class="form-group">
                        <label>مبلغ:</label>
                            <input class="form-control" value="{{number_format($transaction->amount)}} {{ trans('currency.'.config('platform.currency')) }}" readonly>
                    </div>
                        <div class="form-group">
                            <label>توضیحات:</label>
                            <textarea class="form-control" readonly>{{ $transaction->description }}</textarea>
                        </div>
                    @if($transaction->gateway)
                        <div class="form-group">
                            <label>درگاه پرداخت:</label>
                            <input class="form-control" value="{{config('gateways.'.$transaction->gateway.'.name')}}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="trackingCode">شماره پیگیری:</label>
                            <input class="form-control" value="{{ $transaction->options['trackingCode'] }}" id="trackingCode" readonly>
                        </div>
                    @endif
                    @if($transaction->invoice_id)
                        <div class="form-group">
                                <a class="btn btn-sm btn-primary btn-mobile" href="{{ route('invoice.view', ['id' => $transaction->invoice_id]) }}"><i class="fa fa-calculator"></i> مشاهده فاکتور</a>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection

