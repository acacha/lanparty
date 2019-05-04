<template>
    <v-card class="mb-2">
        <v-card-title class="primary darken-3 white--text"><h4>Números</h4></v-card-title>

        <v-data-table
                :items="selectedUser.numbers"
                hide-actions
                hide-headers
                class="elevation-1 mx-1 my-1"
        >
            <template slot="items" slot-scope="props">
                <td>
                    <v-chip :color="randomColor()" text-color="white" >
                        {{ props.item.value }}
                        <v-icon right>star</v-icon>
                    </v-chip>
                </td>
                <td>{{ props.item.description }}</td>
                <td>{{ props.item.created_at }}</td>
                <td>
                    <unassign-number-to-user :session="session" :number="props.item"></unassign-number-to-user>
                </td>
            </template>
            <template slot="no-data">
                Sense números assignats
            </template>
        </v-data-table>

        <v-card-actions class="white">
            <v-spacer></v-spacer>
            <assign-number-to-user :session="session"></assign-number-to-user>
            <v-btn icon slot="activator" @click="unassignNumbersDialog = true" :disabled="selectedUser.numbers && selectedUser.numbers.length === 0">
                <v-icon color="red darken-2">remove_circle</v-icon>
            </v-btn>
            <v-dialog v-model="unassignNumbersDialog" persistent max-width="290">
                <v-card>
                    <v-card-text>Esteu segurs que voleu desassignar tots els números al usuari?</v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="primary" flat @click.native="unassignNumbersDialog = false">Cancel·lar</v-btn>
                        <v-btn v-if="!unassignNumbersDone" :loading="unassigningNumbers" color="error" @click.stop="unassignAllNumbers">Dessasignar</v-btn>
                        <v-btn v-else color="success" flat><v-icon>done</v-icon> Fet</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-card-actions>
    </v-card>
</template>

<script>
import { mapGetters } from 'vuex'
import randomColor from '../mixins/randomColor'
import AssignNumberToUser from './AssignNumberToUser'
import UnAssignNumberToUser from './UnAssignNumberToUser'

export default {
  name: 'NumbersManage',
  components: {
    'assign-number-to-user': AssignNumberToUser,
    'unassign-number-to-user': UnAssignNumberToUser
  },
  data () {
    return {
      assigningNumber: false,
      numberAssigned: false,
      assignNumberDialog: false,
      unassignNumbersDialog: false,
      confirmingUnassigningNumber: null,
      unassigningNumbers: false,
      unassignNumbersDone: false,
      unassigningNumber: false,
      unassignNumberDialog: false
    }
  },
  mixins: [ randomColor ],
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
    unassignAllNumbers () {
      this.unassigningNumbers = true
      this.$store.dispatch(actions.UNASSIGN_NUMBERS_TO_USER, this.selectedUser).then(result => {
        this.unassignNumbersDone = true
        this.$store.commit(mutations.SET_SELECTED_USER_NUMBERS, [])
        this.unassigningNumbers = false
        sleep(1000).then(() => { this.unassignNumbersDialog = false; this.unassignNumbersDone = false })
      }).catch(() => {
        this.unassigningNumbers = false
      })
    }
  }
}
</script>
