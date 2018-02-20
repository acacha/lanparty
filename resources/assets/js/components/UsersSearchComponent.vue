<template>
    <v-card flat>
        <v-card-text>
            <v-container fluid>
                <v-layout row wrap>
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
      }
    },
    methods: {
      input (user) {
        if (user) this.$store.dispatch(actions.SELECTED_USER, user)
        else this.$store.dispatch(actions.SELECTED_USER, {})
      }
    },
    mounted () {
      if (this.users) this.internalUsers = this.users
      else {
        this.$store.dispatch(actions.FETCH_USERS)
      }
    }
  }
</script>