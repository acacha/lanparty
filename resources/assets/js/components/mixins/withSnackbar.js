export default {
  data () {
    return {
      snackbarColor: 'error',
      snackbarText: 'An error occurred',
      snackbar: false
    }
  },
  methods: {
    showError (message) {
      this.showSnackBar(message, 'error')
    },
    showSnackBar (message, color) {
      this.snackbar = true
      this.snackbarText = message
      this.snackbarColor = color || this.snackbarColor
    }
  }
}
