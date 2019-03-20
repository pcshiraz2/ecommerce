@extends('layouts.app')
@section('title', 'فایل های ' .$product->title . " - ")
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
                    <li class="breadcrumb-item active" aria-current="page">فایل های {{$product->title}}</li>
                </ol>
            </nav>
            <div class="card card-default">
                <div class="card-header">فایل های {{$product->title}}
                    <a href="{{route('admin.product.file.create',[$product->id])}}" class="btn btn-primary btn-sm pull-left"><i
                                class="fa fa-plus-circle"></i>فایل جدید</a>
                </div>

                <div class="card-body">

                    <table class="table table-striped table-bordered table-hover two-axis">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col" class="text-center">عنوان</th>
                            <th scope="col" class="text-center">نام</th>
                            <th scope="col" class="text-center">حجم</th>
                            <th scope="col" class="text-center">اقدام ها</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($product->files as $file)
                            <tr>
                                <td scope="row" class="text-center align-middle">{{$file->title}}</td>
                                <td scope="row" class="text-center align-middle">{{$file->name}}</td>
                                <td scope="row" class="text-center align-middle">{{$file->size}}</td>

                                <td scope="row" class="text-center align-middle">
                                    <a href="{{ route('admin.product.file.edit', ['id' => $file->id]) }}"
                                       class="btn btn-sm btn-dark"
                                       data-toggle="tooltip" data-placement="top" title="ویرایش فایل"><i
                                                class="fa fa-edit"></i></a>
                                    <form method="post" class="d-inline"
                                          action="{{ route('admin.product.file.delete',['id' => $file->id]) }}"
                                          style="display:inline;">
                                        @csrf
                                        @method('delete')
                                        <button onclick="return confirm('آیا از عملیات حذف اطمینان دارید؟')"
                                                class="btn btn-danger btn-sm btn-mobile"
                                                data-toggle="tooltip" data-placement="top" title="حذف فایل"><i
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
    <script>

    </script>
@endsection
