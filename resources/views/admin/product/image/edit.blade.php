@extends('layouts.app')
@section('title', 'ویرایش تصویر ' . $image->title .' - ')
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
                    <li class="breadcrumb-item"><a href="{{ route('admin.product.image',[$image->product->id]) }}">تصاویر {{$image->product->title}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">ویرایش تصویر {{ $image->title }}</li>
                </ol>
            </nav>
            <div class="card card-default">
                <div class="card-header">ویرایش تصویر {{ $image->title }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.product.image.update',['id' => $image->id]) }}" onsubmit="$('.price').unmask();"
                          enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        <div class="form-group">
                            <label for="title">عنوان</label>
                            <input id="title" type="text"
                                   class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                   name="title" value="{{ old('title', $image->title) }}" required autofocus>
                            @if ($errors->has('title'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                            @endif
                        </div>


                        <div class="form-group">
                            <label for="source">فایل</label>
                            <input id="source" type="file"
                                   class="form-control{{ $errors->has('source') ? ' is-invalid' : '' }}"
                                   name="source" value="{{ old('source') }}">
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
                                      name="description" id="description"> {{ old('description', $image->description) }}</textarea>

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
                                   name="order" value="{{ old('order', $image->order) }}">
                            @if ($errors->has('order'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('order') }}</strong>
                                    </span>
                            @endif
                        </div>


                                <div class="form-group">
                                    <label for="enable">فعال</label>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="enableRadioYes" name="enabled"
                                               value="1"
                                               class="custom-control-input"{{ old('enabled', $image->enabled) == true  ? ' checked' : '' }}>
                                        <label class="custom-control-label" for="enableRadioYes">بلی</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="enableRadioNo" name="enabled"
                                               value="0"
                                               class="custom-control-input"{{ old('enabled', $image->enabled) == false  ? ' checked' : '' }}>
                                        <label class="custom-control-label" for="enableRadioNo">خیر</label>
                                    </div>
                                    @if ($errors->has('enable'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->firenabledst('enable') }}</strong>
                                    </span>
                                    @endif
                                </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i>
                            ویرایش تصویر
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection