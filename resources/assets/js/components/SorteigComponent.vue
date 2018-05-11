<template>
    <v-container grid-list-md text-xs-center>
        <v-alert v-model="error" type="error" dismissible>
            Especifiqueu el regal a sortejar!
        </v-alert>
        <v-layout row wrap>
            <v-flex xs9>
                <v-text-field
                        v-model="gift"
                        label="Regal a sortejar"
                ></v-text-field>
            </v-flex>
            <v-flex xs3>
                Números sorteig: {{ total }}
                <v-btn @click="roll" :loading="rolling" :disabled="rolling">Sortejar</v-btn>
            </v-flex>
            <v-flex xs2>
                <v-card>
                    <v-toolbar color="cyan" dark>
                        <v-toolbar-title>Guanyadors</v-toolbar-title>
                    </v-toolbar>
                    <v-list two-line>
                        <template v-for="winner in winners">
                            <v-list-tile :key="winner.id" avatar>
                                <v-list-tile-avatar>
                                    <img :src="gravatarURL (winner.email)">
                                </v-list-tile-avatar>
                                <v-list-tile-content>
                                    <v-list-tile-title v-html="winner.name"></v-list-tile-title>
                                    <v-list-tile-sub-title v-html="winner.gift"></v-list-tile-sub-title>
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
                    <h1 class="display-2 mb-0">I el guanyador de {{ gift}} és ...</h1>
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

  export default {
    mixins: [interactsWithGravatar],
    data () {
      return {
        error: false,
        tachan: false,
        gift: '',
        winner: null,
        winners: [],
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
      }
    },
    methods: {
      addWinner () {
        this.winner.gift = this.gift
        this.winners.push(this.winner)
        this.winner = null
        this.tachan = false
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
        console.log('Set winner!')
        console.log('result: ' + this.result)
        let number = this.findNumberByValue(this.result)
        console.log('number: ' + number)
        console.log('user id: ' + number.user.id)
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
        if (!this.gift) {
          this.error = true
          return
        } else {
          this.error = false
        }
        if (this.rolling) return
        this.play(this.sound1Buffer)
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
      }
    },
    created () {
      this.context = new AudioContext()
      this.sound1 = 'https://s3-us-west-2.amazonaws.com/s.cdpn.io/123941/Yodel_Sound_Effect.mp3'
      window.fetch(this.sound1)
        .then(response => response.arrayBuffer())
        .then(arrayBuffer => this.context.decodeAudioData(arrayBuffer))
        .then(audioBuffer => {
          // TODO disable button
          // playButton.disabled = false
          this.sound1Buffer = audioBuffer
        })
    }
  }
</script>
