<template>
    <v-card>
        <v-toolbar style="background-color: #40764e;" class="white--text">
            <v-toolbar-title>Guanyadors</v-toolbar-title>
            <remove-all-winners @removedAll="removedAll"></remove-all-winners>
        </v-toolbar>
        <v-list three-line>
            <v-list-tile v-for="winner in internalWinners" :key="winner.id" avatar>
                <v-list-tile-action>
                    <v-chip :color="randomColor()" text-color="white" slot="activator">
                        {{ winner.number.value }}
                    </v-chip>
                </v-list-tile-action>
                <v-list-tile-content>
                    <v-list-tile-title>
                        <remove-winner-dialog @removed="removed" :winner="winner"></remove-winner-dialog>
                        {{ winner.number && winner.number.user && winner.number.user.name}}
                    </v-list-tile-title>
                    <v-list-tile-sub-title v-html="name(winner.number && winner.number.user && winner.number.user)"></v-list-tile-sub-title>
                    <v-list-tile-sub-title v-html="winner.name"></v-list-tile-sub-title>
                </v-list-tile-content>
                <v-list-tile-avatar>
                    <img :src="gravatarURL (winner.number && winner.number.user && winner.number.user.email)">
                </v-list-tile-avatar>
            </v-list-tile>
        </v-list>
    </v-card>
</template>

<script>
import RemoveAllWinners from './RemoveAllWinners'
import RemoveWinnerDialog from './RemoveWinnerDialog'
import interactsWithGravatar from '../mixins/interactsWithGravatar'

export default {
  name: 'Winners.vue',
  mixins: [interactsWithGravatar],
  components: {
    'remove-all-winners': RemoveAllWinners,
    'remove-winner-dialog': RemoveWinnerDialog
  },
  data () {
    return {
      internalWinners: this.winners
    }
  },
  props: {
    winners: {
      type: Array,
      required: true
    }
  },
  watch: {
    winners (winners) {
      this.internalWinners = winners
    }
  },
  methods: {
    removedAll () {
      this.$emit('removedAll')
    },
    removed () {
      this.$emit('removed')
    }
  },
}
</script>
