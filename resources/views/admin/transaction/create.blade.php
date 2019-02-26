@extends('layouts.app')
@if(Request::segment(4) == 'income')
    @section('title', 'ثبت درآمد - ')
@elseif(Request::segment(4) == 'expense')
    @section('title', 'ثبت هزینه - ')
@endif
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
                    @if(Request::segment(4) == 'income')
                        <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('admin.transaction.create.income') }}"> ثبت درآمد</a></li>
                    @elseif(Request::segment(4) == 'expense')
                        <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('admin.transaction.create.expense') }}"> ثبت هزینه</a></li>
                    @elseif(Request::segment(4) == 'transfer')
                        <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('admin.transaction.create.transfer') }}"> انتقال وجه</a></li>
                    @endif

                </ol>
            </nav>
            <div class="card card-default">
                <div class="card-header">
                    @if(Request::segment(4) == 'income')
                        ثبت درآمد
                    @elseif(Request::segment(4) == 'expense')
                        ثبت هزینه
                    @elseif(Request::segment(4) == 'transfer')
                        انتقال وجه
                    @endif
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.transaction.insert') }}" onsubmit="$('.price').unmask();">
                        @csrf
                        @method('post')
                        @if(Request::segment(4) == 'income')
                            <input type="hidden" name="type" value="income"/>
                        @elseif(Request::segment(4) == 'expense')
                            <input type="hidden" name="type" value="expense"/>
                        @elseif(Request::segment(4) == 'transfer')
                            <input type="hidden" name="type" value="transfer"/>
                        @endif
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
                        @if(Request::segment(4) == 'income' || Request::segment(4) == 'expense')
                        <div class="form-group">
                            <label for="paid_at">تاریخ
                                @if(Request::segment(4) == 'income')
                                    دریافت
                                @elseif(Request::segment(4) == 'expense')
                                    پرداخت
                                @endif
                                <span class="font-weight-light font-italic"> - اختیاری</span>
                            </label>
                            <div dir="ltr">
                                <date-picker
                                        id="paid_at"
                                        name="paid_at"
                                        format="jYYYY/jMM/jDD"
                                        display-format="jYYYY/jMM/jDD"
                                        color="#6838b8"
                                        type="date"
                                        value="{{ old('paid_at') }}"
                                        placeholder="____/__/__">
                                </date-picker>
                            </div>
                            <span class="form-text text-muted">در صورتی که تراکنش پرداخت شده است تاریخ را بنویسید.</span>
                            @if ($errors->has('paid_at'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('paid_at') }}</strong>
                                    </span>
                            @endif
                        </div>
                            <div class="form-group">
                                <label for="category_id">دسته</label>

                                <select name="category_id" id="category_id" class="form-control">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}"{{ old('category_id') == $category->id  ? ' selected' : '' }}>{{$category->title}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('category_id'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('category_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="account_id">حساب</label>

                                <select name="account_id" id="account_id" class="form-control">
                                    @foreach($accounts as $account)
                                        <option value="{{ $account->id }}"{{ old('account_id') == $account->id  ? ' selected' : '' }}>{{$account->title}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('account_id'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('account_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="user_id">شخص</label>

                                <select name="user_id" id="user_id" class="form-control"></select>
                                @if ($errors->has('user_id'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('user_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        @else
                            <div class="form-group">
                                <label for="account_id">مبدا</label>

                                <select name="account_id" id="account_id" class="form-control">
                                    @foreach($accounts as $account)
                                        <option value="{{ $account->id }}"{{ old('account_id') == $account->id  ? ' selected' : '' }}>{{$account->title}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('account_id'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('account_id') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="account_id">مقصد</label>

                                <select name="account_id" id="account_id" class="form-control">
                                    @foreach($accounts as $account)
                                        <option value="{{ $account->id }}"{{ old('account_id') == $account->id  ? ' selected' : '' }}>{{$account->title}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('account_id'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('account_id') }}</strong>
                                    </span>
                                @endif
                            </div>


                            @endif
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
