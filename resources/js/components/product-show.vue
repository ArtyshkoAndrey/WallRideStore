<script>
  import Zooming from 'zooming'
  export default {
    name: "product-show",
    data () {
      return {
        idSku: null,
        counter: 0,
        favoredData: false,
        cart: false,
        skus: []
      }
    },
    props: {
      product: {
        type: Object,
        required: true
      },
      skus_not_order: {
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
      this.skus = this.skus_not_order.sort(function (a, b) {
        if (a.skus.weight > b.skus.weight) {
          return 1;
        }
        if (a.skus.weight < b.skus.weight) {
          return -1;
        }
        return 0;
      })
      this.idSku = this.skus[0].id
      this.favoredData = this.favor

      console.log(this.skus)
      this.$nextTick(() => {
        // SLICK
        let $slider = $('.slider-for')
        $slider.slick({
          slidesToShow: 1,
          slidesToScroll: 1,
          arrows: true,
          fade: true,
          dots: true,
          draggable: false,
          swipe: false,
          touchMove: false,
          adaptiveHeight: true,
        });

        let $bigSlider = $('.slider-for-big')

        $bigSlider.slick({
          autoplay:false,
          autoplaySpeed:10000,
          speed:400,
          slidesToShow:1,
          slidesToScroll:1,
          pauseOnHover:false,
          dots:false,
          pauseOnDotsHover:false,
          cssEase:'linear',
          touch: false,
          verticalSwiping: false,
          accessibility: false,
          draggable:false,
          swipeToSlide: false,
          touchMove: false,
          swipe: false,
          prevArrow:'<button class="PrevArrow"></button>',
          nextArrow:'<button class="NextArrow"></button>',
        })
        $('img.zoom')
          .css('display', 'block')
          .parent()
          .zoom({magnify: 1.6, on: 'grab'});

        $('#wrapper-big-slider').css("opacity", "0").css("z-index", "-1")

        $('.slider-for img').on('click', () => {
          $('#wrapper-big-slider').css("opacity", "1").css("z-index", "9999")
          $('body').css('overflow', 'hidden')
        })

        $slider.on('afterChange', (event, slick, currentSlide) => {
          $bigSlider.slick('slickGoTo', currentSlide)
        });
        $('#close-big-slider').on('click', () => {
          $('#wrapper-big-slider').css("opacity", "0").css("z-index", "-1")
          $('body').css('overflow-y', 'auto')
        })
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
            .then((response) => { // Запрос успешно выполнил этот обратный вызов
              if (response.data.type === 'auth') {
                // swal('Товар добавлен в корзину', '', 'success')
                //   .then(() => {
                this.cart = true
                setTimeout(() => {
                  this.cart = false
                }, 2000)
                    // location.href = '/cart';
                  // });
                let data = response.data
                this.$parent.cartItems = data.cartItems
                this.$parent.priceAmount = data.priceAmount
                this.$parent.amount = data.amount
              } else if (response.data.type === 'web') {
                // $.cookie("products",[5, 1, 54],{expires: 7, path: '/'});
                let arr = $.cookie('products').split(',')
                console.log(arr)
                if (arr[0] === '' || arr.length === 0) {
                  arr = [];
                  arr = this.$addSkusToCart([], this.size.id, this.counter)
                  $.cookie("products", arr.join(','),{expires: 7, path: '/'});
                } else {
                  arr = this.$addSkusToCart(arr, this.size.id, this.counter)
                  $.cookie("products",arr.join(',') ,{expires: 7, path: '/'});
                }
                axios.post('/cart/getData', {
                  ids: arr
                })
                  .then(response => {
                    let data = response.data
                    console.log(data);
                    this.$parent.cartItems = data.cartItems
                    this.$parent.priceAmount = data.priceAmount
                    this.$parent.amount = data.amount
                    // swal('Товар добавлен в корзину', '', 'success')
                    //   .then(() => {
                    this.cart = true
                    setTimeout(() => {
                      this.cart = false
                    }, 2000)
                        // location.href = '/cart';
                      // });
                  })
              }
            }, function (error) { // Запрос не смог выполнить этот обратный вызов
              if (error.response.status === 401) {
                // код статуса http 401, пользователь не авторизован
                swal('Пожалуйста, войдите сначала', '', 'error');
              } else if (error.response.status === 422) {
                // Код состояния http: 422, что указывает на сбой проверки ввода пользователя.--}}
                let html = '<div>';
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
          swal('Товар добавлен в избранные', '', 'success')
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
          swal('Товар удалён из избранных', '', 'success')
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
  @media (max-width: 768px) {
    .btn-group-toggle-skus {
      display: grid;
    }
  }
  .sku-btn {
    border: 1px solid #1D1E23;
    box-sizing: border-box;
    border-radius: 5px!important;

    &.active{
      background: #000!important;
      color: white !important;
    }
  }
  .btn-angle {
    background: #1D1E23;
    color: white;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25);
  }
  #btn-add-to-cart {
    background: #1D1E23;
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

  .img-fill{
    width: 100%;
    display: block;
    overflow: hidden;
    position: relative;
    text-align: center;
  }

  .img-fill img {
    height: 100%;
    width: auto;
    position: relative;
    margin-left: auto;
    margin-right: auto;
  }

  @media screen and (max-width: 768px) {
    .img-fill img {
      display: flex!important;
      height: auto;
      width: 100%;
      position: relative;
      margin-top: auto;
      margin-bottom: auto;
      align-self: center !important;
      //transform: translateY(50%);
    }
    .img-fill {
      display: flex!important;
    }
  }

  *,
  *:before,
  *:after {
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.04);
  }

  .blocks-box,
  .slick-slider {
    margin: 0;
    padding: 0!important;
  }

  .slick-slide {
    float: left /* If RTL Make This Right */ ;
    padding: 0;
  }

  .slider-for-big .item .img-fill{
    height:100vh;
    background:#fff;
  }
  .slider-for-big {
    touch-action: auto;
    -ms-touch-action: auto;
  }

  #close-big-slider:focus, #close-big-slider:active, #close-big-slider:hover, .NextArrow:active, .NextArrow:focus {
    outline: none;
    box-shadow: none;
  }
  #wrapper-big-slider {
    transition: .6s;
  }


  .slick-slider{position:relative;display:block;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;-webkit-touch-callout:none;-khtml-user-select:none;-ms-touch-action:pan-y;touch-action:pan-y;-webkit-tap-highlight-color:transparent}
  .slick-list{position:relative;display:block;overflow:hidden;margin:0;padding:0}
  .slick-list:focus{outline:none}.slick-list.dragging{cursor:hand}
  .slick-slider .slick-track,.slick-slider .slick-list{-webkit-transform:translate3d(0,0,0);-ms-transform:translate3d(0,0,0);transform:translate3d(0,0,0)}
  .slick-track{position:relative;top:0;left:0;display:block}
  .slick-track:before,.slick-track:after{display:table;content:''}.slick-track:after{clear:both}
  .slick-loading .slick-track{visibility:hidden}
  .slick-slide{display:none;float:left /* If RTL Make This Right */ ;height:100%;min-height:1px}
  .slick-slide.dragging img{pointer-events:none}
  .slick-initialized .slick-slide{display:block}
  .slick-loading .slick-slide{visibility:hidden}
  .slick-vertical .slick-slide{display:block;height:auto;border:1px solid transparent}
</style>
