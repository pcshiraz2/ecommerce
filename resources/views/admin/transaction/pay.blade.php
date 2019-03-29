@extends('layouts.app')
@section('title', 'پرداخت تراکنش:' . $transaction->id ." - ")

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-{{ config('platform.sidebar-size') }}">
            @include('admin.sidebar')
        </div>
        <div class="col-md-{{ config('platform.content-size') }}">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ config('platform.name') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">مدیریت سیستم</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.transaction') }}">تراکنش ها</a></li>
                    <li class="breadcrumb-item active" aria-current="page"> پرداخت تراکنش: {{ $transaction->id }}</li>

                </ol>
            </nav>

            <div class="card card-default">
                <div class="card-header">
                    پرداخت تراکنش: {{ $transaction->id }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.transaction.pay',['id' => $transaction->id]) }}"
                          onsubmit="$('.price').unmask();">
                        @csrf
                        @method('post')

                        <div class="form-group">
                            <label for="paid_at">تاریخ
                                @if(Request::segment(4) == 'income')
                                    دریافت
                                @elseif(Request::segment(4) == 'expense')
                                    پرداخت
                                @endif
                            </label>
                            <div dir="rtl">
                                <date-picker
                                        id="paid_at"
                                        name="paid_at"
                                        format="jYYYY/jMM/jDD"
                                        display-format="jYYYY/jMM/jDD"
                                        color="#6838b8"
                                        type="date"
                                        value="{{ old('paid_at', jdate($transaction->paid_at)->format("Y/m/d")) }}">
                                </date-picker>
                            </div>
                            <span class="form-text text-muted">در صورتی که تراکنش پرداخت شده است تاریخ را بنویسید.</span>
                            @if ($errors->has('paid_at'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('paid_at') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-money"></i>
                            ویرایش تراکنش
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

