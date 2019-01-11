@extends('layouts.app')

@section('title', "جستجوی تیکت - ")

@section('css')

@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ config('platform.name') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ticket') }}">پشتیبانی</a></li>
                    <li class="breadcrumb-item active" aria-current="page">جستجوی تیکت</li>
                </ol>
            </nav>
        </div>
        <div class="col-md-12">
            <h1>جستجوی تیکت</h1>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-{{ config('platform.sidebar-size') }}">

            @include('sidebar')
        </div>
        <div class="col-md-{{ config('platform.content-size') }}">
            <form action="{{ route('ticket.search') }}" method="post">
                @csrf
                @method('post')
                <div class="row">
                    <div class="col-md-7 mb-2">
                        <input type="text" name="keyword" value=" {{ old('keyword', $keyword) }}" class="form-control"
                               id="keyword" placeholder="جستجو...">
                    </div>
                    <div class="col-md-3 mb-2">
                        <select name="status" class="form-control">
                            <option value="any"{{ old('status', $status) == 'any' ? ' selected' : ''}}>انتخاب وضعیت
                            </option>
                            <option value="staff"{{ old('status', $status) == 'staff' ? ' selected' : ''}}>پاسخ
                                پشتیبان
                            </option>
                            <option value="user"{{ old('status', $status) == 'user' ? ' selected' : ''}}>پاسخ کاربر
                            </option>
                            <option value="waiting"{{ old('status', $status) == 'waiting' ? ' selected' : ''}}>در انتظار
                                بررسی
                            </option>
                            <option value="close"{{ old('status', $status) == 'close' ? ' selected' : ''}}>بسته شده
                            </option>
                            <option value="lock"{{ old('status', $status) == 'lock' ? ' selected' : ''}}>قفل شده
                            </option>
                            <option value="done"{{ old('status', $status) == 'done' ? ' selected' : ''}}>انجام شده
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-2">
                        <button type="submit" class="btn btn-primary btn-mobile"><i class="fa fa-search"></i> جستجو
                        </button>
                    </div>
                </div>


            </form>
            <div class="card card-default">
                <div class="card-header">
                    تیکت های شما
                    <a href="{{ route('ticket.create')  }}" class="btn btn-primary pull-left mb-2 btn-sm"><i
                                class="fa fa-ticket"></i>ایجاد تیکت جدید</a>
                </div>
                <ul class="list-group list-group-flush">
                    @foreach($tickets as $ticket)
                        <a href="{{route('ticket.view', ['id'=>$ticket->id])}}"
                           class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-between">
                                <h5>
                                    {{$ticket->title}}
                                    @if($ticket->priority == 'urgent')
                                        <span class="badge badge-danger">ضروری</span>
                                    @endif
                                    @if($ticket->priority == 'important')
                                        <span class="badge badge-warning">مهم</span>
                                    @endif
                                    <p>{{ $ticket->category->title }}</p>
                                </h5>
                                <small>
                                    {{ jdate($ticket->created_at)->ago() }}
                                    <br/>
                                    {{ $ticket->user->name }}
                                    <br/>
                                    <span class="badge badge-info">
                                            @if($ticket->status == 'open')
                                            <i class="fa fa-certificate" aria-hidden="true"></i>
                                            جدید
                                        @endif
                                        @if($ticket->status == 'close')
                                            <i class="fa fa-window-close"></i>
                                            بسته شده
                                        @endif
                                        @if($ticket->status == 'staff')
                                            <i class="fa fa-user-md" aria-hidden="true"></i>
                                            پاسخ پشتیبانی
                                        @endif
                                        @if($ticket->status == 'user')
                                            <i class="fa fa-user"></i>
                                            پاسخ کاربر
                                        @endif
                                        @if($ticket->status == 'waiting')
                                            <i class="fa fa-hourglass-start"></i>
                                            در انتظار بررسی
                                        @endif
                                        @if($ticket->status == 'lock')
                                            <i class="fa fa-lock"></i>
                                            قفل شده
                                        @endif
                                        @if($ticket->status == 'done')
                                            <i class="fa fa-check"></i>
                                            انجام شد
                                        @endif
                                            </span>
                                </small>
                            </div>
                        </a>
                    @endforeach
                </ul>
            </div>
            {{ $tickets->links() }}
        </div>
    </div>
@endsection

@section('js')

@endsection
