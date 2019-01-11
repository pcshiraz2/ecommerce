@extends('layouts.app')
@section('title', 'اطلاعات تکمیلی جهت خرید - ')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ config('platform.name') }}</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('cart') }}">سبد خرید</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('cart.information') }}">اطلاعات شما</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('cart.factory') }}">اطلاعات تکمیلی جهت خرید</a></li>
                </ol>
            </nav>
            <form action="{{ route('cart.store-factory') }}" method="post">
            @csrf
            <div class="row mb-2">
                <div class="col-md-12">
                    <a href="{{ route('product')  }}" class="btn btn-primary pull-right"><i
                                class="fa fa-shopping-basket"></i>ادامه خرید</a>
                    @if(Cart::total() != 0)
                        <button type="submit" class="btn btn-warning pull-left"><i
                                    class="fa fa-gears"></i> تکمیل خرید با مشخصات زیر</button>
                    @endif
                </div>
            </div>
            @if(Cart::count())
                    @foreach(Cart::content() as $product)
                        @for($i = 0;$i < $product->qty; $i++)
                            @include('factory.'.strtolower($product->options->factory).'.cart',['i' => $i,'product' => $product])
                        @endfor
                    @endforeach
            @else
                <div class="alert alert-info">
                    <i class="fa fa-info-circle"></i>
                    شما هنوز کالایی انتخاب نکردید.
                </div>

            @endif
            </form>
        </div>
    </div>
@endsection
