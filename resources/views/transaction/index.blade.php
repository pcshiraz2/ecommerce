@extends('layouts.app')

@section('title', "تراکنش ها - ")

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ config('platform.name') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('transaction') }}">تراکنش
                            ها</a></li>
                </ol>
            </nav>
        </div>
        <div class="col-md-12">
            <h1>تراکنش ها</h1>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-{{ config('platform.sidebar-size') }}">
            @include('sidebar')
        </div>
        <div class="col-md-{{ config('platform.content-size') }}">
            <div id="accordion">
                <div class="card card-info mb-2">
                    <div data-toggle="collapse" href="#collapseOne" class="card-header collapsed" aria-expanded="false">
                        <i class="fa fa-arrow-circle-left"></i> جستجو
                    </div>
                    <div id="collapseOne" data-parent="#accordion" class="card-body collapse" style="">
                        <form method="GET" action="{{ route('transaction') }}">
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
                <div class="card-header">تراکنش ها</div>
                <div class="card-body">

                    @include('global.top-table-options',['route' => 'transaction.export'])
                    <table class="table table-striped table-bordered table-hover">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col" class="text-center">نوع</th>
                            <th scope="col" class="text-center">مبلغ</th>
                            <th scope="col" class="text-center">شرح</th>
                            <th scope="col" class="text-center">تاریخ</th>
                            <th scope="col" class="text-center">اقدام</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($transactions as $transaction)
                            <tr>
                                <td scope="row" class="text-center">
                                    @if($transaction->type == 'expense')
                                        <i class="fa fa-minus-circle"></i>
                                        هزینه
                                    @elseif($transaction->type == 'transfer')
                                        <i class="fa fa-exchange"></i>
                                        انتقال
                                    @elseif($transaction->type == 'income')
                                        <i class="fa fa-plus-circle"></i>
                                        واریز
                                    @elseif($transaction->type == 'invoice')
                                        <i class="fa fa-calculator"></i>
                                        فاکتور
                                    @endif
                                </td>
                                @if($transaction->amount < 0)
                                    <td class="text-center table-danger">{{ \App\Utils\MoneyUtil::format($transaction->amount) }}</td>
                                @else
                                    <td class="text-center table-success">{{ \App\Utils\MoneyUtil::format($transaction->amount) }}</td>
                                @endif
                                <td scope="row" class="text-center">
                                    @if($transaction->invoice_id)
                                        <a href="{{route('admin.invoice.view',['id'=>$transaction->invoice_id])}}">{{ $transaction->description }}</a>
                                    @else
                                        {{ $transaction->description }}
                                    @endif
                                </td>
                                <td scope="row" class="text-center">{{ jdate($transaction->transaction_at)->format('Y/m/d H:i:s') }}</td>
                                <td scope="row">
                                    <a href="{{ route('transaction.view',['id' => $transaction->id]) }}"
                                       class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="مشاهده جزئیات تراکنش">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $transactions->links() }}
                </div>
            </div>

        </div>
    </div>

@endsection