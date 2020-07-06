require('./bootstrap');
window.Vue = require('vue');
import kebabCase from 'lodash/kebabCase'

const longpress = require('vue-long-press-directive');

Vue.use(longpress, { duration: 1000 });
// const ComponentContext = require.context('./', true, /\.vue$/i);

// ComponentContext.keys().forEach((componentFilePath) => {

//   const componentName = componentFilePath.split('/').pop().split('.')[0];
//   Vue.component(componentName, () => ComponentContext(componentFilePath));

// });

Vue.config.productionTip = false
// Подключить и зарегистрировать компоненты из директории .components
const requireComponent = require.context(
  // Относительный путь до каталога компонентов
  './components',
  // Обрабатывать или нет подкаталоги
  true,
  // Регулярное выражение для определения файлов базовых компонентов
  /\w+\.(vue|js)$/
)

requireComponent.keys().forEach(fileName => {
  // Получение конфигурации компонента
  const componentConfig = requireComponent(fileName)

  // Получение имени компонента в PascalCase
  const componentName = kebabCase(
      // Удаление из начала `./` и расширения из имени файла
      fileName.replace(/^\.\/(.*)\.\w+$/, '$1')
  )
  /* eslint-disable no-console */
  // console.log('fileName',fileName,'=>',componentName);
  /* eslint-enable no-console */
  // Глобальная регистрация компонента
  Vue.component(
    componentName,
    // Поиск опций компонента в `.default`, который будет существовать,
    // если компонент экспортирован с помощью `export default`,
    // иначе будет использован корневой уровень модуля.
    componentConfig.default || componentConfig
  )
})

Vue.prototype.$cost = function (number) {
  return new Intl.NumberFormat('ru-RU').format((number).toFixed(0))
}

Vue.prototype.$addSkusToCart = function(mas, what, amount) {
  let temp = new Array(amount);
  temp.fill(what);
  mas = mas.concat(temp)
  return mas;
}

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
    window.axios = require('axios');
    window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    let token = document.head.querySelector('meta[name="csrf-token"]');

    if (token) {
        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
    } else {
        console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
    }
    this.amount = this.$el.attributes.amount.value
    let arr = $.cookie('products').split(',')
    if(arr.length === 1 && arr[0] === '') {
      arr.pop();
    }
    axios.post('/cart/getData', {
      ids: arr
    })
    .then(response => {
      let data = response.data
      if (data.type === 'web') {
        this.cartItems = data.cartItems
        this.priceAmount = data.priceAmount
        this.amount = data.amount
        let ids = [];
        this.cartItems.forEach((e) => {
          let i = e.amount
          while(i > 0) {
            ids.push(e.id)
            i--;
          }
        })
        console.log(ids)
        $.cookie("products", ids.join(','), {expires: 7, path: '/'});
      }
    })
  }
});

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
