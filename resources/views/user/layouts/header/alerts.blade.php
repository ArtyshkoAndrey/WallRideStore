
@if (session()->has('success'))
  @foreach (session('success') as $message)
    <div class="alert alert-success position-fixed mt-5 alert-dismissible fade show" role="alert">
      <strong>{{ $message }}</strong>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  @endforeach
@endif

@if($errors->any())
  @foreach ($errors->all() as $error)
    <div class="alert alert-danger mt-5 position-fixed alert-dismissible fade show" role="alert">
      <strong>{{ $error }}</strong>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  @endforeach
@endif
