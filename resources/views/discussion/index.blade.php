@extends('layouts.app')

@section('title', "انجمن - ")

@section('css')

@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ config('platform.name') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('discussion') }}">انجمن</a>
                    </li>
                </ol>
            </nav>
            <h1>انجمن</h1>
            <div class="row justify-content-center">
                <div class="col-md-3">
                    @include('discussion.sidebar',['categories'=>$categories])
                </div>
                <div class="col-md-9">
                    <div class="card card-default">
                        <div class="card-header">
                            مباحث انجمن
                        </div>
                        <ul class="list-group list-group-flush">
                            @foreach($discussions as $discussion)
                                <a href="{{route('discussion.view', ['id'=>$discussion->id])}}"
                                   class="list-group-item list-group-item-action flex-column align-items-start">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">{{$discussion->title}}<span class="badge badge-dark">({{ $discussion->category->title }})</span>
                                        </h5>
                                        <small>
                                            {{ jdate($discussion->created_at)->ago() }}
                                            <br/>
                                            {{ $discussion->user->name }}
                                        </small>
                                    </div>
                                </a>
                            @endforeach
                        </ul>
                    </div>
                    {{ $discussions->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection
