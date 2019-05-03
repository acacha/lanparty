<template>
    <span>
        <v-btn icon slot="activator" @click="dialog = true">
                <v-icon color="teal">add_circle</v-icon>
            </v-btn>
        <v-dialog v-model="dialog" max-width="500px">
                <v-card>
                    <v-card-title class="primary darken-3 white--text">
                        <span>Assignar número</span>
                    </v-card-title>
                    <v-card-text>
                        <v-select
                                :items="descriptions"
                                v-model="description"
                                label="Escolliu un motiu"
                                class="input-group--focused"
                                item-value="text"
                        ></v-select>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn flat @click.stop="dialog=false">Tancar</v-btn>
                        <v-btn v-if="!assigned" :loading="loading" color="primary" @click.stop="assignNumber">Assignar</v-btn>
                        <v-btn v-else color="success" flat><v-icon>done</v-icon> Assignat</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
    </span>
</template>

<script>
import * as actions from '../../store/action-types'
import * as mutations from '../../store/mutation-types'
import { mapGetters } from 'vuex'
import sleep from '../../utils/sleep'

export default {
  name: 'AssignNumberToUser',
  data () {
    return {
      assigned: false,
      loading: false,
      dialog: false,
      description: '',
      descriptions: [
        { 'text': 'Assistència matí divendres' },
        { 'text': 'Assistència tarda divendres' },
        { 'text': 'Assistència matí dissabte' },
        { 'text': 'Assistència tarda dissabte' },
        { 'text': 'Altres' }
      ]
    }
  },
  props: {
    session: {
      type: String,
      required: true
    }
  },
  computed: {
    ...mapGetters(['selectedUser'])
  },
  methods: {
    assignNumber() {
      this.loading = true
      this.$store.dispatch(actions.ASSIGN_NUMBER_TO_USER, {
        user: this.selectedUser,
        session: this.session,
        description: this.description
      }).then(result => {
        this.assigned = true
        this.$store.commit(mutations.ADD_NUMBER_TO_SELECTED_USER_NUMBERS, result.data)
        this.loading = false
        sleep(1000).then(() => {
          this.dialog = false;
          this.assigned = false
        })
      }).catch(() => {
        this.loading = false
      })
    }
  }
}
</script>
