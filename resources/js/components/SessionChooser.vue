<template>
    <v-flex xs8 offset-xs2 v-if="show">
        <v-toolbar color="primary darken-3 white--text" dense>
            <v-toolbar-title>Escolliu una sessió</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items>
                <v-btn icon class="white--text" @click="minimized = false" v-if="minimized">
                    <v-icon>add</v-icon>
                </v-btn>
                <v-btn v-else icon class="white--text" @click="minimized = true">
                    <v-icon>minimize</v-icon>
                </v-btn>
                <v-btn icon dark @click.native="show = false">
                    <v-icon>close</v-icon>
                </v-btn>
            </v-toolbar-items>
        </v-toolbar>
        <v-card v-if="!minimized">
            <v-card-text>
                <session-select v-model="dataSession"></session-select>
            </v-card-text>
        </v-card>
    </v-flex>
</template>

<script>
import SessionSelect from './SessionSelect'
export default {
  name: 'SessionChooser',
  components: {
    'session-select': SessionSelect
  },
  data () {
    return {
      minimized: false,
      show: true,
      dataSession: this.session
    }
  },
  props: {
    session: {
      Type: String,
      required: true
    }
  },
  model: {
    prop: 'session',
    event: 'input'
  },
  watch: {
    dataSession (dataSession) {
      this.$emit('input', dataSession)
    },
    session (session) {
      this.dataSession = session
    }
  }
}
</script>
