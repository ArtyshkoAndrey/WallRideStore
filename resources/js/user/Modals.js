import Alert from "./Alert";
import Cookies from 'js-cookie';
import Modal1 from './components/modal-3'
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
        this.modals.forEach(modal => {
          let m = this.store.state.modals.find(el => el.id === modal.id)
          if(m === undefined) {
            this.store.commit('addModal', modal.id)
            this.openModal(modal)
          }
        })

      })
      .catch(e => {
        console.log(e)
        // for (let key in e.response.data) {
        //   Alert.warning(e.response.data[key])
        //   break;
        // }
      })
  }

  openModal(modal) {
    let modal1 = Vue.extend(Modal1)
    let instance = new modal1({
      propsData: {modal: modal}
    })
    instance.$mount()
    console.log(this.vue.$refs)
    this.vue.$refs.app.appendChild(instance.$el)
  }

}
