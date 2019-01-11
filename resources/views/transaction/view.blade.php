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
                    نتیجه پرداخت
                </div>
                <div class="card-body">
                    <div class="row">
                        <label class="col-md-4 col-sm-4 col-lg-4 @lang('platform.input-pull')">شماره تراکنش:</label>
                        <div class="col-md-8 col-lg-8 col-sm-8">
                            {{$transaction->id}}
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-4 col-sm-4 col-lg-4 @lang('platform.input-pull')">تاریخ تراکنش:</label>
                        <div class="col-md-8 col-lg-8 col-sm-8 text-right" dir="ltr">
                            {{ jdate($transaction->transaction_at)->format('Y/m/d H:i:s') }}
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-4 col-sm-4 col-lg-4 @lang('platform.input-pull')">تاریخ ایجاد:</label>
                        <div class="col-md-8 col-lg-8 col-sm-8 text-right" dir="ltr">
                            {{ jdate($transaction->created_at)->format('Y/m/d H:i:s') }}
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-4 col-sm-4 col-lg-4 @lang('platform.input-pull')">مبلغ:</label>
                        <div class="col-md-8 col-lg-8 col-sm-8 text-right">
                            {{number_format($transaction->amount)}} تومان
                        </div>
                    </div>

                    @if($transaction->gateway)
                        <div class="row">
                            <label class="col-md-4 col-sm-4 col-lg-4 @lang('platform.input-pull')">درگاه پرداخت:</label>
                            <div class="col-md-8 col-lg-8 col-sm-8">
                                {{config('gateway.'.$transaction->gateway.'.title')}}
                            </div>
                        </div>
                    @endif

                    @if($transaction->description)
                        <div class="row">
                            <label class="col-md-4 col-sm-4 col-lg-4 @lang('platform.input-pull')">توضیحات:</label>
                            <div class="col-md-8 col-lg-8 col-sm-8">
                                {{ $transaction->description }}
                            </div>
                        </div>
                    @endif

                    @if($transaction->invoice_id)
                        <div class="row">
                            <label class="col-md-4 col-sm-4 col-lg-4 @lang('platform.input-pull')">فاکتور:</label>
                            <div class="col-md-8 col-lg-8 col-sm-8">
                                <a class="btn btn-sm btn-primary"
                                   href="{{ route('invoice.view', ['id' => $transaction->invoice_id]) }}"><i
                                            class="fa fa-bars"></i> مشاهده</a>
                            </div>
                        </div>
                    @endif

                    @if($transaction->account_id)
                        <div class="row">
                            <label class="col-md-4 col-sm-4 col-lg-4 @lang('platform.input-pull')">حساب:</label>
                            <div class="col-md-8 col-lg-8 col-sm-8">
                                {{$transaction->account->title}}
                            </div>
                        </div>
                    @endif

                    @if($transaction->category_id)
                        <div class="row">
                            <label class="col-md-4 col-sm-4 col-lg-4 @lang('platform.input-pull')">دسته:</label>
                            <div class="col-md-8 col-lg-8 col-sm-8">
                                {{$transaction->category->title}}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

