<template>
    <div>
        <v-snackbar
                timeout="6000"
                :color="snackbarColor"
                v-model="snackbar"
                :vertical="true"
        >
            {{ snackbarText }}
            <v-btn dark flat @click.native="snackbar = false">Close</v-btn>
        </v-snackbar>
        <v-container fluid grid-list-md class="grey lighten-4" v-show="showSelectedUser">
            <v-layout row wrap>
                <v-flex xs12 md4>
                    <v-card flat>
                        <v-card-title class="blue darken-3 white--text"><h4>User</h4></v-card-title>
                        <v-container fluid grid-list-md class="grey lighten-4" v-show="show">
                            <v-layout row wrap>
                                <v-flex xs12 md4>
                                    <gravatar :user="selectedUser" size="100px"></gravatar>
                                </v-flex>
                                <v-flex xs12 md8>
                                    <h3>{{ selectedUser.name }}</h3>
                                    <v-switch label="Pagat" v-model="payed"></v-switch>
                                </v-flex>
                            </v-layout>
                        </v-container>
                        <v-card-text class="px-0 grey lighten-3">
                            <v-form class="pl-3 pr-1 ma-0">
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
                        <v-card-actions>
                            <v-btn flat color="orange">Modificar</v-btn>
                            <v-btn flat color="orange">Esborrar</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-flex>
                <v-flex xs12 md8>
                    <v-card class="mb-2">
                        <v-card-title class="blue darken-3 white--text"><h4>Numbers</h4></v-card-title>
                        <v-list v-if="selectedUser.numbers.length >0">
                            <v-list-tile v-for="number in selectedUser.numbers" v-bind:key="number.value" @click="">
                                <v-list-tile-content>
                                    <v-chip color="orange" text-color="white" >
                                        {{ number.value }}
                                        <v-icon right>star</v-icon>
                                    </v-chip>
                                </v-list-tile-content>
                                <v-list-tile-content>
                                    <v-list-tile-title> {{ number.description }} </v-list-tile-title>
                                </v-list-tile-content>
                                <v-list-tile-content>
                                    <v-list-tile-title> {{ number.created_at }}</v-list-tile-title>
                                </v-list-tile-content>
                                <v-list-tile-action>
                                    <v-icon right @click="unassignNumber(number)">delete</v-icon>
                                </v-list-tile-action>
                            </v-list-tile>
                        </v-list>
                        <p v-else class="pt-2">
                            Sense números assignats
                        </p>
                        <v-card-actions class="white">
                            <v-spacer></v-spacer>
                            <v-btn icon slot="activator" @click="assignNumberDialog = true">
                                <v-icon>add_circle</v-icon>
                            </v-btn>
                            <v-dialog v-model="assignNumberDialog" max-width="500px">
                                <v-card>
                                    <v-card-title class="blue darken-3 white--text">
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
                                        <v-btn v-if="!numberAssigned" :loading="assigningNumber" color="primary" flat @click.stop="assignNumber">Assignar</v-btn>
                                        <v-btn v-else color="success" flat><v-icon>done</v-icon> Assignat</v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-dialog>
                            <v-btn icon slot="activator" @click="unassignNumbersDialog = true">
                                <v-icon>remove_circle</v-icon>
                            </v-btn>
                            <v-dialog v-model="unassignNumbersDialog" persistent max-width="290">
                                <v-card>
                                    <v-card-text>Esteu segurs que voleu desassignar tots els números al usuari?</v-card-text>
                                    <v-card-actions>
                                        <v-spacer></v-spacer>
                                        <v-btn color="green darken-1" flat @click.native="unassignNumbersDialog = false">Cancel·lar</v-btn>
                                        <v-btn v-if="!unassignNumbersDone" :loading="unassigningNumbers" color="primary" flat @click.stop="unassignAllNumbers">Endavant!</v-btn>
                                        <v-btn v-else color="success" flat><v-icon>done</v-icon> Fet</v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-dialog>
                        </v-card-actions>
                    </v-card>
                    <v-card>
                        <v-card-title class="blue darken-3 white--text"><h4>Inscripcions</h4></v-card-title>
                        <v-list>
                            <v-list-tile avatar v-for="number in selectedUser.numbers" v-bind:key="number.value" @click="">
                                <v-list-tile-avatar>
                                    <img src="/img/CounterStrike.png">
                                </v-list-tile-avatar>
                                <v-list-tile-content>
                                    <v-list-tile-title> Counter Strike </v-list-tile-title>
                                </v-list-tile-content>
                                <v-list-tile-content>
                                    <v-list-tile-title> Data inscripció</v-list-tile-title>
                                </v-list-tile-content>
                                <v-list-tile-action>
                                    <v-icon right>delete</v-icon>
                                </v-list-tile-action>
                            </v-list-tile>
                        </v-list>
                        <v-card-actions class="white">
                            <v-spacer></v-spacer>
                            <v-btn icon>
                                <v-icon>add_circle</v-icon>
                            </v-btn>
                            <v-btn icon>
                                <v-icon>remove_circle</v-icon>
                            </v-btn>
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
  import withSnackbar from './mixins/withSnackbar'
  import Gravatar from './GravatarComponent.vue'
  import * as actions from '../store/action-types'
  import * as mutations from '../store/mutation-types'
  import sleep from '../utils/sleep'

  export default {
    name: 'ManageUser',
    mixins: [ interactsWithGravatar, withSnackbar ],
    components: { Gravatar },
    data () {
      return {
        description: '',
        descriptions: [
          { 'text': 'Assistència matí divendres' },
          { 'text': 'Assistència tarda divendres' },
          { 'text': 'Assistència matí dissabte' },
          { 'text': 'Assistència tarda dissabte' },
          { 'text': 'Altres' }
        ],
        assigningNumber: false,
        numberAssigned: false,
        payed: 'false',
        assignNumberDialog: false,
        unassignNumbersDialog: false,
        unassigningNumbers: false,
        unassignNumbersDone: false,
        unassigningNumber: false,
        numberUnassigned: false,
        unassignNumberDialog: false
      }
    },
    computed: {
      ...mapGetters(['selectedUser']),
      showSelectedUser () {
        return !_.isEmpty(this.selectedUser)
      }
    },
    methods: {
      unassignAllNumbers () {
        this.unassigningNumbers = true
        this.$store.dispatch(actions.UNASSIGN_NUMBERS_TO_USER, this.selectedUser).then(result => {
          this.unassignNumbersDone = true
          this.$store.commit(mutations.SET_SELECTED_USER_NUMBERS, [])
          sleep(1000).then(() => { this.unassignNumbersDialog = false; this.unassignNumbersDone = true })
        }).catch(error => {
          console.dir(error)
          this.showError(error.message)
        }).then(() => {
          this.unassigningNumbers = false
        })
      },
      assignNumber () {
        this.assigningNumber = true
        this.$store.dispatch(actions.ASSIGN_NUMBER_TO_USER, { user: this.selectedUser, description: this.description }).then(result => {
          this.numberAssigned = true
          this.$store.commit(mutations.ADD_NUMBER_TO_SELECTED_USER_NUMBERS, result.data)
          sleep(1000).then(() => { this.assignNumberDialog = false; this.numberAssigned = false })
        }).catch(error => {
          console.dir(error)
          this.showError(error.message)
        }).then(() => {
          this.assigningNumber = false
        })
      },
      unassignNumber (number) {
        console.log('unassignNumber!!!!')
        console.log(number)
        this.unassigningNumber = true
        this.$store.dispatch(actions.UNASSIGN_NUMBER_TO_USER, number).then(result => {
          this.numberUnassigned = true
          this.$store.commit(mutations.REMOVE_NUMBER_TO_SELECTED_USER_NUMBERS, number)
          sleep(1000).then(() => { this.unassignNumberDialog = false; this.numberUnassigned = true })
        }).catch(error => {
          console.dir(error)
          this.showError(error.message)
        }).then(() => {
          this.unassigningNumber = false
        })
      }
    }
  }
</script>
