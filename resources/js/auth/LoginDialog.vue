<template>
    <v-dialog
            v-show="!logged"
            v-model="show"
            persistent
            max-width="500px"
            @keydown.esc="show=false"
            :fullscreen="$vuetify.breakpoint.xsOnly">
        <template v-if="registrationsEnabled">
            <v-btn color="primary" dark slot="activator">Entrar</v-btn>
        </template>
        <v-card class="pa-3">
            <v-card-title>
                <span class="headline">Login</span>
            </v-card-title>
            <v-card-text>
                <v-form ref="loginForm" v-model="valid">
                    <v-text-field
                            name="email"
                            label="E-mail"
                            v-model="email"
                            :rules="emailRules"
                            required
                    ></v-text-field>
                    <v-text-field
                            name="password"
                            label="Paraula de pas"
                            v-model="password"
                            :rules="passwordRules"
                            hint="Com a mínim 6 caràcters"
                            min="6"
                            type="password"
                            required
                    ></v-text-field>
                    <v-tooltip bottom class="pb-0">
                        <v-checkbox
                                slot="activator"
                                name="remember"
                                v-model="remember"
                                label="Recordeu el meu usuari"
                        ></v-checkbox>
                        <span>Es recordara el vostre usuari en aquesta màquina</span>
                    </v-tooltip>
                </v-form>
                <v-container grid-list-md text-xs-center class="pa-2 ma-2">
                    <v-layout row wrap>
                        <v-flex xs12>
                            <a href="/password/reset" color="primary darken-2">
                                Recorda'm la paraula de pas</a>
                             | <a href="/register" color="primary darken-2">
                                Registra't
                            </a>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary darken-2" flat @click.native="show = false">Tancar</v-btn>
                <v-btn color="primary darken-2" class="white--text" @click.native="login" :loading="loading" :disabled="!valid">Entrar</v-btn>
                <v-spacer></v-spacer>
            </v-card-actions>
            <v-card-actions>
                <v-spacer></v-spacer>

                <v-btn href="/auth/facebook" style="background-color: #3b5998;" class="white--text">
                    <v-icon class="mr-2">fab fa-facebook</v-icon>
                    <span class="ml-1">Entra amb Facebook</span>
                </v-btn>
                <v-spacer></v-spacer>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import { mapGetters } from 'vuex'
import * as actions from '../store/action-types'

export default {
  name: 'LoginDialog',
  data () {
    return {
      loading:false,
      internalAction: this.action,
      valid: false,
      email: '',
      emailRules: [
        (v) => !!v || 'El email és obligatori',
        (v) => /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'S\'ha d\'indicar un email vàlid'
      ],
      password: '',
      passwordRules: [
        (v) => !!v || 'La paraula de pas és obligatòria',
        (v) => v.length >= 6 || 'La paraula de pas ha de tenir com a mínim 6 caràcters'
      ],
      remember: false
    }
  },
  props: {
    action: {
      type: String,
      default: null
    },
    registrationsEnabled: {
      type: Boolean,
      default: true
    }
  },
  computed: {
    ...mapGetters([
      'logged'
    ]),
    show: {
      get () {
        if (this.internalAction && this.internalAction === 'login') return true
        return false
      },
      set (value) {
        if (value) this.internalAction = 'login'
        else this.internalAction = null
      }
    }
  },
  methods: {
    login () {
      if (this.$refs.loginForm.validate()) {
        this.loading = true
        let credentials = {
          'email': this.email,
          'password': this.password
        }
        if (this.remember) {
          credentials['remember'] = true
        }
        this.$store.dispatch(actions.LOGIN, credentials).then(() => {
          this.loading = false
          this.show = false
          window.location = '/home'
        }).catch(() => {
          this.loading = false
        })
      }
    }
  }
}
</script>

<style scoped>
    .facebook {
        width: 20px;
    }
</style>
