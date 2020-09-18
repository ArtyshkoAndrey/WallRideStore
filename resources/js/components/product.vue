<template>
  <div :class="slider ? 'col-lg col-md-4 offset-1 offset-sm-0  col-10 my-3' : 'col-md-4 col-lg-3 offset-1 offset-sm-0  col-10 my-3'">
    <div class="card h-100">
      <div class="card-body px-0 pb-0 justify-content-between d-flex flex-column">
        <div>
          <div class="position-absolute px-4 py-1" style="top:0;left:0" id="event" v-if="!item.on_sale ? item.promotions.some(elem => elem.status) : item.promotions.some(elem => elem.status && elem.sale_status)">
            <div class="position-relative d-inline-flex">
              <span class="font-weight-bold text-white">Акция</span>
              <div class="position-relative d-block px-2 mt-1 text-white simptip-position-bottom" :data-tooltip="promotionsText"><i class="fal fa-info-circle"></i></div>
            </div>
          </div>
          <div class="position-absolute px-4 py-1" id="like">
            <button class="bg-transparent border-0 m-0 p-0" @click="favored" v-if="!favor" style="transition: 1s;"><i class="fal fa-heart"></i></button>
            <button class="bg-transparent border-0 m-0 p-0" v-else style="transition: 1s;"><i class="fas fa-heart"></i></button>
          </div>
<!--          <img :src="item.image_url" v-if="slider" alt="item.image" class="carousel-cell-img img-fluid w-100 mb-3 rounded">-->
          <a :href="'/product/'+item.id"><img :src="item.photos !== null && item.photos.length > 0  ? '/public/storage/products/' + item.photos[0].name : 'https://developers.google.com/maps/documentation/maps-static/images/error-image-generic.png'" alt="item.image" class="img-fluid w-100 mb-3 rounded"></a>
          <div class="box">
            <a :href="'/product/'+item.id" class="mt-4 pb-0 mb-0 name">{{ item.title }}</a>
          </div>
          <p :class="'price mt-1 pt-0 '">
            <span :class="'d-inline-flex ' + (item.on_sale && item.price_sale ? 'text-muted' : null)"><s v-if="item.on_sale && item.price_sale">{{ $cost(Number(item.price) * currency.ratio) }} {{ currency.symbol }}</s> <span v-else>{{ $cost(Number(item.price) * currency.ratio) }} {{ currency.symbol }}</span></span>
            <span v-if="item.on_sale && item.price_sale" class="d-inline-flex text-danger">{{ $cost(Number(item.price_sale) * currency.ratio) }} {{ currency.symbol }}</span>
          </p>
        </div>
        <div class="row px-0 mx-0">
          <div class="col-3 px-0 btn-to-cart-adaptive">
<!--            Кнопка корзины-->
              <button class="btn w-100 h-100" id="btn-add-to-cart" v-if="!cart" @click="addToCart()" style="transition: 1s; font-size: 18px;"><i class="fal fa-shopping-bag"></i></button>
              <button class="btn w-100 h-100" id="btn-remove-in-cart" v-else disabled readonly style="transition: 1s; font-size: 18px;"><i class="fal fa-check"></i></button>
          </div>
          <div class="align-items-center col-4 d-flex pl-2 pr-0">
            <div class="row m-0" style="border-right: 1px solid #D0D0D0;">
              <div class="col-12  m-0 p-0 pr-1 text-center" style="font-size: 12px">Количество</div>
              <div class="col-5 offset-2 mr-0 my-0 p-0" style="margin-top:-5px !important;">
                <input class="form-control w-100 bg-white h-100 border-0 p-0 font-weight-bolder text-center" type="number" style="font-size: 18px;
line-height: 24px;" v-model="count" readonly disabled>
              </div>
              <div class="col-4 px-0" style="margin-top:-7px !important;">
                <div class="row p-0 m-0 h-100">
                  <div class="col-12 p-0 w-100 d-flex justify-content-start align-items-end">
                    <button class="btn p-0 m-0 btn-angle" v-long-press="addCounter" @click="addCounter"><i class="fal fa-angle-up"></i></button>
                  </div>
                  <div class="col-12 p-0 w-100 d-flex justify-content-start align-items-start">
                    <button class="btn p-0 m-0 btn-angle" v-long-press="removeCounter" @click="removeCounter"><i class="fal fa-angle-down"></i></button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="align-items-center col-4 d-flex pl-1 pr-0" v-if="item.skus.length === 1 && item.skus[0].skus === null">
            <div class="row m-0 pr-2 justify-content-end">
              <div class="col-12 m-0 p-0 text-center" style="font-size: 12px">Размер</div>
              <div class="col-2 px-0 d-flex align-items-center justify-content-end" style="margin-top:-5px !important;">
                <button class="btn p-0 m-0 h-100 bg-transparent btn-angle" v-long-press="addNumberSize" @click="addNumberSize"><i class="fal fa-angle-left mt-1"></i></button>
              </div>
              <div class="col-6 m-0 p-0" style="margin-top:-4px !important;">
                <input class="form-control w-100 h-100 bg-white border-0 p-0 font-weight-bolder text-center" type="text" value="ALL" readonly disabled>
              </div>
              <div class="col-2 px-0 d-flex align-items-center" style="margin-top:-5px !important;">
                <button class="btn p-0 m-0 h-100 bg-transparent btn-angle" v-long-press="removeNumberSize" @click="removeNumberSize"><i class="fal fa-angle-right mt-1"></i></button>
              </div>
            </div>
          </div>
          <div class="align-items-center col-4 d-flex pl-1 pr-0" v-else>
            <div class="row m-0 pr-2 justify-content-end">
              <div class="col-12 m-0 p-0 text-center" style="font-size: 12px">Размер</div>
              <div class="col-2 px-0 d-flex align-items-center justify-content-end" style="margin-top:-5px !important;">
                <button class="btn p-0 m-0 h-100 bg-transparent btn-angle" v-long-press="addNumberSize" @click="addNumberSize"><i class="fal fa-angle-left mt-1"></i></button>
              </div>
              <div class="col-6 m-0 p-0" style="margin-top:-4px !important;">
                <input class="form-control w-100 h-100 bg-white border-0 p-0 font-weight-bolder text-center" type="text" v-model="item.skus[numberSize].skus.title" readonly disabled>
              </div>
              <div class="col-2 px-0 d-flex align-items-center" style="margin-top:-5px !important;">
                <button class="btn p-0 m-0 h-100 bg-transparent btn-angle" v-long-press="removeNumberSize" @click="removeNumberSize"><i class="fal fa-angle-right mt-1"></i></button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: "product",
    props: {
      currency: {
        required: true
      },
      item_not_soted: {
        type: Object,
        required: false,
        default: false
      },
      slider: {
        type: Boolean,
        default: false
      }
    },
    data() {
      return {
        count: 1,
        numberSize: 0,
        cart: false,
        favor: false,
        item: {}
      }
    },
    created() {
      this.item = this.item_not_soted
      this.item.skus = this.item_not_soted.skus.sort(function (a, b) {
        if (a.skus.weight > b.skus.weight) {
          return 1;
        }
        if (a.skus.weight < b.skus.weight) {
          return -1;
        }
        return 0;
      })
    },
    mounted() {

      console.log(this.item.promotions.some(elem => elem.status && elem.sale_status))
      while (this.item.skus[this.numberSize].stock <= 0) {
        this.removeNumberSize()
      }
    },
    computed: {
      promotionsText: function() {
        let t = ''
        console.log(this.item.promotions)
        this.item.promotions.forEach((pr, index) => {
          if (!this.item.on_sale) {
            if (index === 0 || index === this.item.promotions.length && pr.status) {
              t += pr.name
              console.log(pr)
            } else if (index !== this.item.promotions.length && pr.status) {
              t += ', ' + pr.name + ', '
              console.log(pr)
            }
          } else if (pr.sale_status) {
            if (index === 0 || index === this.item.promotions.length && pr.status) {
              t += pr.name
              console.log(pr)
            } else if (index !== this.item.promotions.length && pr.status) {
              t += ', ' + pr.name + ', '
              console.log(pr)
            }
          }
        })
        return t;
      }
    },
    methods: {
      addCounter() {
        this.item.skus[this.numberSize].stock > this.count ? this.count++ : null;
      },
      removeCounter() {
        this.count > 0 ? this.count-- : null;
      },
      addNumberSize() {
        if (this.numberSize < this.item.skus.length - 1) {
          this.numberSize++
          if (this.item.skus[this.numberSize].stock <= 0) {
            this.addNumberSize()
          }
        } else {
          this.numberSize = 0
          if (this.item.skus[this.numberSize].stock <= 0) {
            this.addNumberSize()
          }
        }
        this.count = 1
      },
      removeNumberSize() {
        if (this.numberSize > 0) {
          this.numberSize--;
          if (this.item.skus[this.numberSize].stock <= 0) {
            this.removeNumberSize()
          }
        } else {
          this.numberSize = this.item.skus.length - 1
          if (this.item.skus[this.numberSize].stock <= 0) {
            this.removeNumberSize()
          }
        }
        this.count = 1
      },
      favored () {
        // нициируйте запрос post ajax. URL запроса генерируется функцией backend route ().
        axios.post('/products/' + this.item.id + '/favorite')
          .then(() => {
            swal('Операция прошла успешно', '', 'success')
              .then(() => { // здесь добавлен метод then ()
                this.favor = true
                setTimeout(() => {
                  this.favor = false
                }, 2000)
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
      addToCart() {
        if (this.count > 0) {
          axios.post('/cart', {
            sku_id: this.item.skus[this.numberSize].id,
            amount: this.count,
          })
            .then((response) => { // Запрос успешно выполнил этот обратный вызов
              if (response.data.type === 'auth') {
                // swal('Товар добавлен в корзину', '', 'success')
                //   .then(() => {
                //     this.cart = true
                //     setTimeout(() => {
                //       this.cart = false
                //     }, 2000)
                //     // location.href = '/cart';
                //   });
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
                  arr = this.$addSkusToCart([], this.item.skus[this.numberSize].id, this.count)
                  $.cookie("products", arr.join(','),{expires: 7, path: '/'});
                } else {
                  arr = this.$addSkusToCart(arr, this.item.skus[this.numberSize].id, this.count)
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
                  //     this.cart = true
                  //     setTimeout(() => {
                  //       this.cart = false
                  //     }, 2000)
                  //     // location.href = '/cart';
                  //   });
                })
              }
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
      }
    }
  }
</script>

<style scoped lang="scss">
  .box {
      overflow: hidden;
      height: 50px;
      width: 100%;
  }
  .box > a {
      -webkit-column-width: 150px;
      -moz-column-width: 150px;
      column-width: 150px;
      height: 100%;
  }
  .fade-enter-active, .fade-leave-active {
    transition: opacity .5s;
  }
  .fade-enter, .fade-leave-to /* .fade-leave-active до версии 2.1.8 */ {
    opacity: 0;
  }
  button:focus{
    outline:none !important;
    box-shadow: none !important;
  }
  #like {
    right: 10px;
    font-size: 26px;
    color: #000;
    transition: 1s;
    > * {
      transition: 1s;
    }
    i {
      transition: 1s;
      text-shadow: 0px 4px 10px rgba(0, 0, 0, 0.4);
      color: #000;
    }
  }
  .card {
    border: 0;
    height: 100%;
    background: #FFFFFF;
    box-shadow: 0 4px 5px rgba(0, 0, 0, 0.09);
    border-radius: 15px;
    .card-body {
      #event {
        background-color: #000;
        /*box-shadow: 0 4px 20px rgba(247, 7, 7, 0.43);*/
        border-top-left-radius: 15px;
        left: -15px;
        cursor: pointer;
        span {
          font-size: 18px;
          line-height: 35px;
        }

      }
      > div {
        padding: 0 23px;
      }
      [type="number"] {
        font-size: 14px;
      }
      #btn-add-to-cart {
        background: #000;
        color: white;
        border-radius: 0 15px 0 15px;
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
        border-radius: 0 15px 0 15px;
        &:focus {
          outline:0 !important;
        }
        &:active {
          outline:0 !important;
        }
      }
      .btn-angle {
        background-color: white;
        color: #000;
        height: 15px;
        display: block;
        border: none !important;
        outline: none !important;
        > i {
          font-size: 16px;
          font-weight: bold;
        }
        &:hover {
          color: black;
        }
        &:focus, &::-moz-focus-inner, &:active {
          outline: none !important;
          border: 0 !important;
          box-shadow: none !important;
          -moz-outline-style: none !important;
          outline:0 !important;
        }
      }
    }
    a.name {
      height: 32px;
      font-size: 16px;
      line-height: 24px;
      color: black;
      text-decoration: none;
      &:hover {
        color: #F33C3C;
      }
    }
    p.price {
      font-weight: bold;
      font-size: 20px;
      line-height: 35px;
    }
  }

  .carousel-cell {
    padding-top: 10px;
    padding-bottom: 10px;
    width: 60vw;
    height: 100%;
    margin-left: 30px;
    // margin-right: 15px;
  }
  @media (min-width: 468px) {
    .carousel-cell {
      width: 40vw;
    }
  }

  @media (min-width: 610px) {
    .carousel-cell {
      width: 33vw;
    }
  }
  @media (min-width: 800px) {
    .carousel-cell {
      width: 25vw;
    }
  }

  @media (min-width: 1024px) {
    .carousel-cell {
      width: 20vw;
    }
  }
  @media (min-width: 1150px) {
    .carousel-cell {
      width: 18vw;
    }
  }
  @media (min-width: 1350px) {
    .carousel-cell {
      width: 15vw;
    }
  }
  @media (min-width: 1600px) {
    .carousel-cell {
      width: 13vw;
    }
  }
  @media (min-width: 1921px) {
    .carousel-cell {
      width: 10vw;
    }
  }
  .go-to-product {
    cursor: pointer;
  }

</style>
