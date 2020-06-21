@if (isset($stock))
  @if ($stock->view === 1)
    <div class="modal fade" id="stock" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="LabelStock" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-body p-0">
            <button type="button" class="close position-absolute text-dark" style="right: 10px; top: 10px; font-size: 1.9rem; z-index: 900" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <div class="row p-0 m-0">
              <div class="col-lg-6 col-md-6 col-12 p-0">
                <img src="{{ $stock->getImage() }}" alt="{{ $stock->title }}" style="min-height: 100%; object-fit: cover;" class="img-fluid">
              </div>
              <div class="col-md-6 col-12 col-lg-6 my-5 d-flex align-items-center">
                <div class="row m-0 p-0">
                  <div class="col-12">
                    <h3 class="text-center">{{ $stock->title }}</h3>
                  </div>
                  <div class="col-12">
                    <p class="text-center">{{ $stock->description }}</p>
                  </div>
                  <div class="col-12">
                    <a href="{{ $stock->link }}" class="bg-transparent btn btn-dark text-dark rounded-0 d-block">{{ $stock->text_to_link }}</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endif
@endif
