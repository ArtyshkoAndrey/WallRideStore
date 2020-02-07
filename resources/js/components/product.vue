<template>
  <div :class="slider ? 'carousel-cell' : 'col-md-4 col-lg-3 col-sm-6 col-10 offset-1 offset-sm-0 my-3'">
    <div :class="slider ? 'card' : 'card h-100'">
      <div class="card-body px-0 pb-0 justify-content-between d-flex flex-column">
        <div>
          <div class="position-absolute px-4 py-1" id="event" v-if="item.on_new || item.on_sale">
            <span class="text-uppercase font-weight-bold text-white" v-if="item.on_new">new</span>
            <span class="text-uppercase font-weight-bold text-white" v-else-if="item.on_sale">sale</span>
          </div>
          <img :src="item.image_url" v-if="slider" alt="item.image" class="carousel-cell-img img-fluid w-100 mb-3 rounded">
          <img :src="item.image_url" v-else alt="item.image" class="img-fluid w-100 mb-3 rounded">
          <a :href="'/product/'+item.id" class="mt-4 pb-0 mb-0 name">{{ item.title.length > 30 ? item.title.slice(0, 30) + '...' : item.title }}</a>
          <p class="price mt-1 pt-0">{{ (item.skus[numberSize].price * currency.ratio).toFixed(0) }} {{ currency.symbol }}</p>
        </div>
        <div class="row px-0 mx-0">
          <div class="col-4 px-0">
<!--            Кнопка корзины-->
              <button class="btn w-100" id="btn-add-to-cart" v-if="!cart" @click="addToCart()" style="transition: 1s;"><i class="fal fa-shopping-bag"></i></button>
              <button class="btn w-100" id="btn-remove-in-cart" v-else disabled readonly style="transition: 1s;"><i class="fal fa-check"></i></button>
          </div>
          <div class="col-4 px-0">
            <div class="row m-0">
              <div class="col-8 m-0 p-0">
                <input class="form-control w-100 bg-white border-0 pr-0 font-weight-bolder text-center" type="number" v-model="count" readonly disabled>
              </div>
              <div class="col-4 px-0">
                <div class="row p-0 m-0">
                  <div class="col-12 p-0 h-100 w-100">
                    <button class="btn p-0 m-0 btn-angle" v-long-press="addCounter" @click="addCounter"><i class="fal fa-angle-up"></i></button>
                  </div>
                  <div class="col-12 p-0 h-100 w-100">
                    <button class="btn p-0 m-0 btn-angle" v-long-press="removeCounter" @click="removeCounter"><i class="fal fa-angle-down"></i></button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-4 pr-0 pl-1">
            <div class="row m-0">
              <div class="col-2 pl-0 pr-1">
                <button class="btn p-0 m-0 bg-transparent btn-angle h-100" v-long-press="addNumberSize" @click="addNumberSize"><i class="fal fa-angle-left mt-1"></i></button>
              </div>
              <div class="col-6 m-0 pl-1 pr-0">
                <input class="form-control w-100 bg-white border-0 px-0 font-weight-bolder text-center" type="text" v-model="item.skus[numberSize].title" readonly disabled>
              </div>
              <div class="col-2 px-0">
                <button class="btn p-0 m-0 bg-transparent btn-angle h-100" v-long-press="removeNumberSize" @click="removeNumberSize"><i class="fal fa-angle-right mt-1"></i></button>
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
      slider: {
        type: Boolean,
        required: false,
        default: false
      },
      item: {
        type: Object,
        required: false,
        default: false
      }
    },
    data() {
      return {
        count: 0,
        numberSize: 0,
        cart: false
      }
    },
    mounted() {
      console.log(this.item);
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
          this.numberSize++;
          this.count = 0
        }
      },
      removeNumberSize() {
        if (this.numberSize > 0) {
          this.numberSize--;
          this.count = 0
        }
      },
      addToCart() {
        if (this.count > 0) {
          axios.post('/cart', {
            sku_id: this.item.skus[this.numberSize].id,
            amount: this.count,
          })
            .then((response) => { // Запрос успешно выполнил этот обратный вызов
              swal('Товар добавлен в корзину', '', 'success')
                .then(() => {
                  this.cart = true
                  setTimeout(() => {
                    this.cart = false
                  }, 2000)
                  // location.href = '/cart';
                });
              let data = response.data
              if (this.slider) {
                this.$parent.$parent.$parent.cartItems = data.cartItems
                this.$parent.$parent.$parent.priceAmount = data.priceAmount
                this.$parent.$parent.$parent.amount = data.amount
              } else {
                this.$parent.cartItems = data.cartItems
                this.$parent.priceAmount = data.priceAmount
                this.$parent.amount = data.amount
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

  .carousel-cell {
    padding-top: 10px;
    padding-bottom: 10px;
    /*width: 65vw;*/
    height: 100%;
    margin-left: 15px;
    margin-right: 15px;
  }
  /*@media (min-width: 600px) {*/
  /*  .carousel-cell {*/
  /*    width: 40vw;*/
  /*  }*/
  /*}*/
  @media (max-width: 768px) {
    .carousel-cell {
      margin-left: 30px;
      margin-right: 30px;
    }
  }
  /*@media (min-width: 992px) {*/
  /*  .carousel-cell {*/
  /*    width: 20vw;*/
  /*  }*/
  /*}*/
  /*@media (min-width: 1024px) {*/
  /*  .carousel-cell {*/
  /*    width: 23vw;*/
  /*  }*/
  /*}*/
  /*@media (min-width: 1200px) {*/
  /*  .carousel-cell {*/
  /*    width: 18vw;*/
  /*  }*/
  /*}*/
  /*@media (min-width: 1400px) {*/
  /*  .carousel-cell {*/
  /*    width: 13vw;*/
  /*  }*/
  /*}*/
  .go-to-product {
    cursor: pointer;
  }
  .card {
    border: 0;
    height: 100%;
    background: #FFFFFF;
    box-shadow: 0 4px 5px rgba(0, 0, 0, 0.09);
    border-radius: 15px;
    .card-body {
      #event {
        background-color: #F33C3C;
        box-shadow: 0 4px 20px rgba(247, 7, 7, 0.43);
        border-radius: 32px;
        left: -15px;
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
        color: #F33C3C;
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
      font-size: 24px;
      line-height: 35px;
    }
  }
</style>
