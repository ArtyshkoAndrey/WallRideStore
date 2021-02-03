<div id="left-menu" class="d-lg-none d-block">
  <div class="accordion" style="height: 1000px">

    <div class="section mb-2">
      <input type="radio" name="accordion-1" id="section-language"/>
      <label for="section-language">
        <span>Язык сайта: RUS</span>
        <span class="caret fa fa-angle-right"></span>
      </label>

      <div class="content">
        <ul>
          <li>
            <span>
              <a href="#">Russian</a>
            </span>
          </li>
          <li>
            <span>
              <a href="#">English</a>
            </span>
          </li>
        </ul>
      </div>
    </div>

    <div class="section">
      <label>
        <span>
          <a href="{{ route('index') }}">Главная</a>
        </span>
      </label>
      <div class="content"></div>
    </div>

    <div class="section">
      <input type="radio" name="accordion-1" id="section-1"/>
      <label for="section-1">
        <span>Бренды</span>
        <span class="caret fa fa-angle-right"></span>
      </label>

      <div class="content">
        <ul>
          @foreach(App\Models\Brand::orderBy('name', 'ASC')->get() as $brand)
            <li><span><a href="{{ route('product.all', ['brand' => $brand->id]) }}">{{ $brand->name }}</a></span></li>
          @endforeach
        </ul>
      </div>
    </div>

  </div>
</div>
