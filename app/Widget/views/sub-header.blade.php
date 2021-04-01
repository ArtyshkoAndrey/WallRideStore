<nav class="navbar navbar-expand navbar-light bg-dark-transparent">
  <div class="container-fluid overflow-x-auto">
    <div class="collapse navbar-collapse align-items-center justify-content-center" id="sub-header">
      <ul class="navbar-nav justify-content-center w-100 px-0 px-lg-4">

        @foreach($categories as $category)
          <li class="nav-item dropdown full-width">
            <a class="nav-link dropdown-toggle"
               href="#"
               id="categoryButton-{{ $category->id }}"
               role="button"
               data-mdb-toggle="dropdown"
               aria-expanded="false">
              {{ $category->name }}
            </a>
            <div class="dropdown-menu overflow-auto p-4"
                 aria-labelledby="categoryButton-{{ $category->id }}">
              <div class="row">
                <div class="col-6">
                  <p class="h5 text-muted">
                    {{ $category->name }}
                  </p>
                </div>
                <div class="col-2"></div>
                <div class="col-4">
                  <a href="{{ route('product.all', ['category'=>$category->id]) }}"
                     class="text-dark h6 text-decoration-underline">
                    {{ __('Все товары') }}
                  </a>
                </div>

                @foreach($category->child as $category)

                  <div class="col-md-4 py-2">
                    <a href="{{ route('product.all', ['category'=>$category->id]) }}"
                       class="text-gray-2">
                      {{ $category->name }}
                    </a>
                  </div>

                @endforeach
              </div>
            </div>
          </li>
        @endforeach

        <li class="nav-item dropdown full-width">
          <a class="nav-link dropdown-toggle"
             href="#"
             id="brandsButton"
             role="button"
             data-mdb-toggle="dropdown"
             aria-expanded="false">
            {{ __('Бренды') }}
          </a>
          <div class="dropdown-menu overflow-auto p-4" aria-labelledby="brandsButton">
            <div class="row">
              <div class="col-6">
                <p class="h5 text-muted">{{ __('Бренды') }}</p>
              </div>
              <div class="col-6"></div>

              @foreach($brands as $brand)

                <div class="col-md-4 py-2">
                  <a href="{{ route('brand.show', $brand->id) }}"
                     class="text-gray-2">
                    {{ $brand->name }}
                  </a>
                </div>

              @endforeach
            </div>
          </div>
        </li>

        <li class="nav-item">
          <a class="nav-link"
             href="{{ route('faq.index') }}">
            {{ __('FAQ') }}
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link"
             href="{{ route('post.index') }}">
            {{ __('Новости') }}
          </a>
        </li>

          <li class="nav-item dropdown full-width">
            <a class="nav-link text-danger dropdown-toggle"
               href="#"
               id="saleButton"
               role="button"
               data-mdb-toggle="dropdown"
               aria-expanded="false">
              {{ __('Sale') }}
            </a>
            <div class="dropdown-menu overflow-auto p-4" aria-labelledby="saleButton">
              <div class="row">
                <div class="col-6">
                  <p class="h5 text-muted">{{ __('Sale') }}</p>
                </div>
                <div class="col-6"></div>

                @foreach($saleCategories as $category)

                  <div class="col-md-4 py-2">
                    <a href="{{ route('product.all', ['category' => $category->id, 'sale' => true]) }}"
                       class="text-gray-2">
                      {{ $category->name }}
                    </a>
                  </div>

                @endforeach
              </div>
            </div>
          </li>

      </ul>

    </div>
  </div>
</nav>
