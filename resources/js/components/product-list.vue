<template>
  <flickity ref="flickity" :options="flickityOptions">
    <product :slider=true></product>
    <product :slider=true></product>
    <product :slider=true></product>
    <product :slider=true></product>
    <product :slider=true></product>
    <product :slider=true></product>
    <product :slider=true></product>
    <product :slider=true></product>
    <product :slider=true></product>
    <product :slider=true></product>
    <product :slider=true></product>
  </flickity>
</template>

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
