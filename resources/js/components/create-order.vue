<script>
  export default {
    name: "create-order",
    data () {
      return {
        test: false,
        testPay: false,
        cartItems: [],
        step: 1,
        stepMin: 0.5,
        order: {
          name: $('input[name=username]').val(),
          phone: $('input[name=contact_phone]').val(),
          email: $('input[name=email]').val(),
          country: $('select[id=country]').val(),
          city: $('select[id=city1]').val(),
          street: $('input[name=street]').val(),
          pickup: false,
          payment_method: null,
          express_company: null,
          coupon: null
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
      express_companies: {
        required: true
      },
      pickup: {
        required: true
      }
    },
    mounted () {
      this.$nextTick(function () {
        setTimeout(function () {
          $('#contact_phone').mask("+7 (999) 999-99-99");
        }, 10)
      });
      this.companies = this.express_companies;
      let weight = 0;
      // console.log(this.cart_items)
      this.cart_items.forEach(el => {
        this.cartItems.push({
          amount: el.amount,
          id: el.id,
          productSku: el.product_sku ? el.product_sku : el.productSku
        })
      });
      this.cartItems.forEach(item => {
        weight += Number(item.amount) * Number( item.productSku.product.weight)
      });
      this.express_companies.forEach(com => {
        console.log(typeof com.costedTransfer)
        if (typeof com.costedTransfer === "number" || typeof com.costedTransfer === "string") {
          if ((weight - this.stepMin) > 0) {
            console.log('Вес ' + weight)
            let p = weight - this.stepMin
            let i = 0
            console.log('Перевес на ' + p, 'Шаг перевеса ' + com.step_unlim)
            while(p > 0) {
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
            if (weight >= cost.weight_to && weight < cost.weight_from) {
              com.costedTransfer = Number(cost.cost)
              console.log(111111111111)
              return false;
            }
          })
        }
      })
      if (this.test) {
        this.order.name = "Andrey"
        this.order.email = 'artyshko.andrey@gmail.com'
        this.order.phone = '+79029634366'
        this.order.street = "Горького 24, 25, 660099"
      }
    },
    computed: {
      getCompany () {
        let com = this.order.pickup ? this.pickup : this.companies.find(el => el.id === this.order.express_company)
        if (com) {
          return com
        } else {
          return false
        }
      },
      getCostTransfer () {
        if (this.order.pickup) {
          return 0;
        } else {
          return Number(this.getCompany.costedTransfer)
        }
      },
      getWeight () {
        let weight = 0;
        this.cartItems.forEach(item => {
          weight += Number(item.amount) * Number(item.productSku.product.weight)
        });
        return weight;
      }
    },
    watch: {
      'order.country': {
        handler: function (after, before) {
          console.log(after, before);
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
        },
        deep: true
      },
      'order.pickup': {
        handler: function (after, before) {
          let amount = 0;
          this.cartItems.forEach(item => {
            amount += Number(item.amount) * Number(item.productSku.product.on_sale ? item.productSku.product.price_sale : item.productSku.product.price)
          });
          this.$refs.totalAmountBottom.innerText = 'Общая сумма ' +
            new Intl.NumberFormat('ru-RU').format(((amount + this.getCostTransfer) * this.currency.ratio).toFixed(0)) +
            ' ' + this.currency.symbol
        },
        deep: true
      }
    },
    methods: {
      checkCoupon () {
        let code = this.order.coupon;
        // Если нет ввода, всплывающее окно
        if(!code) {
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
              new Intl.NumberFormat('ru-RU').format(((response.data.totalAmount + (this.getCostTransfer? this.getCostTransfer : 0)) * this.currency.ratio).toFixed(0)) +
              ' ' + this.currency.symbol
            swal('Купон применился', '', 'success')
            $('#checkCoupon').prop('disabled', true);
            $('#coupon').prop('readonly', true);
          }, (error) => {
            // Если код возврата 404, купон не существует
            if(error.response.status === 404) {
              swal('Код купона не существует', '', 'error');
            } else if (error.response.status === 403) {
              // Если код возврата 403, другие условия не выполняются
              swal(error.response.data.msg, '', 'error');
            } else {
              // Другие ошибки
              swal('Внутренняя ошибка системы', '', 'error');
            }
          })
      },
      createOrder () {
        if ( Number($('select[id=country]').val()) === 82 ||  Number($('select[id=country]').val()) === 1) {
          let items = [];
          this.cartItems.forEach(item => {
            items.push({
              sku_id: item.productSku.id,
              amount: item.amount,
            });
            console.log(items);
          });
          axios.post('/orders', {
            address: {
              phone: this.order.phone,
              country: $('select[id=country]').val(),
              city: $('select[id=city1]').val(),
              street: this.order.street,
              contact_name: this.order.name
            },
            email: this.order.email,
            items: this.cartItems,
            coupon: this.order.coupon,
            payment_method: this.order.payment_method,
            express_company: this.order.pickup ? 3 : this.order.express_company,
            cost_transfer: this.order.costTransfer
          })
            .then((response) => {
              console.log(response);
              swal('\n' + 'Заказ успешно создан', '', 'success')
                .then(() => {
                  $.cookie("products", '', {expires: 7, path: '/'});
                  window.location = response.data
                });
            }, function (error) {
              if (error.response.status === 422) {
                // Код состояния http: 422, что указывает на сбой проверки ввода пользователя
                var html = '<div>';
                _.each(error.response.data.errors, function (errors) {
                  _.each(errors, function (error) {
                    html += error + '<br>';
                  })
                });
                html += '</div>';
                console.log(html);
                if (error.response.data.errors.email) {
                  swal({
                    text: 'Пользователь с таким email уже зарегистрирован, пожалуйста войдите или укажите другой email',
                    title: 'Пользователь уже существует.',
                    icon: 'warning',
                    buttons: {
                      success:{
                        text: "Изменить почту",
                        value: true,
                        className: "btn-primary"
                      },
                      cancle: {
                        text: "Войти в аккаунт",
                        value: false,
                        className: "btn-primary"
                      }
                    },
                    }).then((isConfirm) => {
                      if (isConfirm) {

                      } else {
                        window.location = '/login'
                      }
                    })
                } else {
                  swal({content: $(html)[0], icon: 'error'})
                }
              } else if (error.response.status === 403) { // Судя по статусу здесь 403
                swal(error.response.data.msg, '', 'error');
              } else {
                // В других случаях система должна зависать
                swal('Системная ошибка', '', 'error');
              }
            });
        } else {
          swal('Извините, на данный момент доставка осуществляется только по Казахстану и России', '', 'error');
        }
      },
      validEmail: function (email) {
        let re;
        re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
      },
      ordered () {
        if (this.amount > 0) {
          if (this.step === 1) {
            if (this.order.name !== '' && this.order.email !== '' && this.order.phone !== '' && this.validEmail(this.order.email)) {
              this.step = 2;
              let self = this;
              setTimeout(()=> {
                $('#city1').select2({
                  placeholder: 'Город',
                  ajax: {
                    type: "POST",
                    dataType: 'json',
                    url: function (params) {
                      if (self.order.country === null) {
                        return '/api/city/' + params.term;
                      } else {
                        return '/api/city/' + params.term + '/' + self.order.country
                      }
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
                }).on('change', function (e) {
                  $.cookie("city", this.value ,{expires: 7, path: '/'});
                  self.order.city = this.value
                  axios.post('/api/companies', {city: this.value})
                  .then(response => {
                    console.log(response)
                    response.data.length > 0 ? self.companies = response.data : self.companies = []
                    self.companies.forEach(com => {
                      // if ((self.getWeight - self.stepMin) > 0 && com.costedTransfer !== null) {
                      //   console.log('Вес ' + self.getWeight)
                      //   let p = self.getWeight - self.stepMin
                      //   let i = 0
                      //   console.log('Перевес на ' + p, 'Шаг для перевеса ' + com.step_unlim)
                      //   while(p > 0) {
                      //     p = p - com.step_unlim
                      //     i++
                      //   }
                      //   console.log('Кол-во шагов перевеса ' + i);
                      //   com.costedTransfer = Number(com.costedTransfer) + Number(com.step_cost_unlim) * i
                      //   console.log('-----')
                      // }

                      if (typeof com.costedTransfer === "number" || typeof com.costedTransfer === "string") {
                        if ((self.getWeight - self.stepMin) > 0) {
                          console.log('Вес ' + self.getWeight)
                          let p = self.getWeight - self.stepMin
                          let i = 0
                          console.log('Перевес на ' + p, 'Шаг перевеса ' + com.step_unlim)
                          while(p > 0) {
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
                          if (self.getWeight >= cost.weight_to && self.getWeight < cost.weight_from) {
                            com.costedTransfer = Number(cost.cost)
                            console.log(111111111111)
                            return false;
                          }
                        })
                      }
                    })
                    self.order.pickup = false
                    self.order.payment_method = null
                    self.order.express_company = null
                    $('.btn.active').removeClass('active')
                    ;
                  })
                })
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
                }).on('change', function (e) {
                  self.order.country = this.value
                  self.order.pickup = false
                  self.order.payment_method = null
                  self.order.express_company = null
                  self.order.city = null
                  $('#city1').text(null).val(null)
                  $('.btn.active').removeClass('active')
                })
              }, 300)
            } else {
              swal('Не заполнены все данные', '', 'error');
            }
          } else if (this.step === 2) {
            if (!$('#privacy')[0].checked) {
              swal('Необходимо принять условия политики конфиденциальности', '', 'error');
            } else if (this.order.pickup === false) { // не самовывоз
              if (this.order.street !== '' && this.order.payment_method !== null && this.order.city !== null && this.order.country !== null) { // данные для доставки
                if (this.order.payment_method === 'card') { // оплата картой
                  if (this.order.express_company === null) { // не выбрана компания доставки
                    swal('Не заполнены все данные', '', 'error');
                  } else { // выбрана компания доставки
                    let amount = 0;
                    this.cartItems.forEach(item => {
                      amount += Number(item.amount) * Number(item.productSku.product.on_sale ? item.productSku.product.price_sale : item.productSku.product.price)
                    });
                    let com = this.companies.find(el => el.id === this.order.express_company)
                    console.log(com, amount);
                    if (Number(com.min_cost) <= Number(amount)) { // Проверка на ограничение мин стоимости заказа
                      console.log('Покупка картой онлайн с выбранной компанией');
                      this.testPay ? swal('ТИПО ОПЛАЧЕНО ТЕСТ ))', '', 'success') : this.createOrder()
                    } else { // не прошла по стоимости
                      swal('Минимальная сумма заказа для ' +com.name + ' составляет: ' + Number.parseInt(Number(com.min_cost) * Number(this.currency.ratio)) + ' ' + this.currency.symbol, '', 'error');
                    }
                  }
                } else { // оплата наличными и не самовывоз
                  if (this.order.express_company === null) { // не выбрана компания доставки
                    swal('Не заполнены все данные', '', 'error');
                  } else { // выбрана компания доставки
                    let amount = 0;
                    this.cartItems.forEach(item => {
                      amount += Number(item.amount) * Number(item.productSku.product.on_sale ? item.productSku.product.price_sale : item.productSku.product.price)
                    });
                    let com = this.companies.find(el => el.id === this.order.express_company)
                    console.log(com, amount);
                    if (Number(com.min_cost) <= Number(amount)) { // Проверка на ограничение мин стоимости заказа
                      console.log('Покупка наличными с выбранной компанией');
                      this.testPay ? swal('ТИПО ОПЛАЧЕНО ТЕСТ ))', '', 'success') : this.createOrder()
                    } else { // не прошла по стоимости
                      swal('Минимальная сумма заказа для ' +com.name + ' составляет: ' + Number.parseInt(Number(com.min_cost) * Number(this.currency.ratio)) + ' ' + this.currency.symbol, '', 'error');
                    }
                  }
                }
              } else { // не прошла проверку на введённый данных
                swal('Не заполнены все данные', '', 'error');
              }
            } else { // самовывоз
              if (this.order.street !== '' && this.order.city !== null && this.order.country !== null && this.order.payment_method !== null) { // данные для доставки
                this.testPay ? swal('ТИПО ОПЛАЧЕНО ТЕСТ ))', '', 'success') : this.createOrder()
              }else { // не прошла проверку на введённый данных
                swal('Не заполнены все данные', '', 'error');
              }
            }
          }
        }
      }
    }
  }
</script>

<style scoped lang="scss">
</style>
