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
    <div class="row justify-content-center mb-2">
        @foreach($products as $product)
            <div class="{{ config('platform.product-card-class') }}">
                <div class="card mb-2">
                    <img class="card-img-top" src="{{ Storage::url($product->image) }}" alt="{{ $product->title }}"
                         style="width:100%">
                    <div class="card-body">
                        <h4 class="card-title"><a
                                    href="{{ route('product.view',['id'=>$product->id]) }}">{{$product->title}}</a></h4>
                        <p class="card-text">
                            @if($product->sale_price != 0)
                                قیمت:
                                <strong>{{ \App\Utils\MoneyUtil::format($product->sale_price) }}</strong> {{ trans('currency.'.config('platform.currency')) }}
                            @else
                                <strong>رایگان</strong>
                            @endif
                            <br/>
                            {{ $product->description }}
                        </p>
                        <div class="row">
                            <div class="col">
                                <a href="{{ route('product.view',['id'=>$product->id]) }}" class="btn btn-danger btn-block btn-sm">
                                    <i class="fa fa-eye"></i> مشاهده
                                </a>
                            </div>
                            <div class="col">
                                <a href="{{ route('cart.add',['id'=>$product->id]) }}" class="btn btn-warning btn-block btn-sm">
                                    <i class="fa fa-cart-plus"></i> خرید
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
    .
@endsection

@section('js')

@endsection
