@extends('layouts.app')
@section('title', 'کالاها - ')
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
                                href="{{ route('admin.product') }}">کالاها</a></li>
                </ol>
            </nav>
            <div class="card card-default">
                <div class="card-header">کالاها
                    <a href="{{route('admin.product.create')}}" class="btn btn-primary btn-sm pull-left"><i
                                class="fa fa-plus-circle"></i>کالا جدید</a>
                </div>

                <div class="card-body">

                    <table class="table table-striped table-bordered table-hover two-axis">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col" class="text-center">عنوان</th>
                            <th scope="col" class="text-center">نوع</th>
                            <th scope="col" class="text-center">قیمت</th>
                            <th scope="col" class="text-center">موجودی</th>
                            <th scope="col" class="text-center">اقدام ها</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td scope="row" class="text-center align-middle">
                                    {{$product->title}}
                                </td>
                                <td scope="row" class="text-center align-middle">
                                    {{ $product->category->title }}
                                </td>
                                <td class="text-center align-middle">
                                    {{$product->price}}
                                </td>
                                <td scope="row" class="text-center align-middle">
                                    <span-component
                                            web-address="{{ route('admin.product.inventory', [$product->id]) }}"></span-component>
                                </td>

                                <td scope="row" class="text-center align-middle">
                                    <a href="{{ route('admin.product.edit', ['id' => $product->id]) }}"
                                       class="btn btn-sm btn-dark"
                                       data-toggle="tooltip" data-placement="top" title="ویرایش کالا"><i
                                                class="fa fa-edit"></i></a>
                                    <form method="post" class="d-inline"
                                          action="{{ route('admin.product.delete',['id' => $product->id]) }}"
                                          style="display:inline;">
                                        @csrf
                                        @method('delete')
                                        <button onclick="return confirm('آیا از عملیات حذف اطمینان دارید؟')"
                                                class="btn btn-danger btn-sm btn-mobile"
                                                data-toggle="tooltip" data-placement="top" title="حذف کالا"><i
                                                    class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection