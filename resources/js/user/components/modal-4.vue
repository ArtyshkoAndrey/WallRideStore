<template>
  <div class="modal fade modal-user" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body p-0">
          <div class="row m-0">
            <button
              type="button"
              class="btn-close"
              data-mdb-dismiss="modal"
              aria-label="Close"
            ></button>
            <div class="col-12 ps-3 pe-3 text-center align-self-center" id="modal-description">
              <div class="my-4">
                <h4>{{ modal.title }}</h4>
                <hr class="w-50 mx-auto" style="height: 2px;">
                <div v-html="modal.description" class="mb-4 modal-description-text"></div>
              </div>
              <hr class="w-50 mx-auto" style="height: 2px;">
              <div class="mt-4">
                <p class="font-weight-bolder text-dark">{{ modal.coupon_code.code}}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import * as mdb from 'mdb-ui-kit'; // lib
import Cookie from 'js-cookie';
export default {
  name: "modal-4",
  props: {
    modal: Object,
  },
  data: () => {
    return {
      language: Cookie.get('language')
    }
  },
  created () {
    this.$nextTick(() => {
      $('#staticBackdrop').modal('toggle')
      console.log(this.modal)
    })
  },
  methods: {

  }
}
</script>

<style scoped>

.slide-fade-enter-active {
  transition: all .1s ease;
}
.slide-fade-leave-active {
  transition: all .2s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}
.slide-fade-enter, .slide-fade-leave-to
  /* .slide-fade-leave-active до версии 2.1.8 */ {
  transform: translateX(10px);
  opacity: 0;
}

</style>
