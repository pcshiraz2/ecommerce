@extends('layouts.app')

@section('title', "فروشگاه - ")

@section('css')

@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ config('platform.name') }}</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('product') }}">فروشگاه</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a
                                href="{{ route('product.category', $category->id) }}">{{ $category->title }}</a></li>
                </ol>
            </nav>
            <h1>{{ $category->title }}
                @if(Auth::check())
                    @can('products')
                        <a href="{{ route('admin.product.create')  }}" class="btn btn-primary pull-left btn-sm"><i
                                    class="fa fa-plus"></i>افزودن کالا</a>
                    @endcan
                @endif
            </h1>
            <div class="row justify-content-center">
                <div class="col-md-{{ config('platform.sidebar-size') }}">
                    @include('product.sidebar',['categories'=>$categories])
                </div>
                <div class="col-md-{{ config('platform.content-size') }}">
                    <div class="row">
                        @foreach($products as $product)
                            <div class="col-md-4 col-sm-6">
                                <div class="card mb-2">
                                    <img class="card-img-top" src="{{ Storage::url($product->image) }}" alt="image"
                                         style="width:100%">
                                    <div class="card-body">
                                        <h4 class="card-title"><a
                                                    href="{{ route('product.view',['id'=>$product->id]) }}">{{$product->title}}</a>
                                        </h4>
                                        <p class="card-text">
                                            @if($product->sale_price)
                                                قیمت:
                                                <strong>{{ \App\Utils\MoneyUtil::format($product->sale_price) }}</strong> {{ trans('currency.'.config('platform.currency')) }}
                                            @else
                                                <strong>رایگان</strong>
                                            @endif
                                            {{$product->description}}</p>
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
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection
