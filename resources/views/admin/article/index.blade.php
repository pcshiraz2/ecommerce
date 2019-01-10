@extends('layouts.app')
@section('title', 'مقاله ها - ')
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
                    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('admin.page') }}">مقاله
                            ها</a></li>
                </ol>
            </nav>
            <div id="accordion">
                <div class="card card-info mb-2">
                    <div data-toggle="collapse" href="#collapseOne" class="card-header collapsed" aria-expanded="false">
                        <i class="fa fa-arrow-circle-left"></i> جستجو
                    </div>
                    <div id="collapseOne" data-parent="#accordion" class="card-body collapse" style="">
                        <form method="GET" action="{{ route('admin.article') }}">
                            <div class="form-group">
                                <label for="search">عنوان</label>
                                <input name="search" id="search" type="text" class="form-control" value="{{ request('search') }}">
                            </div>
                            <button type="submit" class="btn btn-primary btn-mobile btn-sm"><i class="fa fa-search"></i>
                                جستجو
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card card-default">
                <div class="card-header">مقاله ها
                    <a href="{{route('admin.article.create')}}" class="btn btn-primary btn-sm pull-left"><i
                                class="fa fa-plus-circle"></i> ارسال مقاله جدید</a>
                </div>

                <div class="card-body">
                    @include('global.top-table-options',['route' => 'admin.page.export'])
                    @if($articles->count())
                        <table class="table table-hover table-striped table-bordered two-axis">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">@sortablelink('title', 'عنوان')</th>
                                <th scope="col">@sortablelink('created_at', 'زمان ارسال')</th>
                                <th scope="col">دسته</th>
                                <th scope="col">اقدام ها</th>
                            </tr>
                            </thead>
                            @foreach($articles as $article)
                            <tr>
                                <td>{{ $article->title }}</td>
                                <td>{{ \Morilog\Jalali\Jalalian::forge($article->created_at)->format('%A %d %B %Y') }}</td>
                                <td>{{ $article->category->title }}</td>
                                <td>
                                    <a href="{{ route('admin.article.edit', ['id' => $article->id]) }}"
                                       class="btn btn-sm btn-dark"
                                       data-toggle="tooltip" data-placement="top" title="ویرایش مقاله"><i
                                                class="fa fa-edit"></i></a>
                                    <form method="post" class="d-inline"
                                          action="{{ route('admin.article.delete',['id' => $article->id]) }}"
                                          style="display:inline;">
                                        @csrf
                                        @method('delete')
                                        <button onclick="return confirm('آیا از عملیات حذف اطمینان دارید؟')"
                                                class="btn btn-danger btn-sm"
                                                data-toggle="tooltip" data-placement="top" title="حذف مقاله"><i
                                                    class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                                @endforeach
                        </table>
                        @else
                        <div class="alert-warning alert">{{ trans('platform.no-result') }}</div>
                        @endif
                    @include('global.pagination',['items' => $articles])

                </div>
            </div>
        </div>
    </div>
@endsection
