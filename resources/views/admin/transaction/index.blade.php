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
            <div class="card card-default">
                <div class="card-header">تراکنش ها
                    <div class="btn-group pull-left" role="group" aria-label="Basic example">
                        <a href="{{route('admin.transaction.create.expense')}}" class="btn btn-danger btn-sm"><i
                                    class="fa fa-minus-circle"></i> ثبت هزینه</a>
                        <a href="{{route('admin.transaction.create.income')}}" class="btn btn-success btn-sm"><i
                                    class="fa fa-plus-circle"></i> ثبت درآمد</a>
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
                                    @if($transaction->category['title'])
                                        {{ $transaction->category['title'] }}
                                    @else
                                        فاقد دسته بندی
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($transaction->account['title'])
                                        {{ $transaction->account['title'] }}
                                    @else
                                        فاقد حساب
                                    @endif
                                </td>
                                @if($transaction->amount < 0)
                                    <td class="text-center table-danger">{{ number_format($transaction->amount) }}</td>
                                @else
                                    <td class="text-center">{{ number_format($transaction->amount) }}</td>
                                @endif
                                <td class="text-center">{{ jdate($transaction->transaction_at)->format('Y/m/d H:i:s') }}</td>
                                <td class="text-center">
                                    @if($transaction->invoice_id)
                                        <a href="{{route('admin.invoice.view',['id'=>$transaction->invoice_id])}}">{{ $transaction->description }}</a>
                                    @else
                                        {{ $transaction->description }}
                                    @endif
                                </td>
                                <td>
                                    @if($transaction->amount < 0)
                                        <a href="{{ route('admin.transaction.edit.expense', ['id' => $transaction->id]) }}"
                                           class="btn btn-sm btn-dark"><i class="fa fa-edit"></i> ویرایش</a>
                                    @else
                                        <a href="{{ route('admin.transaction.edit.income', ['id' => $transaction->id]) }}"
                                           class="btn btn-sm btn-dark"><i class="fa fa-edit"></i> ویرایش</a>
                                    @endif

                                    <form method="post"
                                          action="{{ route('admin.transaction.delete',['id' => $transaction->id]) }}"
                                          style="display:inline;">
                                        @csrf
                                        @method('delete')
                                        <button onclick="return confirm('آیا از عملیات حذف اطمینان دارید؟')"
                                                class="btn btn-danger btn-sm btn-mobile"><i class="fa fa-trash"></i> حذف
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
