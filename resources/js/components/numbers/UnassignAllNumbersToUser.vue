<template>
    <span>
        <v-btn icon slot="activator" @click="dialog = true" :disabled="selectedUser.numbers && selectedUser.numbers.length === 0">
            <v-icon color="red darken-2">remove_circle</v-icon>
        </v-btn>
        <v-dialog v-model="dialog" persistent max-width="290">
            <v-card>
                <v-card-text>Esteu segurs que voleu desassignar tots els números al usuari?</v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" flat @click.native="dialog = false">Cancel·lar</v-btn>
                    <v-btn v-if="!done" :loading="loading" :disabled="loading" color="error" @click.stop="unassignAllNumbers">Dessasignar</v-btn>
                    <v-btn v-else color="success" flat><v-icon>done</v-icon> Fet</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </span>
</template>

<script>
import { mapGetters } from 'vuex'
import sleep from '../../utils/sleep'
import * as actions from '../../store/action-types'
import * as mutations from '../../store/mutation-types'

export default {
  name: 'UnassignAllNumbersToUser',
  data () {
    return {
      dialog: false,
      loading: false,
      done: false
    }
  },
  computed: {
    ...mapGetters(['selectedUser'])
  },
  methods: {
    unassignAllNumbers () {
      this.loading = true
      this.$store.dispatch(actions.UNASSIGN_NUMBERS_TO_USER, this.selectedUser).then(() => {
        this.done = true
        this.$store.commit(mutations.SET_SELECTED_USER_NUMBERS, [])
        this.loading = false
        sleep(1000).then(() => {
          this.dialog = false; this.done = false
        })
      }).catch(() => {
        this.loading = false
      })
    }
  }
}
</script>
