
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
import Share from './components/ShareComponent.vue'
import withSnackbar from './components/mixins/withSnackbar'
import Sorteig from './components/SorteigComponent.vue'
import Prizes from './components/PrizesComponent.vue'
import Partners from './components/PartnersComponent.vue'
import MainNavigationDrawer from './components/ui/MainNavigationDrawer'
import MainToolbar from './components/ui/MainToolbar'
import UserInfoDrawer from './components/ui/UserInfoDrawer'

import store from './store'
import * as mutations from './store/mutation-types'

import { mapGetters } from 'vuex'

import 'typeface-montserrat/index.css'
import 'typeface-roboto/index.css'
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import '@fortawesome/fontawesome-free/css/all.css'
import 'font-awesome/css/font-awesome.min.css'

import 'vuetify/dist/vuetify.min.css'

store.commit(mutations.USER,  user)
if (window.user ) store.commit(mutations.LOGGED, true)

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
    'user-info-drawer': UserInfoDrawer
  },
  mixins: [ withSnackbar ],
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
