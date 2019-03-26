<div class="card mb-2">
    <div class="card-header">
        دامنه خود را وارد نمایید
    </div>
    <div class="card-body">
        <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1"><a href="{{ route('product.view',['id'=>$product->id]) }}">{{$product->name}}</a></h5>
        </div>
        <div class="form-group">
            <label>نام دامنه</label>
            <input type="text" dir="ltr" value="{{ old('domain.'.$i) }}" class="form-control{{ $errors->has('domain.'.$i) ? ' is-invalid' : '' }}" name="domain[{{ $i }}]">
        </div>
    </div>
</div>