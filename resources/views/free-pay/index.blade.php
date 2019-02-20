@extends('layouts.app')

@section('title', "پرداخت نقدی - ")

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ config('platform.name') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">پرداخت نقدی</li>
                </ol>
            </nav>
        </div>

    </div>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card-default">
                <div class="card-header">
                    اطلاعات پرداخت
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('free-pay.start') }}" onsubmit="$('.price').unmask();">
                        @csrf
                        @method('post')
                        @guest
                            <input type="hidden" id="user_id" name="user_id" value="">
                            <div class="form-group">
                                <label for="first_name">نام</label>

                                    <input id="first_name" type="text"
                                           class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}"
                                           name="first_name" value="{{ old('first_name', session('first_name')) }}" required autofocus>

                                    @if ($errors->has('first_name'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                    @endif
                            </div>
                            <div class="form-group">
                                <label for="last_name">نام خانوادگی</label>

                                <input id="last_name" type="text"
                                       class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}"
                                       name="last_name" value="{{ old('last_name', session('last_name')) }}" required>

                                @if ($errors->has('last_name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="email">آدرس
                                    ایمیل</label>

                                    <input id="email" type="email" dir="ltr"
                                           class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                           name="email" value="{{ old('email', session('email')) }}">

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif

                            </div>

                            <div class="form-group">
                                <label for="mobile">شماره
                                    همراه</label>


                                    <input id="mobile" type="text" dir="ltr"
                                           class="form-control{{ $errors->has('mobile') ? ' is-invalid' : '' }}"
                                           name="mobile" value="{{ old('mobile', session('mobile')) }}" required>

                                    @if ($errors->has('mobile'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('mobile') }}</strong>
                                    </span>
                                    @endif

                            </div>

                        @else
                            <input type="hidden" id="user_id" name="user_id" value="{{Auth::user()->id}}">
                            <div class="form-group">
                                <label for="first_name">نام</label>

                                    <input id="first_name" type="text"
                                           class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}"
                                           name="first_name" value="{{ old('first_name',Auth::user()->first_name) }}" readonly="readonly"
                                           required>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                    @endif
                            </div>
                            <div class="form-group">
                                <label for="last_name">نام خانوداگی</label>

                                <input id="last_name" type="text"
                                       class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}"
                                       name="last_name" value="{{ old('last_name',Auth::user()->last_name) }}" readonly="readonly"
                                       required>

                                @if ($errors->has('last_name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="email">آدرس
                                    ایمیل</label>

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

                            <div class="form-group">
                                <label for="mobile">شماره
                                    همراه</label>
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


                        @endguest


                        <div class="form-group">
                            <label for="amount">مبلغ</label>


                                <div class="input-group mb-2 ml-sm-2">
                                    <input id="amount" type="tel" dir="ltr"
                                           class="price form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}"
                                           name="amount" value="{{ old('amount') }}" required>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">{{ trans('currency.'.config('platform.currency')) }}</div>
                                    </div>
                                </div>

                                @if ($errors->has('amount'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('amount') }}</strong>
                                    </span>
                                @endif

                        </div>

                        <div class="form-group">
                            <label for="description">توضیحات</label>
                                <textarea id="amount"
                                          class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                                          name="description" required>{{ old('description') }}</textarea>

                                @if ($errors->has('description'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif

                        </div>
                        <div class="form-group">
                            <label for="gateway">درگاه
                                انتخابی</label>

                                <select name="gateway" id="gateway" class="form-control{{ $errors->has('gateway') ? ' is-invalid' : '' }}">
                                    @foreach(\Parsisolution\Gateway\Facades\Gateway::activeDrivers() as $gateway)
                                        <option value="{{ $gateway['key'] }}"{{ old('gateway') == $gateway['key']  ? ' selected' : '' }}>{{ $gateway['name'] }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('gateway'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('gateway') }}</strong>
                                    </span>
                                @endif

                        </div>
                        <div class="form-group ">
                                <button type="submit" class="btn btn-primary btn-mobile">
                                    <i class="fa fa-money"></i>
                                    پرداخت
                                </button>
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
