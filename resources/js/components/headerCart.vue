<script>
  export default {
    name: "headerCart",
    props: {
      cartitems: {
        required: true
      },
      priceamount: {
        required: true
      },
      currency: {
        required: true
      }
    },
    mounted () {
      this.$parent.cartItems = this.cartitems
      this.$parent.priceAmount = this.priceamount
    }
  }
</script>

<style scoped>

</style>
