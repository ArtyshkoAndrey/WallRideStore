@foreach($categories as $category)
  <a href="{{ route('product.all', ['category' => $category->id]) }}"
     class="text-gray-1 d-block mt-2">{{ $category->name }}</a>
@endforeach
