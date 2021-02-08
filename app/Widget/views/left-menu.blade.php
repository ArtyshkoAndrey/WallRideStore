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

    <div class="section">
      <input type="radio" name="accordion-1" id="section-1"/>
      <label for="section-1">
        <span>{{ __('Бренды') }}</span>
        <span class="caret fa fa-angle-right"></span>
      </label>

      <div class="content">
        <ul>
          @foreach($brands as $brand)
            <li><span><a href="{{ route('product.all', ['brand' => $brand->id]) }}">{{ $brand->name }} {{ $brand->translate(App::getLocale())->description }}</a></span></li>
          @endforeach
        </ul>
      </div>
    </div>

  </div>
</div>
