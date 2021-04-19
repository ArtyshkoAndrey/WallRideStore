<template>

</template>

<script>
export default {
  name: "list-cost",
  props: {
    method_cost: {
      type: String,
    },
    step_counter: {
      type: Number,
    },
    step_cost_array: {
      type: Array
    }
  },
  data() {
    return {}
  },
  created() {
    console.log(this.step_cost_array)
  }
}
</script>

<style scoped>

</style>
