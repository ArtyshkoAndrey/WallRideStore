require('./bootstrap');
window.Vue = require('vue');

const longpress = require('vue-long-press-directive');

Vue.use(longpress, { duration: 1000 });
const ComponentContext = require.context('./', true, /\.vue$/i, 'lazy');

ComponentContext.keys().forEach((componentFilePath) => {

  const componentName = componentFilePath.split('/').pop().split('.')[0];
  Vue.component(componentName, () => ComponentContext(componentFilePath));

});
const app = new Vue({
  el: '#app',
  data () {
    return {
      cartItems: [],
      priceAmount: 0,
      amount: 0
    }
  },
  mounted () {
    this.amount = this.$el.attributes.amount.value
  }
});
