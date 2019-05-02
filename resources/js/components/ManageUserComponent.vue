<template>
    <div>
        <v-container fluid grid-list-md v-show="showSelectedUser">
            <v-layout row wrap>
                <v-flex xs12 md4>
                    <v-card flat class="elevation-5">
                        <v-card-title class="primary darken-3 white--text"><h4>User</h4></v-card-title>
                        <v-container fluid grid-list-md>
                            <v-layout row wrap>
                                <v-flex xs12 md4>
                                    <gravatar :user="selectedUser" size="100px"></gravatar>
                                </v-flex>
                                <v-flex xs12 md8 >
                                    <h3>{{ selectedUser.name }}</h3>
                                    <p class="text-xs-center">
                                        <payments-switch :session="session"></payments-switch>
                                    </p>
                                </v-flex>
                            </v-layout>
                        </v-container>
                        <v-card-text class="px-0">
                            <v-form class="pl-3 pr-1 ma-0">
                                <v-text-field readonly
                                              label="Id"
                                              :value="selectedUser.id"
                                              readonly
                                ></v-text-field>
                                <v-text-field readonly
                                              label="Email"
                                              :value="selectedUser.email"
                                              readonly
                                ></v-text-field>
                                <v-text-field readonly
                                              label="Nom usuari"
                                              :value="selectedUser.name"
                                              readonly
                                ></v-text-field>
                                <v-text-field readonly
                                              label="Nom"
                                              :value="selectedUser.givenName"
                                              readonly
                                ></v-text-field>
                                <v-text-field readonly
                                              label="1r cognom"
                                              :value="selectedUser.sn1"
                                              readonly
                                ></v-text-field>
                                <v-text-field readonly
                                              label="2n cognom"
                                              :value="selectedUser.sn2"
                                              readonly
                                ></v-text-field>
                                <v-text-field
                                        label="Data creació"
                                        :value="selectedUser.formatted_created_at_date"
                                        readonly
                                ></v-text-field>
                            </v-form>
                        </v-card-text>
<!--                        TODO-->
<!--                        <v-card-actions>-->
<!--                            <v-btn flat color="orange">Modificar</v-btn>-->
<!--                            <v-btn flat color="orange">Esborrar</v-btn>-->
<!--                        </v-card-actions>-->
                    </v-card>
                </v-flex>
                <v-flex xs12 md8>
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
                                    <template v-if="confirmingUnassigningNumber == props.item.id">
                                        <v-icon right v-if="!unassigningNumber" @click="cancelUnassignNumber()" class="red--text darken-4--text">clear</v-icon>
                                        <v-progress-circular v-if="unassigningNumber" indeterminate color="primary"></v-progress-circular>
                                        <v-icon right v-else @click="unassignNumber(props.item)" class="green--text">done</v-icon>
                                    </template>
                                    <v-icon v-else right @click="confirmUnassignNumber(props.item)" color="pink">delete</v-icon>
                                </td>
                            </template>
                            <template slot="no-data">
                                Sense números assignats
                            </template>
                        </v-data-table>

                        <v-card-actions class="white">
                            <v-spacer></v-spacer>
                            <v-btn icon slot="activator" @click="assignNumberDialog = true">
                                <v-icon color="teal">add_circle</v-icon>
                            </v-btn>
                            <v-dialog v-model="assignNumberDialog" max-width="500px">
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
                                        <v-btn color="primary" flat @click.stop="assignNumberDialog=false">Tancar</v-btn>
                                        <v-btn v-if="!numberAssigned" :loading="assigningNumber" color="primary" @click.stop="assignNumber">Assignar</v-btn>
                                        <v-btn v-else color="success" flat><v-icon>done</v-icon> Assignat</v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-dialog>
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
                                                        <img :src="'/' + data.item.image">
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
                </v-flex>
            </v-layout>

        </v-container>
    </div>
</template>

<style>

</style>

<script>
  import { mapGetters } from 'vuex'
  import _ from 'lodash'
  import interactsWithGravatar from './mixins/interactsWithGravatar'
  import Gravatar from './GravatarComponent.vue'
  import * as actions from '../store/action-types'
  import * as mutations from '../store/mutation-types'
  import sleep from '../utils/sleep'
  import randomColor from './mixins/randomColor'
  import PaymentsSwitch from './payments/PaymentsSwitch'
  export default {
    name: 'ManageUser',
    mixins: [ interactsWithGravatar, randomColor ],
    components: {
      Gravatar,
      'payments-switch': PaymentsSwitch
    },
    data () {
      return {
        description: '',
        eventToRegister: null,
        descriptions: [
          { 'text': 'Assistència matí divendres' },
          { 'text': 'Assistència tarda divendres' },
          { 'text': 'Assistència matí dissabte' },
          { 'text': 'Assistència tarda dissabte' },
          { 'text': 'Altres' }
        ],
        assigningNumber: false,
        numberAssigned: false,
        assignNumberDialog: false,
        unassignNumbersDialog: false,
        confirmingUnassigningNumber: null,
        unassigningNumbers: false,
        unassignNumbersDone: false,
        unassigningNumber: false,
        numberUnassigned: false,
        unassignNumberDialog: false,
        confirmingUnregisterEvent: null,
        unregisteringEvent: false,
        registeringEvent: false,
        eventRegistered: false,
        registerUserToEvent: false,
        unregisterEventsDialog: false,
        unregisterEventsDone: false,
        unregisteringEvents: false
      }
    },
    props: {
      session: {
        type: String,
        required: true
      },
      events: {
        type: Array,
        required: true
      }
    },
    computed: {
      inscriptionPaid () {
        if (this.selectedUser) if (this.selectedUser.inscription_paid) return this.selectedUser.inscription_paid.includes(this.session)
        return false
      },
      ...mapGetters(['selectedUser']),
      showSelectedUser () {
        return !_.isEmpty(this.selectedUser)
      },
      individualInscriptionEvents () {
        return this.events.filter((event) => {
          return event.inscription_type_id === '2'
        })
      }
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
      assignNumber () {
        this.assigningNumber = true
        this.$store.dispatch(actions.ASSIGN_NUMBER_TO_USER, { user: this.selectedUser, description: this.description }).then(result => {
          this.numberAssigned = true
          this.$store.commit(mutations.ADD_NUMBER_TO_SELECTED_USER_NUMBERS, result.data)
          this.assigningNumber = false
          sleep(1000).then(() => { this.assignNumberDialog = false; this.numberAssigned = false })
        }).catch(() => {
          this.assigningNumber = false
        })
      },
      unassignNumber (number) {
        this.unassigningNumber = true
        this.$store.dispatch(actions.UNASSIGN_NUMBER_TO_USER, number).then(result => {
          this.numberUnassigned = true
          this.$store.commit(mutations.REMOVE_NUMBER_TO_SELECTED_USER_NUMBERS, number)
          this.unassigningNumber = false
          sleep(1000).then(() => { this.unassignNumberDialog = false; this.numberUnassigned = true })
        }).catch(() => {
          this.unassigningNumber = false
          this.confirmingUnassigningNumber = null
        })
      },
      cancelUnassignNumber () {
        this.confirmingUnassigningNumber = null
      },
      confirmUnassignNumber (number) {
        this.confirmingUnassigningNumber = number.id
      },
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
