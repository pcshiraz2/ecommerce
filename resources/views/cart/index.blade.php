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
                    @if(Auth::check())
                        @can('products')
                            <a href="{{ route('cart.empty') }}"
                               data-toggle="tooltip" data-placement="top" title="حذف همه آیتم ها از سبد خرید"
                               class="btn btn-danger pull-left"><i class="fa fa-trash-o"></i></a>
                        @endcan
                    @endif
                    @if(Cart::getTotal() != 0)
                        <a href="{{ route('cart.information')  }}" class="btn btn-warning pull-left"><i
                                    class="fa fa-user-circle-o"></i>تکمیل اطلاعات</a>
                    @endif
                </div>
            </div>
            @if(Cart::getContent()->count())
            <div class="list-group mb-2">
                @foreach(Cart::getContent() as $product)
                    <div class="list-group-item list-group-item-action flex-column align-items-start">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1"><a href="{{ route('product.view',['id'=>$product->id]) }}">{{$product->name}}</a></h5>
                            <small>
                                <a href="{{ route('cart.add',['id'=>$product->id]) }}"
                                   data-toggle="tooltip" data-placement="top" title="افزودن یک عدد از کالا"
                                   class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                                <a href="{{ route('cart.remove',['id'=>$product->id, $product->rowId]) }}"
                                   data-toggle="tooltip" data-placement="top" title="کاهش  یک عدد از کالا"
                                   class="btn btn-danger btn-sm"><i class="fa fa-minus"></i></a>
                            </small>
                        </div>
                        <p class="mb-1">
                            قیمت واحد:{{number_format($product->attributes->sale_price)}}{{ trans('currency.'.config('platform.currency')) }}
                            <br/>

                            @if($product->attributes->discount)
                                <strong>
                            قیمت با تخفیف:{{number_format($product->attributes->discount_price)}}{{ trans('currency.'.config('platform.currency')) }}
                                </strong>
                                <br/>
                                تخفیف:{{number_format($product->attributes->discount)}} {{ trans('currency.'.config('platform.currency')) }}
                                <br/>
                            @endif
                            @if($product->attributes->tax)
                                مالیات و عوارض:{{ \App\Utils\MoneyUtil::format($product->attributes->tax)}} {{ trans('currency.'.config('platform.currency')) }}
                                <br/>
                            @endif

                            تعداد:{{\App\Utils\MoneyUtil::format($product->quantity)}}
                            <br/>

                            جمع:{{\App\Utils\MoneyUtil::format($product->price * $product->quantity)}}{{ trans('currency.'.config('platform.currency')) }}
                        </p>
                        <small>{{$product->attributes->description}}</small>
                    </div>
                @endforeach
            </div>
            @else
                <div class="alert alert-info">
                    <i class="fa fa-info-circle"></i>
                    شما هنوز کالایی انتخاب نکردید.
                </div>

            @endif
            <div class="row mt-2">
                <div class="col-md-8">
                    <div class="alert alert-dark"><strong>جمع کل حروف:</strong>{{ \App\Utils\MoneyUtil::letters(Cart::getTotal()) }} {{ trans('currency.'.config('platform.currency')) }}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="alert alert-dark">
                        <strong>جمع کل عدد:</strong>{{ \App\Utils\MoneyUtil::format(Cart::getTotal()) }} {{ trans('currency.'.config('platform.currency')) }}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
