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
                    <li class="breadcrumb-item"><a href="{{ route('admin.product.file',[$product->id]) }}">فایل های {{$product->title}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">فایل جدید</li>
                </ol>
            </nav>
            <div class="card card-default">
                <div class="card-header">فایل جدید</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.product.file.insert',['id' => $product->id]) }}" onsubmit="$('.price').unmask();"
                          enctype="multipart/form-data">
                        @csrf
                        @method('post')
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
                            <label for="name">نام فایل با پسوند</label>
                            <input id="name" type="text"
                                   class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                   name="name" dir="ltr" value="{{ old('name') }}" required>
                            @if ($errors->has('name'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif
                        </div>


                        <div class="form-group">
                            <label for="source">فایل</label>
                            <input id="source" type="file"
                                   class="form-control{{ $errors->has('source') ? ' is-invalid' : '' }}"
                                   name="source" value="{{ old('source') }}" required>
                            @if ($errors->has('source'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('source') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="description">
                                توضیحات
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

                        <div class="row">
                            <div class="col">
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
                            </div>
                            <div class="col">
                                <div class="form-group col-md-2">
                                    <label for="free">رایگان</label>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="freeRadioYes" name="free"
                                               value="1"
                                               class="custom-control-input"{{ old('free',false) == true  ? ' checked' : '' }}>
                                        <label class="custom-control-label" for="freeRadioYes">بلی</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="enableRadioNo" name="free"
                                               value="0"
                                               class="custom-control-input"{{ old('free',false) == false  ? ' checked' : '' }}>
                                        <label class="custom-control-label" for="freeRadioNo">خیر</label>
                                    </div>
                                    @if ($errors->has('free'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('free') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group col-md-2">
                                    <label for="public">عمومی</label>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="publicRadioYes" name="public"
                                               value="1"
                                               class="custom-control-input"{{ old('public',false) == true  ? ' checked' : '' }}>
                                        <label class="custom-control-label" for="publicRadioYes">بلی</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="publicRadioNo" name="public"
                                               value="0"
                                               class="custom-control-input"{{ old('public',false) == false  ? ' checked' : '' }}>
                                        <label class="custom-control-label" for="publicRadioNo">خیر</label>
                                    </div>
                                    @if ($errors->has('public'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('public') }}</strong>
                                    </span>

                                    @endif
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-plus"></i>
                            افزودن فایل
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection
