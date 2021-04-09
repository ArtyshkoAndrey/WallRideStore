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
            <div class="col-lg-4 col-12 ps-0 pe-0">
              <img :src="modal.photo_jpg_storage" id="modal-photo" class="img-fluid" :alt="modal.title">
            </div>
            <div class="col-lg-8 col-12 ps-3 pe-3 align-self-center" id="modal-description">
              <div class="my-4">
                <h4>{{ modal.title }}</h4>
                <div v-html="modal.description" class="mb-4 modal-description-text"></div>

                <a :href="modal.link" class="btn btn-outline-dark text-center d-block">{{ modal.text_to_link}}</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Modal } from 'mdb-ui-kit'; // lib
export default {
  name: "modal-1",
  props: {
    modal: Object,
  },
  created () {
   this.$nextTick(() => {

     $('#staticBackdrop').modal('toggle')
     setTimeout(()=> {
       // $('#modal-photo').height($('#model-description').height())
     }, 500)
     console.log(this.modal)
   })
  }
}
</script>

<style scoped>

</style>
