<div class="card mb-2">
    <div class="card-header">
        ورود اطلاعات برای هاست CPanel
    </div>
    <div class="card-body">

                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1"><a href="{{ route('product.view',['id'=>$product->id]) }}">{{$product->name}}</a></h5>
                </div>
        <div class="form-group">
            <label>نام دامنه</label>
            <input type="text" required dir="ltr" class="form-control" name="cpanel_domain[{{ $i }}]">
        </div>
    </div>
</div>