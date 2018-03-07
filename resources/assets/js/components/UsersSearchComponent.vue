<template>
    <v-card flat>
        <v-card-text>
            <v-container fluid>
                <v-layout row wrap>
                    <v-flex xs12>
                        Usuaris:
                        <v-chip label color="orange darken-3" text-color="white">
                            <v-icon left>group</v-icon>Total: {{ this.internalUsers.length }}
                        </v-chip>
                        <v-chip label color="green darken-3" text-color="white">
                            <v-icon left>group</v-icon>Pagats: {{ this.paidInternalusers.length }}
                        </v-chip>
                    </v-flex>
                    <v-flex xs12>
                        <v-users-search :users="internalUsers" @input="input"></v-users-search>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-card-text>
    </v-card>
</template>

<script>
  import * as actions from '../store/action-types'
  import * as mutations from '../store/mutation-types'
  import interactsWithGravatar from './mixins/interactsWithGravatar'
  import VUsersSearch from './VUsersSearchComponent.vue'

  export default {
    name: 'UsersSearch',
    components: { VUsersSearch },
    mixins: [ interactsWithGravatar ],
    data () {
      return {
        selected_user_id: null
      }
    },
    props: {
      users: {
        type: Array,
        required: false
      },
      label: {
        type: String,
        default: 'Seleccioneu un usuari'
      }
    },
    computed: {
      internalUsers () {
        if (this.users) return this.users
        return this.$store.getters.users
      },
      paidInternalusers () {
        return this.$store.getters.users.filter(function (user) {
          return user.inscription_paid
        })
      }
    },
    methods: {
      input (user) {
        if (user) this.$store.dispatch(actions.SELECTED_USER, user)
        else this.$store.dispatch(actions.SELECTED_USER, {})
      }
    },
    mounted () {
      if (this.users) this.$store.commit(mutations.SET_USERS, this.users)
      else this.$store.dispatch(actions.FETCH_USERS)
    }
  }
</script>