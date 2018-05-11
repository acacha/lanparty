<template>
    <v-container grid-list-md text-xs-center>
        <v-snackbar
                :timeout="6000"
                :color="snackbarColor"
                v-model="snackbar"
                :multi-line="true"
        >
            {{ snackbarText }}<br/>
            {{ snackbarSubtext }}
            <v-btn dark flat @click.native="snackbar = false">Tancar</v-btn>
        </v-snackbar>

        <v-alert v-model="error" type="error" dismissible>
            Especifiqueu el regal a sortejar!
        </v-alert>
        <v-layout row wrap>
            <v-flex xs9>
                <v-select
                        v-model="prize"
                        :items="internalPrizes"
                        label="Seleccioneu un regal o indiqueu un de nou"
                        item-value="name"
                        combobox
                        autocomplete
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
                </v-select>
            </v-flex>
            <v-flex xs3>
                Números sorteig: {{ total }}
                <v-btn @click="roll" :loading="rolling" :disabled="rolling">Sortejar</v-btn>
            </v-flex>
            <v-flex xs2>
                <v-card>
                    <v-toolbar color="blue" dark>
                        <v-toolbar-title>Guanyadors</v-toolbar-title>
                        <v-dialog v-model="removeAllWinnersDialog" persistent max-width="290">
                            <v-btn icon slot="activator">
                                <v-icon>delete</v-icon>
                            </v-btn>
                            <v-card>
                                <v-card-title class="headline">Si us plau confirmeu</v-card-title>
                                <v-card-text>
                                    Segur que voleu esborrar tots els premis assignats?
                                </v-card-text>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn color="green darken-1" flat @click.native="removeAllWinnersDialog = false">Cancel·lar</v-btn>
                                    <v-btn color="red darken-1" flat
                                           :disabled="removingAllWinners"
                                           :loading="removingAllWinners"
                                           @click.native="removeAllWinners">Eliminar tots</v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                    </v-toolbar>
                    <v-list three-line>
                        <template v-for="winner in internalWinners">
                            <v-list-tile :key="winner.id" avatar>
                                <v-list-tile-avatar>
                                    <img :src="gravatarURL (winner.number && winner.number.user && winner.number.user.email)">
                                </v-list-tile-avatar>
                                <v-list-tile-content>
                                    <v-list-tile-title>{{ winner.number.value }} {{ winner.number && winner.number.user && winner.number.user.name}}</v-list-tile-title>
                                    <v-list-tile-sub-title v-html="name(winner.number && winner.number.user && winner.number.user)"></v-list-tile-sub-title>
                                    <v-list-tile-sub-title v-html="winner.name"></v-list-tile-sub-title>
                                </v-list-tile-content>
                            </v-list-tile>
                        </template>
                    </v-list>
                </v-card>
            </v-flex>
            <v-flex xs10>
                <div id="odometer" style="border: 15px solid #40764e;" class="odometer">999</div>
            </v-flex>
            <v-flex xs12 v-if="tachan">
                <v-alert :value="true" type="info" dismissible>
                    <h1 class="display-2 mb-0">I el guanyador de {{ prize.name}} és ...</h1>
                </v-alert>
            </v-flex>
            <v-flex xs4 offset-xs4>
                <v-card v-if="winner">
                    <v-card-media :src="gravatarURL (winner.email)" height="250px">
                    </v-card-media>
                    <v-card-title primary-title>
                        <v-container grid-list-md text-xs-center>
                            <v-layout row wrap>
                                <v-flex xs9>
                                    <h3 class="headline mb-0">{{ userName(winner) }}</h3>
                                    <h1 class="subheading mb-0">{{ winner.name }}</h1>
                                </v-flex>
                                <v-flex xs3>
                                    <v-btn flat color="green" @click="addWinner">Assignar regal</v-btn>
                                </v-flex>
                            </v-layout>
                        </v-container>
                    </v-card-title>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<style>
    .odometer {
        font-size: 450px;
    }

    .odometer.odometer-animating-up .odometer-ribbon-inner, .odometer.odometer-animating-down.odometer-animating .odometer-ribbon-inner {
        -webkit-transition-duration: 1s !important;
        -moz-transition-duration: 1s !important;
        -ms-transition-duration: 1s !important;
        -o-transition-duration: 1s !important;
        transition-duration: 1s !important
    }
    [v-cloak] {display: none}

</style>

<script>
  import interactsWithGravatar from './mixins/interactsWithGravatar'
  import axios from 'axios'
  import withSnackbar from './mixins/withSnackbar'

  export default {
    mixins: [interactsWithGravatar, withSnackbar],
    data () {
      return {
        removingAllWinners: false,
        removeAllWinnersDialog: false,
        error: false,
        tachan: false,
        internalPrizes: this.prizes,
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
      addWinner () {
        this.internalWinners.push({
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
        let selectedPrize = this.internalPrizes.find((prize) => {
          return prize.name === this.prize
        })
        if (parseInt(selectedPrize.multiple) !== 1) {
          this.internalPrizes.splice(this.internalPrizes.indexOf(selectedPrize), 1)
        }
        this.prize = null
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
          }, 1500)
          window.setTimeout(this.setWinner, 2500)
          return
        }
        window.odometer.innerHTML = Math.floor(100 + Math.random() * 899) // returns a number between 100 and 999
        window.setTimeout(this.loop, this.timing)
      },
      setWinner () {
        this.rolling = false
        let number = this.findNumberByValue(this.result)
        this.winner = number.user
        window.Vue.nextTick(function () {
          window.scrollTo(0, document.body.scrollHeight)
        })
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
        this.duration = 1
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
      removeAllWinners () {
        this.removingAllWinners = true
        axios.delete('/api/v1/winners').then(response => {
          this.internalWinners = null
          this.removingAllWinners = false
          this.removeAllWinnersDialog = false
        }).catch(error => {
          console.log(error)
          this.showError(error)
          this.removingAllWinners = false
        })
      }
    },
    created () {
      // this.context = new AudioContext()
      // this.sound1 = 'https://s3-us-west-2.amazonaws.com/s.cdpn.io/123941/Yodel_Sound_Effect.mp3'
      /* window.fetch(this.sound1)
        .then(response => response.arrayBuffer())
        .then(arrayBuffer => this.context.decodeAudioData(arrayBuffer))
        .then(audioBuffer => {
          // TODO disable button
          // playButton.disabled = false
          this.sound1Buffer = audioBuffer
        })
      */
    }
  }
</script>
