@extends('layouts.app')
@section('title', 'تنظیمات - ')
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
                    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('admin.setting') }}">تنظیمات</a>
                    </li>
                </ol>
            </nav>
            <div class="card card-default">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">
                        @foreach($categories as $category)
                            @if($category->id == 1 && Request::segment(3) != 'category')
                                <li class="nav-item">
                                    <a class="nav-link active"
                                       href="{{route('admin.setting.category',['id'=>$category->id])}}">{{$category->title}}</a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link{{ Request::segment(4) == $category->id  ? ' active' : '' }}"
                                       href="{{route('admin.setting.category',['id'=>$category->id])}}">{{$category->title}}</a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.setting.category.update',['id' => $id]) }}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        @foreach($settings as $setting)
                            <div class="form-group row">
                                <label for="setting_{{$setting->id}}"
                                       class="col-md-4 col-form-label @lang('platform.input-pull')">
                                    {{-- <a href="{{route('admin.setting.edit',['id'=>$setting->id])}}" class="btn btn-outline-primary btn-sm"><i class="fa fa-edit"></i></a> --}}

                                    {{$setting->title}}</label>
                                <div class="col-md-7">
                                    @if($setting->type == 'text')
                                        <input id="setting_{{$setting->id}}" type="text" class="form-control"
                                               name="setting_{{$setting->id}}"
                                               value="{{ old('setting_'.$setting->id,config($setting->key)) }}">
                                    @endif
                                    @if($setting->type == 'text-ltr')
                                        <input dir="ltr" id="setting_{{$setting->id}}" type="text" class="form-control"
                                               name="setting_{{$setting->id}}"
                                               value="{{ old('setting_'.$setting->id,config($setting->key)) }}">
                                    @endif
                                    @if($setting->type == 'file')
                                        <input id="setting_{{$setting->id}}" type="file" class="form-control"
                                               name="setting_{{$setting->id}}"
                                               value="{{ old('setting_'.$setting->id,config($setting->key)) }}">
                                    @endif
                                    @if($setting->type == 'textarea')
                                        <textarea id="setting_{{$setting->id}}" class="form-control"
                                                  name="setting_{{$setting->id}}">{{ old('setting_'.$setting->id,config($setting->key)) }}</textarea>
                                    @endif
                                    @if($setting->type == 'select')
                                        <select id="setting_{{$setting->id}}" class="form-control"
                                                name="setting_{{$setting->id}}">
                                            @php
                                                $options = explode(",",$setting->options);
                                            @endphp
                                            @foreach($options as $option)
                                                <option value="{{$option}}"{{ $option == old('setting_'.$setting->id,config($setting->key))  ? ' selected' : '' }}>{{$option}}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                    @if($setting->type == 'select-table')
                                        <select id="setting_{{$setting->id}}" class="form-control"
                                                name="setting_{{$setting->id}}">
                                            @php
                                                $options = explode(",",$setting->options);
                                                $table = $options[0];
                                                $column = $options[1];
                                                $products = DB::table($table)->get();
                                            @endphp
                                            @foreach($products as $product)
                                                <option value="{{$product->id}}"{{ $product->id == old('setting_'.$setting->id,config($setting->key))  ? ' selected' : '' }}>{{ $product->{$column} }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                    @if($setting->type == 'yesno')
                                        <select id="setting_{{$setting->id}}" class="form-control"
                                                name="setting_{{$setting->id}}">
                                            <option value="yes"{{ 'yes' == old('setting_'.$setting->id,config($setting->key))  ? ' selected' : '' }}>
                                                بلی
                                            </option>
                                            <option value="no"{{ 'no' == old('setting_'.$setting->id,config($setting->key))  ? ' selected' : '' }}>
                                                خیر
                                            </option>
                                        </select>
                                    @endif
                                    @if($setting->type == 'enable')
                                        <select id="setting_{{$setting->id}}" class="form-control"
                                                name="setting_{{$setting->id}}">
                                            <option value="1"{{ '1' == old('setting_'.$setting->id,config($setting->key))  ? ' selected' : '' }}>
                                                بلی
                                            </option>
                                            <option value="0"{{ '0' == old('setting_'.$setting->id,config($setting->key))  ? ' selected' : '' }}>
                                                خیر
                                            </option>
                                        </select>
                                    @endif
                                    <small id="setting_{{$setting->id}}Help"
                                           class="form-text">{{$setting->description}}</small>
                                </div>
                            </div>
                        @endforeach
                        <div class="form-group row mb-0">
                            <div class="col-md-7 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i>
                                    ذخیره تنظیمات
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection
