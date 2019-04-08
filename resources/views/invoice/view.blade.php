@extends('layouts.app')

@section('title', "فاکتور شماره:" . $invoice->id . " - ")

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ config('platform.name') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('invoice') }}">فاکتورها</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a
                                href="{{ route('invoice.view',['id' => $invoice->id]) }}">فاکتور
                            شماره:{{ $invoice->id }}</a></li>
                </ol>
            </nav>
        </div>
        <div class="col-md-12">
            <h1>فاکتور شماره:{{ $invoice->id }}</h1>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered table-hover two-axis">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col" class="text-center">ردیف</th>
                            <th scope="col" class="text-center">شرح کالا</th>
                            <th scope="col" class="text-center">تعداد</th>
                            <th scope="col" class="text-center">قیمت واحد</th>
                            <th scope="col" class="text-center">قیمت کل</th>
                            <th scope="col" class="text-center">تخفیف</th>
                            <th scope="col" class="text-center">مالیات و عوارض</th>
                            <th scope="col" class="text-center">مبلغ کل پس تخفیف و مالیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($invoice->records as $record)
                            <tr>
                                <td scope="row" class="text-center">{{$loop->iteration}}</td>
                                <td class="text-center">
                                    @if($record->product_id)
                                        <a href="{{ route('product.view', ['id'=>$record->product_id]) }}">{{$record->title}}</a>
                                    @else
                                        {{$record->title}}
                                    @endif
                                    @if($record->description)
                                        <small>{{$record->description}}</small>
                                    @endif
                                </td>
                                <td class="text-center">{{ abs($record->quantity) }}</td>
                                <td class="text-center">{{number_format($record->price)}}</td>
                                <td class="text-center">{{number_format(abs($record->price * $record->quantity)) }}</td>
                                <td class="text-center">{{number_format(abs($record->discount * $record->quantity))}}</td>
                                <td class="text-center">{{number_format(abs($record->tax * $record->quantity)) }}</td>
                                <td class="text-center">{{number_format($record->total)}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9"></div>
                <div class="col-md-3">
                    <div class="alert alert-dark">
                        تخفیف: {{ number_format($invoice->discount)  }} {{ trans('currency.'.config('platform.currency')) }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9"></div>
                <div class="col-md-3">
                    <div class="alert alert-dark">
                        مالیات: {{ number_format($invoice->tax)  }} {{ trans('currency.'.config('platform.currency')) }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9">
                    <div class="alert alert-dark">
                        مجموع
                        حروف: {{ \App\Utils\MoneyUtil::letters($invoice->total) }} {{ trans('currency.'.config('platform.currency')) }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="alert alert-dark">
                        جمع
                        کل: {{ number_format($invoice->total)  }} {{ trans('currency.'.config('platform.currency')) }}
                    </div>
                </div>
            </div>
            @if($invoice->payment == 'cash')
            <div class="row">
                <div class="col-md-9"></div>
                <div class="col-md-3 text-center">
                    @if($invoice->status == 'paid' || $invoice->status == 'approved')
                        <div class="alert alert-success">
                            زمان پرداخت
                            <br/><span dir="ltr">{{jdate($invoice->paid_at)->format('Y/m/d H:i:s')}}</span>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <form action="{{ route('invoice.pay') }}" method="post">
                                @csrf
                                @method('post')

                                <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                                <div class="form-group">
                                    <label for="gateway text-center">درگاه انتخابی</label>
                                    <select name="gateway" id="gateway"
                                            class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}">
                                        @foreach(\Parsisolution\Gateway\Facades\Gateway::activeDrivers() as $gateway)
                                            <option value="{{ $gateway['key'] }}"{{ old('gateway') == $gateway['key']  ? ' selected' : '' }}>{{ $gateway['name'] }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('gateway'))
                                        <span class="invalid-feedback">
                                                <strong>{{ $errors->first('gateway') }}</strong>
                                            </span>
                                    @endif
                                </div>
                                <button type="submit" class="btn btn-success btn-block">
                                    <i class="fa fa-money"></i>
                                    پرداخت
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-default mb-2">
                        <div class="card-header">
                            تراکنش های فاکتور
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-bordered table-hover">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col" class="text-center">نوع</th>
                                    <th scope="col" class="text-center">مبلغ</th>
                                    <th scope="col" class="text-center">تاریخ</th>
                                    <th scope="col" class="text-center">شرح</th>
                                    <th scope="col" class="text-center">اقدام ها</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $total = 0;
                                    $paid = 0;
                                    $wait = 0;
                                    $profit = 0;
                                    $expiredInstallment = 0;
                                @endphp

                                @foreach($invoice->transactions as $transaction)
                                    @php
                                        $total += $transaction->amount;
                                        if($transaction->paid_at) {
                                            $paid += $transaction->amount;
                                        } else {
                                            $wait += $transaction->amount;
                                        }
                                        if($transaction->transaction_at < now() && $transaction->paid_at == null) {
                                            $expiredInstallment++;
                                        }
                                    @endphp
                                    <tr>
                                        <td scope="row" class="text-center">
                                            @if($transaction->type == 'expense')
                                                <i class="fa fa-minus-circle"></i>
                                            @elseif($transaction->type == 'transfer')
                                                <i class="fa fa-exchange"></i>
                                            @elseif($transaction->type == 'income')
                                                <i class="fa fa-plus-circle"></i>
                                            @elseif($transaction->type == 'invoice')
                                                <i class="fa fa-calculator"></i>
                                                فاکتور
                                            @endif
                                            {{ $transaction->category['title'] }}
                                        </td>
                                        @if($transaction->amount < 0)
                                            <td class="text-center table-danger">{{ \App\Utils\MoneyUtil::format($transaction->amount) }}</td>
                                        @else
                                            @if($transaction->paid_at)
                                                <td class="text-center table-success">{{ \App\Utils\MoneyUtil::format($transaction->amount) }}</td>
                                            @else
                                                <td class="text-center table-warning">{{ \App\Utils\MoneyUtil::format($transaction->amount) }}</td>
                                            @endif
                                        @endif
                                        @if($transaction->transaction_at < now() && $transaction->paid_at == null)
                                            <td class="text-center table-danger">{{ jdate($transaction->transaction_at)->format('Y/m/d') }}</td>
                                        @else
                                            <td class="text-center">{{ jdate($transaction->transaction_at)->format('Y/m/d') }}</td>
                                        @endif
                                        <td class="text-center">
                                                {{ $transaction->description }}
                                        </td>
                                        <td>
                                            @if($transaction->paid_at)
                                                <button class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="اقساط با موفقیت پرداخت شده است."><i class="fa fa-money"></i></button>
                                            @else
                                                <a href="{{ route('invoice.installment', ['id' => $transaction->id]) }}"
                                                   class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="پرداخت اقساط پرداخت نشده"><i class="fa fa-money"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>


                            @if($invoice->payment == 'installment')
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="alert alert-info">
                                        جمع کل تراکنش ها:
                                        <br />
                                        {{ number_format($total)  }}  {{ trans('currency.'.config('platform.currency')) }}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="alert alert-success">
                                        جمع تراکنش های پرداختی:
                                        <br />
                                        {{ number_format($paid)  }}  {{ trans('currency.'.config('platform.currency')) }}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="alert alert-warning">
                                        جمع تراکنش های پرداخت نشده:
                                        <br />
                                        {{ number_format($wait)  }}  {{ trans('currency.'.config('platform.currency')) }}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="alert alert-dark">
                                        سود اقساط:
                                        <br />
                                        {{ number_format($total - $invoice->total)  }}  {{ trans('currency.'.config('platform.currency')) }}
                                    </div>
                                </div>
                            </div>

                            @if($expiredInstallment > 0)
                                <div class="alert-danger alert">
                                    تعداد اقساط سررسید شده
                                    <span class="badge badge-danger">{{ $expiredInstallment }}</span>
                                    می باشد.
                                </div>
                            @endif
                            @else


                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="alert alert-info">
                                            جمع کل تراکنش ها:
                                            <br />
                                            {{ number_format($total)  }}  {{ trans('currency.'.config('platform.currency')) }}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="alert alert-success">
                                            جمع تراکنش های پرداختی:
                                            <br />
                                            {{ number_format($paid)  }}  {{ trans('currency.'.config('platform.currency')) }}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="alert alert-warning">
                                            جمع تراکنش های پرداخت نشده:
                                            <br />
                                            {{ number_format($wait)  }}  {{ trans('currency.'.config('platform.currency')) }}
                                        </div>
                                    </div>
                                </div>

                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
