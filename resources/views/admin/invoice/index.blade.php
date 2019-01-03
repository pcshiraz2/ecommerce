@extends('layouts.app')
@section('title', 'فاکتورها - ')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-3">
            @include('admin.sidebar')
        </div>
        <div class="col-md-9">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ config('platform.name') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">مدیریت سیستم</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('admin.invoice') }}">فاکتورها</a>
                    </li>
                </ol>
            </nav>
            <div class="card card-default">
                <div class="card-header">فاکتورها
                    <div class="btn-group pull-left" role="group" aria-label="Basic example">
                        <a href="{{route('admin.invoice.create.purchase')}}" class="btn btn-danger btn-sm"><i
                                    class="fa fa-minus-circle"></i> فاکتور خرید</a>
                        <a href="{{route('admin.invoice.create.sale')}}" class="btn btn-success btn-sm"><i
                                    class="fa fa-plus-circle"></i> فاکتور فروش</a>
                    </div>
                </div>

                <div class="card-body">

                    <table class="table table-striped table-bordered table-hover">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col" class="text-center">نوع</th>
                            <th scope="col" class="text-center">مبلغ</th>
                            <th scope="col" class="text-center">کاربر</th>
                            <th scope="col" class="text-center">تاریخ</th>
                            <th scope="col" class="text-center">وضعیت</th>
                            <th scope="col" class="text-center">اقدام ها</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($invoices as $invoice)
                            <tr>
                                <td scope="row" class="text-center">
                                    @if($invoice->type == 'purchase')
                                        خرید
                                    @else
                                        فروش
                                    @endif
                                </td>
                                <td class="text-center">
                                    {{ number_format($invoice->total) }}
                                </td>
                                <td class="text-center">
                                    {{ $invoice->user->name }}
                                </td>
                                <td class="text-center" dir="ltr">
                                    {{  jdate($invoice->invoice_at)->format('Y/m/d H:i:s')  }}
                                </td>
                                <td class="text-center">
                                    @if($invoice->status == 'sent')
                                        ارسال شده
                                    @endif
                                    @if($invoice->status == 'draft')
                                        پیشنویس
                                    @endif
                                    @if($invoice->status == 'approved')
                                        تایید شده
                                    @endif
                                    @if($invoice->status == 'paid')
                                        پرداخت شده
                                    @endif
                                    @if($invoice->status == 'normal')
                                        عادی
                                    @endif
                                </td>

                                <td>
                                    <a href="{{ route('admin.invoice.edit', ['id' => $invoice->id]) }}"
                                       class="btn btn-sm btn-dark"><i class="fa fa-edit"></i> ویرایش</a>
                                    <a href="{{ route('admin.invoice.view',['id' => $invoice->id]) }}"
                                       class="btn btn-sm btn-warning"><i class="fa fa-calculator"
                                                                         aria-hidden="true"></i> مشاهده<a>
                                            <form method="post"
                                                  action="{{ route('admin.invoice.delete',['id' => $invoice->id]) }}"
                                                  style="display:inline;">
                                                @csrf
                                                @method('delete')
                                                <button onclick="return confirm('آیا از عملیات حذف اطمینان دارید؟')"
                                                        class="btn btn-danger btn-sm btn-mobile"><i
                                                            class="fa fa-trash"></i> حذف
                                                </button>
                                            </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $invoices->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
