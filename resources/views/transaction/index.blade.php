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
        <div class="col-md-3">
            @include('sidebar')
        </div>
        <div class="col-md-9">
            <table class="table table-striped table-bordered table-hover">
                <thead class="thead-dark">
                <tr>
                    <th scope="col" class="text-center">#</th>
                    <th scope="col" class="text-center">مبلغ</th>
                    <th scope="col" class="text-center">تاریخ</th>
                    <th scope="col">اقدام</th>
                </tr>
                </thead>
                <tbody>
                @foreach($transactions as $transaction)
                    <tr>
                        <td scope="row" class="text-center">{{$transaction->id}}</td>
                        <td dir="ltr" class="text-center">{{number_format($transaction->amount)}}</td>
                        <td dir="ltr"
                            class="text-center">{{ jdate($transaction->transaction_at)->format('Y/m/d H:i:s') }}</td>
                        <td>
                            <a href="{{ route('transaction.view',['id' => $transaction->id]) }}"
                               class="btn btn-sm btn-primary">
                                <i class="fa fa-eye"></i> مشاهده جزئیات
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $transactions->links() }}
        </div>
    </div>

@endsection