@extends('layouts.app')

@section('title', 'دسته ها - ')
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
                                <select name="types[]" id="types" class="form-control" multiple>
                                    @foreach(trans('category') as $key => $type)
                                        <option value="{{ $key }}" {{ old('type') == $key ? ' selected' : '' }}>{{ $type }}</option>
                                    @endforeach
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
                    @if($categories->count())
                    <table class="table table-striped table-bordered table-hover two-axis">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">@sortablelink('title', 'عنوان')</th>
                            <th scope="col">نوع</th>
                            <th scope="col">@sortablelink('order', 'ترتیب')</th>
                            <th scope="col">اقدام ها</th>
                        </tr>
                        </thead>
                        @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->title }}</td>
                            <td>{{ trans('category.'.$category->type) }}</td>
                            <td>{{ $category->order }}</td>
                            <td>
                                <a href="{{ route('admin.category.edit', ['id' => $category->id]) }}"
                                   class="btn btn-sm btn-dark"
                                   data-toggle="tooltip" data-placement="top" title="ویرایش دسته"><i
                                            class="fa fa-edit"></i></a>
                                <form method="post" class="d-inline"
                                      action="{{ route('admin.category.delete',['id' => $category->id]) }}"
                                      style="display:inline;">
                                    @csrf
                                    @method('delete')
                                    <button onclick="return confirm('آیا از عملیات حذف اطمینان دارید؟')"
                                            class="btn btn-danger btn-sm"
                                            data-toggle="tooltip" data-placement="top" title="حذف دسته"><i
                                                class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    @else
                        <div class="alert-warning alert">{{ trans('platform.no-result') }}</div>
                    @endif
                    @include('global.pagination',['items' => $categories])
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')

@endsection
