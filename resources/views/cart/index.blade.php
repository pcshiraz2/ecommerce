@extends('layouts.app')
@section('title', 'سبد خرید - ')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ config('platform.name') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('cart') }}">سبد خرید</a>
                    </li>
                </ol>
            </nav>
            <div class="row mb-2">

                <div class="col-md-12">
                    <a href="{{ route('product')  }}" class="btn btn-primary pull-right"><i
                                class="fa fa-shopping-basket"></i> ادامه خرید</a>
                    @if(Cart::total() != 0)
                        <a href="{{ route('cart.information')  }}" class="btn btn-warning pull-left"><i
                                    class="fa fa-user-circle-o"></i>تکمیل اطلاعات</a>
                    @endif
                </div>
            </div>
            <div class="list-group mb-2">
                @foreach(Cart::content() as $product)
                    <div class="list-group-item list-group-item-action flex-column align-items-start">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">{{$product->name}}</h5>
                            <small>
                                <a href="{{ route('cart.add',['id'=>$product->id]) }}"
                                   data-toggle="tooltip" data-placement="top" title="افزودن یک عدد از کالا"
                                   class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                                <a href="{{ route('cart.remove',['id'=>$product->id, $product->rowId]) }}"
                                   data-toggle="tooltip" data-placement="top" title="کاهش  یک عدد از کالا"
                                   class="btn btn-danger btn-sm"><i class="fa fa-minus"></i></a>
                            </small>
                        </div>
                        <p class="mb-1">قیمت
                            واحد:{{number_format($product->price)}}{{ trans('currency.'.config('platform.currency')) }}
                            <br/>
                            تعداد:{{number_format($product->qty)}}
                            <br/>
                            جمع:{{number_format($product->price * $product->qty)}}{{ trans('currency.'.config('platform.currency')) }}
                        </p>
                        <small>{{$product->options->description}}</small>
                    </div>
                @endforeach
            </div>
            <div class="row mt-2">
                <div class="col-md-8">
                </div>
                <div class="col-md-4">
                    <div class="alert alert-info"><strong>جمع
                            کل:</strong>{{ number_format(Cart::total()) }} {{ trans('currency.'.config('platform.currency')) }}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
