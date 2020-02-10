
<script>
  import carousel from 'vue-owl-carousel';
  import product from "./product";
  export default {
    name: "product-list",
    components: {carousel, product},
    data() {
      return {

      }
    },
    methods: {
      adaptiveHeightButtons () {
        $('.btn-to-cart-adaptive').height($('.btn-to-cart-adaptive').width())
      }
    },
    mounted () {
      this.adaptiveHeightButtons()
      window.addEventListener("resize", this.adaptiveHeightButtons);
    }
  }
</script>

<style>

</style>
