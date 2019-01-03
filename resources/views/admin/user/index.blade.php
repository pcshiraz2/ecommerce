@extends('layouts.app')
@section('title', 'کاربرها - ')
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
                    <li class="breadcrumb-item active" aria-current="page"><a
                                href="{{ route('admin.user') }}">کاربرها</a></li>
                </ol>
            </nav>
            <div class="card card-default">
                <div class="card-header">کاربرها
                    <a href="{{route('admin.user.create')}}" class="btn btn-primary btn-sm pull-left"><i
                                class="fa fa-plus-circle"></i> ایجاد کاربر جدید</a>
                </div>

                <div class="card-body">

                    <table id="users" class="table table-hover table-striped table-bordered two-axis" cellspacing="0"
                           width="100%">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col" class="text-center">نام</th>
                            <th scope="col" class="text-center">شماره همراه</th>
                            <th scope="col" class="text-center">موجودی</th>
                            <th scope="col" class="text-center">اقدام ها</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td scope="row" class="text-center align-middle">
                                    {{$user->name}}
                                </td>
                                <td scope="row" class="text-center align-middle">
                                    {{ $user->mobile }}
                                </td>
                                <td scope="row" class="text-center align-middle">
                                    <span-component
                                            web-address="{{ route('admin.user.balance', [$user->id]) }}"></span-component>
                                </td>

                                <td scope="row" class="text-center align-middle">
                                    <a href="{{ route('admin.user.invoice', ['id' => $user->id]) }}"
                                       class="btn btn-sm btn-warning"
                                       data-toggle="tooltip" data-placement="top" title="ثبت فاکتور"><i
                                                class="fa fa-calculator"></i></a>
                                    <a href="{{ route('admin.user.transaction', ['id' => $user->id]) }}"
                                       class="btn btn-sm btn-info"
                                       data-toggle="tooltip" data-placement="top" title="ثبت سند"><i
                                                class="fa fa-money"></i></a>
                                    <a href="{{ route('admin.user.ticket', ['id' => $user->id]) }}"
                                       class="btn btn-sm btn-primary"
                                       data-toggle="tooltip" data-placement="top" title="ثبت تیکت"><i
                                                class="fa fa-ticket"></i></a>
                                    <a href="{{ route('admin.user.edit', ['id' => $user->id]) }}"
                                       class="btn btn-sm btn-dark"
                                       data-toggle="tooltip" data-placement="top" title="ویرایش کاربر"><i
                                                class="fa fa-edit"></i></a>
                                    <form method="post" class="d-inline"
                                          action="{{ route('admin.user.delete',['id' => $user->id]) }}"
                                          style="display:inline;">
                                        @csrf
                                        @method('delete')
                                        <button onclick="return confirm('آیا از عملیات حذف اطمینان دارید؟')"
                                                class="btn btn-danger btn-sm"
                                                data-toggle="tooltip" data-placement="top" title="حذف کاربر"><i
                                                    class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
@endsection
