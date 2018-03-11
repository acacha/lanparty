<template>
    <v-card tile>
        <v-snackbar
                :timeout="6000"
                :color="snackbarColor"
                v-model="snackbar"
                :multi-line="true"
        >
            {{ snackbarText }}<br/>
            {{ snackbarSubtext }}
            <v-btn dark flat @click.native="snackbar = false">Close</v-btn>
        </v-snackbar>
        <v-toolbar card dark color="primary">
            <v-btn icon @click.native="close" dark>
                <v-icon>close</v-icon>
            </v-btn>
            <v-toolbar-title>Inscripció a una competició de grup</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items>
                <v-btn dark flat @click.native="register" :loading="registering">Inscriure grup</v-btn>
            </v-toolbar-items>
        </v-toolbar>
        <v-card-text>
            <v-alert type="error" :value="true" class="mb-3">
                Les inscripcions a una competició les ha de realitzar només el líder del grup!
            </v-alert>

            <span class="subheading">Sóc el lider del grup i li poso el nom:</span>

            <v-form v-model="valid">
                <v-text-field
                        label="Nom del grup"
                        v-model="name"
                        :rules="nameRules"
                        :counter="30"
                        required
                ></v-text-field>

                <upload label="Escolliu un avatar pel grup"></upload>

                <v-text-field
                        label="Líder"
                        :value="user.name"
                        readonly
                ></v-text-field>

                <template v-for="n in 4">
                    <v-users-search :users="users" @input="userSelected(n+1,$event)" :label="'Participant ' + n"></v-users-search>
                </template>

                <v-btn dark color="primary" @click.native="register" :loading="registering">Inscriure grup</v-btn>

            </v-form>
        </v-card-text>
    </v-card>
</template>

<style>

</style>

<script>
  import VUsersSearch from './VUsersSearchComponent.vue'
  import Upload from './UploadComponent'
  import { mapGetters } from 'vuex'
  import * as actions from '../store/action-types'
  import withSnackbar from './mixins/withSnackbar'

  export default {
    name: 'Group',
    components: { VUsersSearch, Upload },
    mixins: [withSnackbar],
    data () {
      return {
        valid: false,
        registering: false,
        name: '',
        ids: {},
        nameRules: [
          v => !!v || 'El nom és obligatori',
          v => v.length <= 30 || 'Name must be less than 30 characters'
        ],
        selectedUsers: []
      }
    },
    computed: {
      ...mapGetters({
        user: 'user'
      }),
      availableUsers () {
        let users = new Set(this.users)
        let sUsers = new Set(this.selectedUsers)
        return [...users].filter(user => !sUsers.has(user))
      }
    },
    props: {
      dialog: {
        type: Boolean,
        default: false
      },
      event: {
        type: Object,
        required: true
      },
      users: {
        type: Array
      }
    },
    methods: {
      userSelected (n, user) {
        if (user) {
          if (this.isUserAlreadySelected(user)) {
            this.showError({message: "L'usuari ja ha estat seleccionat prèviament!"})
            return
          }
          this.ids[n] = user.id
        } else delete this.ids[n]
        this.selectedUsers.push(user)
      },
      isUserAlreadySelected (user) {
        return new Set(this.selectedUsers).has(user)
      },
      register () {
        this.registering = true
        // TODO avatar
        const group = {
          name: this.name,
          avatar: '',
          user_ids: this.ids
        }
        this.$store.dispatch(actions.REGISTER_GROUP_TO_EVENT, {event: this.event, group: group}).then((response) => {
          console.dir(response)
        }).catch(error => {
          console.dir(error)
          this.showError(error)
        }).then(() => {
          this.registering = false
        })
      },
      close () {
        this.$emit('close')
      }
    },
    mounted () {
      this.ids[1] = this.user.id
      var foundUser = this.users.find((user) => {
        return user.id === this.user.id
      })
      this.selectedUsers.push(foundUser)
    }
  }
</script>
