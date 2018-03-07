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
      console.log('ERROR:')
      console.dir(error)
      console.log(error)
      console.log('TYPEOF ERROR:')
      console.log(typeof error)
      this.snackbar = true
      this.snackbarColor = color || this.snackbarColor
      if (typeof error === 'string') {
        this.snackbarText = error
        return
      }
      console.log('MESSAGE:')
      console.dir(error.message)
      console.log('RESPONSE:')
      console.dir(error.response)
      this.snackbarText = error.message
      if (error.response) this.snackbarSubtext = error.response.data.message
    }
  }
}
