<template>

</template>

<script>
import Cookies from "js-cookie";

export default {
  name: "pay-order",
  data () {
    return {
      windowsLoader: false,
    }
  },
  props: {
    order: Object
  },
  methods: {
    pay () {
      let language = Cookies.get('language') === 'en' ? 'en-US' : 'ru-RU';
      let widget = new cp.CloudPayments({ language: language} );
      widget.pay('charge', // или 'charge'
        { //options
          publicId: 'pk_4180963d51ddacba2982452f72f00', //id из личного кабинета
          description: '', //назначение
          amount: Number(this.order.price) + Number(this.order.ship_price) - Number(this.order.sale), //сумма
          currency: 'KZT', //валюта
          invoiceId: this.order.no, //номер заказа  (необязательно)
          accountId: this.order.user.email, //идентификатор плательщика (необязательно)
          skin: "modern", //дизайн виджета (необязательно)
        },
        {
          onSuccess: (options) => { // success
            //действие при успешной оплате
            this.windowsLoader = true
            window.axios.post('/order/update/status', {
              order: this.order.id,
              state: 'pending'
            })
              .then(response => {
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
            window.Swal.fire({
              title: 'Вы не оплатили заказ!',
              text: 'Вы сможете оплатить свой заказ, иначе он удалится',
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
  }
}
</script>

<style scoped>

</style>
