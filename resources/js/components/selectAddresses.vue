<template>
  <country-select v-model="country" :country="country" topCountry="US" />
  <region-select v-model="region" :country="country" :region="region" />
</template>

<script>
  export default {
    name: "selectAddresses",
    data: () => {
      return {
        country: '',
        region: ''
      }
    }
  }
</script>

<style scoped>

</style>
