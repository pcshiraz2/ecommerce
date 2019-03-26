@extends('layouts.app')

@section('title', 'مشخصه ها - ')
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
                    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('admin.attribute') }}">مشخصه
                            ها</a></li>
                </ol>
            </nav>

            <div class="card card-default">
                <div class="card-header">مشخصه ها
                    <a href="{{route('admin.attribute.create')}}" class="btn btn-primary btn-sm pull-left"><i
                                class="fa fa-plus-circle"></i>ایجاد مشخصه جدید</a>
                </div>

                <div class="card-body">
                        <table class="table table-striped table-bordered table-hover two-axis">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">@sortablelink('title', 'عنوان')</th>
                                <th scope="col">نوع</th>
                                <th scope="col">اقدام ها</th>
                            </tr>
                            </thead>
                            @foreach($attributes as $attribute)
                                <tr>
                                    <td>{{ $attribute->title }}</td>
                                    <td>{{ $attribute->category->title }}</td>
                                    <td>
                                        <a href="{{ route('admin.attribute.edit', ['id' => $attribute->id]) }}"
                                           class="btn btn-sm btn-dark"
                                           data-toggle="tooltip" data-placement="top" title="ویرایش مشخصه"><i
                                                    class="fa fa-edit"></i></a>
                                        <form method="post" class="d-inline"
                                              action="{{ route('admin.attribute.delete',['id' => $attribute->id]) }}"
                                              style="display:inline;">
                                            @csrf
                                            @method('delete')
                                            <button onclick="return confirm('آیا از عملیات حذف اطمینان دارید؟')"
                                                    class="btn btn-danger btn-sm"
                                                    data-toggle="tooltip" data-placement="top" title="حذف مشخصه"><i
                                                        class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @include('global.pagination',['items' => $attributes])
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')

@endsection
