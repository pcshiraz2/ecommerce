@extends('layouts.app')

@section('title', $article->title . "-")

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12 mb-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ config('platform.name') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a
                                href="{{ route('article.view',['id' => $article->id]) }}">{{ $article->title }}</a></li>
                </ol>
            </nav>
            <h1>{{ $article->title }}
                <small class="text-muted">{{ $article->description }}</small>
                @if(Auth::check())
                    @if(Auth::user()->level == 'admin')
                        <a href="{{ route('admin.article.edit',['id' => $article->id])  }}"
                           class="btn btn-primary pull-left btn-sm"><i class="fa fa-edit"></i> ویرایش مقاله</a>
                    @endif
                @endif
            </h1>
        </div>
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">{{ $article->title }}</div>
                <div class="card-body">
                    {!! $article->text  !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection
