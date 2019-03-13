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
                    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('product') }}">فروشگاه</a>
                    </li>
                </ol>
            </nav>
            <h1>فروشگاه
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
                        <div class="col-md-12 mb-2">
                            <ul class="nav nav-pills justify-content-end">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#">جدید ترین</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">پرفروش ترین</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">ارزان ترین</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">گران ترین</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        @foreach($products as $product)
                            @include('product.card',['product'=> $product])
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
