@extends('layouts.app')

@section('title', ' - ' . config('platform.home-page-title'))
@section('description', ' - ' . config('platform.home-page-description'))
@section('keywords', ' - ' . config('platform.home-page-keywords'))

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

            <div id="slides" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ul class="carousel-indicators">
                    @foreach($slides as $slide)
                        @if ($loop->first)
                            <li data-target="#slide_{{$loop->index}}" data-slide-to="{{$loop->index}}" class="active"></li>
                        @else
                            <li data-target="#slide_{{$loop->index}}" data-slide-to="{{$loop->index}}"></li>
                        @endif
                    @endforeach
                </ul>

                <!-- The slideshow -->
                <div class="carousel-inner">
                    @foreach($slides as $slide)
                        @if ($loop->first)
                            <a href="{{$slide->link}}" class="carousel-item active">
                                <img src="{{ Storage::url($slide->image) }}" alt="{{$slide->title}}" title="{{$slide->title}}" class="rounded">
                            </a>
                        @else
                            <a href="{{$slide->link}}" class="carousel-item">
                                <img src="{{ Storage::url($slide->image) }}" alt="{{$slide->title}}" title="{{$slide->title}}" class="rounded">
                            </a>
                        @endif
                    @endforeach
                </div>

                <!-- Left and right controls -->
                <a class="carousel-control-prev" href="#slides" data-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </a>
                <a class="carousel-control-next" href="#slides" data-slide="next">
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

    <h2>پیشنهاد های شگفت انگیز</h2>
    <div class="row justify-content-center mb-2">
                @foreach($discountProducts as $product)
                    @include('product.card',['product'=> $product,'size' => 'col-md-3'])
                @endforeach

    </div>

    <h2>کالاهای جدید</h2>
    <div class="row justify-content-center mb-2">
            @foreach($newProducts as $product)
                @include('product.card',['product'=> $product,'size' => 'col-md-3'])
            @endforeach
    </div>

    <h2>کالاهای اصلی</h2>
    <div class="row justify-content-center mb-2">
            @foreach($topProducts as $product)
                @include('product.card',['product'=> $product,'size' => 'col-md-3'])
            @endforeach
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
    @include('global.logo')

@endsection

@section('js')

@endsection
