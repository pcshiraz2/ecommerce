@extends('layouts.app')

@section('title', "پرداخت آزاد - ")

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ config('platform.name') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">پرداخت آزاد</li>
                </ol>
            </nav>
        </div>

    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">
                    اطلاعات پرداخت
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('free-pay.start') }}" onsubmit="$('#amount').unmask();">
                        @csrf
                        @method('post')
                        @guest
                            <input type="hidden" id="user_id" name="user_id" value="">
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label @lang('platform.input-pull')">نام و نام
                                    خانوادگی</label>

                                <div class="col-md-7">
                                    <input id="name" type="text"
                                           class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                           name="name" value="{{ old('name', session('name')) }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label @lang('platform.input-pull')">آدرس
                                    ایمیل</label>

                                <div class="col-md-7">
                                    <input id="email" type="email" dir="ltr"
                                           class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                           name="email" value="{{ old('email', session('email')) }}" required>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="mobile" class="col-md-4 col-form-label @lang('platform.input-pull')">شماره
                                    همراه</label>

                                <div class="col-md-7">
                                    <input id="mobile" type="text" dir="ltr"
                                           class="form-control{{ $errors->has('mobile') ? ' is-invalid' : '' }}"
                                           name="mobile" value="{{ old('mobile', session('mobile')) }}" required>

                                    @if ($errors->has('mobile'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('mobile') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                        @else
                            <input type="hidden" id="user_id" name="user_id" value="{{Auth::user()->id}}">
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label @lang('platform.input-pull')">نام و نام
                                    خانوادگی</label>

                                <div class="col-md-7">
                                    <input id="name" type="text"
                                           class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                           name="name" value="{{ old('name',Auth::user()->name) }}" readonly="readonly"
                                           required>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label @lang('platform.input-pull')">آدرس
                                    ایمیل</label>

                                <div class="col-md-7">
                                    <input id="email" type="email" dir="ltr"
                                           class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                           name="email" readonly="readonly"
                                           value="{{ old('email',Auth::user()->email) }}" required>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="mobile" class="col-md-4 col-form-label @lang('platform.input-pull')">شماره
                                    همراه</label>

                                <div class="col-md-7">
                                    <input id="mobile" type="text" dir="ltr"
                                           class="form-control{{ $errors->has('mobile') ? ' is-invalid' : '' }}"
                                           readonly="readonly" name="mobile"
                                           value="{{ old('mobile',Auth::user()->mobile) }}" required>

                                    @if ($errors->has('mobile'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('mobile') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                        @endguest


                        <div class="form-group row">
                            <label for="amount"
                                   class="col-md-4 col-form-label @lang('platform.input-pull')">مبلغ</label>

                            <div class="col-md-7">

                                <div class="input-group mb-2 ml-sm-2">
                                    <input id="amount" type="tel" dir="ltr"
                                           class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}"
                                           name="amount" value="{{ old('amount') }}" required>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">تومان</div>
                                    </div>
                                </div>

                                @if ($errors->has('amount'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('amount') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label @lang('platform.input-pull')">توضیحات</label>

                            <div class="col-md-7">
                                <textarea id="amount"
                                          class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                                          name="description" required>{{ old('description') }}</textarea>

                                @if ($errors->has('description'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="gateway" class="col-md-4 col-form-label @lang('platform.input-pull')">درگاه
                                انتخابی</label>

                            <div class="col-md-7">
                                <select name="gateway" id="gateway" class="form-control{{ $errors->has('gateway') ? ' is-invalid' : '' }}">
                                    @foreach(\Parsisolution\Gateway\GatewayManager::activeDrivers() as $gateway)
                                        <option value="{{$key}}"{{ old('gateway')  ? ' selected' : '' }}>{{$gateway['name']}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('gateway'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('gateway') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary btn-mobile">
                                    <i class="fa fa-money"></i>
                                    پرداخت
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(function () {
            $('#amount').mask('#,##0', {reverse: true});
        });
    </script>
@endsection
