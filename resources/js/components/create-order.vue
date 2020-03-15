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
          country: $('select[id=country]').val(),
          city: $('select[id=city1]').val(),
          street: $('input[name=street]').val(),
          pickup: false,
          payment_method: 'card',
          express_company: 2,
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
              setTimeout(()=> {
                $('#city1').select2({
                  placeholder: 'Город',
                  ajax: {
                    type: "POST",
                    dataType: 'json',
                    url: function (params) {
                      return '/api/city/' + params.term;
                    },
                    processResults: function (data) {
                      console.log($('#country').val())
                      return {
                        results: data.items.map((e) => {
                          return {
                            text: e.name,
                            id: e.id
                          };
                        })
                      };
                    }
                  }
                });
                $('#country').select2({
                  placeholder: 'Страна',
                  ajax: {
                    type: "POST",
                    dataType: 'json',
                    url: function (params) {
                      return '/api/country/' + params.term;
                    },
                    processResults: function (data) {
                      return {
                        results: data.items.map((e) => {
                          return {
                            text: e.name,
                            id: e.id
                          };
                        })
                      };
                    }
                  }
                });
              }, 300)
            }
          } else if (this.step === 2) {
            if (this.order.name !== '' && this.order.email !== '' && this.order.phone !== '') {
              let items = []
              this.cart_items.forEach(item => {
                items.push({
                  sku_id: item.product_sku ? item.product_sku.id : item.productSku.id,
                  amount: item.amount
                })
                console.log(items);
              })
              axios.post('/orders', {
                address: {
                  phone: this.order.phone,
                  country: $('select[id=country]').val(),
                  city: $('select[id=city1]').val(),
                  street: this.order.street,
                  contact_name: this.order.name
                },
                email: this.order.email,
                items: items,
                payment_method: this.order.payment_method,
                express_company: this.order.pickup ? 3 : this.order.express_company,
                cost_transfer: this.order.costTransfer
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

<style scoped lang="scss">
</style>
