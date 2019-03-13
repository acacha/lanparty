export default {
  data () {
    return {
      snackbarColor: 'error',
      snackbarText: 'An error occurred',
      snackbarSubtext: '',
      snackbar: false
    }
  },
  methods: {
    showMessage (message) {
      this.showSnackBar(message, 'success')
    },
    showError (error) {
      this.showSnackBar(error, 'error')
    },
    showSnackBar (message, color) {
      this.snackbar = true
      this.snackbarColor = color || this.snackbarColor
      if (typeof message === 'string') {
        this.snackbarText = message
        return
      }
      this.snackbarText = message.message
      if (message.response) this.snackbarSubtext = message.response.data.message
    }
  }
}
