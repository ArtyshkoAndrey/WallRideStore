@extends('admin.layouts.app')
@section('title', 'Магазин - Категории')

@section('content')
  <div class="container-fluid pt-5 px-4">
    <div class="row">
      <div class="col-12 col-md-auto">
        <h2>Категории</h2>
      </div>
    </div>
    <div class="row mt-2" style="z-index: 100">
      <div class="col-sm-auto ml-0 pl-0 col-6 px-0 pr-sm-2"><a href="{{ route('admin.production.products.index') }}" class="bg-dark px-3 py-2 d-block">Товары</a></div>
      <div class="col-sm-auto col-6 px-0 px-sm-2"><a href="{{ route('admin.production.category.index') }}" class="bg-white px-3 py-2 d-block">Категории</a></div>
      <div class="col-sm-auto col-6 px-0 px-sm-2"><a href="{{ route('admin.production.attr.index') }}" class="bg-dark px-3 py-2 d-block">Атрибуты</a></div>
    </div>
    <div class="row mt-0 pt-0">
      <div class="card border-0 w-100 rounded-0" style="z-index: 90;box-shadow: 0 18px 19px rgba(0, 0, 0, 0.25)">
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <form action="{{ route('admin.production.category.store') }}" method="post">
                @csrf
                <div class="form-group">
                  <label for="name">Название категории</label>
                  <input type="text" class="form-control rounded-0" id="name" name="name" placeholder="Название категории">
                </div>
                <div class="form-group">
                  <label for="category">Родительская категория</label>
                  <select name="category" id="category" class="form-control rounded-0">
                    <option value="">Без родителя</option>
                    @foreach(App\Models\Category::all() as $cat)
                      <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <button type="submit" class="btn bg-dark rounded-0 border-0">Добавить</button>
                </div>
              </form>
            </div>
            <div class="col-md-6 category">
              <ul>
                @foreach(App\Models\Category::whereNull('category_id')->get() as $category)
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
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script>
  </script>
@endsection
