@extends('layouts.app')
@section('title', 'ویرایش مشخصه ' . $attribute->title .' - ')
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
                    <li class="breadcrumb-item"><a href="{{ route('admin.product') }}">کالاها</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.product.attribute',[$attribute->product->id]) }}">مشخصه های {{$attribute->product->title}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">ویرایش مشخصه {{ $attribute->attribute->title }}</li>
                </ol>
            </nav>
            <div class="card card-default">
                <div class="card-header">مشخصه جدید</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.product.attribute.update',['id' => $attribute->id]) }}" onsubmit="$('.price').unmask();"
                          enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        <div class="form-group">
                            <label for="category_id">دسته</label>
                            <select class="form-control selector"
                                    onchange="selectAttributes(this.value);"
                                    name="category_id" id="category_id">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"{{ old('category_id', $attribute->attribute->category_id) == $category->id ? ' selected' :'' }}>{{ $category->title }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('category_id'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('category_id') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="attribute_id">ویژگی</label>
                            <select class="form-control selector"
                                    name="attribute_id" id="attribute_id">
                                @foreach($attributes as $item)
                                    <option value="{{ $item->id }}"{{ old('attribute_id', $attribute->attribute->id) == $item->id ? ' selected' :'' }}>{{ $item->title }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('attribute_id'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('attribute_id') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="value">مقدار</label>
                            <input id="value" type="text"
                                   class="form-control{{ $errors->has('value') ? ' is-invalid' : '' }}"
                                   name="value" value="{{ old('value', $attribute->value) }}" required>
                            @if ($errors->has('value'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('value') }}</strong>
                                    </span>
                            @endif
                        </div>



                        <div class="form-group">
                            <label for="order">
                                ترتیب
                                <span class="font-weight-light font-italic"> - اختیاری</span>
                            </label>
                            <input dir="ltr" id="order" type="text"
                                   class="form-control{{ $errors->has('order') ? ' is-invalid' : '' }}"
                                   name="order" value="{{ old('order', $attribute->order) }}">
                            @if ($errors->has('order'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('order') }}</strong>
                                    </span>
                            @endif
                        </div>


                        <div class="form-group">
                            <label for="enabled">فعال</label>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="enableRadioYes" name="enabled"
                                       value="1"
                                       class="custom-control-input"{{ old('enabled',true) == true  ? ' checked' : '' }}>
                                <label class="custom-control-label" for="enableRadioYes">بلی</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="enableRadioNo" name="enabled"
                                       value="0"
                                       class="custom-control-input"{{ old('enabled',true) == false  ? ' checked' : '' }}>
                                <label class="custom-control-label" for="enableRadioNo">خیر</label>
                            </div>
                            @if ($errors->has('enabled'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('enabled') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-plus"></i>
                            افزودن مشخصه
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function selectAttributes (category_id) {
            axios.post('{{ route('admin.ajax.attributes') }}', {'category_id': category_id}).then(function (response) {
                $('#attribute_id').html('');
                for (var i = 0, len = response.data.length; i < len; i++) {
                    var attribute = new Option(response.data[i].title, response.data[i].id, false, false);
                    $('#attribute_id').append(attribute).trigger('change');
                }
            }).catch(function (error) {
                console.log(error);
            });
        }
    </script>
@endsection
