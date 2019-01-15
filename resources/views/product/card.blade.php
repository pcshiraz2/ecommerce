<div class="{{ isset($size) ? $size : config('platform.product-card-class') }}">
    <div class="card mb-2">
        @if($product->sale_price == 0)
            <span class="h6 w-70 mx-auto px-2 py-1 rounded-bottom bg-danger text-white shadow text-center" style="position: absolute;right: 35%;"><i class="fa fa-free-code-camp"></i> رایگان</span>
        @elseif($product->off)
            <span class="h6 w-70 mx-auto px-2 py-1 rounded-bottom bg-info text-white shadow text-center" style="position: absolute;right: 35%;"><i class="fa fa-star"></i> فروش ویژه</span>
        @endif
        <img class="card-img-top" src="{{ Storage::url($product->image) }}" alt="image"
             style="width:100%">
        <div class="card-body">

            <h4 class="card-title"><a
                        href="{{ route('product.view',['id'=>$product->id]) }}">{{$product->title}}</a>
            </h4>

            <p class="card-text">

                @if($product->sale_price == 0)
                    <strong>رایگان</strong>
                @else
                        @if($product->off)
                            <del>{{ \App\Utils\MoneyUtil::format($product->sale_price) }}</del>
                            <strong>{{ \App\Utils\MoneyUtil::format($product->off_price) }}</strong> {{ trans('currency.'.config('platform.currency')) }}
                        @else
                            قیمت:
                            <strong>{{ \App\Utils\MoneyUtil::format($product->sale_price) }}</strong> {{ trans('currency.'.config('platform.currency')) }}
                        @endif
                @endif

                {{$product->description}}</p>
            <div class="row">
                <div class="col-12 clearfix">
                    <a href="{{ route('cart.add',['id'=>$product->id]) }}" class="btn btn-warning btn-mobile btn-sm pull-left">
                        <i class="fa fa-cart-plus"></i> خرید
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>