<template>
    <v-card>
        <v-toolbar style="background-color: #40764e;" class="white--text">
            <v-toolbar-title>Guanyadors</v-toolbar-title>
            <remove-all-winers @removedAll="removedAll"></remove-all-winers>
        </v-toolbar>
        <v-list three-line>
            <v-list-tile v-for="winer in internalWiners" :key="winer.id" avatar>
                <v-list-tile-action>
                    <v-chip :color="randomColor()" text-color="white" slot="activator">
                        {{ winer.number.value }}
                    </v-chip>
                </v-list-tile-action>
                <v-list-tile-content>
                    <v-list-tile-title>
                        <remove-winer-dialog @removed="removed" :winer="winer"></remove-winer-dialog>
                        {{ winer.number && winer.number.user && winer.number.user.name}}
                    </v-list-tile-title>
                    <v-list-tile-sub-title v-html="name(winer.number && winer.number.user && winer.number.user)"></v-list-tile-sub-title>
                    <v-list-tile-sub-title v-html="winer.name"></v-list-tile-sub-title>
                </v-list-tile-content>
                <v-list-tile-avatar>
                    <img :src="gravatarURL (winer.number && winer.number.user && winer.number.user.email)">
                </v-list-tile-avatar>
            </v-list-tile>
        </v-list>
    </v-card>
</template>

<script>
import RemoveAllWiners from './RemoveAllWiners'
import RemoveWinerDialog from './RemoveWinerDialog'
import interactsWithGravatar from './mixins/interactsWithGravatar'

export default {
  name: 'Winers.vue',
  mixins: [interactsWithGravatar],
  components: {
    'remove-all-winers': RemoveAllWiners,
    'remove-winer-dialog': RemoveWinerDialog
  },
  data () {
    return {
      internalWiners: this.winers
    }
  },
  props: {
    winers: {
      type: Array,
      required: true
    }
  },
  watch: {
    winers (winers) {
      this.internalWiners = winers
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
