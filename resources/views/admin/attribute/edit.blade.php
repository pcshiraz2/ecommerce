@extends('layouts.app')
@section('title', 'ویرایش مشخصه ' . $attribute->title . ' - ')
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
                    <li class="breadcrumb-item"><a href="{{ route('admin.attribute') }}">مشخصات</a></li>
                    <li class="breadcrumb-item active" aria-current="page">ویرایش مشخصه {{ $attribute->title }}</li>
                </ol>
            </nav>
            <div class="card card-default">
                <div class="card-header">ویرایش مشخصه {{ $attribute->title }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.attribute.update', ['id' => $attribute->id]) }}" onsubmit="$('.price').unmask();"
                          enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        <div class="form-group">
                            <label for="category_id">دسته</label>
                            <select class="form-control selector"
                                    onchange="selectAttributes(this.value);"
                                    name="category_id" id="category_id">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"{{ old('category_id', $attribute->category_id) == $category->id ? ' selected' :'' }}>{{ $category->title }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('category_id'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('category_id') }}</strong>
                                    </span>
                            @endif
                        </div>



                        <div class="form-group">
                            <label for="title">عنوان</label>
                            <input id="title" type="text"
                                   class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                   name="title" value="{{ old('title', $attribute->title) }}" required>
                            @if ($errors->has('title'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="enabled">فعال</label>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="enableRadioYes" name="enabled"
                                       value="1"
                                       class="custom-control-input"{{ old('enabled',$attribute->enabled) == true  ? ' checked' : '' }}>
                                <label class="custom-control-label" for="enableRadioYes">بلی</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="enableRadioNo" name="enabled"
                                       value="0"
                                       class="custom-control-input"{{ old('enabled',$attribute->enabled) == false  ? ' checked' : '' }}>
                                <label class="custom-control-label" for="enableRadioNo">خیر</label>
                            </div>
                            @if ($errors->has('enabled'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('enabled') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> ویرایش مشخصه
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


