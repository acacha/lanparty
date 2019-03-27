import Snackbar from './Snackbar.vue'
import EventBus from '../../eventBus'

function Install (Vue, options) {
  Vue.component('snackbar', Snackbar)
  Vue.prototype.$snackbar = {
    showMessage (message) {
      EventBus.$emit('showSnackbarMessage', message)
    },
    showError (error) {
      EventBus.$emit('showSnackbarError', error)
    },
    showSnackBar (message, color, subtext = null, textAlign = null) {
      EventBus.$emit('showSnackBar', message, color, subtext, textAlign)
    }
  }
}

if (typeof window !== 'undefined' && window.Vue) {
  window.Vue.use(Install)
}

export default Install
