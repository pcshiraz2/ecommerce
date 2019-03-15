@extends('layouts.app')

@section('title', "مقالات - ")

@section('css')

@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ config('platform.name') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('article') }}">مقالات</a>
                    </li>
                </ol>
            </nav>
            <h1>مقالات</h1>
            <div class="row justify-content-center">
                <div class="col-md-{{ config('platform.sidebar-size') }}">
                    @include('article.sidebar',['categories'=>$categories])
                </div>
                <div class="col-md-{{ config('platform.content-size') }}">
                    <div class="card card-default">
                        <div class="card-header">
                            مقالات
                        </div>
                        <ul class="list-group list-group-flush">
                            @foreach($articles as $article)
                                <a href="{{route('article.view', ['id'=>$article->id])}}"
                                   class="list-group-item list-group-item-action flex-column align-items-start">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">{{$article->title}}<span class="badge badge-dark">({{ $article->category->title }})</span>
                                        </h5>
                                        <small>
                                            {{ jdate($article->created_at)->ago() }}
                                        </small>
                                    </div>
                                </a>
                            @endforeach
                        </ul>
                    </div>
                    {{ $articles->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection
