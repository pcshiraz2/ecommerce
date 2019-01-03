@extends('layouts.app')

@section('title', $discussion->title . " -" )

@section('css')

@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ config('platform.name') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('discussion') }}">انجمن</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a
                                href="{{ route('discussion.view', ['id' => $discussion->id]) }}">{{ $discussion->title }}</a>
                    </li>
                </ol>
            </nav>
            <h1>{{ $discussion->title }}</h1>
            <div class="row justify-content-center">
                <div class="col-md-3">
                    @include('discussion.sidebar',['categories'=>$categories])
                </div>
                <div class="col-md-9">
                    <div class="card card-default mb-2">
                        <div class="card-header">
                            {{ $discussion->title }} ({{$discussion->user->name}})
                            <span class="badge badge-dark pull-left">{{ jdate($discussion->created_at)->ago() }}</span>
                        </div>
                        <div class="card-body">
                            {!! $discussion->text  !!}
                        </div>
                    </div>
                    @foreach($posts as $post)
                        @if($post->user_id == $discussion->user_id)
                            <div class="card card-default ml-5 mb-2">
                                <div class="card-header">
                                    {{ $post->user->name }}
                                    @if($post->user->title)
                                        ({{$post->user->title}})
                                    @endif
                                    <span class="badge badge-dark pull-left">{{ jdate($post->created_at)->ago() }}</span>
                                </div>
                                <div class="card-body">
                                    {!! nl2br($post->text)  !!}
                                </div>
                            </div>
                        @else
                            <div class="card card-default mr-5 mb-2">
                                <div class="card-header">
                                    {{ $post->user->name }}
                                    @if($post->user->title)
                                        ({{$post->user->title}})
                                    @endif
                                    <span class="badge badge-dark pull-left">{{ jdate($post->created_at)->ago() }}</span>
                                </div>
                                <div class="card-body">
                                    {!! nl2br($post->text)  !!}
                                </div>
                            </div>
                        @endif
                    @endforeach
                    {{ $posts->links() }}
                    @auth
                        <div class="card card-default">
                            <div class="card-header">پاسخ به بحث</div>

                            <div class="card-body">
                                <form method="POST" action="{{ route('discussion.post',['id'=>$discussion->id]) }}"
                                      enctype="multipart/form-data">
                                    @csrf
                                    @method('post')
                                    <div class="form-group">
                                        <label for="text">متن</label>
                                        <textarea name="text" id="text"
                                                  class="form-control{{ $errors->has('text') ? ' is-invalid' : '' }}">{{old('text')}}</textarea>
                                        @if ($errors->has('text'))
                                            <span class="invalid-feedback"><strong>{{ $errors->first('text') }}</strong></span>
                                        @endif
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-mobile"><i class="fa fa-send"></i>ارسال
                                        پاسخ
                                    </button>
                                </form>
                            </div>

                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection
