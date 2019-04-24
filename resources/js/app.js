
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import UsersSearch from './components/UsersSearchComponent.vue'
import VUsersSearch from './components/VUsersSearchComponent.vue'
import NumbersSearch from './components/NumbersSearchComponent.vue'
import ManageUser from './components/ManageUserComponent.vue'
import LandingPage from './components/LandingPageComponent.vue'
import Gravatar from './components/GravatarComponent.vue'
import Events from './components/EventsComponent.vue'
import UserNumbers from './components/UserNumbersComponent.vue'
import EventsManage from './components/events/EventsManage.vue'
import EventsList from './components/events/EventsList.vue'
import ManagersManage from './components/managers/ManagersManage.vue'
import PartnersManage from './components/partners/PartnersManage.vue'
import Share from './components/ShareComponent.vue'
import Sorteig from './components/SorteigComponent.vue'
import Prizes from './components/PrizesComponent.vue'
import Partners from './components/PartnersComponent.vue'
import MainNavigationDrawer from './components/ui/MainNavigationDrawer'
import MainToolbar from './components/ui/MainToolbar'
import UserInfoDrawer from './components/ui/UserInfoDrawer'
import snackbar from './plugins/snackbar'
import permissions from './plugins/permissions'
import confirm from './plugins/confirm/index.js'
import store from './store'
import * as mutations from './store/mutation-types'

import { mapGetters } from 'vuex'

import 'typeface-montserrat/index.css'
import 'typeface-roboto/index.css'
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import '@fortawesome/fontawesome-free/css/all.css'
import 'font-awesome/css/font-awesome.min.css'

import 'vuetify/dist/vuetify.min.css'
import Vue from 'vue'
import Vuetify from 'vuetify'
import helpers from './utils/helpers'
import PrizesManage from "./components/prizes/PrizesManage";
import UsersManage from "./components/users/UsersManage";

window.Vue = Vue;
window.Vuetify = Vuetify;
window.Vue.use(Vuetify)
window.Vue.use(snackbar)
window.Vue.use(permissions)
window.Vue.use(confirm)

window.helpers = helpers

store.commit(mutations.USER,  user)
if (window.user ) store.commit(mutations.LOGGED, true)

window.axios.interceptors.response.use((response) => {
  return response
}, function (error) {
  if (window.disableInterceptor) return Promise.reject(error)
  if (error && error.response) {
    if (error.response.status === 419) {
      return window.helpers.getCsrfToken().then((token) => {
        window.helpers.updateCsrfToken(token)
        error.config.headers['X-CSRF-TOKEN'] = token
        return window.axios.request(error.config)
      }).catch(e => {
        console.log("NO s'ha pogut obtenir el CSRFTOKEN")
        console.log(e)
      })
    }
    if (error.response.status === 401) {
      window.Vue.prototype.$snackbar.showError("No heu entrat al sistema o ha caducat la sessió. Renviant-vos a l'entrada del sistema")
      const loginUrl = location.pathname ? '/login?back=' + location.pathname : '/login'
      setTimeout(function () { window.location = loginUrl }, 3000)
      // Break the promise chain -> https://github.com/axios/axios/issues/715
      return new Promise(() => {})
    }
    if (error.response.status === 403) {
      window.Vue.prototype.$snackbar.showSnackBar(
        'Error 403!',
        'error',
        'No teniu permisos per realitzar aquesta acció.',
        'center'
      )
    }
    if (error.response.status === 422) {
      console.log('HEY!!!!!')
      console.log(window.Vue.prototype.$snackbar)
      console.log(error.response.data)
      console.log('PROVA')
      window.Vue.prototype.$snackbar.showSnackBar(
        'Les dades proporcionades no són vàlides',
        'error',
        window.helpers.printObject(error.response.data.errors),
        'center'
      )
    }
    if (error.response.status === 404) {
      window.Vue.prototype.$snackbar.showSnackBar(
        'Error 404!',
        'error',
        "No s'ha pogut trobar al servidor el recurs que demaneu.",
        'center'
      )
    }
    if (error.response.status === 405) {
      window.Vue.prototype.$snackbar.showSnackBar(
        'Error 405!',
        'error',
        'Tipus de petició HTTP incorrecte.',
        'center'
      )
    }
    if (error.response.status === 500) {
      window.Vue.prototype.$snackbar.showSnackBar(
        'Error 500!',
        'error',
        'Error inesperat al servidor',
        'center'
      )
    }
    return Promise.reject(error)
  }
  if (error && error.request) {
    window.Vue.prototype.$snackbar.showError("Error de xarxa! No s'ha obtingut cap resposta a la vostra petició. Consulteu l'estat de la xarxa.")
    window.Vue.prototype.$snackbar.showSnackBar('Error de xarxa!', 'error', "No s'ha obtingut cap resposta a la vostra petició. Consulteu l'estat de la xarxa.")
    return Promise.reject(error)
  }
})

const app = new Vue({
  el: '#app',
  store,
  data: () => ({
    dialog: false,
    drawer: null,
    drawerRight: false
  }),
  components: {
    UsersSearch,
    VUsersSearch,
    NumbersSearch,
    ManageUser,
    LandingPage,
    'gravatar': Gravatar,
    Events,
    UserNumbers,
    Share,
    Sorteig,
    Prizes,
    Partners,
    'main-navigation-drawer': MainNavigationDrawer,
    'main-toolbar': MainToolbar,
    'user-info-drawer': UserInfoDrawer,
    'events-manage': EventsManage,
    'events-list': EventsList,
    'managers-manage': ManagersManage,
    'partners-manage': PartnersManage,
    'prizes-manage': PrizesManage,
    'users-manage': UsersManage
  },
  computed: {
    ...mapGetters({
      user: 'user'
    })
  },
  methods: {
    checkRoles (item) {
      if (item.role) {
        return this.$store.getters.roles.find(function(role) {
          return role == item.role // eslint-disable-line
        })
      }
      return true
    }
  },
  props: {
    source: String
  }
})

// if ('serviceWorker' in navigator && 'PushManager' in window) {
//   window.addEventListener('load', function() {
//     navigator.serviceWorker.register('/service-worker.js').then(function(registration) {
//       // Registration was successful
//       console.log('ServiceWorker registration successful with scope: ', registration.scope);
//     }, function(err) {
//       // registration failed :(
//       console.log('ServiceWorker registration failed: ', err);
//     });
//   });
// }
