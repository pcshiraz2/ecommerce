@extends('layouts.app')

@section('title', "نتایج جستجو - ")

@section('css')

@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ config('platform.name') }}</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('product') }}">فروشگاه</a></li>
                    <li class="breadcrumb-item active" aria-current="page">نتایج جستجو "{{ request('search') }}"</li>
                </ol>
            </nav>
            <h1>نتایج جستجو "{{ request('search') }}"</h1>
            <div class="row justify-content-center">
                <div class="col-md-12">
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
                    @if($products->count())
                    <div class="row">
                        @foreach($products as $product)
                            @include('product.card',['product'=> $product, 'size' => 'col-md-3'])
                        @endforeach
                    </div>
                    @else
                        <div class="alert-warning alert">{{ trans('platform.no-result') }}</div>
                    @endif
                    @include('global.pagination',['items' => $products])
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection
