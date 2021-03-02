@extends('user.layouts.app')

@section('title', __('policy.title'))

@section('content')

  <div class="container pt-5 pb-5">
    <div class="row">
      <div class="col-12">
        <h1 class="h3">{{ __('policy.title') }}</h1>
      </div>

      <div class="col-md-4 col-12 d-flex justify-content-between">
        <span class="p">{{ __('policy.city') }}</span>
        <span class="p">{{ __('policy.date') }}</span>
      </div>

      <div class="col-12">
        <p>{{ __('policy.text_1') }}</p>
      </div>

      <div class="col-12">
        <h5 class="font-weight-bolder">
          {{ __('policy.title_2') }}
        </h5>
        <p>{{ __('policy.text_2.owner') }}</p>
        <p>{{ __('policy.text_2.1') }}</p>
        <p>{{ __('policy.text_2.2') }}</p>
        <p>{{ __('policy.text_2.3') }}</p>
        <p>{{ __('policy.text_2.4') }}</p>
        <p>{{ __('policy.text_2.5') }}</p>
        <p>{{ __('policy.text_2.6') }}</p>
        <p>{{ __('policy.text_2.7') }}</p>
      </div>
      <div class="col-12">
        <h5 class="font-weight-bolder">
          {{ __('policy.title_3') }}
        </h5>
        <p>{{ __('policy.text_3.1') }}</p>
        <p>{{ __('policy.text_3.2') }}</p>
        <p>{{ __('policy.text_3.3') }}</p>
        <p>{{ __('policy.text_3.4') }}</p>
      </div>
      <div class="col-12">
        <h5 class="font-weight-bolder">
          {{ __('policy.title_4') }}
        </h5>
        <p>{{ __('policy.text_4.1') }}</p>
        <p>{{ __('policy.text_4.2') }}</p>
        <p>{{ __('policy.text_4._2.1') }}</p>
        <p>{{ __('policy.text_4._2.2') }}</p>
        <p>{{ __('policy.text_4._2.3') }}</p>
        <p>{{ __('policy.text_4._2.4') }}</p>
        <p>{{ __('policy.text_4._2.5') }}</p>
        <p>{{ __('policy.text_4.3.owner') }}</p>
        <ul class="list-unstyled ms-3">
          <li>{{ __('policy.text_4._3.1') }}</li>
          <li>{{ __('policy.text_4._3.2') }}</li>
          <li>{{ __('policy.text_4._3.3') }}</li>
          <li>{{ __('policy.text_4._3.4') }}</li>
          <li>{{ __('policy.text_4._3.5') }}</li>
          <li>{{ __('policy.text_4._3.6') }}</li>
        </ul>
        <p>{{ __('policy.text_4.3.1') }}</p>
        <p>{{ __('policy.text_4.3.2') }}</p>
        <p>{{ __('policy.text_4.4') }}</p>
      </div>

      <div class="col-12">
        <h5 class="font-weight-bolder">
          {{ __('policy.title_5') }}
        </h5>
        <p>{{ __('policy.text_5.1.owner') }}</p>
        <p>{{ __('policy.text_5.1.1') }}</p>
        <p>{{ __('policy.text_5.1.2') }}</p>
        <p>{{ __('policy.text_5.1.3') }}</p>
        <p>{{ __('policy.text_5.1.4') }}</p>
        <p>{{ __('policy.text_5.1.5') }}</p>
        <p>{{ __('policy.text_5.1.6') }}</p>
        <p>{{ __('policy.text_5.1.7') }}</p>
        <p>{{ __('policy.text_5.1.8') }}</p>
        <p>{{ __('policy.text_5.1.9') }}</p>
        <p>{{ __('policy.text_5.1.10') }}</p>
        <p>{{ __('policy.text_5.1.11') }}</p>
        <p>{{ __('policy.text_5.1.12') }}</p>
      </div>

      <div class="col-12">
        <h5 class="font-weight-bolder">
          {{ __('policy.title_6') }}
        </h5>
        <p>{{ __('policy.text_6.1') }}</p>
        <p>{{ __('policy.text_6.2') }}</p>
        <p>{{ __('policy.text_6.3') }}</p>
        <p>{{ __('policy.text_6.4') }}</p>
        <p>{{ __('policy.text_6.5') }}</p>
        <p>{{ __('policy.text_6.6') }}</p>
      </div>

      <div class="col-12">
        <h5 class="font-weight-bolder">
          {{ __('policy.title_7') }}
        </h5>
        <p>{{ __('policy.text_7.1.owner') }}</p>
        <p>{{ __('policy.text_7.1.1') }}</p>
        <p>{{ __('policy.text_7.1.2') }}</p>
        <p>{{ __('policy.text_7.2.owner') }}</p>
        <p>{{ __('policy.text_7.2.1') }}</p>
        <p>{{ __('policy.text_7.2.2') }}</p>
        <p>{{ __('policy.text_7.2.3') }}</p>
        <p>{{ __('policy.text_7.2.4') }}</p>
      </div>

      <div class="col-12">
        <h5 class="font-weight-bolder">
          {{ __('policy.title_8') }}
        </h5>
        <p>{{ __('policy.text_8.1') }}</p>
        <p>{{ __('policy.text_8.2.owner') }}</p>
        <p>{{ __('policy.text_8.2.1') }}</p>
        <p>{{ __('policy.text_8.2.2') }}</p>
        <p>{{ __('policy.text_8.2.3') }}</p>
      </div>

      <div class="col-12">
        <h5 class="font-weight-bolder">
          {{ __('policy.title_10') }}
        </h5>
        <p>{{ __('policy.text_10.1') }}</p>
        <p>{{ __('policy.text_10.2') }}</p>
        <p>{{ __('policy.text_10.3') }}</p>
        <p>{{ __('policy.text_10.4') }}</p>
      </div>

      <div class="col-12 pt-5">
        <p>{{ __('policy.end') }}</p>
      </div>

    </div>
  </div>

@endsection
