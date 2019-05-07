<template>
    <v-layout row wrap>
        <v-flex xs10>
            <prizes-select v-model="prize" ></prizes-select>
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
      internalPrizes: this.prizes
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
    prize(prize) {
      this.$emit('input', prize)
    },
    prizes (prizes) {
      this.internalPrizes = prizes
    }
  },
  computed: {
    internalPrizesBySession () {
      return this.internalPrizes.filter(prize => prize.session === this.session)
    }
  }
}
</script>
