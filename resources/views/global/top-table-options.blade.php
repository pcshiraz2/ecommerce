<div class="clearfix">
    <a class="btn btn-sm btn-success pull-right mb-1" href="{{ \App\Utils\UrlUtil::downloadExcel($route) }}"><i class="fa fa-file-excel-o"></i> دریافت فایل Excel</a>
    <div class="btn-group btn-group-sm pull-left mb-1">
        <a href="{{ route('misc.per-page',[25]) }}" class="btn {{ ((session('per-page') == 25 || !session('per-page')) ? 'btn-info' : 'btn-outline-info') }}">25</a>
        <a href="{{ route('misc.per-page',[50]) }}" class="btn {{ (session('per-page') == 50 ? 'btn-info' : 'btn-outline-info') }}">50</a>
        <a href="{{ route('misc.per-page',[75]) }}" class="btn {{ (session('per-page') == 75 ? 'btn-info' : 'btn-outline-info') }}">75</a>
        <a href="{{ route('misc.per-page',[100]) }}" class="btn {{ (session('per-page') == 100 ? 'btn-info' : 'btn-outline-info') }}">100</a>
    </div>
</div>
