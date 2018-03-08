<template>
    <v-card tile>
        <v-toolbar card dark color="primary">
            <v-btn icon @click.native="close" dark>
                <v-icon>close</v-icon>
            </v-btn>
            <v-toolbar-title>Inscripció a una competició de grup</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items>
                <v-btn dark flat @click.native="showInscribeToGroupEvent = false">Guardar</v-btn>
            </v-toolbar-items>
        </v-toolbar>
        <v-card-text>
            <v-alert type="error" :value="true" class="mb-3">
                Les inscripcions a una competició les ha de realitzar només el lider del grup!
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
                    <v-users-search :users="users" @input="userSelected(n)" :label="'Participant ' + n"></v-users-search>
                </template>

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

  export default {
    name: 'Group',
    components: { VUsersSearch, Upload },
    data () {
      return {
        valid: false,
        name: '',
        nameRules: [
          v => !!v || 'El nom és obligatori',
          v => v.length <= 30 || 'Name must be less than 30 characters'
        ]
      }
    },
    computed: {
      ...mapGetters({
        user: 'user'
      })
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
      userSelected (position) {
        //TODO
        console.log('User has been selected for position: ' + position)
      },
      close () {
        this.$emit('close')
      }
    }
  }
</script>
