<template>
    <v-card>
        <v-card-title class="primary darken-3 white--text"><h4>Inscripcions</h4></v-card-title>
        <v-alert
                dismissible
                :value="true"
                type="warning"
        >
            Atenció: Només es mostren les inscripcions de l'usuari a esdeveniments individuals!.
        </v-alert>
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
            <v-btn icon slot="activator" @click="registerUserToEvent = true">
                <v-icon color="teal">add_circle</v-icon>
            </v-btn>
            <v-dialog v-model="registerUserToEvent" max-width="750px">
                <v-card>
                    <v-card-title class="primary darken-3 white--text">
                        <span>Inscriure a un esdeveniment</span>
                    </v-card-title>
                    <v-card-text>
                        <v-select
                                :items="individualInscriptionEvents"
                                v-model="eventToRegister"
                                label="Escolliu un esdeveniment"
                                clearable
                        >
                            <template slot="selection" slot-scope="data">
                                <v-chip class="chip--select">
                                    {{ data.item.name }}
                                </v-chip>
                            </template>
                            <template slot="item" slot-scope="data">
                                <v-list-tile avatar>
                                    <v-list-tile-avatar>
                                        <img :src="data.item.image">
                                    </v-list-tile-avatar>
                                    <v-list-tile-content>
                                        {{ data.item.name }} ( Places: {{ data.item.available_tickets }})
                                    </v-list-tile-content>
                                </v-list-tile>
                            </template>
                        </v-select>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn color="primary" flat @click.stop="registerUserToEvent=false">Tancar</v-btn>
                        <v-btn v-if="!eventRegistered" :loading="registeringEvent" color="primary" @click.stop="registerEvent" :disabled="eventToRegister === null">Inscriure</v-btn>
                        <v-btn v-else color="success" flat><v-icon>done</v-icon> Inscrit</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>

            <unregister-user-from-all-events></unregister-user-from-all-events>
        </v-card-actions>
    </v-card>
</template>

<script>
import { mapGetters } from 'vuex'
import * as actions from '../../store/action-types'
import UnregisterUserFromAllEvents from '../users/UnregisterUserFromAllEvents'
export default {
  name: 'UserInscriptions',
  components: {
    'unregister-user-from-all-events': UnregisterUserFromAllEvents
  },
  data () {
    return {
      confirmingUnregisterEvent: null,
      eventToRegister: null,
      unregisteringEvent: false,
      registerUserToEvent: false,
      eventRegistered: false,
      registeringEvent: false
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
    individualInscriptionEvents () {
      return this.events.filter((event) => {
        return event.inscription_type_id === '2'
      })
    },
    currentEvents () {
      if (this.selectedUser.events) return this.selectedUser.events.filter(event => event.session === this.session)
      return this.selectedUser.events
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
    },
    registerEvent () {
      this.registeringEvent = true
      this.$store.dispatch(actions.REGISTER_USER_TO_EVENT, { user: this.selectedUser, event: this.eventToRegister }).then((response) => {
        this.eventRegistered = true
        this.registeringEvent = false
        sleep(1000).then(() => { this.registerUserToEvent = false; this.eventRegistered = false })
      }).catch(() => {
        this.registeringEvent = false
      })
    }
  }
}
</script>
