require('./bootstrap');

window.Vue = require('vue');

const longpress = require('vue-long-press-directive');

Vue.use(longpress, { duration: 1000 });

const ComponentContext = require.context('./', true, /\.vue$/i, 'lazy');

ComponentContext.keys().forEach((componentFilePath) => {

  const componentName = componentFilePath.split('/').pop().split('.')[0];
  Vue.component(componentName, () => ComponentContext(componentFilePath));

});
require('./components/SelectDistrict');
require('./components/UserAddressesCreateAndEdit');
const app = new Vue({
  el: '#app'
});
