<div class="list-group mb-2">
    @foreach($categories as $category)
        <a class="list-group-item list-group-item-action{{ (Request::segment(2) == 'category' && Request::segment(3) == $category->id) ? ' active' : '' }}"
           href="{{ route('article.category',['id'=>$category->id]) }}"><i
                    class="{{ $category->icon }}"></i> {{ $category->title }}</a>
    @endforeach
</div>