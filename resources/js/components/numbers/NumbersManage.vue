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
                    <unassign-number-to-user :number="props.item"></unassign-number-to-user>
                </td>
            </template>
            <template slot="no-data">
                Sense números assignats
            </template>
        </v-data-table>

        <v-card-actions class="white">
            <v-spacer></v-spacer>
            <assign-number-to-user :session="session"></assign-number-to-user>
            <unassign-all-numbers-to-user :session="session"></unassign-all-numbers-to-user>
        </v-card-actions>
    </v-card>
</template>

<script>
import { mapGetters } from 'vuex'
import randomColor from '../mixins/randomColor'
import AssignNumberToUser from './AssignNumberToUser'
import UnAssignNumberToUser from './UnAssignNumberToUser'
import UnassignAllNumbersToUser from './UnassignAllNumbersToUser'

export default {
  name: 'NumbersManage',
  components: {
    'assign-number-to-user': AssignNumberToUser,
    'unassign-number-to-user': UnAssignNumberToUser,
    'unassign-all-numbers-to-user': UnassignAllNumbersToUser
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
  }
}
</script>
