<template>
  <div>
    <div class="modal fade modal-user" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true" v-if="modalmail">
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
              <div class="col-12 ps-4 pe-4 text-center align-self-center" id="modal-description">
                <div class="my-4">
                  <h4>{{ modal.title }}</h4>
                  <hr style="height: 2px;">
                  <div v-html="modal.description" class="mb-4 modal-description-text"></div>
                </div>

                <form
                  id="app"
                  @submit="checkForm"
                  action="/api/notification"
                  method="post"
                >
                  <div v-if="errors.length">
                    <b v-if="language === 'ru'">Пожалуйста исправьте указанные ошибки:</b>
                    <b v-else>Please correct the indicated errors:</b>
                    <p class="text-danger" v-for="error in errors">{{ error }}</p>
                  </div>
                  <div v-if="success.length">
                    <p class="text-success" v-for="s in success">{{ s }}</p>
                  </div>
                  <div class="button_submit">
                    <input type="email" v-model="email" id="email" class="form-control" placeholder="Ваш Email"/>
                  </div>
                  <div class="mt-4 mb-4">
                    <transition name="slide-fade" appear mode="out-in">
                      <button v-if="!loader" :disabled='disable' id="submit_go" type="submit"
                              class="btn btn-outline-dark text-center">
                        {{ modal.text_to_link }}
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
  </div>
</template>

<script>
import * as mdb from 'mdb-ui-kit'; // lib
import Cookie from 'js-cookie';

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
      loader: false,
      modalsuccess: true,
      modalmail: false,
      language: Cookie.get('language')
    }
  },
  created() {
    this.$nextTick(() => {
      $('#staticBackdrop').modal('toggle')
      console.log(this.modal)
      document.querySelectorAll('.form-outline').forEach((formOutline) => {
        new mdb.Input(formOutline).init();
      });
    })
  },
  methods: {
    checkForm(e) {
      this.errors = [];
      if (!this.email) {
        if (this.language === 'ru')
          this.errors.push('Укажите электронную почту.');
        else
          this.errors.push('Enter your email.');
        this.loader = false
      } else if (!this.validEmail(this.email)) {
        if (this.language === 'ru')
          this.errors.push('Укажите корректный адрес электронной почты.');
        else
          this.errors.push('Please enter a valid email address.');
      }
      this.loader = true
      if (this.errors.length === 0) {
        window.axios.post('api/notification', {
          email: this.email,
          language: this.language ?? 'ru'
        })
          .then(r => {
            this.success = []
            this.success.push("Добавлено")
            this.modalmail = false
            this.disable = true
            this.loader = false
            this.modalShow = false;
            window.Swal.fire({
              title: 'подписка успешно оформлена',
              text: 'Теперь вы всегда будете в курсе новостей и акций в нашем магазине',
              icon: 'success',
              confirmButtonText: 'Продолжить'
            })

          })
          .catch(e => {
            if (e.response.data.message) {
              this.errors.push(e.response.data.message)
            } else {
              if (this.language === 'ru')
                this.errors.push('Произошла ошибка. Повторите попытку позже')
              else
                this.errors.push('An error has occurred. Please try again later')
            }
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
.modal-body {
  background: rgba(0, 0, 0, 0.5);
  height: 600px;
}

.slide-fade-enter-active {
  transition: all .1s ease;
}

.slide-fade-leave-active {
  transition: all .2s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}

.slide-fade-enter, .slide-fade-leave-to
  /* .slide-fade-leave-active до версии 2.1.8 */
{
  transform: translateX(10px);
  opacity: 0;
}

#app {
  position: absolute;
  bottom: 0px;
}


@media screen and (max-width: 650px) {
  #email {
    width: 229px;
    height: 49px;
    background: #fff;
  }
  #submit_go {
    width:229px;
    height: 49px;
    border: solid 1px #fff;
    color: #fff;
  }
}
@media screen and (min-width: 650px) {
  #email {
    width: 229px;
    height: 49px;
    background: #fff;

  }
  #submit_go {
    width: 229px;
    height: 49px;
    border: solid 1px #fff;
    color: #fff;
  }

}
#email::placeholder {
  padding-left: 10px;
}

#modal_description {

}


.button_submit {
  position: relative;
}

.button_submit .form-label {
  position: absolute;
  top: 25px;
  left: 20px;
  font-size: 21px;
}

#modal-description-text .p .span {
  font-family: "Open Sans" !important;
}
</style>
