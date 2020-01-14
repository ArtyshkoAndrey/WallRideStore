@extends('layouts.app')
@section('title', 'Операция прошла успешно')

@section('content')
  <div class="card">
    <div class="card-header">Операция прошла успешно</div>
    <div class="card-body text-center">
      <h1>{{ $msg }}</h1>
      <a class="btn btn-primary" href="{{ route('root') }}">Вернуться на главную</a>
    </div>
  </div>
@endsection
