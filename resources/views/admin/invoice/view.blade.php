@extends('layouts.app')
@if($invoice->type == 'sale')
    @section('title', 'مشاهده فاکتور فروش:' . $invoice->id .' - ')
@endif

@if($invoice->type == 'purchase')
    @section('title', 'مشاهده فاکتور خرید:' . $invoice->id .' - ')
@endif

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ config('platform.name') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">مدیریت سیستم</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.invoice') }}">فاکتورها</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        @if($invoice->type == 'sale')
                            فاکتور فروش: {{ $invoice->id }}
                        @endif

                        @if($invoice->type == 'purchase')
                                فاکتور خرید: {{ $invoice->id }}
                        @endif
                    </li>
                </ol>
            </nav>

            <div class="card card-default mb-2">
                <div class="card-header">
                    @if($invoice->type == 'sale')
                        فاکتور فروش: {{ $invoice->id }}
                    @endif

                    @if($invoice->type == 'purchase')
                            فاکتور خرید: {{ $invoice->id }}
                    @endif
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="alert alert-dark">
                                صورت حساب: {{ $invoice->user->name }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="alert alert-dark">
                                تاریخ: {{ jdate($invoice->invoice_at)->format("Y/m/d") }}
                            </div>
                        </div>
                        <div class="col">
                            <div class="alert alert-dark">
                                سر رسید: {{ jdate($invoice->due_at)->format("Y/m/d") }}
                            </div>
                        </div>
                    </div>
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
                                تخفیف: {{ number_format($invoice->discount)  }} تومان
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-9"></div>
                        <div class="col-md-3">
                            <div class="alert alert-dark">
                                مالیات: {{ number_format($invoice->tax)  }} تومان
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-9">
                            <div class="alert alert-dark">
                                مجموع حروف: {{ \App\Utils\MoneyUtil::letters($invoice->total) }} تومان
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="alert alert-dark">
                                جمع کل: {{ number_format($invoice->total)  }} تومان
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-default mb-2">
                        <div class="card-header">
                            تراکنش های فاکتور
                        </div>
                        <div class="card-body">
                            @if($invoice->transactions()->count() > 0)
                            <table class="table table-striped table-bordered table-hover">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col" class="text-center">نوع</th>
                                    <th scope="col" class="text-center">حساب</th>
                                    <th scope="col" class="text-center">مبلغ</th>
                                    <th scope="col" class="text-center">تاریخ</th>
                                    <th scope="col" class="text-center">شرح</th>
                                    <th scope="col" class="text-center">اقدام ها</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($invoice->transactions() as $transaction)
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
                                        <td class="text-center">
                                            @if($transaction->account['title'])
                                                {{ $transaction->account['title'] }}
                                            @else
                                                فاقد حساب
                                            @endif
                                        </td>
                                        @if($transaction->amount < 0)
                                            <td class="text-center table-danger">{{ \App\Utils\MoneyUtil::format($transaction->amount) }}</td>
                                        @else
                                            <td class="text-center table-success">{{ \App\Utils\MoneyUtil::format($transaction->amount) }}</td>
                                        @endif
                                        <td class="text-center">{{ jdate($transaction->transaction_at)->format('Y/m/d') }}</td>
                                        <td class="text-center">
                                            @if($transaction->invoice_id)
                                                <a href="{{route('admin.invoice.view',['id'=>$transaction->invoice_id])}}">{{ $transaction->description }}</a>
                                            @else
                                                {{ $transaction->description }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($transaction->paid_at)
                                                <a href="{{ route('admin.transaction.pay', ['id' => $transaction->id]) }}"
                                                   class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="ویرایش تاریخ پرداخت تراکنش"><i class="fa fa-money"></i></a>
                                            @else
                                                <a href="{{ route('admin.transaction.pay', ['id' => $transaction->id]) }}"
                                                   class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="پرداخت تراکنش پرداخت نشده"><i class="fa fa-money"></i></a>
                                            @endif
                                            <a href="{{ route('admin.transaction.edit', ['id' => $transaction->id]) }}"
                                               class="btn btn-sm btn-dark" data-toggle="tooltip" data-placement="top" title="ویرایش تراکنش"><i class="fa fa-edit"></i></a>

                                            <form method="post"
                                                  action="{{ route('admin.transaction.delete',['id' => $transaction->id]) }}"
                                                  style="display:inline;">
                                                @csrf
                                                @method('delete')
                                                <button onclick="return confirm('آیا از عملیات حذف اطمینان دارید؟')"
                                                        class="btn btn-danger btn-sm btn-mobile" data-toggle="tooltip" data-placement="top" title="حذف تراکنش"><i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            @else
                            <div class="alert alert-warning">
                                هنوز تراکنشی برای این فاکتور ثبت نشده است.
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-default mb-2">
                        <div class="card-header">
                           فروش اقساطی
                            <button class="btn btn-primary pull-left btn-sm">
                                <i class="fa fa-calculator"></i> محاسبه گر اقساط
                            </button>
                        </div>
                        <div class="card-body">
                                <form>
                                    @method('post')
                                    @csrf
                                    <div class="form-group">
                                        <label for="prepaid">پیش پرداخت</label>
                                        <input dir="ltr" name="prepaid" id="prepaid" class="price form-control{{ $errors->has('prepaid') ? ' is-invalid' : '' }}">
                                        @if ($errors->has('prepaid'))
                                            <span class="invalid-feedback">
                                             <strong>{{ $errors->first('prepaid') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="installment">مبلغ اقساط</label>
                                        <input dir="ltr" name="installment" id="installment" class="price form-control{{ $errors->has('installment') ? ' is-invalid' : '' }}">
                                        @if ($errors->has('installment'))
                                            <span class="invalid-feedback">
                                             <strong>{{ $errors->first('installment') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="count">تعداد اقساط</label>
                                        <input dir="ltr" name="count" id="count" class="price form-control{{ $errors->has('count') ? ' is-invalid' : '' }}">
                                        @if ($errors->has('count'))
                                            <span class="invalid-feedback">
                                             <strong>{{ $errors->first('count') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="period">دوره زمانی</label>
                                        <select class="selector form-control" name="period" id="period">
                                            <option value="1">هر ماه</option>
                                            <option value="2">هر دوماه</option>
                                            <option value="3">هر سه ماه</option>
                                            <option value="6">هر شش ماه</option>
                                            <option value="12">سالی یک بار</option>
                                        </select>
                                        @if ($errors->has('period'))
                                            <span class="invalid-feedback">
                                             <strong>{{ $errors->first('period') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="day">روز ماه</label>
                                        <select class="selector form-control" name="day" id="day">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                            <option value="13">13</option>
                                            <option value="14">14</option>
                                            <option value="15">15</option>
                                            <option value="16">16</option>
                                            <option value="17">17</option>
                                            <option value="18">18</option>
                                            <option value="19">19</option>
                                            <option value="20">20</option>
                                            <option value="21">21</option>
                                            <option value="22">22</option>
                                            <option value="23">23</option>
                                            <option value="24">24</option>
                                            <option value="25">25</option>
                                            <option value="26">26</option>
                                            <option value="27">27</option>
                                            <option value="28">28</option>
                                            <option value="29">29</option>
                                            <option value="30">30</option>
                                            <option value="31">31</option>
                                        </select>
                                        @if ($errors->has('day'))
                                            <span class="invalid-feedback">
                                             <strong>{{ $errors->first('day') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fa fa-money"></i>
                                        ثبت فروش اقساطی
                                    </button>
                                </form>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card card-default mb-2">
                    <div class="card-header">
                       دریافت نقدی کل فاکتور
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.invoice.pay',[$invoice->id])}}" method="post">
                            @csrf
                            @method('post')
                            <input type="hidden" name="type" id="type" value="{{ $invoice->type }}">
                            <input type="hidden" name="amount" id="amount" value="{{ $invoice->total }}">
                            <input type="hidden" name="invoice_id" id="invoice_id" value="{{ $invoice->id }}">
                            <div class="form-group">
                                <label for="account_id">واریز به حساب</label>
                                <select name="account_id" id="account_id"
                                        class="selector form-control{{ $errors->has('account_id') ? ' is-invalid' : '' }}">
                                    @foreach($accounts as $account)
                                        <option value="{{ $account->id }}"{{ old('account_id') == $account->id  ? ' selected' : '' }}>{{ $account->title }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('account_id'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('account_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fa fa-money"></i>
                                پرداخت فاکتور
                            </button>
                        </form>


                    </div>
                </div>


        </div>
    </div>
@endsection
