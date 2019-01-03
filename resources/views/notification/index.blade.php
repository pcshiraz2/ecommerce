@extends('layouts.app')

@section('title', "اطلاعیه ها - ")

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ config('platform.name') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('notification') }}">اطلاعیه
                            ها</a></li>
                </ol>
            </nav>
            <h1>اطلاعیه ها</h1>
            <div class="card card-default">
                <div class="card-header">اطلاعیه ها</div>
                <div class="list-group list-group-flush">
                    @if($notifications->count() > 0)
                        @foreach($notifications as $notification)
                            <a href="{{route('notification.view', ['id'=>$notification->id])}}"
                               class="list-group-item list-group-item-action flex-column align-items-start">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">{{ $notification->data['title'] }}</h5>
                                    <small>{{ jdate($notification->created_at)->ago() }}</small>
                                </div>
                            </a>
                        @endforeach
                    @else
                        <div class="list-group-item list-group-item-action flex-column align-items-start">هیچ اطلاعیه
                            خوانده نشده ای وجود ندارد.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection
