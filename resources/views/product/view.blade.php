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
                                <div class="btn-group pull-left" role="group" aria-label="Basic example">
                                    <a href="{{ route('admin.product.edit',['id' => $product->id])  }}"
                                       class="btn btn-mobile btn-primary btn-sm"><i class="fa fa-edit"></i> ویرایش کالا</a>
                                    <button type="button" onclick="$('#deleteProduct').toggle();"
                                            class="btn btn-mobile btn-danger btn-sm"><i class="fa fa-trash-o"></i> حذف
                                        کالا
                                    </button>
                                    <a type="button"
                                       href="{{ route('admin.product.image.create',['id' => $product->id]) }}"
                                       class="btn btn-mobile btn-dark btn-sm"><i class="fa fa-plus"></i> افزودن
                                        تصویر</a>
                                </div>
                            @endcan
                        @endif
                    </h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    @if($product->image)
                        <img class="card-img-top mb-2" src="{{ Storage::url($product->image) }}" alt="image"
                             style="width:100%">
                    @endif
                    <a href="{{ route('cart.add',['id' => $product->id]) }}"
                       class="btn btn-mobile btn-warning btn-lg btn-block"><i class="fa fa-cart-plus"></i> خرید</a>
                    <ul class="list-group mt-2">
                        <li class="list-group-item">
                            @if($product->sale_price)
                                قیمت:
                                <strong>{{ \App\Utils\MoneyUtil::format($product->sale_price) }}</strong> {{ trans('currency.'.config('platform.currency')) }}
                            @else
                                <strong>رایگان</strong>
                            @endif
                        </li>
                    </ul>
                </div>

                <div class="col-md-9">
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
                                                        href="#file-text" role="tab" aria-controls="text"
                                                        aria-selected="true">توضیحات</a></li>
                                <li class="nav-item"><a class="nav-link" id="versions" data-toggle="tab"
                                                        href="#file-versions" role="tab" aria-controls="versions"
                                                        aria-selected="false">فایل ها</a></li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="file-tabsContent">
                                <div class="tab-pane fade show active" id="file-text" role="tabpanel"
                                     aria-labelledby="file-tab">{!! $product->text  !!}</div>
                                <div class="tab-pane fade" id="file-versions" role="tabpanel"
                                     aria-labelledby="versions-tab">

                                    </ul>
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
