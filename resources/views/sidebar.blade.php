<div class="list-group mb-2 d-none d-md-block d-lg-block d-xl-block">
    <a class="list-group-item list-group-item-action{{ Request::segment(1) == 'dashboard' ? ' active' : '' }}"
       href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> پیشخوان</a>
    <a class="list-group-item list-group-item-action{{ Request::segment(1) == 'ticket' ? ' active' : '' }}"
       href="{{ route('ticket') }}"><i class="fa fa-life-ring"></i> پشتیبانی</a>
    <a class="list-group-item list-group-item-action{{ Request::segment(1) == 'invoice' ? ' active' : '' }}"
       href="{{ route('invoice') }}"><i class="fa fa-bars"></i> فاکتورها</a>
    <a class="list-group-item list-group-item-action{{ Request::segment(1) == 'transaction' ? ' active' : '' }}"
       href="{{ route('transaction') }}"><i class="fa fa-money"></i> تراکنش ها</a>
</div>


<div class="d-block d-md-none d-lg-none d-xl-none mb-2">
    <div class="dropdown">
        <button class="btn btn-primary dropdown-toggle btn-block" type="button" id="adminDashboard"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            منو ابزار ها
        </button>
        <div class="dropdown-menu" aria-labelledby="adminDashboard">
            <a class="dropdown-item{{ Request::segment(1) == 'dashboard' ? ' active' : '' }}"
               href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> پیشخوان</a>
            <a class="dropdown-item{{ Request::segment(1) == 'ticket' ? ' active' : '' }}" href="{{ route('ticket') }}"><i
                        class="fa fa-life-ring"></i> پشتیبانی</a>
            <a class="dropdown-item{{ Request::segment(1) == 'invoice' ? ' active' : '' }}"
               href="{{ route('invoice') }}"><i class="fa fa-bars"></i> فاکتورها</a>
            <a class="dropdown-item{{ Request::segment(1) == 'transaction' ? ' active' : '' }}"
               href="{{ route('transaction') }}"><i class="fa fa-money"></i> تراکنش ها</a>
        </div>
    </div>
</div>