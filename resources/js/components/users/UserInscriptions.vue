<template>
    <span>
        <v-card>
            <v-card-title class="primary darken-3 white--text"><h4>Inscripcions competicions individuals</h4></v-card-title>

            <v-data-table
                    :items="currentEvents"
                    hide-actions
                    hide-headers
                    class="elevation-1 mx-1 my-1"
            >
                <template slot="items" slot-scope="props">
                    <td>
                        <img width="40px;" :src="props.item.image">
                    </td>
                    <td>{{ props.item.name }}</td>
                    <td>{{ props.item.session }}</td>
                    <td>{{ props.item.inscription_date }}</td>
                    <td>
                        <template v-if="confirmingUnregisterEvent == props.item.id">
                            <v-icon right v-if="!unregisteringEvent" @click="cancelUnregisterEvent()" class="red--text darken-4--text">clear</v-icon>
                            <v-progress-circular v-if="unregisteringEvent" indeterminate color="primary"></v-progress-circular>
                            <v-icon right v-else @click="unregisterEvent(props.item)" class="green--text">done</v-icon>
                        </template>
                        <v-icon v-else right @click="confirmUnregisterEvent(props.item)" color="pink">delete</v-icon>
                    </td>
                </template>
                <template slot="no-data">
                    L'usuari no s'ha inscrit encara a cap event/competició
                </template>
            </v-data-table>

            <v-card-actions class="white">
                <v-spacer></v-spacer>
                <register-user-to-event :events="events"></register-user-to-event>
                <unregister-user-from-all-events></unregister-user-from-all-events>
            </v-card-actions>
        </v-card>
        <v-card class="mt-2">
            <v-card-title class="primary darken-3 white--text"><h4>Inscripcions competicions per grup</h4></v-card-title>

            <v-data-table
                    :items="currentGroupEvents"
                    hide-actions
                    hide-headers
                    class="elevation-1 mx-1 my-1"
            >
                <template slot="items" slot-scope="props">
                    <td>
                        <img width="40px;" :src="props.item.image">
                    </td>
                    <td>{{ props.item.name }}</td>
                    <td>{{ props.item.session }}</td>
                    <td>{{ props.item.inscription_date }}</td>
                </template>
                <template slot="no-data">
                    L'usuari no s'ha inscrit encara a cap event/competició
                </template>
            </v-data-table>
        </v-card>
    </span>
</template>

<script>
import { mapGetters } from 'vuex'
import * as actions from '../../store/action-types'
import UnregisterUserFromAllEvents from '../users/UnregisterUserFromAllEvents'
import RegisterUserToEvent from '../users/RegisterUserToEvent'
export default {
  name: 'UserInscriptions',
  components: {
    'unregister-user-from-all-events': UnregisterUserFromAllEvents,
    'register-user-to-event': RegisterUserToEvent
  },
  data () {
    return {
      confirmingUnregisterEvent: null,
      unregisteringEvent: false
    }
  },
  props: {
    events: {
      type: Array,
      required: true
    },
    session: {
      type: String,
      required: true
    }
  },
  computed: {
    ...mapGetters(['selectedUser']),
    currentEvents () {
      if (this.selectedUser.events) return this.selectedUser.events.filter(event => event.session === this.session)
      return this.selectedUser.events
    },
    currentGroupEvents() {
      if (this.selectedUser.group_events) return this.selectedUser.group_events.filter(event => event.session === this.session)
      return this.selectedUser.group_events
    }
  },
  methods: {
    cancelUnregisterEvent () {
      this.confirmingUnregisterEvent = null
    },
    confirmUnregisterEvent (event) {
      this.confirmingUnregisterEvent = event.id
    },
    unregisterEvent (event) {
      this.unregisteringEvent = true
      this.$store.dispatch(actions.UNREGISTER_USER_TO_EVENT, { user: this.selectedUser, event }).then(() => {
        this.unregisteringEvent = false
        this.confirmingUnregisterEvent = null
      }).catch(() => {
        this.unregisteringEvent = false
        this.confirmingUnregisterEvent = null
      })
    }
  }
}
</script>
