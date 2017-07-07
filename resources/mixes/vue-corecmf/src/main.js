import Vue from 'vue'
import {App, router, store} from 'builder-vue'
import CoreCmf from './components'
import BuilderVueElement from 'builder-vue-element'
import ElementUI from 'element-ui'
window.Vue = Vue
window.axios = require('axios')

window.axios.defaults.headers.common = {
  'X-CSRF-TOKEN': window.config.csrfToken,
  'X-Requested-With': 'XMLHttpRequest'
}

Vue.use(CoreCmf)
Vue.use(BuilderVueElement)
Vue.use(ElementUI)

/* 设置api通信url */
store.state.apiUrl = window.config.apiUrl

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  render: h => h(App)
})
