@extends('layouts.app')
@section('title', 'کالا جدید - ')
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
                    <li class="breadcrumb-item active" aria-current="page"><a
                                href="{{ route('admin.product.create') }}">کالا جدید</a></li>
                </ol>
            </nav>
            <div class="card card-default">
                <div class="card-header">کالا جدید
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.product.insert') }}" onsubmit="$('.price').unmask();"
                          enctype="multipart/form-data">
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
                                                   id="image" aria-describedby="imageSelect" required>
                                            <label class="custom-file-label" for="imageSelect">انتخاب فایل</label>
                                        </div>
                                    </div>
                                    @if ($errors->has('image'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('image') }}</strong>
                                        </span>
                                    @endif
                                    <img id="previewSource" style="width: 225px;height: 225px;"
                                         src="{{ asset('images/product.png') }}"
                                         alt="تصویر شما"/>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="title">عنوان</label>
                                    <input id="title" type="text"
                                           class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                           name="title" value="{{ old('title') }}" required autofocus>
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
                                               name="sale_price" value="{{ old('sale_price') }}" required>
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
                                               name="purchase_price" value="{{ old('purchase_price') }}" required>
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

                                    <select name="category_id" id="category_id" class="form-control selector">
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}"{{ old('category_id') == $category->id  ? ' selected' : '' }}>{{$category->title}}</option>
                                        @endforeach

                                    </select>
                                    @if ($errors->has('category_id'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('category_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="code">
                                کد یکتا محصول
                                <span class="font-weight-light font-italic"> - اختیاری</span>
                            </label>
                            <input id="code" type="text" dir="ltr"
                                   class="form-control{{ $errors->has('code') ? ' is-invalid' : '' }}"
                                   name="code" value="{{ old('code') }}">
                            @if ($errors->has('code'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('code') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="slug">
                                متن لینک
                                <span class="font-weight-light font-italic"> - اختیاری</span>
                            </label>
                            <input id="slug" type="text"
                                   class="form-control{{ $errors->has('slug') ? ' is-invalid' : '' }}"
                                   name="slug" value="{{ old('slug') }}">
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
                                   name="initial_balance" value="{{ old('initial_balance') }}">
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
                                   name="order" value="{{ old('order') }}">
                            @if ($errors->has('order'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('order') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="factory">سازنده<span
                                        class="font-weight-light font-italic"> - اختیاری</span></label>
                            <select name="factory" id="factory" class="form-control selector">
                                <option value="">بدون سازنده</option>
                                @foreach(array_diff(scandir(app_path('Factories')), array('..', '.')) as $factory)
                                    @php
                                        $factoryPath = '\App\Factories'."\\".basename($factory, ".php");
                                        $factoryClass = new $factoryPath();
                                    @endphp
                                    <option value="{{ $factoryClass->factoryClass }}"{{ (old('factory') == $factoryClass->factoryClass)  ? ' selected' : '' }}>
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

                            <textarea class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
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
                                      name="text" id="text"> {{ old('text') }}</textarea>

                            @if ($errors->has('text'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('text') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="row">
                            <div class="form-group col-md-2">
                                <label for="enable">فعال</label>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="enableRadioYes" name="enabled"
                                           value="1"
                                           class="custom-control-input"{{ old('enabled',true) == true  ? ' checked' : '' }}>
                                    <label class="custom-control-label" for="enableRadioYes">بلی</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="enableRadioNo" name="enabled"
                                           value="0"
                                           class="custom-control-input"{{ old('enabled',true) == false  ? ' checked' : '' }}>
                                    <label class="custom-control-label" for="enableRadioNo">خیر</label>
                                </div>
                                @if ($errors->has('enable'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('enable') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-md-2">
                                <label for="asset">انبارداری</label>

                                <div class="custom-control custom-radio">
                                    <input type="radio" id="assetRadioYes" name="asset"
                                           value="1"
                                           class="custom-control-input"{{ old('asset',false) == true  ? ' checked' : '' }}>
                                    <label class="custom-control-label" for="assetRadioYes">دارد</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="assetRadioNo" name="asset"
                                           value="0"
                                           class="custom-control-input"{{ old('asset',false) == false  ? ' checked' : '' }}>
                                    <label class="custom-control-label" for="assetRadioNo">ندارد</label>
                                </div>
                                @if ($errors->has('asset'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('asset') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-md-2">
                                <label for="shop">قابلیت فروش</label>

                                <div class="custom-control custom-radio">
                                    <input type="radio" id="shopRadioYes" name="shop"
                                           value="1"
                                           class="custom-control-input"{{ old('shop',true) == true  ? ' checked' : '' }}>
                                    <label class="custom-control-label" for="shopRadioYes">دارد</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="shopRadioNo" name="shop"
                                           value="0"
                                           class="custom-control-input"{{ old('shop',true) == false  ? ' checked' : '' }}>
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
                                           class="custom-control-input"{{ old('post',false) == true  ? ' checked' : '' }}>
                                    <label class="custom-control-label" for="postRadioYes">دارد</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="postRadioNo" name="post"
                                           value="0"
                                           class="custom-control-input"{{ old('post',false) == false  ? ' checked' : '' }}>
                                    <label class="custom-control-label" for="postRadioNo">ندارد</label>
                                </div>
                                @if ($errors->has('post'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('post') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group col-md-2">
                                <label for="top">صفحه اول</label>

                                <div class="custom-control custom-radio">
                                    <input type="radio" id="topRadioYes" name="top"
                                           value="1"
                                           class="custom-control-input"{{ old('top',false) == true  ? ' checked' : '' }}>
                                    <label class="custom-control-label" for="topRadioYes">بله</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="topRadioNo" name="top"
                                           value="0"
                                           class="custom-control-input"{{ old('top',false) == false  ? ' checked' : '' }}>
                                    <label class="custom-control-label" for="topRadioNo">خیر</label>
                                </div>
                                @if ($errors->has('top'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('top') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-md-2">
                                <label for="discount">حراج</label>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="discountRadioYes" name="discount"
                                           value="1"
                                           class="custom-control-input"{{ old('discount',false) == true  ? ' checked' : '' }}>
                                    <label class="custom-control-label" for="discountRadioYes">دارد</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="discountRadioNo" name="discount"
                                           value="0"
                                           class="custom-control-input"{{ old('discount',false) == false  ? ' checked' : '' }}>
                                    <label class="custom-control-label" for="discountRadioNo">ندارد</label>
                                </div>
                                @if ($errors->has('discount'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('discount') }}</strong>
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
                                       name="period" value="{{ old('period',0) }}">
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
                            <label for="period_price">قیمت تمدید
                                <span class="font-weight-light font-italic"> - اختیاری</span>
                            </label>
                            <div class="input-group mb-2 ml-sm-2">
                                <input id="period_price" type="tel" dir="ltr"
                                       class="price form-control{{ $errors->has('period_price') ? ' is-invalid' : '' }}"
                                       name="period_price" value="{{ old('period_price') }}">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">{{ trans('currency.'.config('platform.currency')) }}</div>
                                </div>
                            </div>
                            @if ($errors->has('period_price'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('period_price') }}</strong>
                                    </span>
                            @endif
                        </div>


                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="discount_expire_at">انقضای حراج<span class="font-weight-light font-italic"> - اختیاری</span></label>
                                <div dir="ltr">
                                    <date-picker
                                            id="discount_expire_at"
                                            name="discount_expire_at"
                                            format="jYYYY/jMM/jDD HH:mm"
                                            display-format="jYYYY/jMM/jDD HH:mm"
                                            color="#6838b8"
                                            type="datetime"
                                            value="{{ old('discount_expire_at') }}"
                                            placeholder="____/__/__ __:__">
                                    </date-picker>
                                </div>
                                @if ($errors->has('discount_expire_at'))
                                    <span class="invalid-feedback">
                            <strong>{{ $errors->first('discount_expire_at') }}</strong>
                        </span>
                                @endif
                            </div>



                            <div class="form-group col-md-6">
                                <label for="discount_price">قیمت حراج
                                    <span class="font-weight-light font-italic"> - اختیاری</span>
                                </label>
                                <div class="input-group mb-2 ml-sm-2">
                                    <input id="discount_price" type="tel" dir="ltr"
                                           class="price form-control{{ $errors->has('discount_price') ? ' is-invalid' : '' }}"
                                           name="discount_price" value="{{ old('discount_price') }}">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">{{ trans('currency.'.config('platform.currency')) }}</div>
                                    </div>
                                </div>
                                @if ($errors->has('discount_price'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('discount_price') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tax_id">مالیات
                                <span class="font-weight-light font-italic"> - اختیاری</span>
                            </label>

                            <select name="tax_id" id="tax_id" class="form-control selector">
                                <option value="0"{{ old('tax_id') == 0 ? ' selected' : '' }}>-- مالیات --</option>
                                @foreach($taxes as $tax)
                                    <option value="{{ $tax->id }}"{{ old('tax_id') == $tax->id  ? ' selected' : '' }}>{{$tax->name}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('tax_id'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('tax_id') }}</strong>
                                    </span>
                            @endif
                        </div>


                        <div class="form-group">
                            <label for="tags">برچسب ها<span
                                        class="font-weight-light font-italic"> - اختیاری</span></label>
                            <select id="tags" name="tags[]" class="form-control tags" multiple="multiple">
                            </select>
                            @if ($errors->has('tags'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('tags') }}</strong>
                                </span>
                            @endif
                        </div>


                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-plus"></i>
                            افزودن کالا
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
