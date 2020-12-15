@extends('admin.layouts.app')
@section('title', 'Редактирование купона')

@section('content')
  <div class="container-fluid pt-5 px-4">
    <div class="row">
      <div class="col-12">
        <h2>Промокод</h2>
      </div>
    </div>
    @include('admin.layouts.menu_store')
    <div class="row mt-0 pt-0">
      <div class="card border-0 w-100 rounded-0" style="z-index: 90;box-shadow: 0 18px 19px rgba(0, 0, 0, 0.25)">
        <div class="card-header">
          <div class="row">
            <div class="col-auto">
              <a href="{{ url()->previous() }}" class="h4 d-flex align-content-center"><i class="fal fa-long-arrow-left mr-2"></i> Назад</a>
            </div>
          </div>
        </div>
        <div class="card-body">
          <form action="{{ route('admin.store.coupon.update', $coupon->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="row justify-content-end">
              <div class="col-auto">
                <button class="btn btn-dark rounded-0 border-0 px-3 py-2" type="submit">Обновить</button>
              </div>
            </div>
            <div class="row mt-3">

              <div class="col-sm-6 col-md-4 col-12">
                <input type="text" name="code" class="form-control rounded-0 {{ $errors->has('code') ? ' is-invalid' : '' }}" placeholder="Код промокода" value="{{ $coupon->code }}" required>
                <span id="exampleInputEmail1-error" class="error invalid-feedback">Код не должен повтаряться</span>
              </div>

              <div class="col-12 mt-5">
                <div class="row">
                  <div class="col-md-6">
                    <h5 class="font-weight-bold">Данные купона</h5>
                    <div class="row">

                      <div class="col-md-6 mt-md-0 mt-2">
                        <div class="row">
                          <div class="col-12">
                            <label for="type">Тип скидки</label>
                          </div>
                          <div class="col-12">
                            <select name="type" id="type" class="form-control rounded-0" required>
                              <option value="percent" {{ $coupon->type === 'percent' ? 'selected' : null }}>Процентная скидка</option>
                              <option value="fixed" {{ $coupon->type === 'fixed' ? 'selected' : null }}>Фиксированная скидка</option>
                            </select>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6 mt-md-0 mt-2">
                        <div class="row">
                          <div class="col-12">
                            <label for="value">Размер скидки</label>
                          </div>
                          <div class="col-12">
                            <input type="number" name="value" class="form-control rounded-0 {{ $errors->has('value') ? ' is-invalid' : '' }}" id="value" value="{{ $coupon->value }}" required>
                            <span id="exampleInputEmail1-error" class="error invalid-feedback">Минимаьное значение 1</span>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6 mt-md-3 mt-2">
                        <div class="row">
                          <div class="col-12">
                            <label for="not_after">Дата окончания</label>
                          </div>
                          <div class="col-12">
                            <input type="date" name="not_after" value="{{ $coupon->not_after->format('Y-m-d') }}" class="form-control rounded-0" id="not_after" required>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6 mt-md-3 mt-2">
                        <div class="row">
                          <div class="col-12">
                            <label for="total">Кол-во</label>
                          </div>
                          <div class="col-12">
                            <input type="number" name="total" value="{{ $coupon->total }}" class="form-control rounded-0 {{ $errors->has('total') ? ' is-invalid' : '' }}" id="total" required>
                            <span id="exampleInputEmail1-error" class="error invalid-feedback">Минимальное значение 0</span>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>

                  <div class="col-md-6 mt-3 mt-md-0">
                    <h5 class="font-weight-bold">Ограничения</h5>
                    <div class="row">

                      <div class="col-md-6 mt-md-0 mt-2">
                        <div class="row">
                          <div class="col-12">
                            <label for="min_amount">Минимальный расход</label>
                          </div>
                          <div class="col-9">
                            <input type="number" min="0" value="{{ $coupon->min_amount }}" name="min_amount" id="min_amount" class="form-control rounded-0" required>
                          </div>
                          <div class="col-2"> тг.</div>
                        </div>
                      </div>

                      <div class="col-md-6 mt-md-0 mt-2">
                        <div class="row">
                          <div class="col-12">
                            <label for="max_amount">Максимальный расход</label>
                          </div>
                          <div class="col-9">
                            <input type="number" min="0" value="{{ $coupon->max_amount }}" name="max_amount" id="max_amount" class="form-control rounded-0" required>
                          </div>
                          <div class="col-2"> тг.</div>
                        </div>
                      </div>

                      <div class="col-md-12 mt-md-4 mt-2">
                        <div class="row">
                          <div class="col-12">
                            <label>
                              <input type="checkbox" {{ $coupon->disabled_other_coupons ? 'checked' : null }} name="disabled_other_coupons">
                              Нельзя использовать с другими купонами
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12 mt-md-2 mt-2">
                        <div class="row">
                          <div class="col-12">
                            <label>
                              <input type="checkbox" {{ $coupon->disabled_other_sales ? 'checked' : null }} name="disabled_other_sales">
                              Исключить товары со скидкой
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12 mt-md-2 mt-2">
                        <div class="row">
                          <div class="col-12">
                            <label>
                              <input type="checkbox" {{ $coupon->notification ? 'checked' : null }} name="notification">
                              Только для пользователей с подпиской на рассылку
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="row">
                  <div class="col-md-4 mt-md-2 mt-2">
                    <div class="row">
                      <div class="col-12">
                        <label for="products[]">Товары</label>
                      </div>
                      <div class="col-12">
                        <select class="js-example-basic-multiple w-100 rounded-0" name="products[]" multiple="multiple">
                          @foreach(\App\Models\Product::all() as $product)
                            <?= $check = false; ?>
                            @foreach($coupon->productsEnabled as $prod)
                              @if($prod->id === $product->id)
                                <?= $check = true; ?>
                                <option value="{{ $product->id }}" selected>{{ ucwords(strtolower($product->title)) }}</option>
                              @endif
                            @endforeach
                            @if(!$check)
                              <option value="{{ $product->id}}">{{ ucwords(strtolower($product->title)) }}</option>
                            @endif
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-4 mt-md-2 mt-2">
                    <div class="row">
                      <div class="col-12">
                        <label for="brands[]">Бренды</label>
                      </div>
                      <div class="col-12">
                        <select class="js-example-basic-multiple w-100 rounded-0" name="brands[]" multiple="multiple">
                          @foreach(\App\Models\Brand::all() as $brand)
                            <?= $check = false; ?>
                            @foreach($coupon->brandsEnabled as $cat)
                              @if($cat->id === $brand->id)
                                <?= $check = true; ?>
                                <option value="{{ $brand->id }}" selected>{{ $brand->name }}</option>
                              @endif
                            @endforeach
                            @if(!$check)
                              <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endif
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-4 mt-md-2 mt-2">
                    <div class="row">
                      <div class="col-12">
                        <label for="categories[]">Категории</label>
                      </div>
                      <div class="col-12">
                        <select class="js-example-basic-multiple w-100 rounded-0" name="categories[]" multiple="multiple">
                          @foreach(\App\Models\Category::all() as $category)
                            <?= $check = false; ?>
                            @foreach($coupon->categoriesEnabled as $cat)
                              @if($cat->id === $category->id)
                                <?= $check = true; ?>
                                <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                              @endif
                            @endforeach
                            @if(!$check)
                              <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endif
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-4 mt-md-2 mt-2">
                    <div class="row">
                      <div class="col-12">
                        <label for="disabled_products[]">Исключить товары</label>
                      </div>
                      <div class="col-12">
                        <select class="js-example-basic-multiple w-100 rounded-0" name="disabled_products[]" multiple="multiple">
                          @foreach(\App\Models\Product::all() as $product)
                            <?= $check = false; ?>
                            @foreach($coupon->productsDisabled as $prod)
                              @if($prod->id === $product->id)
                                <?= $check = true; ?>
                                <option value="{{ $product->id }}" selected>{{ ucwords(strtolower($product->title)) }}</option>
                              @endif
                            @endforeach
                            @if(!$check)
                              <option value="{{ $product->id}}">{{ ucwords(strtolower($product->title)) }}</option>
                            @endif
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-4 mt-md-2 mt-2">
                    <div class="row">
                      <div class="col-12">
                        <label for="disabled_brands[]">Исключить бренды</label>
                      </div>
                      <div class="col-12">
                        <select class="js-example-basic-multiple w-100 rounded-0" name="disabled_brands[]" multiple="multiple">
                          @foreach(\App\Models\Brand::all() as $brand)
                            <?= $check = false; ?>
                            @foreach($coupon->brandsDisabled as $cat)
                              @if($cat->id === $brand->id)
                                <?= $check = true; ?>
                                <option value="{{ $brand->id }}" selected>{{ $brand->name }}</option>
                              @endif
                            @endforeach
                            @if(!$check)
                              <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endif
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-4 mt-md-2 mt-2">
                    <div class="row">
                      <div class="col-12">
                        <label for="disabled_categories[]">Исключить категории</label>
                      </div>
                      <div class="col-12">
                        <select class="js-example-basic-multiple w-100 rounded-0" name="disabled_categories[]" multiple="multiple">
                          @foreach(\App\Models\Category::all() as $category)
                            <?= $check = false; ?>
                            @foreach($coupon->categoriesDisabled as $cat)
                              @if($cat->id === $category->id)
                                <?= $check = true; ?>
                                <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                              @endif
                            @endforeach
                            @if(!$check)
                              <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endif
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script>
    $(document).ready(() => {
      $('input[type="checkbox"]').iCheck({
        checkboxClass: 'icheckbox_minimal',
        radioClass: 'iradio_minimal',
      })
      $('.js-example-basic-multiple').select2({
        width: '100%'
      });
    })
  </script>
@endsection
