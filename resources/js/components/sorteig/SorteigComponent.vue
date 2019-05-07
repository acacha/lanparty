<template>
    <v-container fluid grid-list-md text-xs-center>
        <v-alert v-model="error" type="error" dismissible>
            Especifiqueu el regal a sortejar!
        </v-alert>
        <v-layout row wrap>
            <v-flex xs1>
                <session-select v-model="session"></session-select>
            </v-flex>
            <v-flex xs6>
                <prizes :prize="prize" :prizes="prizes" :session="session"></prizes>
            </v-flex>
            <v-flex xs4>
                Números sorteig: {{ total }}
                <v-btn @click="roll" :loading="rolling" :disabled="rolling || session === null || prize === null">Sortejar</v-btn>
            </v-flex>
            <v-flex xs2>
                <and-the-winer-is></and-the-winer-is>
                <winers :winers="internalWiners" @removedAll="removedAll"></winers>
            </v-flex>
            <v-flex xs10>
                <div id="odometer" style="border: 15px solid #40764e;" class="odometer">666</div>
            </v-flex>
            <v-flex xs12 v-if="prize">
                <h1 class="display-3" v-html="prize"></h1>
                <h3 class="display-3" v-if="winer">{{ winer.name}}</h3>
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
  import interactsWithGravatar from '../mixins/interactsWithGravatar'
  import randomColor from '../mixins/randomColor'
  import SessionSelect from '../SessionSelect'
  import Winers from './Winers'
  import Prizes from '../prizes/Prizes'
  import AndTheWinerIs from './AndTheWinerIs'
  export default {
    mixins: [interactsWithGravatar, randomColor],
    components: {
      'session-select': SessionSelect,
      'winers': Winers,
      'prizes': Prizes,
      'and-the-winer-is': AndTheWinerIs
    },
    data () {
      return {
        session: '',
        refreshing: false,
        error: false,
        prize: null,
        winer: null,
        internalWiners: this.winers,
        result: null,
        value: 999,
        timing: 1,
        stop: false,
        stopTiming: false,
        rolling: false
      }
    },
    computed: {
      total () {
        return this.numbers.length
      },
      internalPrizesBySession () {
        return this.internalPrizes.filter(prize => prize.session === this.session)
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
      winers: {
        type: Array,
        required: true
      }
    },
    methods: {
      finishAddWiner (multiple, selectedPrize) {
        this.internalWiners.unshift({
          id: selectedPrize.id,
          name: this.prize,
          number: {
            value: this.result,
            user: {
              name: this.winer.name,
              givenName: this.winer.givenName,
              sn1: this.winer.sn1,
              sn2: this.winer.sn2,
              email: this.winer.email
            }
          }
        })
        EventBus.$emit('noWiner')
        EventBus.$emit('refreshPrizes')
        // TODO -> REFRESH PRIZES!
        // if (multiple !== 1) {
        //   this.internalPrizes.splice(this.internalPrizes.indexOf(selectedPrize), 1)
        // }
        this.prize = null
      },
      // TODO ELIMINAR!
      // name (winer) {
      //   let name = ''
      //   if (!winer) return name
      //   if (winer.sn1) name = name + winer.sn1
      //   if (winer.sn2) name = name + ' ' + winer.sn2
      //   if (winer.name) {
      //     if (name) {
      //       name = name + ', ' + winer.givenName
      //     } else {
      //       name = name + winer.givenName
      //     }
      //   }
      //   return name
      // },
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
      loop () {
        if (this.stop) {
          this.timing = 1
          this.stop = false
          this.result = Math.floor(1 + Math.random() * this.total)
          window.odometer.innerHTML = this.result
          window.setTimeout(() => {
            EventBus.$emit('tachan', true)
          }, 4500)
          window.setTimeout(this.setWiner, 8500)
          return
        }
        window.odometer.innerHTML = Math.floor(100 + Math.random() * 899) // returns a number between 100 and 999
        window.setTimeout(this.loop, this.timing)
      },
      setWiner () {
        this.rolling = false
        let number = this.findNumberByValue(this.result)
        // this.winer = number.user TODO ELIMINAR
        EventBus.$emit('winer',number.user)
      },
      findNumberByValue (value) {
        return this.numbers.find((number) => {
          return parseInt(number.value) === value
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
        if (!this.prize) {
          this.error = true
          return
        } else {
          this.error = false
        }
        if (this.rolling) return
        this.rolling = true
        this.winer = null
        this.duration = Math.floor(3000 + Math.random() * 9000)
        console.log('Rolling during ' + this.duration + ' ms...')
        this.loop()
        this.updateTiming()
        window.setTimeout(() => {
          console.log('Stopping rolling!')
          this.stop = true
        }, this.duration)
        window.setTimeout(() => {
          console.log('Stopping timing!')
          this.stopTiming = true
        }, this.duration - 10)
      },
      play (audioBuffer) {
        const source = this.context.createBufferSource()
        source.buffer = audioBuffer
        source.connect(this.context.destination)
        source.start()
      },
      removedAll () {
        this.internalWiners = null
        this.prize = null
        this.refreshPrizes()
      },
      removed () {
        this.internalWiners.splice(this.internalWiners.indexOf(winer), 1)
        this.refreshPrizes()
      },
      refreshPrizes () {
        this.refreshing = true
        window.axios.get('/api/v1/prizes').then(response => {
          this.internalPrizes = response.data
          this.refreshing = false
        }).catch(() => {
          this.refreshing = false
        })
      }
    },
    created () {
      this.session = window.lanparty.session
    }
  }
</script>
