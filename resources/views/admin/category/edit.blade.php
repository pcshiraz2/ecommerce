@extends('layouts.app')
@section('title', 'ویرایش دسته ' . $category->title .' - ')
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
                    <li class="breadcrumb-item"><a href="{{ route('admin.category') }}">دسته ها</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a
                                href="{{ route('admin.category.edit',['id' => $category->id]) }}">ویرایش
                            دسته {{ $category->title }}</a></li>
                </ol>
            </nav>
            <div class="card card-default">
                <div class="card-header">ویرایش دسته {{ $category->title }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.category.update',['id' => $category->id]) }}">
                        @csrf
                        @method('post')
                        <div class="form-group">
                            <label for="title">عنوان</label>
                            <input id="title" type="text"
                                   class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title"
                                   value="{{ old('title', $category->title) }}" required autofocus>

                            @if ($errors->has('title'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="type">نوع</label>
                            <select name="type" id="type"
                                    class="form-control{{ $errors->has('type') ? ' is-invalid' : '' }}">
                                @foreach(trans('category') as $key => $type)
                                    <option value="{{ $key }}" {{ old('type', $category->type) == $key ? ' selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('type'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('type') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="color">رنگ</label>
                            <input dir="ltr" id="color" type="text"
                                   class="color form-control{{ $errors->has('color') ? ' is-invalid' : '' }}"
                                   name="color" value="{{ old('color', $category->color) }}">

                            @if ($errors->has('color'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('color') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="icon">آیکون</label>
                            <input dir="ltr" id="icon" type="text"
                                   class="form-control{{ $errors->has('icon') ? ' is-invalid' : '' }}" name="icon"
                                   value="{{ old('icon', $category->icon) }}">

                            @if ($errors->has('icon'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('icon') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="enabled">فعال</label>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="enableRadioYes" name="enabled"
                                       value="1"
                                       class="custom-control-input"{{ old('enabled', $category->enabled) == true  ? ' checked' : '' }}>
                                <label class="custom-control-label" for="enableRadioYes">بلی</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="enableRadioNo" name="enabled"
                                       value="0"
                                       class="custom-control-input"{{ old('enabled', $category->enabled) == false  ? ' checked' : '' }}>
                                <label class="custom-control-label" for="enableRadioNo">خیر</label>
                            </div>
                            @if ($errors->has('enabled'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('enabled') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i>
                            ویرایش دسته
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        $('.color').colorPicker(); // that's it
    </script>
@endsection
