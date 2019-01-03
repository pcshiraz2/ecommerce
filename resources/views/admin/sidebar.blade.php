<div class="list-group mb-2 d-none d-md-block d-lg-block d-xl-block position-sticky">
    <a class="list-group-item list-group-item-action{{ Request::segment(2) == 'dashboard' ? ' active' : '' }}"
       href="{{ route('admin.dashboard') }}"><i class="fa fa-cogs"></i> پیشخوان</a>
    @can('users')
        <a class="list-group-item list-group-item-action{{ Request::segment(2) == 'user' ? ' active' : '' }}"
           href="{{ route('admin.user') }}"><i class="fa fa-users"></i> کاربرها</a>
    @endcan
    @can('pages')
        <a class="list-group-item list-group-item-action{{ Request::segment(2) == 'page' ? ' active' : '' }}"
           href="{{ route('admin.page') }}"><i class="fa fa-window-restore"></i> صفحه ها</a>
    @endcan
    @can('articles')
        <a class="list-group-item list-group-item-action{{ Request::segment(2) == 'article' ? ' active' : '' }}"
           href="{{ route('admin.article') }}"><i class="fa fa-newspaper-o"></i> مقاله ها</a>
    @endcan
    @can('transactions')
        <a class="list-group-item list-group-item-action{{ Request::segment(2) == 'transaction' ? ' active' : '' }}"
           href="{{ route('admin.transaction') }}"><i class="fa fa-money"></i> تراکنش ها </a>
    @endcan
    @can('products')
        <a class="list-group-item list-group-item-action{{ Request::segment(2) == 'product' ? ' active' : '' }}"
           href="{{ route('admin.product') }}"><i class="fa fa-cubes"></i> کالاها</a>
    @endcan
    @can('invoices')
        <a class="list-group-item list-group-item-action{{ Request::segment(2) == 'invoice' ? ' active' : '' }}"
           href="{{ route('admin.invoice') }}"><i class="fa fa-bars"></i> فاکتورها</a>
    @endcan
    @can('accounts')
        <a class="list-group-item list-group-item-action{{ Request::segment(2) == 'account' ? ' active' : '' }}"
           href="{{ route('admin.account') }}"><i class="fa fa-address-book-o"></i> حساب ها</a>
    @endcan
    @can('categories')
        <a class="list-group-item list-group-item-action{{ Request::segment(2) == 'category' ? ' active' : '' }}"
           href="{{ route('admin.category') }}"><i class="fa fa-object-group"></i> دسته ها</a>
    @endcan
    @can('settings')
        <a class="list-group-item list-group-item-action{{ Request::segment(2) == 'setting' ? ' active' : '' }}"
           href="{{ route('admin.setting') }}"><i class="fa fa-cog fa-spin"></i> تنظیمات</a>
    @endcan
</div>

<div class="d-block d-md-none d-lg-none d-xl-none mb-2">
    <div class="dropdown">
        <button class="btn btn-primary dropdown-toggle btn-block" type="button" id="adminDashboard"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            منو ابزار ها
        </button>
        <div class="dropdown-menu" aria-labelledby="adminDashboard">
            <a class="dropdown-item{{ Request::segment(2) == 'dashboard' ? ' active' : '' }}"
               href="{{ route('admin.dashboard') }}"><i class="fa fa-cogs"></i> پیشخوان</a>
            <a class="dropdown-item{{ Request::segment(2) == 'user' ? ' active' : '' }}"
               href="{{ route('admin.user') }}"><i class="fa fa-users"></i> کاربرها</a>
            <a class="dropdown-item{{ Request::segment(2) == 'page' ? ' active' : '' }}"
               href="{{ route('admin.page') }}"><i class="fa fa-window-restore"></i> صفحه ها</a>
            <a class="dropdown-item{{ Request::segment(2) == 'article' ? ' active' : '' }}"
               href="{{ route('admin.article') }}"><i class="fa fa-newspaper-o"></i> مقاله ها</a>
            <a class="dropdown-item{{ Request::segment(2) == 'transaction' ? ' active' : '' }}"
               href="{{ route('admin.transaction') }}"><i class="fa fa-money"></i> تراکنش ها </a>
            <a class="dropdown-item{{ Request::segment(2) == 'product' ? ' active' : '' }}"
               href="{{ route('admin.product') }}"><i class="fa fa-cubes"></i> کالاها</a>
            <a class="dropdown-item{{ Request::segment(2) == 'invoice' ? ' active' : '' }}"
               href="{{ route('admin.invoice') }}"><i class="fa fa-bars"></i> فاکتورها</a>
            <a class="dropdown-item{{ Request::segment(2) == 'account' ? ' active' : '' }}"
               href="{{ route('admin.account') }}"><i class="fa fa-address-book-o"></i> حساب ها</a>
            <a class="dropdown-item{{ Request::segment(2) == 'category' ? ' active' : '' }}"
               href="{{ route('admin.category') }}"><i class="fa fa-object-group"></i> دسته ها</a>
            <a class="dropdown-item{{ Request::segment(2) == 'setting' ? ' active' : '' }}"
               href="{{ route('admin.setting') }}"><i class="fa fa-cog fa-spin"></i> تنظیمات</a>
        </div>
    </div>
</div>