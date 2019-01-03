<ul class="list-unstyled">
    @foreach($products as $product)
        <li class="media">
            <img class="mr-3" src="{{ Storage::url($product->image) }}" alt="{{ $product->title }}">
            <div class="media-body">
                <h5 class="mt-0 mb-1">{{ $product->title }}</h5>
                {{ $product->description }}
            </div>
        </li>
    @endforeach
</ul>