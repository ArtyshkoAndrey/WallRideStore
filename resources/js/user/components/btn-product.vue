<template>
  <button class="btn h-100 w-100 d-block btn-to-cart btn-dark" :style="check ? 'background-color: #00913b!important' : null"
          @click="addItem">
    <span class="pe-2" v-if="check">Добавлено</span>
    <span class="pe-2" v-else>{{ label }}</span>
    <i class="far fa-shopping-bag"></i>
  </button>
</template>

<script>
export default {
  name: "btn-product",
  data: () => {
    return {
      check: false
    }
  },
  props: {
    id: Number,
    label: String
  },
  methods: {
    addItem () {
      this.$store.commit('addItem', {id: this.id, amount: 1});
      this.check = true;
      setTimeout(()=> {
        this.check = false
      }, 1000)
    }
  }
}
</script>

<style scoped>

</style>
