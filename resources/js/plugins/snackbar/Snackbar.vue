<template>
    <v-snackbar
            :timeout="timeout"
            :color="color"
            v-model="show"
            :multi-line="true"
            v-bind:style="{'text-align': textAlign}">
        {{ message }}<br/>
        {{ subtext }}
        <v-btn dark flat @click="show=false">Tancar</v-btn>
    </v-snackbar>
</template>

<script>
import EventBus from '../../eventBus'
export default {
  data () {
    return {
      message: '',
      subtext: '',
      timeout: 3000,
      color: 'success',
      show: false,
      textAlign: 'inherit'
    }
  },
  methods: {
    showMessage (message, subtext = '') {
      this.message = message
      this.subtext = subtext
      this.color = 'success'
      this.show = true
    },
    showError (error) {
      this.message = error
      this.color = 'error'
      this.show = true
    },
    showSnackBar (message, color, subtext, textAlign) {
      this.message = message
      this.color = color
      this.subtext = subtext
      this.textAlign = textAlign
      this.show = true
    }
  },
  mounted () {
    EventBus.$on('showSnackbarError', (error) => {
      this.showError(error)
    })
    EventBus.$on('showSnackbarMessage', (message) => {
      this.showMessage(message)
    })
    EventBus.$on('showSnackBar', (message, color, subtext, textAlign) => {
      this.showSnackBar(message, color, subtext, textAlign)
    })
  }
}
</script>
