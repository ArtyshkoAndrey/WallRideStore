<template>

</template>

<script>
import Cookies from 'js-cookie'
export default {
  name: "order",
  data () {
    return {
      info: {
        country: {
          id: null,
          name: null
        },
        city: {
          id: null,
          name: null,
          pickup: null
        },
        phone: null,
        name: null,
        email: null,
        address: null,
        post_code: null,
      },
      code: null,         // Промокод
      sale: false,        // Былали скидка
      price_with_sale: 0, // Скидка в тенге
      transfer: {
        price: 0,
        name: null
      },
      method_pay: null,
      loaderButton: false,
      loaderButtonAfter: false,
      windowsLoader: false,
      freeCompany: false,
      order: {
        no: null,
        id: null
      },
      errors: {
        ems: null
      },
      ems: {
        price: null,
        error: false,
      },
      customCompanies: []
    }
  },
  mounted () {
    this.$nextTick(() => {
      this.info.phone     = $('#phone').val()
      this.info.email     = $('#email').val()
      this.info.name      = $('#name').val()
      this.info.address   = $('#address').val()
      this.info.post_code = $('#post_code').val()

    })

  },
  methods: {
    setCountry (country) {
      this.info.country = country
    },

    setCity (city) {
      this.info.city = city
    },

    setName (event) {
      this.info.name = event.target.value
    },

    setEmail (event) {
      this.info.email = event.target.value
    },
    setPhone (event) {
      this.info.phone = event.target.value
    },

    setAddress (event) {
      this.info.address = event.target.value
    },

    setPostCode(event) {
      this.info.post_code = event.target.value
    },

    setPickupTransfer () {
      this.transfer = {
        price: 0,
        name: 'pickup'
      }
      this.method_pay = null
    },

    setEmsTransfer () {
      this.transfer = {
        price: this.ems.price,
        name: 'ems'
      }
      this.method_pay = null
    },
    setCompanyTransfer (company) {
      this.transfer = {
        price: company.price,
        name: company.name,
        enabled_cash: company.enabled_cash,
        enabled_card: company.enabled_card
      }
      this.method_pay = null
    },

    resetTransfer () {
      this.transfer = {
        price: 0,
        name: null
      }
      this.method_pay = null
    },

    setCloudPaymentMethod () {
      this.method_pay = 'cloudPayment'
    },

    setCashMethod () {
      this.method_pay = 'cash'
    },

    checkSale () {
      window.axios.post('/api/coupon', {
        code: this.code,
        items: this.$store.getters.productsCart
      })
      .then(response => {
        if(response.data.sale) {
          this.sale = true
          this.price_with_sale = response.data.sale
        }
      })
      .catch(error => {
        window.Swal.fire({
          icon: "error",
          title: 'Ошибка',
          text: error.response.data.error
        })
        this.code = null
      })
    },
    pay () {
      let language = Cookies.get('language') === 'en' ? 'en-US' : 'ru-RU';
      let widget = new cp.CloudPayments({ language: language} );
      widget.pay('charge', // или 'charge'
        { //options
          publicId: 'pk_4180963d51ddacba2982452f72f00', //id из личного кабинета
          description: '', //назначение
          amount: this.priceWithoutCurrency, //сумма
          currency: 'KZT', //валюта
          invoiceId: this.order.no, //номер заказа  (необязательно)
          accountId: this.info.email, //идентификатор плательщика (необязательно)
          skin: "modern", //дизайн виджета (необязательно)
          // data: {
            // myProp: 'myProp value'
          // }
        },
        {
          onSuccess: (options) => { // success
            //действие при успешной оплате
            !this.$root.test ? this.$store.commit('clearCart') : null
            this.windowsLoader = true
            window.axios.post('/order/update/status', {
              order: this.order.id,
              state: 'pending'
            })
            .then(response => {
              this.loaderButton = false
              window.location = '/order'
            })
            .catch(error => {
              window.Swal.fire({
                icon: "error",
                title: 'Ошибка',
                text: 'Возникла системная ошибка подстверждения оплаты. Обратитесь к администрации'
              })
            })

          },
          onFail: (reason, options) => { // fail
            //действие при неуспешной оплате
            this.loaderButton = true
            window.Swal.fire({
              title: 'Вы не оплатили заказ!',
              text: 'В течении 3-х часов Вы сможете оплатить свой заказ, иначе он удалится',
              icon: 'error',
              confirmButtonText: 'Далее'
            })
              .then((result) => {
                window.location = '/order'
              })
          }
        }
      )
    },
    createOrder () {
      return window.axios.post('/order/store', {
        info: this.info,
        method_pay: this.method_pay,
        transfer: this.transfer,
        items: this.$store.getters.productsCart,
        code: this.code,
        price: this.priceAmount,
        sale: this.price_with_sale
      })
    },
    cashPay () {
      this.createOrder()
        .then(response => {
          !this.$root.test ? this.$store.commit('clearCart') : null

          window.Swal.fire({
            title: 'Успешно',
            text: 'Заказ успешно создан',
            icon: 'success',
            confirmButtonText: 'Отследить'
          })
          .then(result => {
            window.location = '/order'
          })

        })
        .catch(error => {
          let errors = Object.values(error.response.data.errors)
          errors = errors.flat()
          let txt = ''
          errors.forEach(value => {
            txt += ('<p>' + value + '</p>')
          })

          window.Swal.fire({
            title: 'Ошибка',
            html: txt,
            icon: 'error',
            confirmButtonText: 'Изменить',
            width: '40rem'
          })
          .then(result => {
            this.loaderButtonAfter = false
          })
        })
    },
    orderedNow () {
      this.loaderButton = true;
      this.createOrder()
        .then(response => {
          this.order = response.data.order
          this.pay()
        })
        .catch(error => {
          let errors = Object.values(error.response.data.errors)
          errors = errors.flat()
          let txt = ''
          errors.forEach(value => {
            txt += ('<p>' + value + '</p>')
          })

          window.Swal.fire({
            title: 'Ошибка',
            html: txt,
            icon: 'error',
            confirmButtonText: 'Изменить',
            width: '40rem'
          })
            .then(result => {
              this.loaderButton = false
            })
        })
    },
    orderAfter () {
      this.loaderButtonAfter = true
      this.cashPay()
    },
    getEmsCost () {
      this.errors.ems = null
      this.ems.price = null
      this.ems.error = true

      this.getCustomCompanies()

      window.axios.post('/api/cost-ems', {
        country_code: this.info.country.code,
        post_code: this.info.post_code,
        weight: this.$store.getters.weight
      })
        .then(response => {
          this.ems.price = Number(response.data)
          this.ems.error = false


          if(this.freeCompany === false ) {
            if(!this.ems.error) {
              this.setEmsTransfer();
            }
          }
          console.log("FRREC" + this.freeCompany)
          console.log("FRREC" + this.ems.price)
        })
        .catch(error => {
          this.errors.ems = error.response.data
        })
    },
    getCustomCompanies () {
      window.axios.post('/api/companies', {
        city: this.info.city.id,
        weight: this.$store.getters.weight,
        cost: this.priceWithoutCurrency
      })
        .then(response => {
         let companies = Object.values(response.data.companies);
          this.freeCompany = companies.some(el => el.price === 0);
          if (this.freeCompany) {
            this.setCompanyTransfer(companies.find(el => el.price === 0))
            this.customCompanies = [companies.find(el => el.price === 0)]

          } else {
            this.customCompanies = companies
          }
        })
        .catch(error => {
          this.errors.ems = error.response.data
        })
    }
  },
  computed: {
    checkTransferZero () {
      let ch = []
      ch.push(this.info.city ? this.info.city.pickup : false)
      ch.push(!this.ems.error && this.ems.price !== null)
      ch.push( this.customCompanies.length >= 0)
      return !ch.includes(true);
    },
    price () {
      return this.$store.getters.priceAmount + (-this.price_with_sale + this.transfer.price) * this.$store.state.currency.ratio
    },
    priceWithoutCurrency () {
      return this.$store.getters.priceAmountWithoutCurrency + (-this.price_with_sale + this.transfer.price)
    },
    priceAmount () {
      return this.$store.getters.priceAmountWithoutCurrency
    },
    disabledButton () {
      let disabled = this.disabled

      if (this.loaderButton)
        disabled = true

      if(this.method_pay === 'cash')
        disabled = true

      return disabled
    },
    disabled () {
      let disabled = false
      for (let key in this.info) {
        if (!this.info[key] || this.info[key] === '')
          disabled = true
      }

      if(!this.transfer.name || !this.method_pay || !this.info.country.id || !this.info.city.id)
        disabled = true

      return disabled
    },
    disabledButtonCode () {
      if (this.sale)
        return true

      return !this.sale && (this.code === null || this.code === '')


    },
    disabledButtonAfter () {
      let disabled = this.disabled

      if (this.loaderButtonAfter)
        disabled = true

      // if(this.method_pay === '')
      //   disabled = true

      return disabled
    },
  },
  watch: {
    'info.country': {
      handler: function (after, before) {
        this.resetTransfer()
        this.method_pay = null
        if (after.name !== null && after.name !== '' && this.info.post_code !== null && this.info.post_code !== '') {
          if(this.info.post_code.length >= 4)
            this.getEmsCost()
          else {
            this.resetTransfer()
            this.errors.ems = 'Почтовый индекс должен иметь 4 символа'
            this.ems.error = true
          }
        }
      },
      deep: true
    },

    'info.city': {
      handler: function (after, before) {
        this.resetTransfer()
        this.method_pay = null

        if (after.name !== null && after.name !== '' && this.info.post_code !== null && this.info.post_code !== '') {
          if(this.info.post_code.length >= 4)
            this.getEmsCost()
          else {
            this.resetTransfer()
            this.errors.ems = 'Почтовый индекс должен иметь 4 символа'
            this.ems.error = true
          }
        }
      },
      deep: true
    },

    'info.post_code': {
      handler: function (after, before) {
        this.resetTransfer()
        this.method_pay = null
        if (after !== null && after !== '' && this.info.country.name !== null && this.info.country.name !== '') {
          if(after.length >= 4)
            this.getEmsCost()
          else {
            this.resetTransfer()
            this.errors.ems = 'Почтовый индекс должен иметь 4 символа'
            this.ems.error = true
          }
        }
      },
      deep: true
    },
  }
}
</script>

<style scoped>

</style>
