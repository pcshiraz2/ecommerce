@extends('layouts.app')
@section('title', 'فروشگاه - ')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ config('platform.name') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('cart') }}">سبد خرید</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a
                                href="{{ route('cart.order') }}">فروشگاه</a></li>
                </ol>
            </nav>
            <div class="row mb-2">
                <div class="col-md-3 mb-2">
                    <div class="list-group">
                        @foreach($categories as $category)
                            <a class="list-group-item list-group-item-action{{ (Request::segment(2) == 'category' && Request::segment(3) == $category['id']) ? ' active' : '' }}"
                               href="{{ route('cart.category',['id'=>$category['id']]) }}"><i
                                        class="{{ $category['icon'] }}"></i> {{ $category['title'] }}</a>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="list-group mb-2">
                        @foreach($products as $product)

                            <div class="list-group-item list-group-item-action flex-column align-items-start">
                                <div class="row">
                                    <div class="col-6">
                                        <h5 class="mb-1">{{$product->title}}</h5>
                                        <strong>قیمت واحد:{{number_format($product->sale_price)}} تومان</strong>
                                        <br/>
                                        <small>{{$product->description}}</small>
                                    </div>
                                    <div class="col-6 align-middle text-center my-auto align-self-center">
                                        <form action="{{ route('cart.add-cart') }}" method="post" class="form-inline">
                                            @csrf
                                            @method('post')
                                            <input type="hidden" id="id" value="{{$product->id}}" name="id">
                                            <label for="qty" class="mb-1">مقدار:</label>
                                            <input type="text" name="qty" dir="ltr"
                                                   class="form-control form-control-sm mb-1" id="qty"
                                                   placeholder="مقدار">
                                            <button type="submit" class="btn btn-primary btn-sm mb-1 mr-1"><i
                                                        class="fa fa-cart-plus" aria-hidden="true"></i> ثبت سفارش
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            </form>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
