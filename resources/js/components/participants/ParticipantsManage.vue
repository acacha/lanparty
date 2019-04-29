<template>
    <v-container fluid grid-list-md text-xs-center>
        <v-layout row wrap>
            <v-flex xs12>
                <v-select
                        :items="sessions"
                        label="Standard"
                ></v-select>
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
                        <users-search :users="users"></users-search>
                        <manage-user :events="events"></manage-user>
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
      session: null,
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
