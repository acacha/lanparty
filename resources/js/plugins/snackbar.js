import * as mutations from '../store/mutation-types'
import store from '../store'

export default {
  install (Vue, options) {
    // Add Vue instance methods by attaching them to Vue.prototype.
    Vue.prototype.$snackbar = {
      showMessage (message) {
        this.showSnackBar(message, 'success')
      },
      showError (error) {
        // https://kapeli.com/cheat_sheets/Axios.docset/Contents/Resources/Documents/index
        // Handle errors sections
        if (error) {
          if (typeof error === 'string') {
            this.showSnackBar(error, 'error')
            return
          }
          if (error.response) {
            // The request was made and the server responded with a status code
            // that falls out of the range of 2xx
            this.showSnackBar(error.response.data, 'error', error.response.status)
            return
          }
          if (error.request) {
            // The request was made but no response was received
            // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
            // http.ClientRequest in node.js
            if (navigator.onLine) {
              this.showSnackBar('Error de xarxa', 'error')
            } else {
              this.showSnackBar('Error de xarxa. Estat de la xarxa: sense connexió', 'error')
            }
            return
          }
          // Something happened in setting up the request that triggered an Error
          if (error.message) {
            this.showSnackBar(error.message, 'error')
            return
          }
          this.showSnackBar(error, 'error')
        }
      },
      cleanState () {
        setTimeout(() => {
          store.commit(mutations.SET_SNACKBAR_SHOW, false)
          store.commit(mutations.SET_SNACKBAR_TEXT, '')
          store.commit(mutations.SET_SNACKBAR_SUBTEXT, '')
        }, store.getters.snackbarTimeout)
      },
      showSnackBar (message, color, subtext = null, textAlign = null) {
        store.commit(mutations.SET_SNACKBAR_SHOW, true)
        store.commit(mutations.SET_SNACKBAR_COLOR, color || 'error')
        if (subtext) store.commit(mutations.SET_SNACKBAR_SUBTEXT, subtext)
        if (textAlign) store.commit(mutations.SET_SNACKBAR_TEXT_ALIGN, textAlign)
        store.commit(mutations.SET_SNACKBAR_TEXT, message)
        this.cleanState()
      }
    }
  }
}
