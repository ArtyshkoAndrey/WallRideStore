<template>
  <div class="modal fade modal-user" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
       aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
      <div class="modal-content"
           :style="'background-image:url(' + modal.photo_jpg_storage + '); no-repeat; background-size:cover'"
      >
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
              <hr class="mx-auto" style="height: 2px;">
              <div v-html="modal.description" class="mb-4 modal-description-text"></div>
            </div>
            <hr class="mx-auto" style="height: 2px;">
            <div id="modal-coupon">

              <input id="code" class="font-weight-bolder text-white" type="text" :value="modal.coupon_code.code">
              <!--              <span id="code"-->
              <!--                    v-clipboard:copy="JSON.stringify(text)"-->
              <!--              >{{ modal.coupon_code.code }}</span>-->
            </div>
            <div id="modal-copy">
              <a @click="vuecopydemo">Копировать промокод</a>
            </div>
            <div id="modal-buy">
              <a href="#">Перейти к покупками</a>
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
import Vue from 'vue'
import VueClipboard from 'vue-clipboard2'

Vue.use(VueClipboard)
export default {
  name: "modal-4",
  props: {
    modal: Object,
  },
  data: () => {

    return {
      cssBackground: {
        backgroundImage: `url(modal.photo_jpg_storage)`
      },
      language: Cookie.get('language'),

    }
  },

  created() {
    this.$nextTick(() => {
      $('#staticBackdrop').modal('toggle')

    })
  },
  methods: {
    vuecopydemo() {

      let testingCodeToCopy = document.querySelector('#code')
      console.log(testingCodeToCopy);
      testingCodeToCopy.select()

      try {
        var successful = document.execCommand('copy');
        var msg = successful ? 'successful' : 'unsuccessful';
      } catch (err) {

      }

      /* unselect the range */
      window.getSelection().removeAllRanges()
    },
  },
}
</script>

<style scoped>
.modal-body {
  background: rgba(0, 0, 0, 0.5);
}

#modal-description {
  background: rgba(0, 0, 0, 0.5);
  height: 409px;
}

#modal-copy {
  margin-bottom: 10px !important;
}

#modal-copy a {
  color: #fff;
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

#modal-buy {
  background: #fff;
  height: 49px;
  line-height:49px;
}

#modal-buy a {
  color: #000 !important;
}
#code {
  background:none;
  color:#fff;
  border:none;
  text-align:center;
}
</style>
