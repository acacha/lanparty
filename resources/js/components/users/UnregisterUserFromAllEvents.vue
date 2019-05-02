<template>
    <span>
        <v-tooltip bottom>
            <v-btn slot="activator" icon @click="dialog = true" :disabled="selectedUser.events && selectedUser.events.length === 0">
                <v-icon color="red darken-2">remove_circle</v-icon>
            </v-btn>
            <span>Desregistra l'usuari de tots els esdeveniments als que està inscrit</span>
        </v-tooltip>

        <v-dialog v-model="dialog" persistent max-width="290">
            <v-card>
                <v-card-text>Esteu segurs que voleu desapuntar de tots els esdeveniments a l'usuari?</v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" flat @click.native="dialog = false">Cancel·lar</v-btn>
                    <v-btn v-if="!done" :loading="loading" :disabled="loading" color="error" @click.stop="unregisterAllEvents">Desapuntar</v-btn>
                    <v-btn v-else color="success" flat><v-icon>done</v-icon> Fet</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </span>
</template>

<script>
import sleep from '../../utils/sleep'
import * as actions from '../../store/action-types'
import { mapGetters } from 'vuex'

export default {
  name: 'UnregisterUserFromAllEvents',
  data () {
    return {
      loading: false,
      dialog: false,
      done: false
    }
  },
  computed: {
    ...mapGetters(['selectedUser'])
  },
  methods: {
    unregisterAllEvents () {
      this.loading = true
      this.$store.dispatch(actions.UNREGISTER_ALL_EVENTS, this.selectedUser).then(() => {
        this.done = true
        this.loading = false
        sleep(1000).then(() => { this.dialog = false; this.done = false })
      }).catch(() => {
        this.loading = false
      })
    }
  }
}
</script>
