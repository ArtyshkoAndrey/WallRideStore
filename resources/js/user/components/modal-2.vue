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
                <div v-html="modal.description" class="mb-4 modal-description-text"></div>

                <a :href="modal.link" class="btn btn-outline-dark text-center">{{ modal.text_to_link}}</a>
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
  created () {
    this.$nextTick(() => {
      $('#staticBackdrop').modal('toggle')
      console.log(this.modal)
    })
  }
}
</script>

<style scoped>

</style>
