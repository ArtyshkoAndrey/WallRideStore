<template>
  <div class="modal fade modal-user" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
       aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
      <div class="modal-content"
           :style="'background-image:url(' + modal.photo_jpg_storage + '); no-repeat; background-size:cover'"
      >
        <div class="modal-body p-0">
          <div class="row m-0">
            <button
              type="button"
              class="btn-close"
              data-mdb-dismiss="modal"
              aria-label="Close"
            ></button>
            <div class="col-12 text-center align-self-center" id="modal-description">
              <div class="my-4">
                <h4>{{ modal.title }}</h4>
                <hr style="height: 2px;">
                <div v-html="modal.description" class="mb-4 modal-description-text"></div>
                <div id="app">
                  <a :href="modal.link" class="btn btn-outline-dark text-center">{{ modal.text_to_link }}</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  name: "modal-2",
  props: {
    modal: Object,
  },
  created() {
    this.$nextTick(() => {
      $('#staticBackdrop').modal('toggle')
      console.log(this.modal)
    })
  }
}
</script>

<style scoped>
.modal-body {
  background: rgba(0, 0, 0, 0.5);
  width:279px;
  height: 472px;
}

#app {
  position: absolute;
  bottom: 20px;
  width: 279px;
  left:0px;
}

#app .btn {
  width: 233px;

  font-size: 16px;
  color: #fff;
  border: solid 1px #fff;
  line-height:49px;
}

#modal-description {
  padding: 25px;
}
.modal-description-text .p .span {
  font-family: "Open Sans" !important;
}
</style>
