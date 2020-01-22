<template>
  <div :class="slider ? 'carousel-cell' : 'col-md-3 col-lg-2 col-6'">
    <div class="card">
      <div class="card-body px-0 pb-0">
        <div>
          <div class="position-absolute px-4 py-1" id="event" v-if="item.inNew || item.inSale">
            <span class="text-uppercase font-weight-bold text-white" v-if="item.inNew">new</span>
            <span class="text-uppercase font-weight-bold text-white" v-else-if="item.inSale">sale</span>
          </div>
          <img :src="item.img" alt="item.name" class="img-fluid w-100">
          <p class="mt-2 pb-0 mb-0 name">{{ item.name }}</p>
          <p class="price mt-1 pt-0">{{ item.size[0].pr }} {{ currency }}</p>
        </div>
        <div class="row px-0 mx-0">
          <div class="col-4 px-0">
            <button class="btn w-100" id="btn-add-to-cart" v-if="!item.inCart" @click="addToCart()"><i class="fal fa-shopping-bag"></i></button>
            <button class="btn w-100" id="btn-remove-in-cart" v-else @click="addToCart()"><i class="fal fa-check"></i></button>
          </div>
          <div class="col-4 px-0">
            <div class="row m-0">
              <div class="col-8 m-0 p-0">
                <input class="form-control w-100 bg-white border-0 pr-0 font-weight-bolder text-center" type="number" value="1" v-model="count" readonly disabled>
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
                <input class="form-control w-100 bg-white border-0 px-0 font-weight-bolder text-center" type="text" v-model="item.size[numberSize].name" readonly disabled>
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
  import _ from 'lodash';
  export default {
    name: "product",
    props: {
      slider: {
        type: Boolean,
        required: false,
        default: false
      },
      item: {
        type: Object,
        required: false,
        default: function () {
          return {
            name: 'Fucking Awesome – Angel 2 Hoodie Hunter',
            img: "../../../public/storage/inventory/t.png",
            size: [
              {
                name: 'L',
                count: 3,
                price: 40031,
                pr: localStorage.currency === 'usd' ? 40031 / 377.320 : (localStorage.currency === 'ru') ? 40031 / 6 : 40031
              },
              {
                name: 'M',
                count: 10,
                price: 40101,
                pr: localStorage.currency === 'usd' ? 40101 / 377.320 : (localStorage.currency === 'ru') ? 40101 / 6 : 40101
              },
              {
                name: 'XXL',
                count: 0,
                price: 40001,
                pr: localStorage.currency === 'usd' ? 40001 / 377.320 : (localStorage.currency === 'ru') ? 40001 / 6 : 40001
              },
            ],
            inCart: _.sample([true, false]),
            inFavourite: _.sample([true, false]),
            inSale: _.sample([true, false]),
            inNew: _.sample([true, false])
          }
        }
      },
    },
    data() {
      return {
        count: 0,
        numberSize: 0
      }
    },
    mounted() {
      console.log(this.item);
    },
    computed: {
      currency: function () {
        return localStorage.currency === 'usd' ? '$' : (localStorage.currency === 'ru') ? 'р.' : 'тг.';
      }
    },
    methods: {
      addCounter () {
        this.count++;
      },
      removeCounter () {
        this.count > 0 ? this.count-- : null;
      },
      addNumberSize () {
        console.log(this.numberSize);
        this.numberSize < this.item.size.length - 1 ? this.numberSize++ : null;
      },
      removeNumberSize () {
        console.log(this.numberSize);
        this.numberSize > 0 ? this.numberSize-- : null;
      },
      addToCart () {
        this.item.inCart = !this.item.inCart
      }
    }
  }
</script>

<style scoped lang="scss">
  button:focus{
    outline:none !important;
    box-shadow: none !important;
  }

  .carousel-cell {
    padding-top: 50px;
    padding-bottom: 50px;
    width: 50%;
    height: auto;
    margin-left: 10px;
    margin-right: 10px;
  }
  @media (min-width: 768px) {
    .carousel-cell {
      width: 25%;
    }
  }
  @media (min-width: 992px) {
    .carousel-cell {
      width: 16.66666667%;
    }
  }
  .card {
    background: #FFFFFF;
    box-shadow: 0 4px 40px rgba(0, 0, 0, 0.09);
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
    p.name {
      font-size: 16px;
      line-height: 24px;
    }
    p.price {
      font-weight: bold;
      font-size: 24px;
      line-height: 35px;
    }
  }
</style>
