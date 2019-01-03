@extends('layouts.app')

@section('title', $page->title . "-")

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ config('platform.name') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a
                                href="{{ route('page',['id' => $page->id]) }}">{{ $page->title }}</a></li>
                </ol>
            </nav>
            <h1>{{ $page->title }}
                <small class="text-muted">{{ $page->description }}</small>
                @if(Auth::check())
                    @can('pages')
                        <a href="{{ route('admin.page.edit',['id' => $page->id])  }}"
                           class="btn btn-primary pull-left btn-sm"><i class="fa fa-edit"></i> ویرایش صفحه</a>
                    @endif
                @endif
            </h1>
            <div class="card card-default">
                <div class="card-header">{{ $page->title }}</div>
                <div class="card-body">
                    {!! $page->text  !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection
