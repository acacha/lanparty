<template>
    <v-navigation-drawer
            fixed
            v-model="dataDrawer"
            right
            clipped
            app
    >
        <v-card>
            <v-container fluid grid-list-md class="grey lighten-4">
                <v-layout row wrap>
                    <v-flex xs12>
                        <gravatar :user="user" size="100px"></gravatar>
                    </v-flex>
                    <v-flex xs12>
                        <h3>{{ user.name }}</h3>
                        <a href="https://en.gravatar.com/connect/" target="_blank">Canvia el teu avatar a Gravatar</a>
                    </v-flex>
                </v-layout>
            </v-container>
            <v-card-text class="px-0 grey lighten-3">
                <v-form class="pl-3 pr-1 ma-0">
                    <v-text-field :readonly="!editingUser"
                                  label="Email"
                                  :value="user.email"
                                  ref="email"
                                  @input="updateEmail"
                    ></v-text-field>
                    <v-text-field :readonly="!editingUser"
                                  label="Nom usuari"
                                  :value="user.name"
                                  @input="updateName"
                    ></v-text-field>
                    <v-text-field :readonly="!editingUser"
                                  label="Nom"
                                  :value="user.givenName"
                                  @input="updateGivenName"
                    ></v-text-field>
                    <v-text-field :readonly="!editingUser"
                                  label="1r Cognom"
                                  :value="user.sn1"
                                  @input="updateSn1"
                    ></v-text-field>
                    <v-text-field :readonly="!editingUser"
                                  label="2n Cognom"
                                  :value="user.sn2"
                                  @input="updateSn2"
                    ></v-text-field>
                    <v-text-field readonly
                                  label="Created at"
                                  :value="user.formatted_created_at_date"
                                  readonly
                    ></v-text-field>
                </v-form>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn :loading="updatingUser" flat color="success" @click="updateUser" v-if="editingUser">
                    <v-icon right dark>save</v-icon>
                    Guardar
                </v-btn>
                <v-btn flat color="orange" @click="editUser()" v-else>
                    <v-icon right dark>edit</v-icon>
                    Editar
                </v-btn>
                <v-btn :loading="logoutLoading" @click="logout" flat color="orange">
                    <v-icon right dark>exit_to_app</v-icon>
                    Sortir</v-btn>
                <v-spacer></v-spacer>
            </v-card-actions>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn :loading="changingPassword" flat color="red" @click="changePassword">Canviar Paraula de pas</v-btn>
                <v-spacer></v-spacer>
            </v-card-actions>
            <v-card-actions>
                <v-spacer></v-spacer>
                <a href="https://en.gravatar.com/connect/">Canvia el teu avatar a Gravatar</a>
                <v-spacer></v-spacer>
            </v-card-actions>
        </v-card>
    </v-navigation-drawer>
</template>
<script>
import * as mutations from '../../store/mutation-types'
import * as actions from '../../store/action-types'
import Gravatar from '../GravatarComponent.vue'

export default {
  'name': 'UserInfoDrawer',
  components: {
    'gravatar': Gravatar
  },
  data () {
    return {
      dataDrawer: this.drawer,
      logoutLoading: false,
      editingUser: false,
      updatingUser: false,
      changingPassword: false
    }
  },
  watch: {
    drawer (drawer) {
      this.dataDrawer = drawer
    }
  },
  props: {
    drawer: {
      type: Boolean,
      required: true
    }
  },
  methods: {
    updateEmail (email) {
      this.$store.commit(mutations.USER, {...this.user, email})
    },
    updateName(name) {
      this.$store.commit(mutations.USER, {...this.user, name})
    },
    updateGivenName (givenName){
      this.$store.commit(mutations.USER,{...this.user, givenName})
    },
    updateSn1(sn1){
      this.$store.commit(mutations.USER,{...this.user, sn1})
    },
    updateSn2(sn2){
      this.$store.commit(mutations.USER,{...this.user, sn2})
    },
    editUser() {
      this.editingUser = true
      this.$nextTick(this.$refs.email.focus)
    },
    logout() {
      this.logoutLoading = true
      this.$store.dispatch(actions.LOGOUT).then(response => {
        window.location = '/'
      }).catch(error => {
        console.log(error)
      }).then(() => {
        this.logoutLoading = false
      })
    },
    updateUser () {
      this.updatingUser = true
      this.$store.dispatch(actions.UPDATE_USER, this.user).then(response => {
        this.$snackbar.showMessage('Usuari modificat correctament')
        this.editingUser = false
        this.updatingUser = false
      }).catch(() => {
        this.editingUser = false
        this.updatingUser = false
      })
    },
    changePassword() {
      this.changingPassword = true
      this.$store.dispatch(actions.REMEMBER_PASSWORD, this.user.email).then(response => {
        this.$snackbar.showMessage('Se us ha enviat un email per tal de modificar la paraula de pas')
        this.changingPassword = false
      }).catch(() => {
        this.changingPassword = false
      })
    },
  },
  created () {
    this.user = window.user
  }
}
</script>
