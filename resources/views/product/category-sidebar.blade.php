<div class="list-group mb-2">
    @foreach($brands as $brand)
        <a class="list-group-item list-group-item-action{{ (Request::segment(2) == 'category' && Request::segment(3) == $brand->id) ? ' active' : '' }}"
           href=""><i
                    class="{{ $brand->icon }}"></i> {{ $brand->title }}</a>
    @endforeach
</div>