@extends('layouts.app')
@section('title', 'ویرایش اسلاید ' .$slide->title . " - ")
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
                    <li class="breadcrumb-item"><a href="{{ route('admin.slide') }}">اسلایدها</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <a href="{{ route('admin.slide.edit', [$slide->id]) }}">ویرایش اسلاید {{$slide->title}}</a>
                    </li>
                </ol>
            </nav>
            <div class="card card-default">
                <div class="card-header">ویرایش اسلاید {{$slide->title}}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.slide.update', [$slide->id]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('post')

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
                        </div>

                        <div class="form-group">
                            <label for="title">عنوان</label>
                            <input id="title" type="text"
                                   class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title"
                                   value="{{ old('title', $slide->title) }}" required autofocus>
                            @if ($errors->has('title'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="link">لینک</label>
                            <input placeholder="http://..." id="link" type="text"
                                   class="form-control{{ $errors->has('link') ? ' is-invalid' : '' }}" dir="ltr" name="link"
                                   value="{{ old('link', $slide->link) }}">
                            @if ($errors->has('link'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('link') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="description">توضیحات</label>

                            <textarea class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                                      name="description" id="description"> {{ old('description', $slide->description) }}</textarea>

                            @if ($errors->has('description'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="link">ترتیب</label>
                            <input id="order" type="tel"
                                   class="form-control{{ $errors->has('order') ? ' is-invalid' : '' }}" dir="ltr" name="order"
                                   value="{{ old('order', $slide->order) }}">
                            @if ($errors->has('order'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('order') }}</strong>
                                    </span>
                            @endif
                        </div>




                        <div class="form-group">
                            <label for="enabled">فعال</label>

                            <div class="custom-control custom-radio">
                                <input type="radio" id="enabledRadioYes" name="enabled"
                                       value="1"
                                       class="custom-control-input"{{ old('enabled', $slide->enabled) == true  ? ' checked' : '' }}>
                                <label class="custom-control-label" for="enabledRadioYes">بله</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="enabledRadioNo" name="enabled"
                                       value="0"
                                       class="custom-control-input"{{ old('enabled', $slide->enabled) == false  ? ' checked' : '' }}>
                                <label class="custom-control-label" for="enabledRadioNo">خیر</label>
                            </div>
                            @if ($errors->has('enabled'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('enabled') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i>
                            ویرایش اسلاید
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
