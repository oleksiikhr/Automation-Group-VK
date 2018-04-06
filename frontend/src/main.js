// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import 'element-ui/lib/theme-chalk/display.css'
import App from './App'
import router from './router'
import axios from 'axios'
import store from './store'
import moment from 'moment'

// Axios
axios.defaults.baseURL = 'http://vk.local/api/'

axios.interceptors.request.use((config) => {
  const groupId = store.state.groups.selected.id || null
  const userTokenId = store.state.userTokens.selected.id || null

  switch (config.method) {
    case 'get':
      if (typeof config.params === 'undefined') {
        config.params = {}
      }
      config.params.group_id = groupId
      config.params.user_token_id = userTokenId
      break
    case 'put':
    case 'patch':
    case 'post':
      // FIXME Delete console.log
      console.log(config, config.data)
      config.data.group_id = groupId
      config.data.user_token_id = userTokenId
      break
  }

  return config
}, (err) => {
  return Promise.reject(err)
})

moment.locale('ru-RU')

Vue.use(ElementUI)

Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  components: { App },
  template: '<App/>'
})
