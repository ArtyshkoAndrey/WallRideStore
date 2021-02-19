<div id="left-menu" class="d-lg-none d-block">
  <div class="accordion" style="height: 1000px">

    <div class="section mb-2">
      <input type="radio" name="accordion-1" id="section-language"/>
      <label for="section-language">
        <span>{{ __('Язык сайта') }}: {{ isset($_COOKIE['language']) ? $_COOKIE['language'] == 'ru' ? 'RUS' : 'ENG' : 'RUS' }}</span>
        <span class="caret fa fa-angle-right"></span>
      </label>

      <div class="content">
        <ul>
          <li>
            <span>
              <a href="{{ url('/language/change/ru') }}">Russian</a>
            </span>
          </li>
          <li>
            <span>
              <a href="{{ url('/language/change/en') }}">English</a>
            </span>
          </li>
        </ul>
      </div>
    </div>

    <div class="section">
      <label>
        <span>
          <a href="{{ route('index') }}">{{ __('Главная') }}</a>
        </span>
      </label>
      <div class="content"></div>
    </div>

    @foreach($categories as $category)
      <div class="section">
        <input type="radio" name="accordion-1" id="section-category-{{$category->id}}"/>
        <label for="section-category-{{$category->id}}">
          <span>{{ $category->name }}</span>
          <span class="caret fa fa-angle-right"></span>
        </label>

        <div class="content">
          <ul>
            @foreach($category->child as $ct)
              <li>
                <span>
                  <a href="{{ route('product.all', ['category' => $ct->id]) }}">
                    {{ $ct->name }}
                  </a>
                </span>
              </li>
            @endforeach
          </ul>
        </div>
      </div>
    @endforeach

    <div class="section">
      <input type="radio" name="accordion-1" id="section-brands"/>
      <label for="section-brands">
        <span>{{ __('Бренды') }}</span>
        <span class="caret fa fa-angle-right"></span>
      </label>

      <div class="content">
        <ul>
          @foreach($brands as $brand)
            <li>
              <span>
                <a href="{{ route('product.all', ['brand' => $brand->id]) }}">
                  {{ $brand->name }}
                </a>
              </span>
            </li>
          @endforeach
        </ul>
      </div>
    </div>

    <div class="section">
      <label>
        <span>
          <a href="{{ route('index') }}">{{ __('FAQ') }}</a>
        </span>
      </label>
      <div class="content"></div>
    </div>

    <div class="section">
      <label>
        <span>
          <a href="{{ route('index') }}">{{ __('Новости') }}</a>
        </span>
      </label>
      <div class="content"></div>
    </div>

    <div class="section">
      <label>
        <span>
          <a href="{{ route('index') }}" class="text-danger">{{ __('Sale') }}</a>
        </span>
      </label>
      <div class="content"></div>
    </div>

  </div>
</div>
