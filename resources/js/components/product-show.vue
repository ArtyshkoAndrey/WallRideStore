<script>
  import 'jquery-zoom'
  export default {
    name: "product-show",
    data () {
      return {
        idSku: null,
        counter: 0
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
        required: true
      }
    },
    created() {
      console.log("show");
      this.idSku = this.skus[0].id
      this.$nextTick(() => {
        // SLICK
        $('.slider-for').slick({
          slidesToShow: 1,
          slidesToScroll: 1,
          arrows: false,
          fade: true,
          dots: true,
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
        $('.ex1')
          .parent()
          .zoom();
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
      addCounter () {
        this.size.stock > this.counter ? this.counter++ : null;
      },
      removeCounter () {
        this.counter > 0 ? this.counter-- : null;
      },
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
    }
  }
  .slider-for__item img {
    width: 100%;
  }
</style>
