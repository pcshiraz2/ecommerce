@extends('layouts.app')
@section('title', 'ویرایش کالا ' .$product->title . " - ")
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
                    <li class="breadcrumb-item active" aria-current="page">ویرایش کالا {{$product->title}}</li>
                </ol>
            </nav>
            <div class="card card-default">
                <div class="card-header">ویرایش کالا {{$product->title}}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.product.update',['id' => $product->id]) }}"
                          onsubmit="$('.price').unmask();" enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="image">تصویر</label>
                                    <div class="input-group mb-3">

                                        <div class="custom-file">
                                            <input name="image" type="file"
                                                   class="custom-file-input{{ $errors->has('image') ? ' is-invalid' : '' }}"
                                                   id="image" aria-describedby="imageSelect">
                                            <label class="custom-file-label" for="imageSelect">انتخاب فایل</label>
                                        </div>
                                    </div>
                                    @if ($errors->has('image'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('image') }}</strong>
                                        </span>
                                    @endif
                                    <img id="previewSource" style="width: 225px;height: 225px;"
                                         src="{{ Storage::url($product->image) }}"
                                         alt="تصویر شما"/>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="title">عنوان</label>
                                    <input id="title" type="text"
                                           class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                           name="title" value="{{ old('title', $product->title) }}" required autofocus>
                                    @if ($errors->has('title'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>



                                <div class="form-group">
                                    <label for="sale_price">قیمت فروش</label>
                                    <div class="input-group mb-2 ml-sm-2">
                                        <input id="sale_price" type="tel" dir="ltr"
                                               class="price form-control{{ $errors->has('sale_price') ? ' is-invalid' : '' }}"
                                               name="sale_price" value="{{ old('sale_price',\App\Utils\MoneyUtil::display($product->sale_price)) }}" required>
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">{{ trans('currency.'.config('platform.currency')) }}</div>
                                        </div>
                                    </div>
                                    @if ($errors->has('sale_price'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('sale_price') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="purchase_price">قیمت خرید</label>
                                    <div class="input-group mb-2 ml-sm-2">
                                        <input id="purchase_price" type="tel" dir="ltr"
                                               class="price form-control{{ $errors->has('purchase_price') ? ' is-invalid' : '' }}"
                                               name="purchase_price" value="{{ old('purchase_price',\App\Utils\MoneyUtil::display($product->purchase_price)) }}" required>
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">{{ trans('currency.'.config('platform.currency')) }}</div>
                                        </div>
                                    </div>
                                    @if ($errors->has('purchase_price'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('purchase_price') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="category_id">دسته</label>

                                    <select name="category_id" id="category_id" class="form-control select2">
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}"{{ old('category_id') == $category->id  ? ' selected' : '' }}>{{$category->title}}</option>
                                        @endforeach

                                    </select>
                                    @if ($errors->has('category_id'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('access') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="slug">
                                متن لینک
                                <span class="font-weight-light font-italic"> - اختیاری</span>
                            </label>
                            <input id="slug" type="text"
                                   class="form-control{{ $errors->has('slug') ? ' is-invalid' : '' }}"
                                   name="slug" value="{{ old('slug', $product->slug) }}">
                            @if ($errors->has('slug'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('slug') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="initial_balance">
                                موجودی اولیه
                                <span class="font-weight-light font-italic"> - اختیاری</span>
                            </label>
                            <input dir="ltr" id="initial_balance" type="text"
                                   class="form-control{{ $errors->has('initial_balance') ? ' is-invalid' : '' }}"
                                   name="initial_balance"
                                   value="{{ old('initial_balance', $product->initial_balance) }}">
                            @if ($errors->has('initial_balance'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('initial_balance') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="order">
                                ترتیب
                                <span class="font-weight-light font-italic"> - اختیاری</span>
                            </label>
                            <input dir="ltr" id="order" type="text"
                                   class="form-control{{ $errors->has('order') ? ' is-invalid' : '' }}"
                                   name="order" value="{{ old('order', $product->order) }}">
                            @if ($errors->has('order'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('order') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="factory">سازنده<span
                                        class="font-weight-light font-italic"> - اختیاری</span></label>
                            <select name="factory" id="factory" class="form-control select2">
                                <option value="">بدون سازنده</option>
                                @foreach(array_diff(scandir(app_path('Factory')), array('..', '.')) as $factory)
                                    @php
                                        $factoryPath = '\App\Factory'."\\".basename($factory, ".php");
                                        $factoryClass = new $factoryPath();
                                    @endphp
                                    <option value="{{ $factoryClass->factoryClass }}"{{ (old('factory', $product->factory) == $factoryClass->factoryClass)  ? ' selected' : '' }}>
                                        {{ $factoryClass->factoryName }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('factory'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('factory') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="description">
                                توضیحات کوتاه
                                <span class="font-weight-light font-italic"> - اختیاری</span>
                            </label>

                            <textarea
                                    class="form-control{{ $errors->has('description', $product->description) ? ' is-invalid' : '' }}"
                                    name="description" id="description"> {{ old('description') }}</textarea>

                            @if ($errors->has('description'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                            @endif
                        </div>


                        <div class="form-group">
                            <label for="text">
                                توضیحات کامل
                                <span class="font-weight-light font-italic"> - اختیاری</span>

                            </label>

                            <textarea class="form-control wysiwyg{{ $errors->has('text') ? ' is-invalid' : '' }}"
                                      name="text" id="text"> {{ old('text', $product->text) }}</textarea>

                            @if ($errors->has('text'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('text') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="row">
                            <div class="form-group col-md-2">
                                <label for="enabled">فعال</label>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="enableRadioYes" name="enabled"
                                           value="1"
                                           class="custom-control-input"{{ old('enabled', $product->enabled) == true  ? ' checked' : '' }}>
                                    <label class="custom-control-label" for="enableRadioYes">بلی</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="enableRadioNo" name="enabled"
                                           value="0"
                                           class="custom-control-input"{{ old('enabled', $product->enabled) == false  ? ' checked' : '' }}>
                                    <label class="custom-control-label" for="enableRadioNo">خیر</label>
                                </div>
                                @if ($errors->has('enabled'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('enabled') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-md-2">
                                <label for="asset">انبارداری</label>

                                <div class="custom-control custom-radio">
                                    <input type="radio" id="assetRadioYes" name="asset"
                                           value="1"
                                           class="custom-control-input"{{ old('asset', $product->asset) == true  ? ' checked' : '' }}>
                                    <label class="custom-control-label" for="assetRadioYes">دارد</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="assetRadioNo" name="asset"
                                           value="0"
                                           class="custom-control-input"{{ old('asset', $product->asset) == false  ? ' checked' : '' }}>
                                    <label class="custom-control-label" for="assetRadioNo">ندارد</label>
                                </div>
                                @if ($errors->has('asset'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('asset') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-md-2">
                                <label for="shop">فروش آنلاین</label>

                                <div class="custom-control custom-radio">
                                    <input type="radio" id="shopRadioYes" name="shop"
                                           value="1"
                                           class="custom-control-input"{{ old('shop', $product->shop) == true  ? ' checked' : '' }}>
                                    <label class="custom-control-label" for="shopRadioYes">دارد</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="shopRadioNo" name="shop"
                                           value="0"
                                           class="custom-control-input"{{ old('shop', $product->shop) == false  ? ' checked' : '' }}>
                                    <label class="custom-control-label" for="shopRadioNo">ندارد</label>
                                </div>
                                @if ($errors->has('shop'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('shop') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-md-2">
                                <label for="post">فروش پستی</label>

                                <div class="custom-control custom-radio">
                                    <input type="radio" id="postRadioYes" name="post"
                                           value="1"
                                           class="custom-control-input"{{ old('post', $product->post) == true  ? ' checked' : '' }}>
                                    <label class="custom-control-label" for="postRadioYes">دارد</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="postRadioNo" name="post"
                                           value="0"
                                           class="custom-control-input"{{ old('post', $product->post) == false  ? ' checked' : '' }}>
                                    <label class="custom-control-label" for="postRadioNo">ندارد</label>
                                </div>
                                @if ($errors->has('post'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('post') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-md-2">
                                <label for="renewal">دوره ای</label>

                                <div class="custom-control custom-radio">
                                    <input type="radio" id="renewalRadioYes" name="renewal"
                                           value="1"
                                           class="custom-control-input"{{ old('renewal', $product->renewal) == true  ? ' checked' : '' }}>
                                    <label class="custom-control-label" for="renewalRadioYes">دارد</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="renewalRadioNo" name="renewal"
                                           value="0"
                                           class="custom-control-input"{{ old('renewal', $product->renewal) == false  ? ' checked' : '' }}>
                                    <label class="custom-control-label" for="renewalRadioNo">ندارد</label>
                                </div>
                                @if ($errors->has('renewal'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('renewal') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-md-2">
                                <label for="top">صفحه اول</label>

                                <div class="custom-control custom-radio">
                                    <input type="radio" id="topRadioYes" name="top"
                                           value="1"
                                           class="custom-control-input"{{ old('top', $product->top) == true  ? ' checked' : '' }}>
                                    <label class="custom-control-label" for="topRadioYes">بله</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="topRadioNo" name="top"
                                           value="0"
                                           class="custom-control-input"{{ old('top', $product->top) == false  ? ' checked' : '' }}>
                                    <label class="custom-control-label" for="topRadioNo">خیر</label>
                                </div>
                                @if ($errors->has('top'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('top') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="period">دوره تمدید
                                <span class="font-weight-light font-italic"> - اختیاری</span>
                            </label>
                            <div class="input-group mb-2 ml-sm-2">
                                <input id="period" type="tel" dir="ltr"
                                       class="form-control{{ $errors->has('period') ? ' is-invalid' : '' }}"
                                       name="period" value="{{ old('period', $product->period) }}">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">روز</div>
                                </div>
                            </div>
                            @if ($errors->has('period'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('period') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="renewal_price">قیمت تمدید
                                <span class="font-weight-light font-italic"> - اختیاری</span>
                            </label>
                            <div class="input-group mb-2 ml-sm-2">
                                <input id="renewal_price" type="tel" dir="ltr"
                                       class="price form-control{{ $errors->has('renewal_price') ? ' is-invalid' : '' }}"
                                       name="renewal_price" value="{{ old('renewal_price',\App\Utils\MoneyUtil::display($product->renewal_price)) }}">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">{{ trans('currency.'.config('platform.currency')) }}</div>
                                </div>
                            </div>
                            @if ($errors->has('renewal_price'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('renewal_price') }}</strong>
                                    </span>
                            @endif
                        </div>


                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="tax">مالیات</label>

                                <div class="custom-control custom-radio">
                                    <input type="radio" id="taxRadioYes" name="tax"
                                           value="1"
                                           class="custom-control-input"{{ old('top',$product->tax) == true  ? ' checked' : '' }}>
                                    <label class="custom-control-label" for="taxRadioYes">دارد</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="taxRadioNo" name="tax"
                                           value="0"
                                           class="custom-control-input"{{ old('top',$product->tax) == false  ? ' checked' : '' }}>
                                    <label class="custom-control-label" for="taxRadioNo">ندارد</label>
                                </div>
                                @if ($errors->has('tax'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('tax') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label for="marketing">بازاریابی</label>

                                <div class="custom-control custom-radio">
                                    <input type="radio" id="marketingRadioYes" name="marketing"
                                           value="1"
                                           class="custom-control-input"{{ old('marketing',$product->marketing) == true  ? ' checked' : '' }}>
                                    <label class="custom-control-label" for="marketingRadioYes">دارد</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="marketingRadioNo" name="marketing"
                                           value="0"
                                           class="custom-control-input"{{ old('marketing',$product->marketing) == false  ? ' checked' : '' }}>
                                    <label class="custom-control-label" for="marketingRadioNo">ندارد</label>
                                </div>
                                @if ($errors->has('marketing'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('marketing') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label for="off">حراج با قیمت تخفیف</label>

                                <div class="custom-control custom-radio">
                                    <input type="radio" id="offRadioYes" name="off"
                                           value="1"
                                           class="custom-control-input"{{ old('marketing',$product->off) == true  ? ' checked' : '' }}>
                                    <label class="custom-control-label" for="offRadioYes">دارد</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="offRadioNo" name="off"
                                           value="0"
                                           class="custom-control-input"{{ old('off', $product->off) == false  ? ' checked' : '' }}>
                                    <label class="custom-control-label" for="offRadioNo">ندارد</label>
                                </div>
                                @if ($errors->has('off'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('off') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="off_expire_at">انقضای حراج<span class="font-weight-light font-italic"> - اختیاری</span></label>
                            <div dir="ltr">
                                <date-picker
                                        id="off_expire_at"
                                        name="off_expire_at"
                                        format="jYYYY/jMM/jDD HH:mm"
                                        display-format="jYYYY/jMM/jDD HH:mm"
                                        color="#6838b8"
                                        type="datetime"
                                        value="{{ old('off_expire_at', jdate($product->off_expire_at)->format("Y/m/d H:i")) }}"
                                        placeholder="____/__/__ __:__">
                                </date-picker>
                            </div>
                            @if ($errors->has('off_expire_at'))
                                <span class="invalid-feedback">
                            <strong>{{ $errors->first('off_expire_at') }}</strong>
                        </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="off_price">قیمت حراج
                                <span class="font-weight-light font-italic"> - اختیاری</span>
                            </label>
                            <div class="input-group mb-2 ml-sm-2">
                                <input id="off_price" type="tel" dir="ltr"
                                       class="price form-control{{ $errors->has('off_price') ? ' is-invalid' : '' }}"
                                       name="off_price" value="{{ old('off_price',\App\Utils\MoneyUtil::display($product->off_price)) }}">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">{{ trans('currency.'.config('platform.currency')) }}</div>
                                </div>
                            </div>
                            @if ($errors->has('off_price'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('off_price') }}</strong>
                                    </span>
                            @endif
                        </div>


                        <div class="form-group">
                            <label for="tax_percent">مالیات
                                <span class="font-weight-light font-italic"> - اختیاری</span>
                            </label>
                            <div class="input-group mb-2 ml-sm-2">
                                <input id="tax_percent" type="tel" dir="ltr"
                                       class="price form-control{{ $errors->has('tax_percent') ? ' is-invalid' : '' }}"
                                       name="tax_percent" value="{{ old('tax_percent', $product->tax_percent) }}">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">درصد</div>
                                </div>
                            </div>
                            @if ($errors->has('tax_percent'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('tax_percent') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="marketing_percent">سهم بازاریاب
                                <span class="font-weight-light font-italic"> - اختیاری</span>
                            </label>
                            <div class="input-group mb-2 ml-sm-2">
                                <input id="marketing_percent" type="tel" dir="ltr"
                                       class="price form-control{{ $errors->has('marketing_percent') ? ' is-invalid' : '' }}"
                                       name="marketing_percent" value="{{ old('marketing_percent', $product->marketing_percent) }}">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">درصد</div>
                                </div>
                            </div>
                            @if ($errors->has('marketing_percent'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('marketing_percent') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="tags">برچسب ها<span
                                        class="font-weight-light font-italic"> - اختیاری</span></label>
                            <select id="tags" name="tags[]" class="form-control tags" multiple="multiple">
                                @foreach($product->tags as $tag)
                                    <option value="{{ $tag->name }}" selected>{{ $tag->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('tags'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('tags') }}</strong>
                                </span>
                            @endif
                        </div>


                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-edit"></i>
                            ویرایش کالا
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#previewSource').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#image").change(function () {
            readURL(this);
        });
    </script>
@endsection
