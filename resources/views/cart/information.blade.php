@extends('layouts.app')
@section('title', 'اطلاعات شما - ')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ config('platform.name') }}</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('cart') }}">سبد خرید</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('cart.information') }}">اطلاعات شما</a></li>
                </ol>
            </nav>
            <div class="row mb-2">

                <div class="col-md-12">
                    <a href="{{ route('product')  }}" class="btn btn-primary pull-right"><i
                                class="fa fa-shopping-basket"></i> ادامه خرید</a>
                    @if(Cart::getTotal() != 0)
                        <button onclick="$('#information').submit();" class="btn btn-warning pull-left"><i
                                    class="fa fa-check-circle-o"></i>ثبت اطلاعات و پرداخت
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mb-2">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">اطلاعات تکمیلی</div>

                <div class="card-body">
                    <form method="POST" id="information" action="{{ route('cart.store-information') }}">
                        @csrf
                        @method('post')
                        <div class="form-group">
                            <label for="first_name">نام</label>
                                <input id="first_name" type="text"
                                       class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name"
                                       value="{{ old('first_name',Auth::user()->first_name) }}" required autofocus>

                                @if ($errors->has('first_name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                        </div>


                        <div class="form-group">
                            <label for="last_name">نام خانوادگی</label>
                            <input id="last_name" type="text"
                                   class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name"
                                   value="{{ old('last_name',Auth::user()->last_name) }}" required>

                            @if ($errors->has('last_name'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="gender">جنسیت</label>
                                <select class="form-control{{ $errors->has('gender') ? ' is-invalid' : '' }}"
                                        name="gender" required>
                                    <option value="male"{{ old('gender', Auth::user()->gender) == 'male' ? ' selected' :'' }}>
                                        مرد
                                    </option>
                                    <option value="female"{{ old('gender', Auth::user()->gender) == 'female' ? ' selected' :'' }}>
                                        زن
                                    </option>
                                </select>

                                @if ($errors->has('gender'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group">
                            <label for="national_code">کد
                                ملی</label>


                                <input id="national_code" type="text" dir="ltr"
                                       class="form-control{{ $errors->has('national_code') ? ' is-invalid' : '' }}"
                                       name="national_code"
                                       value="{{ old('national_code',Auth::user()->national_code) }}" required>

                                @if ($errors->has('national_code'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('national_code') }}</strong>
                                    </span>
                                @endif

                        </div>

                        <div class="form-group">
                            <label for="phone">شماره
                                تماس</label>

                                <input id="phone" type="text" dir="ltr"
                                       class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone"
                                       value="{{ old('phone', Auth::user()->mobile) }}" required>

                                @if ($errors->has('mobile'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('mobile') }}</strong>
                                    </span>
                                @endif

                        </div>
                        <div class="form-group">
                            <label for="zip_code">کد
                                پستی</label>

                                <input id="zip_code" type="text" dir="ltr"
                                       class="form-control{{ $errors->has('zip_code') ? ' is-invalid' : '' }}"
                                       name="zip_code" value="{{ old('zip_code', Auth::user()->zip_code) }}" required>

                                @if ($errors->has('zip_code'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('zip_code') }}</strong>
                                    </span>
                                @endif
                        </div>
                        <div class="form-group">
                            <label for="province_id">استان</label>

                                <select onchange="selectProvince(this.value);"
                                        class="form-control{{ $errors->has('province_id') ? ' is-invalid' : '' }}"
                                        name="province_id" required>
                                    @foreach($provinces as $province)
                                        <option value="{{ $province->id }}"{{ old('province_id', Auth::user()->province_id) == $province->id ? ' selected' :'' }}>{{ $province->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('province_id'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('province_id') }}</strong>
                                    </span>
                                @endif
                        </div>
                        <div class="form-group">
                            <label for="city_id">شهر</label>

                                <select id="city_id"
                                        class="form-control{{ $errors->has('city_id') ? ' is-invalid' : '' }}"
                                        name="city_id" required>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}"{{ old('city_id', Auth::user()->city_id) == $city->id ? ' selected' :'' }}>{{ $city->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('city_id'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('city_id') }}</strong>
                                    </span>
                                @endif

                        </div>
                        <div class="form-group">
                            <label for="address">آدرس
                                پستی</label>

                                <textarea class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}"
                                          name="address" value=""
                                          required>{{ old('address', Auth::user()->address) }}</textarea>

                                @if ($errors->has('address'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif

                        </div>
                        <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i>
                                    ثبت اطلاعات و پرداخت
                                </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
