@extends('layouts.app')

@section('title', $ticket->title . " -" )

@section('css')

@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ config('platform.name') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ticket') }}">پشتیبانی</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a
                                href="{{ route('ticket.view', ['id' => $ticket->id]) }}">{{ $ticket->title }}</a></li>
                </ol>
            </nav>
            <h1>{{ $ticket->title }}
                @if($ticket->priority == 'urgent')
                    <span class="badge badge-danger">ضروری</span>
                @endif
                @if($ticket->priority == 'important')
                    <span class="badge badge-warning">مهم</span>
                @endif
            </h1>
        </div>
        <div class="col-md-12">
            <div class="row justify-content-center">
                <div class="col-md-3">
                    @include('sidebar')
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-10">
                            @if($ticket->status == 'lock')
                                <div class="alert alert-warning">
                                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                    این تیکت با توجه به نظر مدیریت و کارشناسان قفل شده است و جهت پیگیری مجدد نیاز است
                                    تیکت جدیدی ایجاد نمایید.
                                </div>
                            @elseif($ticket->status == 'close')
                                <div class="alert alert-info">
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                    این تیکت به صورت سیستمی یا توسط خود شما بسته شده است، لذا در صورتی که می خواهید آن
                                    را مجدد پیگیری کنید برای آن پاسخ ثبت کنید.
                                </div>
                                <div id="accordion">
                                    <div class="card card-info mb-2">
                                        <div class="card-header" data-toggle="collapse" href="#collapseOne"><i
                                                    class="fa fa-arrow-circle-left"></i> پاسخ به تیکت
                                        </div>

                                        <div class="card-body collapse" id="collapseOne" data-parent="#accordion">
                                            <form method="POST"
                                                  action="{{ route('ticket.replay',['id'=> $ticket->id]) }}"
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
                                                <button type="submit" class="btn btn-primary btn-mobile btn-sm"><i
                                                            class="fa fa-send"></i>ارسال پاسخ
                                                </button>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            @elseif($ticket->status == 'done')
                                <div class="alert alert-success">
                                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                                    تیکت شما در این تیکت بررسی شده است و شما آن را به عنوان انجام شده ثبت کرده اید، در
                                    صورت نیاز به پیگیری مجدد تیکت جدیدی ثبت نمایید.
                                </div>
                            @else
                                @if($ticket->status == 'waiting')
                                    <div class="alert alert-info">
                                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                                        تیکت شما توسط کارشناس مشاهده شده است و در دست پیگیری است، لذا صبور باشید.
                                    </div>
                                @endif
                                <div id="accordion">
                                    <div class="card card-info mb-2">
                                        <div class="card-header" data-toggle="collapse" href="#collapseOne"><i
                                                    class="fa fa-arrow-circle-left"></i> پاسخ به تیکت
                                        </div>

                                        <div class="card-body collapse" id="collapseOne" data-parent="#accordion">
                                            <form method="POST"
                                                  action="{{ route('ticket.replay',['id'=> $ticket->id]) }}"
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
                                                <button type="submit" class="btn btn-primary btn-mobile btn-sm"><i
                                                            class="fa fa-send"></i>ارسال پاسخ
                                                </button>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-2 mb-1 mt-2">
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle btn-mobile" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                    اقدام های تیکت
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                    <a class="dropdown-item" href=""><i class="fa fa-paperclip"></i> افزودن پیوست</a>
                                    @if($ticket->status != 'done' && $ticket->status != 'lock' && $ticket->status != 'close' && $ticket->status != 'waiting')
                                        <a class="dropdown-item" href="{{ route('ticket.done', [$ticket->id]) }}"><i
                                                    class="fa fa-check"></i> انجام شد</a>
                                    @endif
                                    @if($ticket->status != 'close' && $ticket->status != 'lock' && $ticket->status != 'done' && $ticket->status != 'waiting')
                                        <a class="dropdown-item" href="{{ route('ticket.close', [$ticket->id]) }}"><i
                                                    class="fa fa-window-close"></i> بستن</a>
                                    @endif
                                    @if(Auth::user()->level == 'admin' || Auth::user()->level == 'staff' || Auth::user()->level == 'marketer' )
                                        @if($ticket->status != 'done' && $ticket->status != 'lock' && $ticket->status != 'close' && $ticket->status != 'waiting')
                                            <a class="dropdown-item"
                                               href="{{ route('ticket.waiting', [$ticket->id]) }}"><i
                                                        class="fa fa-hourglass-start"></i> انتظار</a>
                                        @endif
                                        @if($ticket->status != 'done' && $ticket->status != 'lock' && $ticket->status != 'close' && $ticket->status != 'waiting')
                                            <a class="dropdown-item" href="{{ route('ticket.lock', [$ticket->id]) }}"><i
                                                        class="fa fa-lock"></i> قفل کردن</a>
                                        @endif
                                        <a class="dropdown-item"
                                           href="{{ route('admin.invoice.create.user',[$ticket->user_id]) }}"><i
                                                    class="fa fa-plus-circle"></i> ثبت فاکتور</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="pull-left">{{ $replays->links() }}</div>
                        </div>
                    </div>
                    @foreach($replays as $replay)

                        @if($replay->user_id == $ticket->user_id)
                            <div class="card card-default ml-5 mb-2">
                                @else
                                    <div class="card card-default mr-5 mb-2">
                                        @endif
                                        <div class="card-header">
                                            {{ $replay->user->name }}
                                            @if($replay->user->title)
                                                ({{$replay->user->title}})
                                            @endif
                                            <span class="badge badge-dark pull-left">{{ jdate($replay->created_at)->ago() }}</span>
                                        </div>
                                        <div class="card-body">
                                            {!! nl2br($replay->text)  !!}
                                        </div>
                                    </div>
                                    @endforeach
                                    {{ $replays->links() }}
                                    <div class="card card-default mb-2">
                                        <div class="card-header">
                                            {{ $ticket->title }} ({{$ticket->user->name}})
                                            <span class="badge badge-dark pull-left">{{ jdate($ticket->created_at)->ago() }}</span>
                                        </div>
                                        <div class="card-body">
                                            {!! nl2br($ticket->text)  !!}
                                        </div>
                                    </div>


                            </div>
                </div>
            </div>
        </div>
@endsection

@section('js')

@endsection
