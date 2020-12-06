<script>
  export default {
    name: "create-order",
    data () {
      return {
        cost: 0,
        cartItems: [],
        stepMin: 0.5,
        order: {
          name: $('input[name=username]').val(),
          phone: $('input[name=contact_phone]').val(),
          email: $('input[name=email]').val(),
          country: null,
          city: null,
          street: $('input[name=street]').val(),
          payment_method: null,
          express_company: null,
          coupon: null,
          service: null
        },
        companies: []
      }
    },
    props: {
      cart_items: {
        required: true
      },
      currency: {
        required: true
      },
      amount: {
        type: Number,
        required: true
      },
      pays: {
        required: true
      }
    },
    beforeMount() {
      this.order.country = $('select[id=country]').val()
    },
    mounted () {
      let self = this
      $('#city1').select2().on('change', function (e) {
        self.order.city = this.value
      })
      $('#country').select2().on('change', function (e) {
        self.order.country = this.value
      })
      this.cart_items.forEach(el => {
        this.cartItems.push({
          amount: el.amount,
          id: el.id,
          productSku: el.product_sku ? el.product_sku : el.productSku
        })
      });
      this.cartItems.forEach(item => {
        this.cost += Number(item.amount) * Number(item.productSku.product.on_sale ? item.productSku.product.price_sale : item.productSku.product.price)
      });
    },
    computed: {
      getMethod () {
        return this.order.payment_method
      },
      getCompany () {
        return this.order.express_company
      },
      getCostCompany () {
        return this.order.express_company.costedTransfer
      },
      getCost () {
        return this.order.express_company !== null ? this.cost + this.company.costedTransfer : this.cost
      },
      getCompanies () {
        if (this.city === null || this.country === null) {
          return []
        } else {
          let companies = [...this.companies]
          this.companies = []
          companies.forEach(com => {
            if ( com.costedTransfer !== null && com.costedTransfer >= 0 && Number(com.min_cost) <= Number(this.cost) && com.enabled && (com.enabled_cash || com.enabled_card) ) {
              console.log(com.enabled_cash || com.enabled_card)
              this.companies.push(com)
            }
          })
          return this.companies
        }
      },
      getCostTransfer () {
        return Number(this.getCompany.costedTransfer)
      },
      getWeight () {
        let weight = 0;
        this.cartItems.forEach(item => {
          weight += Number(item.amount) * Number(item.productSku.product.weight)
        });
        return weight;
      },
      getService () {
        return this.order.service
      }
    },
    watch: {
      'order.country': {
        handler: function (after, before) {
          if (this.order.city == null) {
            this.order.city = $('select[id=city1]').val()
          } else {
            $('#city1').text(null).val(null)
            this.order.city = null
            this.setCompany(null)
            this.setMethod(null)
          }
        },
        deep: true
      },
      'order.express_company': {
        handler: function (after, before) {
          let amount = 0;
          this.cartItems.forEach(item => {
            amount += Number(item.amount) * Number(item.productSku.product.on_sale ? item.productSku.product.price_sale : item.productSku.product.price)
          });
          $('#checkCoupon').prop('disabled', false);
          $('#coupon').prop('readonly', false);
          this.$refs.totalAmountBottom.innerText = 'Общая сумма ' +
            new Intl.NumberFormat('ru-RU').format(((amount + this.getCostTransfer) * this.currency.ratio).toFixed(0)) +
            ' ' + this.currency.symbol

          this.checkCoupon(false);
        },
        deep: true
      },

      'order.city': {
        handler: function (after, before) {
          this.setCompany(null)
          this.setMethod(null)
          this.setService(null)
          this.companies = []
          if (after !== null)
            axios.post('/api/companies', {city: this.order.city})
              .then(response => {
                response.data.length > 0 ? this.companies = response.data : this.companies = []
                this.companies.forEach(com => {
                  if (typeof com.costedTransfer === "number" || typeof com.costedTransfer === "string") {
                    if ((this.getWeight - this.stepMin) > 0) {
                      console.log('Вес ' + this.getWeight)
                      let p = this.getWeight - this.stepMin
                      let i = 0
                      console.log('Перевес на ' + p, 'Шаг перевеса ' + com.step_unlim)
                      while (p > 0) {
                        p = p - com.step_unlim
                        i++
                      }
                      console.log('Кол-во шагов перевеса ' + i);
                      com.costedTransfer = Number(com.costedTransfer) + Number(com.step_cost_unlim) * i
                      console.log('-----')
                    }
                  } else if (typeof com.costedTransfer === "object" && com.costedTransfer !== null) {
                    let costs = com.costedTransfer.slice()
                    com.costedTransfer = null
                    costs.some(cost => {
                      if (this.getWeight >= cost.weight_to && this.getWeight < cost.weight_from) {
                        com.costedTransfer = Number(cost.cost)
                        return false;
                      }
                    })
                  }
                })
              })
        },
        deep: true
      },
    },
    methods: {
      setCompany (company) {
        this.order.express_company = company
        this.setMethod(null)
        this.setService(null)
      },
      setMethod (methodPay) {
        this.order.payment_method = methodPay
      },
      setService (service) {
        this.order.service = service
        if (this.getMethod !== 'card')
          this.setMethod('card')
      },
      checkCoupon (swalable = true) {
        let code = this.order.coupon;
        // Если нет ввода, всплывающее окно
        if((!code || code === '' || code === null) && swalable) {
          swal('Пожалуйста, введите код скидки', '', 'warning');
          return;
        }
        let amount = 0
        this.cartItems.forEach(item => {
          amount += Number(item.amount) * Number(item.productSku.product.on_sale ? item.productSku.product.price_sale : item.productSku.product.price)
        });
        // Вызов интерфейса проверки
        axios.post('/coupon_codes/' + code, {totalAmount: amount, items: this.cartItems})
          .then((response) => {  // Первым параметром метода then является обратный вызов, который будет вызываться при успешном выполнении запроса
            console.log(response.data)
            this.$refs.totalAmountBottom.innerText = 'Общая сумма ' +
              new Intl.NumberFormat('ru-RU').format(((response.data.totalAmount + (this.getCostTransfer ? this.getCostTransfer : 0)) * this.currency.ratio).toFixed(0)) +
              ' ' + this.currency.symbol
            if (swalable) {
              swal('Купон применился', '', 'success')
            }
            $('#checkCoupon').prop('disabled', true);
            $('#coupon').prop('readonly', true);
          }, (error) => {
            if (swalable) {
              // Если код возврата 404, купон не существует
              if (error.response.status === 404) {
                swal('Код купона не существует', '', 'error');
              } else if (error.response.status === 403) {
                // Если код возврата 403, другие условия не выполняются
                swal(error.response.data.msg, '', 'error');
              } else {
                // Другие ошибки
                swal('Попробуйте перезагрузить страницу или напишите в тех поддержку', '', 'error');
              }
            }
          })
      },
      ordered () {
        if (this.getCompany
          && this.getMethod
          && this.order.country
          && this.order.city
          && this.order.name
          && this.order.street
          && this.order.phone
          && this.order.email) {
          if (this.getMethod === 'card' && this.getService === null) {
            swal({
              icon: 'error',
              title: 'Упс...',
              text: 'Заполните все поля',
            })
          }
          else {
            axios.post('/orders', {
              address: {
                phone: this.order.phone,
                country: this.order.country,
                city: this.order.city,
                street: this.order.street,
                contact_name: this.order.name
              },
              email: this.order.email,
              items: this.cartItems,
              coupon: this.order.coupon,
              payment_method: this.order.payment_method,
              express_company: this.order.express_company,
              cost_transfer: this.getCostCompany,
              service: this.order.service
            })
              .then((response) => {
                console.log(response);
                swal('\n' + 'Заказ успешно создан', '', 'success')
                  .then(() => {
                    $.cookie("products", '', {expires: 7, path: '/'});
                    window.location = response.data
                  });
              })
              .catch(error => {

              })
          }
        } else {
          swal({
            icon: 'error',
            title: 'Упс...',
            text: 'Заполните все поля',
          })
        }
      }
    }
  }
</script>

<style scoped lang="scss">
</style>
