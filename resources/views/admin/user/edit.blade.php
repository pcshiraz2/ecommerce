@extends('layouts.app')
@section('title', 'ویرایش کاربر ' . $user->name .' - ')
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
                    <li class="breadcrumb-item"><a href="{{ route('admin.user') }}">کاربرها</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a
                                href="{{ route('admin.user.edit',['id' => $user->id]) }}">ویرایش
                            کاربر {{ $user->name }}</a></li>
                </ol>
            </nav>
            <div class="card card-default">
                <div class="card-header">ویرایش کاربر {{ $user->name }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.user.update', ['id' => $user->id]) }}">
                        @csrf
                        @method('post')
                        <div class="form-group">
                            <label for="first_name">نام</label>

                            <input id="first_name" type="text"
                                   class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name"
                                   value="{{ old('first_name', $user->first_name) }}" required autofocus>
                            @if ($errors->has('first_name'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="last_name">نام خانوادگی</label>

                            <input id="last_name" type="text"
                                   class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name"
                                   value="{{ old('last_name', $user->last_name) }}" required>
                            @if ($errors->has('last_name'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                            @endif
                        </div>


                        <div class="form-group">
                            <label for="title">عنوان حقوقی</label>

                            <input id="title" type="text"
                                   class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title"
                                   value="{{ old('title', $user->title) }}">
                            @if ($errors->has('title'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="email">پست الکترونیکی</label>

                            <input id="email" type="email" dir="ltr"
                                   class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                                   value="{{ old('email', $user->email) }}" required>

                            @if ($errors->has('email'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif

                        </div>

                        <div class="form-group">
                            <label for="mobile">شماره همراه</label>
                            <input id="mobile" type="text" dir="ltr"
                                   class="form-control{{ $errors->has('mobile') ? ' is-invalid' : '' }}"
                                   name="mobile" value="{{ old('mobile', $user->mobile) }}" required>

                            @if ($errors->has('mobile'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('mobile') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="password">کلمه عبور</label>

                            <input id="password" type="password" dir="ltr"
                                   class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                   name="password">

                            @if ($errors->has('password'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="password-confirm">تکرار
                                کلمه عبور</label>

                            <input id="password-confirm" dir="ltr" type="password" class="form-control"
                                   name="password_confirmation">
                        </div>


                        <div class="form-group">
                            <label for="note">توضیحات</label>


                            <textarea name="note" id="note"
                                      class="form-control{{ $errors->has('note') ? ' is-invalid' : '' }}">{{old('note', $user->note)}}</textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i>
                                ویرایش کاربر
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')


@endsection
