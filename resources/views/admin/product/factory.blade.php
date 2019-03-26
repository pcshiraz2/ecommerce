@extends('layouts.app')
@section('title', 'تنظیمات سازنده ' .$product->title . " - ")
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
                    <li class="breadcrumb-item"><a href="{{ route('admin.product') }}">کالاها</a></li>
                    <li class="breadcrumb-item active" aria-current="page">تنظیمات سازنده {{$product->title}}</li>
                </ol>
            </nav>
            <div class="card card-default">
                <div class="card-header">تنظیمات سازنده {{$product->title}}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.product.factory', [$product->id]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        @include('factories.'.strtolower($product->factory).'.product',['product' => $product])
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-gear"></i>
                            ذخیره تنظیمات
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

