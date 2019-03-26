@extends('layouts.app')
@section('title', 'کالاها - ')
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
                    <li class="breadcrumb-item active" aria-current="page"><a
                                href="{{ route('admin.product') }}">کالاها</a></li>
                </ol>
            </nav>
            <div id="accordion">
                <div class="card card-info mb-2">
                    <div data-toggle="collapse" href="#collapseOne" class="card-header collapsed" aria-expanded="false">
                        <i class="fa fa-arrow-circle-left"></i> جستجو
                    </div>
                    <div id="collapseOne" data-parent="#accordion" class="card-body collapse" style="">
                        <form method="GET" action="{{ route('admin.category') }}">
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
                <div class="card-header">کالاها
                    <a href="{{route('admin.product.create')}}" class="btn btn-primary btn-sm pull-left"><i
                                class="fa fa-plus-circle"></i>کالا جدید</a>
                </div>

                <div class="card-body">
                    @include('global.top-table-options',['route' => 'admin.product.export'])
                    @if($products->count())
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
                                    @if($product->sale_price == 0)
                                        رایگان
                                    @else
                                        {{ \App\Utils\MoneyUtil::format($product->sale_price) }}
                                    @endif
                                </td>
                                <td scope="row" class="text-center align-middle">
                                    <span-component web-address="{{ route('admin.product.inventory', [$product->id]) }}"></span-component>
                                </td>

                                <td scope="row" class="text-center align-middle">
                                    @if($product->factory)
                                        <a href="{{ route('admin.product.factory', ['id' => $product->id]) }}"
                                           class="btn btn-sm btn-success"
                                           data-toggle="tooltip" data-placement="top" title="تنظیمات سازنده"><i
                                                    class="fa fa-gear"></i></a>
                                    @endif

                                    <a href="{{ route('admin.product.attribute', ['id' => $product->id]) }}"
                                       class="btn btn-sm btn-primary"
                                       data-toggle="tooltip" data-placement="top" title="مشخصات محصول"><i
                                                class="fa fa-cogs"></i></a>

                                    <a href="{{ route('admin.product.file', ['id' => $product->id]) }}"
                                       class="btn btn-sm btn-warning"
                                       data-toggle="tooltip" data-placement="top" title="فایل های محصول"><i
                                                class="fa fa-files-o"></i></a>
                                    <a href="{{ route('admin.product.image', ['id' => $product->id]) }}"
                                       class="btn btn-sm btn-info"
                                       data-toggle="tooltip" data-placement="top" title="تصاویر محصول"><i
                                                class="fa fa-file-image-o"></i></a>
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
                    @else
                        <div class="alert-warning alert">{{ trans('platform.no-result') }}</div>
                    @endif
                    @include('global.pagination',['items' => $products])
                </div>
            </div>
        </div>
    </div>
@endsection