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
              <form
                id="app"
                @submit="checkForm"
                action="/api/notification"
                method="post"
              >
                <div v-if="errors.length">
                  <b>Пожалуйста исправьте указанные ошибки:</b>
                  <p class="text-danger" v-for="error in errors">{{ error }}</p>
                </div>
                <div v-if="success.length">
                  <p class="text-success" v-for="s in success">{{ s }}</p>
                </div>
                <div class="form-outline mx-5">
                  <input type="email" v-model="email" id="email" class="form-control text-danger" />
                  <label class="form-label" for="email">Email</label>
                </div>
                <div class="mt-4 mb-4">
                  <transition name="slide-fade" appear mode="out-in">
                    <button v-if="!loader" :disabled='disable' type="submit" class="btn btn-outline-dark text-center">
                      {{ modal.text_to_link}}
                    </button>
                    <div v-else class="spinner-border" role="status">
                      <span class="visually-hidden">Loading...</span>
                    </div>
                  </transition>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import * as mdb from 'mdb-ui-kit'; // lib
export default {
  name: "modal-3",
  props: {
    modal: Object,
  },
  data: () => {
    return {
      email: null,
      errors: [],
      success: [],
      disable: false,
      loader: false
    }
  },
  created () {
    this.$nextTick(() => {
      $('#staticBackdrop').modal('toggle')
      console.log(this.modal)

      document.querySelectorAll('.form-outline').forEach((formOutline) => {
        new mdb.Input(formOutline).init();
      });
    })
  },
  methods: {
    checkForm (e) {
      this.errors = [];

      if (!this.email) {
        this.errors.push('Укажите электронную почту.');
        this.loader = false
      } else if (!this.validEmail(this.email)) {
        this.errors.push('Укажите корректный адрес электронной почты.');
      }

      this.loader = true

      if (this.errors.length === 0) {
        window.axios.put('/api/notification', {
          email: this.email
        })
        .then(r => {
          this.success = []
          this.success.push('Почта успешно добавлена к рассылки')
          this.disable = true
          this.loader = false
        })
        .catch(e => {
          this.errors.push('Произошла ошибка. Повторите попытку позже')
          this.loader = false
        })


      } else {
        this.loader = false
      }

      // this.loader = false
      e.preventDefault()
    },
    validEmail: function (email) {
      let re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(email);
    }
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
