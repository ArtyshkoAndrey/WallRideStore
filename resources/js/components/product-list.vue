
<script>
  import Flickity from 'vue-flickity';
  import product from "./product";
  export default {
    name: "product-list",
    components: {Flickity, product},
    props: {
      nameid: {
        type: String,
        required: true
      }
    },
    data() {
      return {
        flickityOptions: {
          // initialIndex: 3,
          wrapAround: true,
          prevNextButtons: false,
          pageDots: false,
          freeScroll: false,
          adaptiveHeight: true,
          percentPosition: false,
          imagesLoaded: true,
          lazyLoad: 10,
        },
        maxHeight: null
      }
    },
    methods: {
      next() {
        this.$refs.flickity.next();
      },
      previous() {
        this.$refs.flickity.previous();
      }
    },
    updated() {
      console.log(this.maxHeight)
    },
    mounted () {

      let cells = $('#'+this.nameid + ' .carousel-cell');
      let flickityViewport = $('#'+this.nameid + ' div.flickity-viewport');
      let cards = $('#'+this.nameid + " div.carousel-cell .card");
      $(window).resize(function() {
        cells.height('auto')
      });
      setInterval(() => {
        cells.height('auto');
        this.maxHeight = Math.max.apply(null, cards.map(function ()
        {
          return ($(this).height())
        }).get());
        flickityViewport.height(this.maxHeight + 20);
        cells.height(this.maxHeight);
      }, 100);
    }
  }
</script>

<style>

</style>
