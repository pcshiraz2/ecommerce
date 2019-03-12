@extends('layouts.app')
@section('title', 'فاکتورها - ')
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
                    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('admin.invoice') }}">فاکتورها</a>
                    </li>
                </ol>
            </nav>
            <div id="accordion">
                <div class="card card-info mb-2">
                    <div data-toggle="collapse" href="#collapseOne" class="card-header collapsed" aria-expanded="false">
                        <i class="fa fa-arrow-circle-left"></i> جستجو
                    </div>
                    <div id="collapseOne" data-parent="#accordion" class="card-body collapse" style="">
                        <form method="GET" action="{{ route('admin.invoice') }}">
                            <div class="form-group">
                                <label for="search">عنوان</label>
                                <input name="search" id="search" type="text" class="form-control" value="{{ request('search') }}">
                            </div>
                            <button type="submit" class="btn btn-primary btn-mobile btn-sm"><i class="fa fa-search"></i>ارسال
                                جستجو
                            </button>
                        </form>
                    </div>
                </div>
            </div>
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
                    @include('global.top-table-options',['route' => 'admin.page.export'])
                    @if($invoices->count())
                    <table class="table table-hover table-striped table-bordered two-axis" cellspacing="0">
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
                                <td class="text-center">
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
                                       class="btn btn-sm btn-dark"
                                       data-toggle="tooltip" data-placement="top" title="ویرایش فاکتور"><i
                                                class="fa fa-edit"></i></a>
                                    <form method="post" class="d-inline"
                                          action="{{ route('admin.invoice.delete',['id' => $invoice->id]) }}"
                                          style="display:inline;">
                                        @csrf
                                        @method('delete')
                                        <button onclick="return confirm('آیا از عملیات حذف اطمینان دارید؟')"
                                                class="btn btn-danger btn-sm"
                                                data-toggle="tooltip" data-placement="top" title="حذف فاکتور"><i
                                                    class="fa fa-trash"></i></button>
                                    </form>
                                    <a href="{{ route('admin.invoice.view',['id' => $invoice->id]) }}"
                                       class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="مشاهده فاکتور"><i class="fa fa-calculator" aria-hidden="true"></i><a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @else
                        <div class="alert-warning alert">{{ trans('platform.no-result') }}</div>
                    @endif
                    @include('global.pagination',['items' => $invoices])
                </div>
            </div>
        </div>
    </div>
@endsection
