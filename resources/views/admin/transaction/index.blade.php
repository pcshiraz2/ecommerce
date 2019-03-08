@extends('layouts.app')
@section('title', 'تراکنش ها - ')
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
                    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('admin.transaction') }}">تراکنش
                            ها</a></li>
                </ol>
            </nav>
            <div id="accordion">
                <div class="card card-info mb-2">
                    <div data-toggle="collapse" href="#collapseOne" class="card-header collapsed" aria-expanded="false">
                        <i class="fa fa-arrow-circle-left"></i> جستجو
                    </div>
                    <div id="collapseOne" data-parent="#accordion" class="card-body collapse" style="">
                        <form method="GET" action="{{ route('admin.transaction') }}">
                            <div class="form-group">
                                <label for="search">عنوان</label>
                                <input name="search" id="search" type="text" class="form-control" value="{{ request('search') }}">
                            </div>
                            <button type="submit" class="btn btn-primary btn-mobile btn-sm"><i class="fa fa-search"></i>
                                جستجو
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card card-default">
                <div class="card-header">تراکنش ها
                    <div class="btn-group pull-left" role="group" aria-label="transaction type">
                        <a href="{{route('admin.transaction.create.expense')}}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="ثبت هزینه"><i
                                    class="fa fa-minus-circle"></i></a>

                        <a href="{{route('admin.transaction.create.transfer')}}" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="انتقال وجه"><i
                                    class="fa fa-exchange"></i></a>

                        <a href="{{route('admin.transaction.create.income')}}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="ثبت درآمد"><i
                                    class="fa fa-plus-circle"></i></a>
                    </div>
                </div>

                <div class="card-body">

                    @include('global.top-table-options',['route' => 'admin.page.export'])
                    @if($transactions->count())
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
                        @foreach($transactions as $transaction)
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
                                    <a href="{{ route('admin.transaction.pay', ['id' => $transaction->id]) }}"
                                       class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="پرداخت تراکنش"><i class="fa fa-money"></i></a>

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
                        <div class="alert-warning alert">{{ trans('platform.no-result') }}</div>
                    @endif
                    @include('global.pagination',['items' => $transactions])
                </div>
            </div>
        </div>
    </div>
@endsection
