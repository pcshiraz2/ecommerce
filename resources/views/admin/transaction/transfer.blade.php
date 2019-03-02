@extends('layouts.app')
@section('title', 'انتقال وجه - ')
@section('css')

@endsection

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
                    <li class="breadcrumb-item"><a href="{{ route('admin.transaction') }}">تراکنش ها</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('admin.transaction.create.transfer') }}"> انتقال وجه</a></li>
                </ol>
            </nav>
            <div class="card card-default">
                <div class="card-header">انتقال وجه</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.transaction.insert.transfer') }}" onsubmit="$('.price').unmask();">
                        @csrf
                        @method('post')
                        <input type="hidden" name="type" value="transfer"/>

                        <div class="form-group">
                            <label for="amount">مبلغ</label>
                            <div class="input-group mb-2 ml-sm-2">
                                <input id="amount" type="text" dir="ltr"
                                       class="price form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}"
                                       name="amount" value="{{ old('amount') }}" required autofocus>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">{{ trans('currency.'.config('platform.currency')) }}</div>
                                </div>
                            </div>
                            @if ($errors->has('amount'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('amount') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="transaction_at">تاریخ</label>
                            <div dir="ltr">
                                <date-picker
                                        id="transaction_at"
                                        name="transaction_at"
                                        format="jYYYY/jMM/jDD"
                                        display-format="jYYYY/jMM/jDD"
                                        color="#6838b8"
                                        type="date"
                                        value="{{ old('transaction_at') }}"
                                        placeholder="____/__/__">
                                </date-picker>
                            </div>
                            <span class="form-text text-muted"></span>
                            @if ($errors->has('transaction_at'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('transaction_at') }}</strong>
                                    </span>
                            @endif
                        </div>

                            <div class="form-group">
                                <label for="source_account_id">مبدا</label>

                                <select name="source_account_id" id="source_account_id" class="form-control">
                                    @foreach($accounts as $account)
                                        <option value="{{ $account->id }}"{{ old('source_account_id') == $account->id  ? ' selected' : '' }}>{{$account->name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('source_account_id'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('source_account_id') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="destination_account_id">مقصد</label>

                                <select name="destination_account_id" id="destination_account_id" class="form-control">
                                    @foreach($accounts as $account)
                                        <option value="{{ $account->id }}"{{ old('destination_account_id') == $account->id  ? ' selected' : '' }}>{{$account->name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('destination_account_id'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('destination_account_id') }}</strong>
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

                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-plus"></i>
                            ثبت تراکنش
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $("#user_id").select2({
            dir: "rtl",
            language: "fa",
            ajax: {
                url: "{{ route('admin.ajax.users') }}",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        search: params.term, // search term
                    };
                },
                processResults: function (data, params) {
                    return {
                        results: $.map(data.data, function(item) {
                            if(item.title) {
                                return { id: item.id, text: item.first_name + ' ' + item.last_name + '(' + item.title + ')' };
                            } else {
                                return { id: item.id, text: item.first_name + ' ' + item.last_name };
                            }

                        })
                    };
                },
                cache: true
            },
            placeholder: 'جستجوی شخص',
            minimumInputLength: 3,
        });
    </script>
@endsection
