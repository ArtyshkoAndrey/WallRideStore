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
