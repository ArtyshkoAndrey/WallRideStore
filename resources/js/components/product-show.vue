<script>
  import 'jquery-zoom'
  export default {
    name: "product-show",
    data () {
      return {
        idSku: null,
        counter: 0,
        favoredData: false,
        cart: false
      }
    },
    props: {
      product: {
        type: Object,
        required: true
      },
      skus: {
        type: Array,
        required: true
      },
      currency: {
        type: Object,
        required: true
      },
      favor: {
        type: Boolean,
        required: true
      }
    },
    created () {
      console.log("show");
      this.idSku = this.skus[0].id
      this.favoredData = this.favor
      this.$nextTick(() => {
        // SLICK
        $('.slider-for').slick({
          slidesToShow: 1,
          slidesToScroll: 1,
          arrows: false,
          fade: true,
          dots: true,
          draggable: false,
          swipe: false,
          touchMove: false,
          adaptiveHeight: true,
          asNavFor: '.slider-nav'
        });
        $('.slider-nav').slick({
          slidesToShow: 3,
          slidesToScroll: 1,
          asNavFor: '.slider-for',
          dots: false,
          focusOnSelect: true
        });
        $('.ex1').zoom();
      })
    },
    computed: {
      size () {
        return this.skus.find( (element) => {
          return element.id === this.idSku
        })
      }
    },
    methods: {
      addToCart () {
        if (this.counter > 0) {
          axios.post('/cart', {
            sku_id: this.size.id,
            amount: this.counter,
          })
            .then(() => { // Запрос успешно выполнил этот обратный вызов
              swal('Товар добавлен в корзину', '', 'success')
                .then(() => {
                  this.cart = true
                  setTimeout(() => {
                    this.cart = false
                  }, 2000)
                  // location.href = '/cart';
                });
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
        } else {
          swal({
            title: "Выберите количество больше нуля",
            text: "Данное колличество невозможно купить",
            icon: "warning",
            dangerMode: true,
          })
        }
      },
      addCounter () {
        this.size.stock > this.counter ? this.counter++ : null;
      },
      removeCounter () {
        this.counter > 0 ? this.counter-- : null;
      },
      favored () {
        // нициируйте запрос post ajax. URL запроса генерируется функцией backend route ().
        axios.post('/products/' + this.product.id + '/favorite')
        .then(() => {
          swal('Операция прошла успешно', '', 'success')
            .then(() => { // здесь добавлен метод then ()
              this.favoredData = true
            });
        }, (error) => { // Этот обратный вызов будет выполнен в случае сбоя запроса
          // Если код возврата 401, вы не авторизованы
          if (error.response && error.response.status === 401) {
            swal('Пожалуйста, войдите сначала', '', 'error');
          } else if (error.response && error.response.data.msg) {
            // В других случаях с полем msg, отправьте сообщение пользователю
            swal(error.response.data.msg, '', 'error');
          }  else {
            // В других случаях система должна зависать
            swal('Системная ошибка', '', 'error');
          }
        })
      },
      disFavored () {
        axios.delete('/products/'+ this.product.id +'/favorite')
        .then(() => {
          swal('Операция прошла успешно', '', 'success')
          .then(() => {
            this.favoredData = false
          });
        });
      }
    },
    watch: {
      size () {
        this.counter = 0;
      }
    }
  }
</script>

<style scoped lang="scss">
  @import "~slick-carousel/slick/slick.css";
  @import "~slick-carousel/slick/slick-theme.css";
  .sku-btn {
    border: 1px solid #000000;
    box-sizing: border-box;
    border-radius: 5px!important;

    &.active{
      background: #000!important;
      color: white !important;
    }
  }
  .btn-angle {
    background: #000;
    color: white;
    box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.25);
  }
  #btn-add-to-cart {
    background: #000;
    color: white;
    &:focus {
      outline:0 !important;
    }
    &:active {
      outline:0 !important;
    }
  }
  #btn-remove-in-cart {
    background: #04B900;
    color: white;
    &:focus {
      outline:0 !important;
    }
    &:active {
      outline:0 !important;
    }
  }
  .slider-nav__item {
    height: 100%;
    width: 100%;
    > img {
      height: auto;
      width: 100%;
      padding: 5px;
    }
  }
  .slider-for__item img {
    width: 100%;
  }
  #btn-remove-in-cart {
    background: #04B900;
    color: white;
    &:focus {
      outline:0 !important;
    }
    &:active {
      outline:0 !important;
    }
  }
</style>
