<div class="card mb-2">
    <div class="card-header">برند ها</div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">X.Vision</li>
        <li class="list-group-item">TCL</li>
    </ul>
</div>

<div class="list-group mb-2">
    @foreach($categories as $category)
        <a class="list-group-item list-group-item-action{{ (Request::segment(2) == 'category' && Request::segment(3) == $category->id) ? ' active' : '' }}"
           href="{{ route('product.category',['id'=>$category->id]) }}"><i
                    class="{{ $category->icon }}"></i> {{ $category->title }}</a>
    @endforeach
</div>