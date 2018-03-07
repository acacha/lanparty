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
    showError (error) {
      this.showSnackBar(error, 'error')
    },
    showSnackBar (error, color) {
      this.snackbar = true
      this.snackbarColor = color || this.snackbarColor
      if (typeof error === 'string') {
        this.snackbarText = error.message
        return
      }
      this.snackbarText = error.message
      if (error.response) this.snackbarSubtext = error.response.data.message
    }
  }
}
