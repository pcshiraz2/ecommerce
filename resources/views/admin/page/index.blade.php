@extends('layouts.app')
@section('title', 'صفحه ها - ')
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
                    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('admin.page') }}">صفحه
                            ها</a></li>
                </ol>
            </nav>
            <div id="accordion">
                <div class="card card-info mb-2">
                    <div data-toggle="collapse" href="#collapseOne" class="card-header collapsed" aria-expanded="false">
                        <i class="fa fa-arrow-circle-left"></i> جستجو
                    </div>
                    <div id="collapseOne" data-parent="#accordion" class="card-body collapse" style="">
                        <form method="GET" action="{{ route('admin.page') }}">
                            <div class="form-group">
                                <label for="search">کلمه کلیدی</label>
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
                <div class="card-header">صفحه ها
                    <a href="{{route('admin.page.create')}}" class="btn btn-primary btn-sm pull-left"><i
                                class="fa fa-plus-circle"></i> ایجاد صفحه جدید</a>
                </div>

                <div class="card-body">
                    @include('global.top-table-options',['route' => 'admin.page.export'])
                    @if($pages->count())
                    <table class="table table-hover table-striped table-bordered two-axis">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">@sortablelink('title', 'عنوان')</th>
                                <th scope="col">اقدام ها</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($pages as $page)
                            <tr>
                                <td scope="row" class="align-middle">
                                    {{$page->title}}
                                </td>
                                <td scope="row" class="align-middle">
                                    <a href="{{ route('admin.page.edit', ['id' => $page->id]) }}"
                                       class="btn btn-sm btn-dark"
                                       data-toggle="tooltip" data-placement="top" title="ویرایش صفحه"><i
                                                class="fa fa-edit"></i></a>
                                    <form method="post" class="d-inline"
                                          action="{{ route('admin.page.delete',['id' => $page->id]) }}"
                                          style="display:inline;">
                                        @csrf
                                        @method('delete')
                                        <button onclick="return confirm('آیا از عملیات حذف اطمینان دارید؟')"
                                                class="btn btn-danger btn-sm"
                                                data-toggle="tooltip" data-placement="top" title="حذف صفحه"><i
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
                    @include('global.pagination',['items' => $pages])
                </div>
            </div>
        </div>
    </div>
@endsection
