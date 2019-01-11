@extends('layouts.app')

@section('title', "فاکتورها - ")

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ config('platform.name') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('invoice') }}">فاکتورها</a>
                    </li>
                </ol>
            </nav>
        </div>
        <div class="col-md-12">
            <h1>فاکتورها</h1>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-{{ config('platform.sidebar-size') }}">
            @include('sidebar')
        </div>
        <div class="col-md-{{ config('platform.content-size') }}">
            <table class="table table-striped table-bordered table-hover">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">شماره</th>
                    <th scope="col">جمع</th>
                    <th scope="col">تاریخ</th>
                    <th scope="col">اقدام</th>
                </tr>
                </thead>
                <tbody>
                @foreach($invoices as $invoice)
                    <tr>
                        <td scope="row" class="text-center">{{$invoice->id}}</td>
                        <td class="text-center">{{number_format($invoice->total)}}</td>
                        <td class="text-center">{{ jdate($invoice->invoice_at)->format('Y/m/d H:i:s') }}</td>
                        <td>
                            <a href="{{ route('invoice.view',['id' => $invoice->id]) }}" class="btn btn-sm btn-primary">
                                <i class="fa fa-eye"></i>مشاهده فاکتور
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $invoices->links() }}
        </div>
    </div>
@endsection
