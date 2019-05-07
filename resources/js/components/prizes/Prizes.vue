<template>
    <v-layout row wrap>
        <v-flex xs10>
            <prizes-select v-model="internalPrize" :prizes="internalPrizesBySession" ></prizes-select>
        </v-flex>
        <v-flex xs2>
            <v-icon @click="refreshPrizes">refresh</v-icon>
            Regals: {{ internalPrizesBySession.length }}
        </v-flex>
    </v-layout>
</template>

<script>
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
    internalPrizesBySession () {
      return this.internalPrizes.filter(prize => prize.session === this.session)
    }
  },
  methods: {
    refreshPrizes () {
      this.refreshing = true
      window.axios.get('/api/v1/prizes').then(response => {
        this.internalPrizes = response.data
        this.refreshing = false
      }).catch(() => {
        this.refreshing = false
      })
    }
  }
}
</script>
