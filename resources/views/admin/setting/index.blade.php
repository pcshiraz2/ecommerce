@extends('layouts.app')
@section('title', 'تنظیمات - ')
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
                            <div class="form-group">
                                <label for="setting_{{$setting->id}}">
                                    {{-- <a href="{{route('admin.setting.edit',['id'=>$setting->id])}}" class="btn btn-outline-primary btn-sm"><i class="fa fa-edit"></i></a> --}}

                                    {{$setting->title}}</label>

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
                                        <select id="setting_{{$setting->id}}" class="form-control select2" name="setting_{{$setting->id}}">
                                            @foreach($setting->options as $key => $value)
                                                <option value="{{$key}}"{{ $key == old('setting_'.$setting->id,config($setting->key))  ? ' selected' : '' }}>{{$value}}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                    @if($setting->type == 'select-table')
                                        <select id="setting_{{$setting->id}}" class="form-control select2"
                                                name="setting_{{$setting->id}}">
                                            @php
                                                $table = $setting->options['table'];
                                                $column = $setting->options['attrib'];
                                                $products = DB::table($table)->get();
                                            @endphp
                                            @foreach($products as $product)
                                                <option value="{{$product->id}}"{{ $product->id == old('setting_'.$setting->id,config($setting->key))  ? ' selected' : '' }}>{{ $product->{$column} }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                        @if($setting->type == 'select-model')
                                            <select id="setting_{{$setting->id}}" class="form-control select2"
                                                    name="setting_{{$setting->id}}">
                                                @php
                                                    $modelClass = $setting->options['model'];
                                                    $models = $modelClass::all();
                                                    $column = $setting->options['attrib'];
                                                @endphp
                                                @foreach($models as $model)
                                                    <option value="{{$model->id}}"{{ $model->id == old('setting_'.$setting->id,config($setting->key))  ? ' selected' : '' }}>{{ $model->{$column} }}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                    @if($setting->type == 'yesno')
                                    <div class="form-group">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="enable{{$setting->id}}RadioYes" name="setting_{{$setting->id}}"
                                                   value="1"
                                                   class="custom-control-input"{{ old('setting_'.$setting->id,config($setting->key)) == true  ? ' checked' : '' }}>
                                            <label class="custom-control-label" for="enable{{$setting->id}}RadioYes">بله</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="enable{{$setting->id}}RadioNo" name="setting_{{$setting->id}}"
                                                   value="0"
                                                   class="custom-control-input"{{ old('setting_'.$setting->id,config($setting->key)) == false  ? ' checked' : '' }}>
                                            <label class="custom-control-label" for="enable{{$setting->id}}RadioNo">خیر</label>
                                        </div>
                                    </div>
                                    @endif
                                    @if($setting->type == 'enable')
                                    <div class="form-group">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="enable{{$setting->id}}RadioYes" name="setting_{{$setting->id}}"
                                                   value="1"
                                                   class="custom-control-input"{{ old('setting_'.$setting->id,config($setting->key)) == true  ? ' checked' : '' }}>
                                            <label class="custom-control-label" for="enable{{$setting->id}}RadioYes">فعال</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="enable{{$setting->id}}RadioNo" name="setting_{{$setting->id}}"
                                                   value="0"
                                                   class="custom-control-input"{{ old('setting_'.$setting->id,config($setting->key)) == false  ? ' checked' : '' }}>
                                            <label class="custom-control-label" for="enable{{$setting->id}}RadioNo">غیر فعال</label>
                                        </div>
                                    </div>
                                    @endif

                                    <small id="setting_{{$setting->id}}Help"
                                           class="form-text">{{$setting->description}}</small>
                            </div>
                        @endforeach
                        <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-mobile">
                                    <i class="fa fa-save"></i>
                                    ذخیره تنظیمات
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
