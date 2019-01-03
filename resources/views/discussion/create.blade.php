@extends('layouts.app')

@section('title', "ایجاد بحث جدید - ")

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ config('platform.name') }}</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('discussion') }}">انجمن</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('discussion.create') }}">ایجاد بحث
                            جدید</a></li>
                </ol>
            </nav>
            <h1>ایجاد بحث جدید</h1>
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-header">ایجاد بحث جدید</div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('discussion.insert') }}" enctype="multipart/form-data">
                                @csrf
                                @method('post')
                                <div class="form-group row">
                                    <label for="title" class="col-md-4 col-form-label @lang('platform.input-pull')">عنوان</label>
                                    <div class="col-md-7">
                                        <input id="title" type="text"
                                               class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                               name="title" value="{{ old('title') }}" required autofocus>
                                        @if ($errors->has('title'))
                                            <span class="invalid-feedback"><strong>{{ $errors->first('title') }}</strong></span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="level" class="col-md-4 col-form-label @lang('platform.input-pull')">موضوع</label>

                                    <div class="col-md-7">
                                        <select name="category_id" id="category_id"
                                                class="form-control{{ $errors->has('category_id') ? ' is-invalid' : '' }}">
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}"{{old('category_id') == $category->id ? ' selected' : ''}}>{{$category->title}}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('category_id'))
                                            <span class="invalid-feedback"><strong>{{ $errors->first('category_id') }}</strong></span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="text"
                                           class="col-md-4 col-form-label @lang('platform.input-pull')">متن</label>
                                    <div class="col-md-7">
                                        <textarea name="text" id="text"
                                                  class="form-control{{ $errors->has('text') ? ' is-invalid' : '' }}">{{old('text')}}</textarea>
                                        @if ($errors->has('text'))
                                            <span class="invalid-feedback"><strong>{{ $errors->first('text') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                @if(Auth::user()->level == 'admin')
                                    <div class="form-group row">
                                        <label for="important"
                                               class="col-md-4 col-form-label @lang('platform.input-pull')">مهم</label>
                                        <div class="col-md-7">
                                            <select id="important" name="important"
                                                    class="form-control{{ $errors->has('type') ? ' is-invalid' : '' }}">
                                                <option value="yes"{{old('important') == 'yes' ? ' selected' : ''}}>
                                                    بله
                                                </option>
                                                <option value="no"{{old('important') == 'no' ? ' selected' : ''}}>خیر
                                                </option>
                                            </select>
                                            @if ($errors->has('important'))
                                                <span class="invalid-feedback"><strong>{{ $errors->first('important') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="type" class="col-md-4 col-form-label @lang('platform.input-pull')">وضعیت</label>
                                        <div class="col-md-7">
                                            <select id="type" name="type"
                                                    class="form-control{{ $errors->has('type') ? ' is-invalid' : '' }}">
                                                <option value="normal"{{old('type') == 'normal' ? ' selected' : ''}}>
                                                    عادی
                                                </option>
                                                <option value="done"{{old('type') == 'done' ? ' selected' : ''}}>انجام
                                                    شده
                                                </option>
                                                <option value="close"{{old('type') == 'close' ? ' selected' : ''}}>بسته
                                                    شده
                                                </option>
                                                <option value="lock"{{old('type') == 'lock' ? ' selected' : ''}}>قفل
                                                    شده
                                                </option>
                                            </select>
                                            @if ($errors->has('type'))
                                                <span class="invalid-feedback"><strong>{{ $errors->first('type') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary btn-mobile">
                                            <i class="fa fa-plus"></i>
                                            ارسال بحث جدید
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection