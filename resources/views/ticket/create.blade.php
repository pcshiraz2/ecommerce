@extends('layouts.app')

@section('title', "ایجاد تیکت جدید - ")

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ config('platform.name') }}</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('ticket') }}">پشتیبانی</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('ticket.create') }}">ایجاد تیکت
                            جدید</a></li>
                </ol>
            </nav>
            <h1>ایجاد تیکت جدید</h1>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card card-default">
                        <div class="card-header">ایجاد تیکت جدید</div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('ticket.insert') }}" enctype="multipart/form-data">
                                @csrf
                                @method('post')
                                @if(Auth::user()->level != 'user')
                                    <div class="form-group">
                                        <label for="user_id">مخاطب</label>

                                            <select id="user_id" name="user_id"
                                                    class="form-control{{ $errors->has('user_id') ? ' is-invalid' : '' }}">
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}"{{old('user_id') == $user->id ? ' selected' : ''}}>{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('user_id'))
                                                <span class="invalid-feedback"><strong>{{ $errors->first('user_id') }}</strong></span>
                                            @endif

                                    </div>
                                @endif
                                <div class="form-group">
                                    <label for="title">عنوان</label>

                                        <input id="title" type="text"
                                               class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                               name="title" value="{{ old('title') }}" required autofocus>
                                        @if ($errors->has('title'))
                                            <span class="invalid-feedback"><strong>{{ $errors->first('title') }}</strong></span>
                                        @endif

                                </div>

                                <div class="form-group">
                                    <label for="level">موضوع</label>


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
                                <div class="form-group">
                                    <label for="priority">اهمیت</label>

                                        <select id="priority" name="priority"
                                                class="form-control{{ $errors->has('priority') ? ' is-invalid' : '' }}">
                                            <option value="normal"{{old('priority') == 'normal' ? ' selected' : ''}}>
                                                عادی
                                            </option>
                                            <option value="not_important"{{old('priority') == 'important' ? ' selected' : ''}}>
                                                مهم
                                            </option>
                                            <option value="important"{{old('priority') == 'urgent' ? ' selected' : ''}}>
                                                ضروری
                                            </option>
                                        </select>
                                        @if ($errors->has('priority'))
                                            <span class="invalid-feedback"><strong>{{ $errors->first('priority') }}</strong></span>
                                        @endif

                                </div>
                                <div class="form-group">
                                    <label for="text">متن</label>

                                        <textarea name="text" id="text"
                                                  class="form-control{{ $errors->has('text') ? ' is-invalid' : '' }}">{{old('text')}}</textarea>
                                        @if ($errors->has('text'))
                                            <span class="invalid-feedback"><strong>{{ $errors->first('text') }}</strong></span>
                                        @endif

                                </div>


                                <div class="form-group">

                                        <button type="submit" class="btn btn-primary btn-mobile">
                                            <i class="fa fa-send"></i>
                                            ارسال تیکت جدید
                                        </button>

                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

