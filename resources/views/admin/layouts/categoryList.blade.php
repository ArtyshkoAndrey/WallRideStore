@foreach ($cat as $category)
  <li>{{ $category->name }} <form action="{{ route('admin.production.category.destroy', $category->id) }}" method="post">
      @csrf
      @method('delete')
      <button class="bg-transparent border-0 rounded-0" style="color: #F33C3C" type="submit"><i style="font-size: 1.5rem" class="fal fa-trash"></i></button>
    </form></li>
  @if(App\Models\Category::where('category_id', $category->id)->count() > 0)
    <ul>
      @include('admin.layouts.categoryList', ['cat' => App\Models\Category::where('category_id', $category->id)->get()])
    </ul>
  @endif
@endforeach
