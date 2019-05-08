<template>
    <v-container fluid grid-list-md text-xs-center>
        <v-layout row wrap>
            <session-chooser v-model="session"></session-chooser>
        </v-layout>
        <v-layout row wrap v-if="session">
            <v-flex xs12 v-if="status">
                <v-alert type="success" :value="true">
                    {{ status }}
                </v-alert>
            </v-flex>
            <v-flex xs12>
                <v-card>
                    <v-card-title class="primary darken-3 white--text">
                        <h3>Usuaris</h3>
                    </v-card-title>
                    <v-card-text class="px-0 mb-2">
                        <users-search :users="users" :tickets="tickets" :session="session"></users-search>
                        <manage-user :events="events" :session="session"></manage-user>
                    </v-card-text>
                </v-card>
            </v-flex>
            <v-flex xs12>
                <v-card>
                    <v-card-title class="primary darken-3 white--text">
                        <h3>Números del sorteig</h3>
                    </v-card-title>
                    <v-card-text class="px-0 mb-2">
                        <numbers-search :numbers="numbers" :session="session"></numbers-search>
                    </v-card-text>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
import UsersSearch from '../UsersSearchComponent.vue'
import NumbersSearch from '../NumbersSearchComponent.vue'
import ManageUser from '../ManageUserComponent.vue'
import SessionChooser from '../SessionChooser.vue'

export default {
  name: 'ParticipantsManage',
  components: {
    'users-search': UsersSearch,
    'numbers-search': NumbersSearch,
    'manage-user': ManageUser,
    'session-chooser': SessionChooser
  },
  data () {
    return {
      show: true,
      session: ''
    }
  },
  props: {
    events: {
      type: Array,
      required: true
    },
    users: {
      type: Array,
      required: true
    },
    tickets: {
      type: Array,
      required: true
    },
    numbers: {
      type: Array,
      required: true
    },
    status: {
      type: String,
      default:null
    }
  },
  created () {
    this.session = window.lanparty.session
  }
}
</script>
