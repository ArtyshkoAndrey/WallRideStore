@extends('layouts.app')
@section('title', 'Название новости')

@section('content')
  <section class="container-fluid p-0 text-white" id="slider">
    <div class="row p-0 m-0">
      <div class="col-12 p-0">
        <img class="img-fluid"  src="{{ asset("public/storage/images/slide1.png") }}" alt="">
      </div>
      <div class="col-12 p-0 position-absolute text-center">
        <h1>Новогодние скидки в Wallride Store</h1>
        <a href="javascript:window.history.back()" class="btn"><img src="{{ asset("public/images/arrow-left.png") }}" alt=""> Назад</a>
      </div>
    </div>
  </section>
  <section class="container mt-5 mb-5" id="news">
    <div class="row">
      <div class="col-12">
        <h2>H2 Тег.</h2>
        <h3>H3 Тег.</h3>
        <h4>H4 Тег.</h4>
        <h5>H5 Тег.</h5>
        <h5>H6 Тег.</h5>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid consectetur illum iure molestiae mollitia odio placeat repellat sed sit ut. Impedit iste omnis ratione recusandae reiciendis! Aliquam consequatur culpa dicta dolore eos esse est expedita illum iure laborum laudantium modi non, nostrum numquam officia officiis, pariatur perspiciatis provident reiciendis repellat repudiandae tempora temporibus ullam. Asperiores facere, fugiat fugit id molestiae nobis odio odit qui repellendus sapiente. Accusamus debitis dolore eos et libero magni quae quaerat quod sunt! Beatae culpa delectus deserunt doloribus eaque facilis fugit, harum quaerat quam quasi, quo quos rem voluptatem. Adipisci animi deleniti dignissimos illum molestias necessitatibus?</p>
        <h3>H3 Заголовок</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laboru</p>
        <p>А это картинка</p>
        <img src="{{ asset("public/storage/images/slide1.png") }}" alt="картинка">

        <p class="lead">
          Лидированный текст
        </p>
        <p>тег-выделитель для <mark>подсветки</mark> текста.</p>
        <p><del>Удаленный текст.</del></p>
        <p><s>Зачеркнутый.</s></p>
        <p><ins>Строка - дополнение к документу.</ins></p>
        <p><u>Подчеркнутая</u></p>
        <p><small>Мелкий шрифт (типа нижний индекс).</small></p>
        <p><strong>Жирный текст.</strong></p>
        <p><em>Курсив.</em></p>

        <p><abbr title="attribute">attr</abbr></p>
        <p><abbr title="HyperText Markup Language" class="initialism">HTML</abbr></p>

        <blockquote class="blockquote">
          <p class="mb-0">Цитата</p>
        </blockquote>

        <blockquote class="blockquote">
          <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
          <footer class="blockquote-footer">Кто-то знаменитый в <cite title="Название источника">Source Title</cite></footer>
        </blockquote>

        <ul class="list-unstyled">
          <li>Lorem ipsum dolor sit amet</li>
          <li>Consectetur adipiscing elit</li>
          <li>Integer molestie lorem at massa</li>
          <li>Facilisis in pretium nisl aliquet</li>
          <li>Nulla volutpat aliquam velit
            <ul>
              <li>Phasellus iaculis neque</li>
              <li>Purus sodales ultricies</li>
              <li>Vestibulum laoreet porttitor sem</li>
              <li>Ac tristique libero volutpat at</li>
            </ul>
          </li>
          <li>Faucibus porta lacus fringilla vel</li>
          <li>Aenean sit amet erat nunc</li>
          <li>Eget porttitor lorem</li>
        </ul>
      </div>
    </div>
  </section>
@endsection

@section('scriptsAfterJs')

@endsection
