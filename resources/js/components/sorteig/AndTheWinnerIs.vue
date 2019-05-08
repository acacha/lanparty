<template>
    <v-card v-if="tachan">
        <v-toolbar style="background-color: #40764e;" class="white--text">
            <v-toolbar-title>I el guanyador és ...</v-toolbar-title>
        </v-toolbar>
        <v-card-title primary-title>
            <v-card v-if="winner">
                <v-img :src="gravatarURL (winner.email)" height="250px">
                </v-img>
                <v-card-title primary-title>
                    <h1 class="display-1 mb-0">{{ winner.name }}</h1>
                    <h3 class="headline mb-0">{{ userName(winner) }}</h3>
                </v-card-title>
                <v-card-actions>
                    <v-btn flat
                           color="success"
                           :disabled="assigning"
                           :loading="assigning"
                           @click="assignWinner">Assignar regal</v-btn>
                </v-card-actions>
            </v-card>
            <v-progress-circular v-else indeterminate color="primary"></v-progress-circular>
        </v-card-title>
    </v-card>
</template>


<script>
import interactsWithGravatar from '../mixins/interactsWithGravatar'
import EventBus from '../../eventBus'

export default {
  name: 'AndTheWinnerIs',
  mixins: [interactsWithGravatar],
  data () {
    return {
      tachan: false,
      winner: null,
      assigning: false
    }
  },
  props: {
    prizes: {
      type: Array,
      required: true
    },
    prize: {},
    result: {}
  },
  methods: {
    userName (user) {
      let name = ''
      if (user.sn1) name = user.sn1
      if (user.sn2) {
        if (name !== '') name = name + ' '
        name = name + user.sn2
      }
      if (name !== '') name = name + ', ' + user.givenName
      return name
    },
    assignWinner () {
      this.assigning = true
      console.log('this.prize:')
      console.log(this.prize)
      let multiple = parseInt(this.prize.multiple)
      console.log('multiple:')
      console.log(multiple)
      if (!this.prize || (multiple === 1)) {
        console.log('UMMMMMMMMMMMMMM!')
        this.$emit('assigned',multiple, this.prize)
        this.assigning = false
        return
      }
      console.log('this.result:')
      console.log(this.result)
      window.axios.post('/api/v1/winner/' + this.prize.id, {
        number: this.result.id
      }).then(() => {
        this.assigning = false
        this.$snackbar.showMessage('Regal assignat correctament')
        this.$emit('assigned',multiple, this.prize)
      }).catch(() => {
        this.assigning = false
      })
    }
  },
  created () {
    EventBus.$on('winner', (winner) => {
      console.log('WINNER RECEIVED: ')
      console.log(winner)
      this.winner = winner
    })
    EventBus.$on('tachan', (tachan) => {
      console.log('TACHAN RECEIVED: ')
      console.log(tachan)
      this.tachan = tachan
    })
  }
}
</script>
