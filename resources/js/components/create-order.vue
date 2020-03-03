<script>
  export default {
    name: "create-order",
    data () {
      return {
        step: 1,
        order: {
          name: $('input[name=username]').val(),
          phone: $('input[name=contact_phone]').val(),
          email: $('input[name=email]').val(),
          country: $('input[name=country]').val(),
          city: $('input[name=city]').val(),
          street: $('input[name=street]').val(),
          pickup: false,
          payment_method: 'card',
          express_company: 'ase',
          coupon: null
        }
      }
    },
    props: {
      // address: {
      //   required: true,
      //   type: Object
      // },
      cart_items: {
        required: true
      },
      amount: {
        type: Number,
        required: true
      },
      express_companies: {
        required: true
      }
    },
    methods: {
      ordered () {
        if (this.amount > 0) {
          if (this.step === 1) {
            if (this.order.name !== '' && this.order.email !== '' && this.order.phone !== '') {
              this.step = 2
            }
          } else if (this.step === 2) {
            if (this.order.name !== '' && this.order.email !== '' && this.order.phone !== '') {
              let items = []
              this.cart_items.forEach(item => {
                items.push({
                  sku_id: item.product_sku_id,
                  amount: item.amount
                })
              })
              axios.post('/orders', {
                address: {
                  phone: this.order.phone,
                  country: this.order.country,
                  city: this.order.city,
                  street: this.order.street,
                  contact_name: this.order.name
                },
                items: items,
                payment_method: this.order.payment_method,
                express_company: this.order.pickup ? 3 : this.order.express_company
              })
              .then((response) => {
                console.log(response);
                window.location = response.data
              })
              .catch(e => {
                console.error(e)
              })
            }
          }
        }
      }
    }
  }
</script>

<style scoped>

</style>
