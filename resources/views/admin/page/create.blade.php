@extends('layouts.app')
@section('title', 'ایجاد صفحه جدید - ')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-3">
            @include('admin.sidebar')
        </div>
        <div class="col-md-9">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ config('platform.name') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">مدیریت سیستم</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.page') }}"> صفحه ها</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('admin.page.create') }}">ایجاد
                            صفحه جدید</a></li>
                </ol>
            </nav>
            <div class="card card-default">
                <div class="card-header">ایجاد صفحه جدید
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.page.insert') }}">
                        @csrf
                        @method('post')
                        <div class="form-group">
                            <label for="title">عنوان</label>
                            <input id="title" type="text"
                                   class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title"
                                   value="{{ old('title') }}" required autofocus>
                            @if ($errors->has('title'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="title">لینک Slug</label>
                            <input id="slug" type="text"
                                   class="form-control{{ $errors->has('slug') ? ' is-invalid' : '' }}" name="slug"
                                   value="{{ old('slug') }}" required>
                            @if ($errors->has('slug'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('slug') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="description">توضیحات</label>

                            <textarea class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                                      name="description" id="description"> {{ old('description') }}</textarea>

                            @if ($errors->has('description'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="text">محتوای صفحه</label>
                            <textarea class="wysiwyg form-control{{ $errors->has('text') ? ' is-invalid' : '' }}" name="text"
                                      id="text" required>{{ old('text') }}</textarea>

                            @if ($errors->has('text'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('text') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="access">دسترسی</label>

                            <select name="access" id="access" class="form-control">
                                <option value="public"{{ old('access') == 'public'  ? ' selected' : '' }}>عمومی</option>
                                <option value="private"{{ old('access') == 'private' ? ' selected' : '' }}>فقط اعضا
                                </option>
                            </select>
                            @if ($errors->has('access'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('access') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-plus"></i>
                            ایجاد صفحه
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
