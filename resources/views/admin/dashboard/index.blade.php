@extends('layouts.app')
@section('title', 'مدیریت سیستم - ')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-3">
            @include('admin.sidebar')
        </div>
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-12 col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ config('platform.name') }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                        href="{{ route('admin.dashboard') }}">مدیریت سیستم</a></li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-12 col-12">
                    <div class="row justify-content-center">
                        <div class="col-md-12 col-xs-12">
                            <div class="alert alert-info">
                                <i class="fa fa-clock-o" aria-hidden="true"></i>
                                امروز {{ jdate('now')->format('l j %B Y')  }}
                            </div>
                        </div>

                    </div>
                    <div class="row justify-content-center">
                        <div class="col-sm-3 col-md-3 col-6">
                            <a class="mb-1 btn btn-primary btn-block" href="{{ route('admin.invoice.create.sale') }}"><i
                                        class="fa fa-plus-circle"></i> فاکتور فروش</a>
                        </div>
                        <div class="col-sm-3 col-md-3 col-6">
                            <a class="mb-1 btn btn-warning btn-block"
                               href="{{ route('admin.invoice.create.purchase') }}"><i class="fa fa-minus-circle"></i>
                                فاکتور خرید</a>
                        </div>

                        <div class="col-sm-3 col-md-3 col-6">
                            <a class="mb-1 btn btn-success btn-block"
                               href="{{ route('admin.transaction.create.income') }}"><i
                                        class="fa fa-arrow-circle-left"></i> ثبت درآمد</a>
                        </div>
                        <div class="col-sm-3 col-md-3 col-6">
                            <a class="mb-1 btn btn-danger btn-block"
                               href="{{ route('admin.transaction.create.expense') }}"><i
                                        class="fa fa-arrow-circle-left"></i> ثبت هزینه</a>
                        </div>


                    </div>
                    <div class="row justify-content-center">
                        <div class="col-sm-3 col-md-3 col-6">
                            <div class="card text-white bg-primary mb-2">
                                <div class="card-body">
                                    <h5 class="card-title">موجودی کل</h5>
                                    <p class="card-text" id="total_of_accounts"></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-3 col-md-3 col-6">
                            <div class="card text-white bg-warning mb-2">
                                <div class="card-body">
                                    <h5 class="card-title">سررسید ها</h5>
                                    <p class="card-text" id="num_of_dues"></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-3 col-md-3 col-6">
                            <div class="card text-white bg-success mb-2">
                                <div class="card-body">
                                    <h5 class="card-title">واریزی ماه</h5>
                                    <p class="card-text" id="month_income"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-3 col-6">
                            <div class="card text-white bg-danger mb-2">
                                <div class="card-body">
                                    <h5 class="card-title">برداشتی ماه</h5>
                                    <p class="card-text" id="month_expense"></p>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6 mb-2">
                    <div class="card card-default">
                        <div class="card-header">تفکیک هزینه ها</div>
                        <div class="card-body">
                            <canvas id="chart_expense"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 mb-2">
                    <div class="card card-default">
                        <div class="card-header">تفکیک درآمد ها</div>
                        <div class="card-body">
                            <canvas id="chart_income"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="dashboard">
                <div class="col-md-6 col-sm-6 mb-2">
                    <item-list-component title="تیکت ها"
                                         web-address="{{ route('admin.dashboard.tickets') }}"></item-list-component>
                </div>
                <div class="col-md-6 col-sm-6 mb-2">
                    <item-list-component title="اخبار نرم افزار شیراز"
                                         web-address="{{ route('admin.dashboard.news') }}"></item-list-component>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    <script>
        $(function () {
            axios.get('{{ route('admin.dashboard.incomes') }}').then(function (response) {
                var ctx = document.getElementById("chart_income").getContext('2d');
                new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: response.data.income_label,
                        datasets: [{
                            label: " تومان",
                            data: response.data.income_data,
                            backgroundColor: response.data.income_color,
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        legend: {
                            position: 'bottom',
                            labels: {
                                // This more specific font property overrides the global property
                                fontFamily: 'Vazir,Tahoma'
                            }
                        },
                        tooltips: {
                            titleFontFamily: 'Vazir,Tahoma',
                            bodyFontFamily: 'Vazir,Tahoma'
                        }
                    }
                });
            }).catch(function (error) {
                console.log(error);
            });
            axios.get('{{ route('admin.dashboard.expenses') }}').then(function (response) {
                var ctx = document.getElementById("chart_expense").getContext('2d');
                new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: response.data.expense_label,
                        datasets: [{
                            label: " تومان",
                            data: response.data.expense_data,
                            backgroundColor: response.data.expense_color,
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        inGraphDataShow: true,
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                // This more specific font property overrides the global property
                                fontFamily: 'Vazir,Tahoma'
                            }
                        },
                        tooltips: {
                            titleFontFamily: 'Vazir,Tahoma',
                            bodyFontFamily: 'Vazir,Tahoma'
                        }
                    }
                });
            }).catch(function (error) {
                console.log(error);
            });
            axios.get('{{ route('admin.dashboard.tiles') }}').then(function (response) {
                $('#total_of_accounts').html(response.data.total_of_accounts);
                $('#num_of_dues').html(response.data.num_of_dues);
                $('#month_income').html(response.data.month_income);
                $('#month_expense').html(response.data.month_expense);
            }).catch(function (error) {
                console.log(error);
            });
        });
    </script>
@endsection