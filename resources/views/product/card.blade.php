<div class="{{ isset($size) ? $size : config('platform.product-card-class') }}">
    <div class="card card-product mb-2" onclick="window.location='{{ route('product.view.slug',['id' => $product->id, 'slug'=> $product->slug]) }}'">
        @if($product->sale_price == 0)
            <span class="h6 w-70 mx-auto px-2 py-1 rounded-bottom bg-danger text-white shadow text-center"
                  style="position: absolute;right: 35%;"><i class="fa fa-free-code-camp"></i> رایگان</span>
        @elseif($product->discount)
            <span class="h6 w-70 mx-auto px-2 py-1 rounded-bottom bg-primary text-white shadow text-center"
                  style="position: absolute;right: 35%;"><i class="fa fa-star"></i> فروش ویژه</span>
        @endif
        <img class="card-img-top" title="{{$product->title}}" src="{{ Storage::url($product->image) }}" alt="image"
             style="width:100%">
        <div class="card-body">

            <h4 class="card-title text-center">
                {{$product->title}}
            </h4>

                    <p class="card-text">
                    @if($product->shop)
                        @if($product->call_price)
                            <div class="card-price-free"><strong>تماس بگیرید</strong></div>
                        @else
                            @if($product->sale_price == 0)
                                <div class="card-price-free"><strong>رایگان</strong></div>
                            @else
                                @if($product->discount)
                                    <del class="clearfix card-price-del">{{ \App\Utils\MoneyUtil::format($product->sale_price) }}</del>
                                    <strong class="clearfix card-price-discount">{{ \App\Utils\MoneyUtil::format($product->discount_price) }}  {{ trans('currency.'.config('platform.currency')) }}</strong>
                                @else
                                    <strong class="clearfix card-price">{{ \App\Utils\MoneyUtil::format($product->sale_price) }}  {{ trans('currency.'.config('platform.currency')) }}</strong>
                                    @endif

                            @endif
                        @endif
                   @else
                        <strong class="card-price-stop">ناموجود</strong>
                   @endif

                    </p>

                @if($product->shop)
                    @if($product->call_price)
                            <div class="clearfix">
                                <button data-toggle="tooltip" data-placement="top" title="{{ config('platform.contact-phone') }}"
                                        class="btn btn-info btn-mobile btn-sm pull-left">
                                    <i class="fa fa-phone-square"></i> تماس
                                </button>
                            </div>
                    @else
                            <div class="clearfix">
                                <a href="{{ route('cart.add',['id'=>$product->id]) }}"
                                   class="btn btn-warning btn-mobile btn-sm pull-left">
                                    <i class="fa fa-cart-plus"></i> خرید
                                </a>
                            </div>
                    @endif

                @else
                    <div class="clearfix">
                        <button data-toggle="tooltip" data-placement="top" title="متاسفانه این کالا در انبار وجود ندارد."
                                class="btn btn-danger btn-mobile btn-sm pull-left">
                            <i class="fa fa-info-circle"></i> اطلاعات کالا
                        </button>
                    </div>
                @endif
        </div>
    </div>
</div>