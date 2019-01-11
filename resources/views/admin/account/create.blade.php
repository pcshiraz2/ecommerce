@extends('layouts.app')
@section('title', 'ایجاد حساب جدید - ')
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
                    <li class="breadcrumb-item"><a href="{{ route('admin.account') }}"> حساب ها</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a
                                href="{{ route('admin.account.create') }}">ایجاد حساب جدید</a></li>
                </ol>
            </nav>
            <div class="card card-default">
                <div class="card-header">ایجاد حساب جدید
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.account.insert') }}">
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
                            <label for="order">ترتیب</label>
                            <input dir="ltr" id="order" type="number"
                                   class="form-control{{ $errors->has('order') ? ' is-invalid' : '' }}" name="order"
                                   value="{{ old('order') }}">

                            @if ($errors->has('order'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('order') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-plus"></i>
                            ایجاد حساب
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @include('global.ckeditor',['editors' => ['text']])
@endsection
