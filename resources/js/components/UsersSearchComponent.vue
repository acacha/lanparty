<template>
    <v-card flat>
        <v-card-text>
            <v-container fluid>
                <v-layout row wrap>
                    <v-flex xs12>
                        <span style="display: inline-flex;">
                            Usuaris:
                            <v-chip label color="orange darken-3" text-color="white">
                                <v-icon left>group</v-icon>Total: {{ this.internalUsers.length }}
                            </v-chip>

                            <paid-users :session="session" :users="internalUsers"></paid-users>

                            <v-chip label color="accent darken-3" text-color="white">
                                Tickets disponibles: {{ this.availableTickets.length }}
                            </v-chip>
                            <span style="display: inline-flex;">
                                <add-tickets-button :session="session"></add-tickets-button>
                                <delete-tickets-button :session="session"></delete-tickets-button>
                            </span>
                        </span>
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
import AddTicketsButton from './tickets/AddTicketsButton'
import DeleteTicketsButton from './tickets/DeleteTicketsButton'
import PaidUsers from './users/PaidUsers'

export default {
  name: 'UsersSearch',
  components: {
    VUsersSearch,
     'paid-users': PaidUsers,
     'add-tickets-button': AddTicketsButton,
     'delete-tickets-button': DeleteTicketsButton
  },
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
    tickets: {
      type: Array
    },
    label: {
      type: String,
      default: 'Seleccioneu un usuari'
    }
  },
  computed: {
    internalUsers () {
      return this.$store.getters.users
    },
    paidInternalusers () {
      return this.$store.getters.users.filter((user) => {
        return user.inscription_paid.includes(this.session)
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
    if (this.tickets) this.$store.commit(mutations.SET_TICKETS, this.tickets)
    else this.$store.dispatch(actions.FETCH_TICKETS)
  }
}
</script>
