@extends('layouts.app')

@section('title', $product->title . "-")

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ config('platform.name') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('product') }}">فروشگاه</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a
                                href="{{ route('product.view',['id' => $product->id]) }}">{{ $product->title }}</a></li>
                </ol>
            </nav>
            <div class="row">
                <div class="col-md-12">
                    <h1>{{ $product->title }}
                        <small class="text-muted">{{ $product->description }}</small>
                        @if(Auth::check())
                            @can('products')
                                <div class="btn-group pull-left mb-1" role="group" aria-label="Basic example">
                                    <a href="{{ route('admin.product.edit',['id' => $product->id])  }}"
                                       class="btn btn-mobile btn-primary btn-sm"><i class="fa fa-edit"></i> ویرایش کالا</a>
                                    <button type="button" onclick="$('#deleteProduct').toggle();"
                                            class="btn btn-mobile btn-danger btn-sm"><i class="fa fa-trash-o"></i> حذف
                                        کالا
                                    </button>
                                    <a type="button"
                                       href="{{ route('admin.product.image.create',['id' => $product->id]) }}"
                                       class="btn btn-mobile btn-dark btn-sm"><i class="fa fa-file-image-o"></i> افزودن
                                        تصویر</a>
                                    <a type="button"
                                       href="{{ route('admin.product.file.create',['id' => $product->id]) }}"
                                       class="btn btn-mobile btn-info btn-sm"><i class="fa fa-files-o"></i> افزودن
                                        فایل</a>
                                </div>
                            @endcan
                        @endif
                    </h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-{{ config('platform.sidebar-size') }}">
                    @if($product->image)
                        <img class="card-img-top mb-2" src="{{ Storage::url($product->image) }}" title="{{$product->title}}"  alt="{{$product->title}}"
                             style="width:100%">
                    @endif
                        @if($product->sale_price != 0)
                            @if($product->shop)
                                    @if($product->call_price)
                                        <button class="btn btn-mobile btn-info btn-lg btn-block"><i class="fa fa-phone-square"></i> تماس:{{ config('platform.contact-phone') }}</button>

                                    @else
                                        <a href="{{ route('cart.add',['id' => $product->id]) }}"
                                           class="btn btn-mobile btn-warning btn-lg btn-block"><i class="fa fa-cart-plus"></i> خرید</a>

                                        @endif
                            @endif
                        @endif
                            <ul class="list-group mt-2">
                        <li class="list-group-item">
                            @if($product->shop)
                            @if($product->call_price)
                                <strong>استعلام قیمت تلفنی</strong>

                                @else

                                @if($product->sale_price)
                                        @if($product->sale_price != 0)
                                            قیمت:
                                            @if($product->discount)
                                                <del class="clearfix card-price-del">{{ \App\Utils\MoneyUtil::format($product->final_price) }}</del>
                                                <strong class="clearfix card-price-discount">{{ \App\Utils\MoneyUtil::format($product->final_discount) }}  {{ trans('currency.'.config('platform.currency')) }}</strong>
                                            @else
                                                <strong class="clearfix card-price">{{ \App\Utils\MoneyUtil::format($product->final_price) }}  {{ trans('currency.'.config('platform.currency')) }}</strong>
                                            @endif
                                        @else
                                            <strong>رایگان</strong>
                                        @endif
                                @else
                                    <strong>رایگان</strong>
                                @endif

                            @endif

                           @else

                            <strong>ناموجود</strong>
                            @endif
                        </li>
                    </ul>
                </div>

                <div class="col-md-{{ config('platform.content-size') }}">
                    @if(Auth::check())
                        @can('products')
                            <div class="alert alert-danger" id="deleteProduct" role="alert" style="display: none;">
                                <h4 class="alert-heading">حذف کالا</h4>
                                <p>آیا از حذف کالا اطمینان دارید؟</p>
                                <hr>
                                <p class="mb-0">
                                <form style="display: inline"
                                      action="{{ route('admin.product.delete',['id'=>$product->id]) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-sm btn-danger">حذف</button>

                                </form>
                                <button type="button" onclick="$('#deleteProduct').hide();" class="btn btn-sm btn-dark">
                                    لغو حذف
                                </button>
                                </p>
                            </div>
                        @endcan
                    @endif

                    <div class="card card-default">
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs" id="file-tabs" role="tablist">

                                <li class="nav-item"><a class="nav-link active" id="text" data-toggle="tab"
                                                        href="#product-text" role="tab" aria-controls="text"
                                                        aria-selected="true"><i class="fa fa-file-text"></i> توضیحات</a></li>

                                <li class="nav-item"><a class="nav-link" id="spec" data-toggle="tab"
                                                        href="#product-spec" role="tab" aria-controls="text"
                                                        aria-selected="true"><i class="fa fa-cogs"></i> مشخصات</a></li>

                                <li class="nav-item"><a class="nav-link" id="files" data-toggle="tab"
                                                        href="#product-files" role="tab" aria-controls="files"
                                                        aria-selected="false"><i class="fa fa-files-o"></i> فایل ها</a></li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="file-tabsContent">
                                <div class="tab-pane fade show active" id="product-text" role="tabpanel"
                                     aria-labelledby="text-tab">{!! $product->text  !!}</div>
                                <div class="tab-pane fade" id="product-spec" role="tabpanel"
                                     aria-labelledby="spec-tab">
                                    <i class="fa fa-cogs"></i> مشخصات
                                </div>
                                <div class="tab-pane fade" id="product-files" role="tabpanel"
                                     aria-labelledby="files-tab">
                                    فایل ها
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection

@section('js')

@endsection
