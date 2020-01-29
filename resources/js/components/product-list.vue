
<script>
  import Flickity from 'vue-flickity';
  import product from "./product";
  export default {
    name: "product-list",
    components: {Flickity, product},
    data() {
      return {
        flickityOptions: {
          initialIndex: 3,
          prevNextButtons: false,
          pageDots: false,
          freeScroll: true,
          adaptiveHeight: true,
          percentPosition: false,
          imagesLoaded: true,
          lazyLoad: 10
        }
      }
    },
    methods: {
      next() {
        this.$refs.flickity.next();
      },
      previous() {
        this.$refs.flickity.previous();
      }
    }
  }
</script>

<style>

</style>
