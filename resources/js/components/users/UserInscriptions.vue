<template>
    <v-card>
        <v-card-title class="primary darken-3 white--text"><h4>Inscripcions</h4></v-card-title>
        <v-data-table
                :items="selectedUser.events"
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
            <v-btn icon slot="activator" @click="unregisterEventsDialog = true" :disabled="selectedUser.events && selectedUser.events.length === 0">
                <v-icon color="red darken-2">remove_circle</v-icon>
            </v-btn>
            <v-dialog v-model="unregisterEventsDialog" persistent max-width="290">
                <v-card>
                    <v-card-text>Esteu segurs que voleu desapuntar de tots els esdeveniments al usuari?</v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="primary" flat @click.native="unregisterEventsDialog = false">Cancel·lar</v-btn>
                        <v-btn v-if="!unregisterEventsDone" :loading="unregisteringEvents" color="error" @click.stop="unregisterAllEvents">Desapuntar</v-btn>
                        <v-btn v-else color="success" flat><v-icon>done</v-icon> Fet</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-card-actions>
    </v-card>
</template>

<script>
import { mapGetters } from 'vuex'
import * as actions from '../../store/action-types'
export default {
  name: 'UserInscriptions',
  data () {
    return {
      confirmingUnregisterEvent: null,
      eventToRegister: null,
      unregisteringEvent: false,
      unregisteringEvents: false,
      unregisterEventsDone: false,
      registerUserToEvent: false,
      eventRegistered: false,
      unregisterEventsDialog: false,
      registeringEvent: false
    }
  },
  props: {
    events: {
      type: Array,
      required: true
    }
  },
  computed: {
    ...mapGetters(['selectedUser']),
    individualInscriptionEvents () {
      return this.events.filter((event) => {
        return event.inscription_type_id === '2'
      })
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
    unregisterAllEvents () {
      this.unregisteringEvents = true
      this.$store.dispatch(actions.UNREGISTER_ALL_EVENTS, this.selectedUser).then(result => {
        this.unregisterEventsDone = true
        this.unregisteringEvents = false
        sleep(1000).then(() => { this.unregisterEventsDialog = false; this.unregisterEventsDone = false })
      }).catch(() => {
        this.unregisteringEvents = false
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
