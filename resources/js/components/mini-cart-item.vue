<script>
  export default {
    name: "mini-cart-item",
    props: {
      id: {
        type: Number,
        required: true
      },
      item: {
        required: false
      },
      currency: {
        required: false
      }
    },
    data () {
      return {
        cartItem: {},
        type: ''
      }
    },
    mounted () {
      this.cartItem = this.item
    },
    methods: {
      postServe () {
        axios.post('/cart/minus', {
          sku_id: this.cartItem.product_sku ? this.cartItem.product_sku.id : this.cartItem.productSku.id,
          amount: this.cartItem.amount,
          type: this.type
        })
          .then((response) => { // Запрос успешно выполнил этот обратный вызов
            // swal('Значение изменено', '', 'success')
            console.log(response.data);
            let data = response.data;
            this.$parent.cartItems = data.cartItems
            this.$parent.priceAmount = data.priceAmount
            this.$parent.amount = data.amount
            if (response.data.ids) {
              $.cookie("products", response.data.ids, {expires: 7, path: '/'});
            }
            $('#amount').text(data.amount + ' шт.')
            $('#priceAmount').text((data.priceAmount * this.currency.ratio).toFixed(0) + ' ' + this.currency.symbol)
          }, function (error) { // Запрос не смог выполнить этот обратный вызов
            if (error.response.status === 401) {
              // код статуса http 401, пользователь не авторизован
              swal('Пожалуйста, войдите сначала', '', 'error');
            } else if (error.response.status === 422) {
              // Код состояния http: 422, что указывает на сбой проверки ввода пользователя.--}}
              var html = '<div>';
              _.each(error.response.data.errors, function (errors) {
                _.each(errors, function (error) {
                  html += error + '<br>';
                })
              });
              html += '</div>';
              swal({content: $(html)[0], icon: 'error'})
            } else {
              // В других случаях система должна зависать--}}
              swal('Системная ошибка', '', 'error');
            }
          })
      },
      addCounter() {
        if (this.cartItem.product_sku ? this.cartItem.product_sku.stock : this.cartItem.productSku.stock > this.cartItem.amount) {
          this.cartItem.amount++;
          this.type = 'pluses'
          this.postServe()
        }
      },
      removeCounter() {
        console.log(this.cartItem.amount);
        if (this.cartItem.amount > 1) {
          this.cartItem.amount--
          this.type='minus'
          this.postServe();
        }
      },
      deleteItem () {
        swal({
          title: "\n" + "Вы уверены, что хотите удалить этот товар?",
          icon: "warning",
          buttons: ['Отменить', 'Удалить'],
          dangerMode: true,
        })
        .then((willDelete) => {
          // Пользователь нажимает кнопку ОК, значение willDelete будет истинным, иначе ложным
          if (!willDelete) {
            return;
          }
          axios.delete('/cart/' + this.id)
          .then((response) => {
            if (response.data.ids === '' || response.data.ids) {
              console.log(response.data.ids)
              $.cookie("products", response.data.ids, {expires: 7, path: '/'});
            }
            location.reload();
          })
        });
      }
    }
  }
</script>

<style scoped>

</style>
