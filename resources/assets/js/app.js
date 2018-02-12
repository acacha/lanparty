
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import UsersSearch from './components/UsersSearchComponent.vue'
import NumbersSearch from './components/NumbersSearchComponent.vue'
import ManageUser from './components/ManageUserComponent.vue'
import LandingPage from './components/LandingPageComponent.vue'
import Gravatar from './components/GravatarComponent.vue'

import store from './store'

const app = new Vue({
  el: '#app',
  store,
  data: () => ({
    dialog: false,
    drawer: null,
    drawerRight: false,
    items: [
      { icon: 'home', text: 'Home' },
      { icon: 'contacts', text: 'Col·laboradors' },
      { icon: 'favorite_border', text: 'Premis' },
      { icon: 'settings', text: 'Settings' },
      { icon: 'chat_bubble', text: 'Contact' },
      { heading: 'Links'},
      { icon: 'link', text: 'Institut de l\'Ebre', href: 'https://www.iesebre.com', new: true },
      { icon: 'link', text: 'Web Lan Party', href: 'http://lanparty.iesebre.com' , new: true },
      { icon: 'link', text: 'Facebook Lan Party', href: 'https://www.facebook.com/LanPartyIesEbre' , new: true },
      { icon: 'link', text: 'Streaming (Twitch)', href: 'https://www.twitch.tv/iesebrelanparty' , new: true },
      { heading: 'Administració'},
      { icon: 'face', text: 'Participants', href: '/manage/participants' },
    ]
  }),
  components: { UsersSearch, NumbersSearch, ManageUser, LandingPage, Gravatar },
  methods: {
    toogleRightDrawer() {
      this.drawerRight = ! this.drawerRight
    },
    menuItemSelected(item) {
      if (item.href) {
        if (item.new) {
          window.open(item.href)
        } else {
          window.location.href = item.href;
        }
      }
    }
  },
  props: {
    source: String
  }
})
