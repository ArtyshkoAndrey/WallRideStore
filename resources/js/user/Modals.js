import Alert from "./Alert";
import Cookies from 'js-cookie';
import Modal1 from './components/modal-1'
import Modal2 from './components/modal-2'
import Modal3 from './components/modal-3'
import Modal4 from './components/modal-4'
import Vue from 'vue'
export default class Modals {

  constructor(store, vue) {
    this.store = store
    this.vue = vue
    axios.get('/api/modals', {
      language: Cookies.get('language') ?? 'ru'
    })
      .then(r => {
        this.modals = r.data.modals
        console.log(this.modals)

        for (let key in this.modals) {
          let m = this.store.state.modals.find(el => el.id === this.modals[key].id)
          if(m === undefined) {
            if (this.modals[key].on_auth && this.store.state.auth || this.modals[key].on_auth === false) {
              console.log(this.modals[key].on_auth && this.store.state.auth || this.modals[key].on_auth === false)
              console.log(this.modals[key].on_auth && this.store.state.auth)
              // this.store.commit('addModal', this.modals[key].id)
              this.openModal(this.modals[key])
              break
            }
          }
        }

      })
      .catch(e => {
        console.log(e)
        for (let key in e.response.data) {
          Alert.warning(e.response.data[key])
          break;
        }
      })
  }

  async openModal(modal) {
    setTimeout(async () => {
      let modalVue
      let flag = true;
      if (modal.type === 1) {
        modalVue = Vue.extend(Modal1)
      } else if (modal.type === 2) {
        modalVue = Vue.extend(Modal2)
      } else if (modal.type === 3) {
        modalVue = Vue.extend(Modal3)
      } else {
        modalVue = Vue.extend(Modal4)
        await axios.get('api/modals/code')
          .then(r => {
            modal.coupon_code = r.data.code
            console.log('code', r.data.code)
          })
          .catch(e => {
            console.log(e.response.data)
            flag = false;
          })
      }

      if (flag) {
        let instance = new modalVue({
          propsData: {modal: modal}
        })
        instance.$mount()
        // TODO: Подумать как сделать что бы окно было после прелоадера

        this.vue.$refs.app.appendChild(instance.$el)
      }
    }, 2000)
  }

}
