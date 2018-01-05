// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'

Vue.config.productionTip = false

// Bootstrap a global axios instance
window.axios = require('axios')
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

// Set up a global auth object
window.auth = {
  'access_token': '',
  'token_type': '',
  'expires_in': ''
}

// Set up event bus
window.events = new Vue(); // Event bus

// Set up global "flash" method
window.flash = function (message, level = 'info') {
  window.events.$emit('flash', message, level)
}

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  components: { App },
  template: '<App/>'
})
