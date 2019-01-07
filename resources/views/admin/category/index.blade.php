@extends('layouts.app')

@section('title', 'دسته ها - ')
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
                    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('admin.category') }}">دسته
                            ها</a></li>
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
                                <label for="search">عنوان:</label>
                                <input name="search" id="search" type="text" class="form-control" value="{{ request('search') }}">
                            </div>
                            <div class="form-group">
                                <label for="types">دسته:</label>
                                <select name="types[]" id="types" multiple>
                                    <option value="Product">Product</option>
                                    <option value="Income">Income</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-mobile btn-sm"><i class="fa fa-search"></i>ارسال
                                جستجو
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card card-default">
                <div class="card-header">دسته ها
                    <a href="{{route('admin.category.create')}}" class="btn btn-primary btn-sm pull-left"><i
                                class="fa fa-plus-circle"></i>ایجاد دسته جدید</a>
                </div>

                <div class="card-body">
                    @include('global.top-table-options',['route' => 'admin.category.export'])
                    <table class="table table-striped table-bordered table-hover two-axis">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">عنوان</th>
                            <th scope="col">نوع</th>
                            <th scope="col">اقدام ها</th>
                        </tr>
                        </thead>
                        @foreach($categories as $category)
                        <tr>
                            <th>{{ $category->title }}</th>
                            <th>{{ $category->type }}</th>
                            <th>
                                <a href="{{ route('admin.category.edit',['id' => $category->id]) }}" class="btn btn-sm btn-dark"><i class="fa fa-edit"></i> ویرایش</a>
                                <form method="post" action="{{ route('admin.category.delete',['id' => $category->id]) }}" style="display:inline;">
                                    @csrf
                                    @method('delete')
                                    <button onclick="return confirm('آیا از عملیات حذف اطمینان دارید؟')" class="btn btn-danger btn-sm btn-mobile"><i
                                                class="fa fa-trash"></i> حذف
                                    </button>
                                </form>
                            </th>
                        </tr>
                        @endforeach
                        <tfoot class="thead-dark">
                        <tr>
                            <th>عنوان</th>
                            <th>نوع</th>
                            <th>اقدام ها</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')

@endsection
