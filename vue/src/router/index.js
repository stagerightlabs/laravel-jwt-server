import Vue from 'vue'
import Router from 'vue-router'
import Dashboard from '@/components/Dashboard'
import Register from '@/components/Register'
import Login from '@/components/Login'
import ForgotPassword from '@/components/ForgotPassword'
import Secrets from '@/components/Secrets'
import NotFound from '@/components/NotFound'

Vue.use(Router)

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/register',
      name: 'Register',
      component: Register
    },
    {
      path: '/login',
      name: 'Login',
      component: Login
    },
    {
      path: '/forgot-password',
      name: 'ForgotPassword',
      component: ForgotPassword
    },
    {
      path: '/',
      name: 'Dashboard',
      component: Dashboard,
      beforeEnter: (to, from, next) => {
        if (window.authority.authenticated()) {
          return next()
        }

        return next({ name: 'Login' })
      }
    },
    {
      path: '/secrets',
      name: 'Secrets',
      component: Secrets,
      beforeEnter: (to, from, next) => {
        if (window.authority.authenticated()) {
          return next()
        }

        return next({name: 'Login'})
      }
    },
    {
      path: '*',
      name: 'NotFound',
      component: NotFound
    }
  ]
})
