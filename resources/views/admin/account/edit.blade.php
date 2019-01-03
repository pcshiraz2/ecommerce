@extends('layouts.app')
@section('title', 'ویرایش حساب ' . $account->title .' - ')
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
                    <li class="breadcrumb-item"><a href="{{ route('admin.account') }}">حساب ها</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a
                                href="{{ route('admin.account.edit',['id' => $account->id]) }}">ویرایش
                            دسته {{ $account->title }}</a></li>
                </ol>
            </nav>
            <div class="card card-default">
                <div class="card-header">ویرایش دسته {{ $account->title }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.account.update',['id' => $account->id]) }}">
                        @csrf
                        @method('post')
                        <div class="form-group">
                            <label for="title">عنوان</label>
                            <input id="title" type="text"
                                   class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title"
                                   value="{{ old('title',$account->title) }}" required autofocus>

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
                                   value="{{ old('order',$account->order) }}">

                            @if ($errors->has('order'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('order') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i>
                            ویرایش حساب
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection
