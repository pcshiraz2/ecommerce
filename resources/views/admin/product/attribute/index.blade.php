@extends('layouts.app')
@section('title', 'مشخصات ' .$product->title . " - ")
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
                    <li class="breadcrumb-item"><a href="{{ route('admin.product') }}">کالاها</a></li>
                    <li class="breadcrumb-item active" aria-current="page">مشخصات {{$product->title}}</li>
                </ol>
            </nav>
            <div class="card card-default">
                <div class="card-header">مشخصات {{$product->title}}
                    <a data-toggle="tooltip" data-placement="top" title="مشخصه جدید" href="{{route('admin.product.attribute.create',[$product->id])}}" class="btn btn-primary btn-sm pull-left"><i
                                class="fa fa-plus-circle"></i></a>
                    <a data-toggle="tooltip" data-placement="top" title="مدیریت مشخصات" href="{{route('admin.attribute')}}" class="btn btn-info btn-sm pull-left"><i
                                class="fa fa-cogs"></i></a>
                </div>

                <div class="card-body">

                    <table class="table table-striped table-bordered table-hover two-axis">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col" class="text-center">عنوان</th>
                            <th scope="col" class="text-center">مقدار</th>
                            <th scope="col" class="text-center">اقدام ها</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($product->attributes as $attribute)
                            <tr>
                                <td scope="row" class="text-center align-middle">{{$attribute->attribute->title}}</td>
                                <td scope="row" class="text-center align-middle">{{$attribute->value}}</td>
                                <td scope="row" class="text-center align-middle">
                                    <a href="{{ route('admin.product.attribute.edit', ['id' => $attribute->id]) }}"
                                       class="btn btn-sm btn-dark"
                                       data-toggle="tooltip" data-placement="top" title="ویرایش مشخصه"><i
                                                class="fa fa-edit"></i></a>
                                    <form method="post" class="d-inline"
                                          action="{{ route('admin.product.attribute.delete',['id' => $attribute->id]) }}"
                                          style="display:inline;">
                                        @csrf
                                        @method('delete')
                                        <button onclick="return confirm('آیا از عملیات حذف اطمینان دارید؟')"
                                                class="btn btn-danger btn-sm btn-mobile"
                                                data-toggle="tooltip" data-placement="top" title="حذف مشخصه"><i
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
