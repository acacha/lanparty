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
                <v-autocomplete
                        v-model="prize"
                        :items="internalPrizes"
                        label="Seleccioneu un regal o indiqueu un de nou"
                        item-value="name"
                        item-text="name"
                        combobox
                        chips
                        clearable
                >
                    <template slot="selection" slot-scope="data">
                        <v-chip
                                :key="JSON.stringify(data.item)"
                                class="chip--select-multi"
                        >
                            {{ data.item }}
                        </v-chip>
                    </template>
                    <template slot="item" slot-scope="data">
                        <v-list-tile-content>
                            <v-list-tile-title v-html="data.item.name"></v-list-tile-title>
                            <v-list-tile-sub-title v-html="data.item.partner && data.item.partner.name"></v-list-tile-sub-title>
                        </v-list-tile-content>
                    </template>
                </v-autocomplete>
            </v-flex>
            <v-flex xs4>
                Regals: {{ internalPrizes.length }}
                <v-icon @click="refreshPrizes">refresh</v-icon>
                Números sorteig: {{ total }}
                <v-btn @click="roll" :loading="rolling" :disabled="rolling">Sortejar</v-btn>
            </v-flex>
            <v-flex xs2>
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
                                       :disabled="assigningWinning"
                                       :loading="assigningWinning"
                                       @click="addWinner">Assignar regal</v-btn>
                            </v-card-actions>
                        </v-card>
                        <v-progress-circular v-else indeterminate color="primary"></v-progress-circular>
                    </v-card-title>
                </v-card>
                <winers :winers="internalWiners" @removedAll="removedAll"></winers>
            </v-flex>
            <v-flex xs10>
                <div id="odometer" style="border: 15px solid #40764e;" class="odometer">666</div>
            </v-flex>
            <v-flex xs12 v-if="prize">
                <h1 class="display-3" v-html="prize"></h1>
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
  import interactsWithGravatar from './mixins/interactsWithGravatar'
  import axios from 'axios'
  import randomColor from './mixins/randomColor'
  import SessionSelect from './SessionSelect'
  import Winers from './Winers'
  export default {
    mixins: [interactsWithGravatar, randomColor],
    components: {
      'session-select': SessionSelect,
      'winers': Winers
    },
    data () {
      return {
        session: '',
        refreshing: false,
        assigningWinning: false,
        removingWinner: false,
        removeWinnerDialog: false,
        error: false,
        tachan: false,
        internalPrizes: this.prizes,
        prize: null,
        winner: null,
        internalWiners: this.winners,
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
      name (winner) {
        let name = ''
        if (!winner) return name
        if (winner.sn1) name = name + winner.sn1
        if (winner.sn2) name = name + ' ' + winner.sn2
        if (winner.name) {
          if (name) {
            name = name + ', ' + winner.givenName
          } else {
            name = name + winner.givenName
          }
        }
        return name
      },
      finishAddWinner (multiple, selectedPrize) {
        this.internalWiners.unshift({
          id: selectedPrize.id,
          name: this.prize,
          number: {
            value: this.result,
            user: {
              name: this.winner.name,
              givenName: this.winner.givenName,
              sn1: this.winner.sn1,
              sn2: this.winner.sn2,
              email: this.winner.email
            }
          }
        })
        this.winner = null
        this.tachan = false
        if (multiple !== 1) {
          this.internalPrizes.splice(this.internalPrizes.indexOf(selectedPrize), 1)
        }
        this.prize = null
      },
      addWinner () {
        this.assigningWinning = true
        let selectedPrize = this.internalPrizes.find((prize) => {
          return prize.name === this.prize
        })
        let multiple = parseInt(selectedPrize.multiple)
        if (!selectedPrize || (multiple === 1)) {
          this.finishAddWinner(multiple, selectedPrize)
          this.assigningWinning = false
          return
        }
        axios.post('/api/v1/winner/' + selectedPrize.id, {
          number: this.result
        }).then(() => {
          this.assigningWinning = false
          this.finishAddWinner(multiple, selectedPrize)
        }).catch(() => {
          this.assigningWinning = false
        })
      },
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
            this.tachan = true
          }, 4500)
          window.setTimeout(this.setWinner, 8500)
          return
        }
        window.odometer.innerHTML = Math.floor(100 + Math.random() * 899) // returns a number between 100 and 999
        window.setTimeout(this.loop, this.timing)
      },
      setWinner () {
        this.rolling = false
        let number = this.findNumberByValue(this.result)
        this.winner = number.user
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
        this.tachan = false
        if (!this.prize) {
          this.error = true
          return
        } else {
          this.error = false
        }
        if (this.rolling) return
        // TODO add sound
        // this.play(this.sound1Buffer)
        this.rolling = true
        this.winner = null
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
        this.internalWiners.splice(this.internalWiners.indexOf(winner), 1)
        this.refreshPrizes()
      },
      refreshPrizes () {
        this.refreshing = true
        axios.get('/api/v1/prizes').then(response => {
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
