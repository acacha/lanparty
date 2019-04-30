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
                        <v-chip label color="success darken-3" text-color="white">
                            <v-icon left>group</v-icon>Pagats: {{ this.paidInternalusers.length }}
                        </v-chip>
                        <v-chip label color="accent darken-3" text-color="white">
                            Tickets disponibles: {{ this.availableTickets.length }}
                        </v-chip>
                    </v-flex>
                    <v-flex xs12>
                        <v-users-search :users="internalUsers" @input="input" :return-object="true"></v-users-search>
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
      session: {
        type: String,
        required: true
      },
      users: {
        type: Array
      },
      label: {
        type: String,
        default: 'Seleccioneu un usuari'
      }
    },
    computed: {
      internalUsers () {
        console.log('internalUsers computed!')
        return this.$store.getters.users
      },
      paidInternalusers () {
        console.log('paidInternalusers computed!')
        console.log('session:')
        console.log(this.session)
        return this.$store.getters.users.filter((user) => {
          return user.inscription_paid[this.session]
        })
      },
      availableTickets () {
        return this.$store.getters.tickets.filter((ticket) => {
          return !ticket.user_id && ticket.session === this.session
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
