import Vue from 'vue'
import Router from 'vue-router'
import Dashboard from '@/views/Dashboard'
import Groups from '@/views/Groups'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'dashboard',
      component: Dashboard
    },
    {
      path: '/groups',
      name: 'groups',
      component: Groups
    }
  ]
})
