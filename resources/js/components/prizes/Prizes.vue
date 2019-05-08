<template>
    <v-layout row wrap align-baseline>
        <v-flex xs10>
            <prizes-select :loading="refreshing" v-model="internalPrize" :prizes="internalPrizesBySession" ></prizes-select>
        </v-flex>
        <v-flex xs2>
            <v-icon @click="refreshPrizes">refresh</v-icon>
            Número de regals: {{ total }}
        </v-flex>
    </v-layout>
</template>

<script>
import EventBus from '../../eventBus'
import PrizesSelect from '../prizes/PrizesSelect'
export default {
  name: 'Prizes',
  components: {
    'prizes-select': PrizesSelect
  },
  data () {
    return {
      internalPrizes: this.prizes,
      internalPrize: this.prize,
      refreshing: false
    }
  },
  model: {
    prop: 'prize',
    event: 'input'
  },
  props: {
    session: {
      type: String,
      required: true
    },
    prizes: {
      type: Array,
      required: true
    },
    prize: {}
  },
  watch: {
    session() {
      this.internalPrize = null
    },
    internalPrize(internalPrize) {
      this.$emit('input', internalPrize)
    },
    prize(prize) {
      this.internalPrize = prize
    },
    prizes (prizes) {
      this.internalPrizes = prizes
    }
  },
  computed: {
    total() {
      return this.internalPrizesBySession.length
    },
    internalPrizesBySession () {
      return this.internalPrizes.filter(prize => prize.session === this.session)
    }
  },
  methods: {
    refreshPrizes (message = true) {
      this.refreshing = true
      window.axios.get('/api/v1/available_prizes').then(response => {
        if (message) this.$snackbar.showMessage('Premis actualitzats correctament')
        this.internalPrizes = response.data
        this.refreshing = false
      }).catch(() => {
        this.refreshing = false
      })
    }
  },
  created () {
    EventBus.$on('refreshPrizes', (message = true) => {
      this.refreshPrizes(message)
    })
  }
}
</script>
