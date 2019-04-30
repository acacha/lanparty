<template>
    <v-container fluid grid-list-md text-xs-center>
        <v-layout row wrap>
            <v-flex xs8 offset-xs2 v-if="show">
                <v-toolbar color="primary darken-3 white--text" dense>
                    <v-toolbar-title>Escolliu una sessió</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-toolbar-items>
                        <v-btn icon class="white--text" @click="minimized = false" v-if="minimized">
                            <v-icon>add</v-icon>
                        </v-btn>
                        <v-btn v-else icon class="white--text" @click="minimized = true">
                            <v-icon>minimize</v-icon>
                        </v-btn>
                        <v-btn icon dark @click.native="show = false">
                            <v-icon>close</v-icon>
                        </v-btn>
                    </v-toolbar-items>
                </v-toolbar>
                <v-card v-if="!minimized">
                    <v-card-text>
                        <v-select
                                v-model="session"
                                :items="sessions"
                                label="Escolliu una sessió"
                        ></v-select>
                    </v-card-text>
                </v-card>
            </v-flex>
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
                        <numbers-search :numbers="numbers"></numbers-search>
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

export default {
  name: 'ParticipantsManage',
  components: {
    'users-search': UsersSearch,
    'numbers-search': NumbersSearch,
    'manage-user': ManageUser
  },
  data () {
    return {
      show: true,
      minimized: false,
      session: '2019',
      sessions: [
        '2018',
        '2019'
      ]
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
  }
}
</script>
