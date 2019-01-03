<div class="list-group" style="z-index: 2000;position: fixed;left: {{$left}};top: {{$top}};">
    @foreach($products as $product)
        <button type="button" onclick="selectItem({{$product->id}}, {{$id}}, {{$product->sale_price}})"
                class="list-group-item list-group-item-action">{{ $product->title }}</button>
    @endforeach
</div>