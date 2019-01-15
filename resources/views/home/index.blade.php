@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12 mb-2">
            <h1>{{ config('platform.name') }}
                <small class="text-muted">{{ $page->description }}</small>
                @if(Auth::check())
                    @can('admin')
                        <a href="{{ route('admin.page.edit',['id' => $page->id])  }}"
                           class="btn btn-primary pull-left btn-sm"><i class="fa fa-edit"></i> ویرایش صفحه</a>
                    @endcan
                @endif
            </h1>
        </div>
    </div>
    <div class="row justify-content-center mb-2">
        <div class="col-md-12">
            <div id="demo" class="carousel slide" data-ride="carousel">

                <!-- Indicators -->
                <ul class="carousel-indicators">
                    <li data-target="#demo" data-slide-to="0" class="active"></li>
                    <li data-target="#demo" data-slide-to="1"></li>
                    <li data-target="#demo" data-slide-to="2"></li>
                </ul>

                <!-- The slideshow -->
                <div class="carousel-inner">
                    <div class="carousel-item active rounded-2">
                        <img src="https://www.w3schools.com/bootstrap4/ny.jpg" alt="Los Angeles">
                    </div>
                    <div class="carousel-item  rounded-2">
                        <img src="https://www.w3schools.com/bootstrap4/chicago.jpg" alt="Chicago">
                    </div>
                    <div class="carousel-item  rounded-2">
                        <img src="https://www.w3schools.com/bootstrap4/ny.jpg" alt="New York">
                    </div>
                </div>

                <!-- Left and right controls -->
                <a class="carousel-control-prev" href="#demo" data-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </a>
                <a class="carousel-control-next" href="#demo" data-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </a>

            </div>
        </div>
    </div>
    @if(config('platform.index-page-content-enabled'))
    <div class="row justify-content-center">
        <div class="col-md-12 mb-2">
            <div class="card card-default">
                <div class="card-header">{{ $page->title }}</div>

                <div class="card-body">
                    {!! $page->text !!}
                </div>
            </div>
        </div>
    </div>
    @endif
    <h2>فروش ویژه</h2>
    <div class="row justify-content-center mb-2">
        <div class="col-md-12">
            <div class="row">
                @foreach($products as $product)
                    @include('product.card',['product'=> $product,'size' => 'col-md-3'])
                @endforeach
            </div>
        </div>
    </div>

    <div class="row justify-content-center mb-2">
        <div class="col-md-6 mb-2">
            <div class="card card-default">
                <div class="card-header">
                    آخرین اخبار
                </div>
                <ul class="list-group list-group-flush">
                    @foreach($articles as $article)
                        <a href="{{route('article.slug', ['id'=>$article->id,'slug' => $article->slug])}}"
                           class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">{{$article->title}}</h5>
                                <small>انتشار:{{ jdate($article->created_at)->format('Y/m/d') }}</small>
                            </div>
                        </a>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="col-md-6 mb-2">
            <div class="card card-default">
                <div class="card-header">
                    مباحث انجمن
                </div>
                <ul class="list-group list-group-flush">
                    @foreach($discussions as $discussion)
                        <a href="{{route('discussion.view', ['id'=>$discussion->id])}}"
                           class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">{{$discussion->title}}</h5>
                                <small>بروز رسانی:{{ jdate($discussion->updated_at)->format('Y/m/d') }}</small>
                            </div>
                        </a>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <h2>دسته بندی ها</h2>
    <div class="row justify-content-center">

    </div>
    @include('global.logo')

@endsection

@section('js')

@endsection
