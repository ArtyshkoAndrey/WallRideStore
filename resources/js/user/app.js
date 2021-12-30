/*
 * Copyright (c) 2020. Данный файл является интелектуальной собственостью Fulliton.
 * Я буду рад если вы будите вносить улучшения, всегда жду ваших пул реквестов
 */

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Cookies from "js-cookie";
require('./bootstrap.js')
require('./header.js')
require('./root.js')
import Alert from './Alert';
import store from "./store";
import Modals from "./Modals";
import Vue from "vue";
window.Vue = require('vue')

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./components', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', import('./components/ExampleComponent.vue'));
Vue.prototype.$cost = function (number) {
  return new Intl.NumberFormat('ru-RU').format(Math.ceil(number))
}
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


Vue.config.productionTip = true

Vue.config.devtools = false;
Vue.config.performance = true;

const app = new Vue({
  el: '#app',
  store: store,

  data() {
    return {
      test: !process.env.NODE_ENV || process.env.NODE_ENV === 'development',
      cartLoader: true,
      selectSkus: null,
      modal: []
    }
  },
  async created () {
    await window.axios.post('/auth/check')
      .then(response => {

        this.$store.commit('auth', response.data)

        this.test ? console.log('Auth bool server', response.data) : null
      })
      .catch(response => {
        for (let key in error.response.data) {
          Alert.warning(error.response.data[key])
          break;
        }
        console.error(response)
      })

    await window.axios.post('/api/currency/' + this.$store.state.currency_id)
      .then(response => {
        this.$store.commit('currency', response.data)

        this.test ? console.log('Server return currency', response.data) : null
      })
      .catch(error => {
        for (let key in error.response.data) {
          Alert.warning(error.response.data[key])
          break;
        }
        // alert(error.response.data.error)
      })

    await window.axios.post('/api/products', {
      products_skuses_ids: this.$store.state.cart.items.map(el => el.id)
    })
      .then(response => {
        this.$store.commit('setProducts', response.data)
        let flag = false
        try {
          this.$store.state.cart.items.map(item => {
            let product = this.$store.state.cart.products.find(el => el.product_skuses.some(sk => sk.id === item.id))
            if (product === undefined) {
              flag = true
              this.$store.commit('removeItem', item.id)
            }
          })
        } catch ($e) {
          console.log($e)
        }
        if (flag)
          window.Swal.fire({
            icon: 'info',
            title: 'Товар в вашей корзине закончился',
            text: 'Товар из вашей корзины только-что закончился и был автоматически удален из корзины',
            width: '40rem'
          })

      })
      .catch(error => {
        for (let key in error.response.data) {
          Alert.warning(error.response.data[key])
          break;
        }
        // alert(error.response.data)
      })

    // Cookies.set('modals', JSON.stringify([1, 2, 3, 4]));
    // console.log(JSON.parse(Cookies.get('modals')))

    this.cartLoader = false
  },
  mounted() {
    this.$store.dispatch('deleteModals')
    this.modal = new Modals(this.$store, this)
  },
  computed: {
    productsCart() {
      return this.$store.state.cart.items.map(item => {
        let product = this.$store.state.cart.products.find(el => el.product_skuses.some(sk => sk.id === item.id))

        if (product) {
          product = Object.assign({}, product)
          product.item = item
          product.product_skuses = Object.values(product.product_skuses)
          product.skus = product.product_skuses
          product.skus = product.product_skuses.find(el => el.id === item.id)
          return product
        } else {
          this.$store.commit('removeItem', item.id)
        }
      })
    }
  },
  destroyed () {
    this.$store.state.cart.products = []
  }
})
