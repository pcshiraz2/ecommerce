<div class="clearfix">
    <div class="pull-right">
        {!! $items->appends(Request::except('page'))->render() !!}
    </div>
    <div class="pull-left">

    </div>
</div>