import Vue from 'vue'
import Vuex from 'vuex'
import users from './modules/users'
import numbers from './modules/numbers'
import auth from './modules/auth'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

export default new Vuex.Store({
  modules: {
    users,
    numbers,
    auth
  },
  strict: debug
})
