@extends('layouts.app')
@section('title', 'پیشخوان - ')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ config('platform.name') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a
                                href="{{ route('dashboard') }}">پیشخوان</a></li>
                </ol>
            </nav>
        </div>
        <div class="col-md-12">
            <h1>پیشخوان</h1>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-{{ config('platform.sidebar-size') }}">
            @include('sidebar')
        </div>
        <div class="col-md-{{ config('platform.content-size') }}">

            <div class="row justify-content-center">
                <div class="col-md-12 col-xs-12">
                    <div class="alert alert-info">
                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                        امروز {{ jdate('now')->format('l j %B Y')  }}
                    </div>
                </div>

            </div>
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <a class="mb-1 btn btn-primary btn-block" href="{{ route('free-pay') }}"><i class="fa fa-money"></i>
                        افزایش موجودی</a>
                </div>
                <div class="col-md-4">
                    <a class="mb-1 btn btn-warning btn-block" href="{{ route('invoice') }}"><i class="fa fa-bars"></i>
                        فاکتورها</a>
                </div>
                <div class="col-md-4">
                    <a class="mb-1 btn btn-danger btn-block" href="{{ route('ticket.create') }}"><i
                                class="fa fa-plus"></i> ارسال تیکت</a>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="card text-white bg-primary mb-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 col-3"><i class="fa fa-database fa-3x" aria-hidden="true"></i>
                                </div>
                                <div class="col-md-9 col-9">
                                    <h5 class="card-title">موجودی کل</h5>
                                    <p class="card-text" id="total_of_accounts"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card text-white bg-warning mb-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 col-3"><i class="fa fa-calendar-plus-o fa-3x"
                                                               aria-hidden="true"></i></div>
                                <div class="col-md-9 col-9">
                                    <h5 class="card-title">سررسید ها</h5>
                                    <p class="card-text" id="num_of_dues"></p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-danger mb-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 col-3"><i class="fa fa-ticket fa-3x" aria-hidden="true"></i></div>
                                <div class="col-md-9 col-9">
                                    <h5 class="card-title">تیکت ها</h5>
                                    <p class="card-text" id="num_of_tickets"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row justify-content-center">
                <div class="col-md-6 mb-2">
                    <item-list-component title="تراکنش ها"
                                         web-address="{{ route('dashboard.transactions') }}"></item-list-component>
                </div>
                <div class="col-md-6 mb-2">
                    <item-list-component title="فاکتورها"
                                         web-address="{{ route('dashboard.invoices') }}"></item-list-component>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(function () {
            axios.get('{{ route('dashboard.tiles') }}').then(function (response) {
                $('#total_of_accounts').html(response.data.total_of_accounts);
                $('#num_of_dues').html(response.data.num_of_dues);
                $('#num_of_tickets').html(response.data.num_of_tickets);
            }).catch(function (error) {
                console.log(error);
            });
        });
    </script>

@endsection