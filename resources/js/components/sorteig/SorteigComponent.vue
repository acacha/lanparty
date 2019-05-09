<template>
    <v-container fluid grid-list-md text-xs-center>
        <v-alert :value="numbersForCurrentSession.length === 0" type="error" dismissible>
            <span class="title">No hi ha números per sortejar! Primer cal assignar
                <a href="/manage/participants" target="_blank">números als usuaris</a></span>
        </v-alert>
        <v-layout row wrap align-baseline>
            <v-flex xs1>
                <session-select v-model="session" :chips="true"></session-select>
            </v-flex>
            <v-flex xs9>
                <prizes :prizes="prizes" :session="session" v-model="prize"></prizes>
            </v-flex>
            <v-flex xs2>
                Total números a sortejar: {{ total }}
                <v-btn @click="roll" :loading="rolling" :disabled="rolling || session === null || !prize || numbers.length === 0">Sortejar</v-btn>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs2>
                <and-the-winner-is :prizes="prizes" :prize="prize" :result="result" @assigned="finishAddWinner"></and-the-winner-is>
                <winners :winners="internalWinners" @removedAll="removedAll" :session="session"></winners>
            </v-flex>
            <v-flex xs10>
                <div id="odometer" style="border: 15px solid #40764e;" class="odometer">666</div>
            </v-flex>
            <v-flex xs12 v-if="prize">
                <h1 class="display-3">{{ prize.name }}</h1>
                <h3 class="display-3" v-if="prize.value">{{ price }}</h3>
                <h3 class="display-3" v-if="winner">{{ winner.name}}</h3>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<style>
    .odometer {
        font-size: 450px;
    }

    .odometer.odometer-animating-up .odometer-ribbon-inner, .odometer.odometer-animating-down.odometer-animating .odometer-ribbon-inner {
        -webkit-transition-duration: 8s !important;
        -moz-transition-duration: 8s !important;
        -ms-transition-duration: 8s !important;
        -o-transition-duration: 8s !important;
        transition-duration: 8s !important
    }
    [v-cloak] {display: none}

</style>

<script>
  import SessionSelect from '../SessionSelect'
  import Winners from './Winners'
  import Prizes from '../prizes/Prizes'
  import AndTheWinnerIs from './AndTheWinnerIs'
  import EventBus from '../../eventBus'
  import helpers from '../../utils/helpers'

  export default {
    components: {
      'session-select': SessionSelect,
      'winners': Winners,
      'prizes': Prizes,
      'and-the-winner-is': AndTheWinnerIs
    },
    data () {
      return {
        session: '',
        error: false,
        prize: null,
        winner: null,
        internalWinners: this.winners,
        result: null,
        value: 999,
        timing: 1,
        stop: false,
        stopTiming: false,
        rolling: false
      }
    },
    computed: {
      price() {
        return helpers.priceInEuros(this.prize.value)
      },
      total () {
        return this.numbersForCurrentSession.length
      },
      numbersForCurrentSession() {
        return this.numbers.filter(number => number.session === this.session)
      }
    },
    props: {
      numbers: {
        type: Array,
        required: true
      },
      prizes: {
        type: Array,
        required: true
      },
      winners: {
        type: Array,
        required: true
      }
    },
    methods: {
      loop () {
        if (this.stop) {
          this.timing = 1
          this.stop = false
          let resultNumber = Math.floor(1 + Math.random() * this.total)
          this.result = this.findNumberByValue(resultNumber)
          window.odometer.innerHTML = this.result.value
          window.setTimeout(() => {
            EventBus.$emit('tachan', true)
            EventBus.$emit('winner', null)
          }, 4500)
          window.setTimeout(this.setWinner, 8500)
          return
        }
        window.odometer.innerHTML = Math.floor(100 + Math.random() * 899) // returns a number between 100 and 999
        window.setTimeout(this.loop, this.timing)
      },
      setWinner () {
        this.rolling = false
        this.winner = this.result.user
        EventBus.$emit('winner', this.result.user)
      },
      findNumberByValue (value) {
        return this.numbers.find((number) => {
          return parseInt(number.value) === value && number.session === this.session
        })
      },
      updateTiming () {
        if (this.stopTiming) {
          this.stopTiming = false
          return
        }
        this.timing = this.timing + 0.074
        window.setTimeout(this.updateTiming, Math.floor())
      },
      roll () {
        EventBus.$emit('tachan', false)
        if (this.rolling) return
        this.rolling = true
        this.winner = null
        this.duration = Math.floor(3000 + Math.random() * 9000)
        this.loop()
        this.updateTiming()
        window.setTimeout(() => {
          this.stop = true
        }, this.duration)
        window.setTimeout(() => {
          this.stopTiming = true
        }, this.duration - 10)
      },
      removedAll () {
        this.internalWinners = null
        this.prize = null
        EventBus.$emit('refreshPrizes',false)
      },
      removed () {
        this.internalWinners.splice(this.internalWinners.indexOf(this.winner), 1)
        EventBus.$emit('refreshPrizes',false)
      },
      finishAddWinner (multiple, selectedPrize) {
        EventBus.$emit('winner',null)
        EventBus.$emit('tachan',false)
        if (this.internalWinners) {
          this.internalWinners.unshift({
            id: selectedPrize.id,
            name: this.prize.name,
            number: {
              value: this.result.value,
              user: {
                name: this.winner.name,
                givenName: this.winner.givenName,
                sn1: this.winner.sn1,
                sn2: this.winner.sn2,
                email: this.winner.email
              }
            }
          })
        }
        EventBus.$emit('refreshPrizes',false)
        // TODO -> REFRESH PRIZES no cal seguents linies ESBORRAR:
        // if (multiple !== 1) {
        //   this.internalPrizes.splice(this.internalPrizes.indexOf(selectedPrize), 1)
        // }
        this.prize = null
      }
    },
    created () {
      this.session = window.lanparty.session
    }
  }
</script>
