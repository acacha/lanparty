<template>
    <span>
        <v-dialog
                v-if="!logged"
                @keydown.esc="show=false"
                :fullscreen="$vuetify.breakpoint.smAndDown"
                max-width="900px"
                v-model="show"
                persistent>
            <template v-if="registrationsEnabled">
                <v-btn
                        slot="activator"
                        :color="color"
                        :large="large"
                        :dark="dark"
                >Registra't</v-btn>
            </template>
            <v-card class="pa-3">
                <v-card-title>
                    <span class="headline">Alta d'usuari</span>
                </v-card-title>
                <v-card-text>
                    <v-form ref="registrationForm" v-model="valid">
                        <v-text-field
                                label="Nom d'usuari"
                                v-model="name"
                                :rules="nameRules"
                                :counter="255"
                                required
                        ></v-text-field>
                        <v-text-field
                                label="Correu electrònic"
                                v-model="email"
                                :rules="emailRules"
                                :error="errors['email']"
                                :error-messages="errors['email']"
                                required
                        ></v-text-field>
                        <v-text-field
                                name="password"
                                label="Paraula de pas"
                                v-model="password"
                                :rules="passwordRules"
                                hint="Com a mínim 8 caràcters"
                                min="8"
                                type="password"
                                required
                        ></v-text-field>
                        <v-text-field
                                name="password"
                                label="Confirmació paraula de pas"
                                v-model="passwordConfirmation"
                                :rules="passwordConfirmationRules"
                                hint="Com a mínim 8 caràcters"
                                min="8"
                                type="password"
                                required
                                :error="errors['password']"
                                :error-messages="errors['password']"
                        ></v-text-field>
                        <v-text-field
                                label="Nom"
                                v-model="givenName"
                                :rules="givenNameRules"
                                required
                        ></v-text-field>
                        <v-text-field
                                label="1r cognom"
                                v-model="sn1"
                                :rules="sn1Rules"
                                required
                        ></v-text-field>
                        <v-text-field
                                label="2n cognom"
                                v-model="sn2"
                        ></v-text-field>
                        <v-checkbox
                                name="accept"
                                v-model="accept"
                                :rules="acceptRules"
                                required
                        >
                            <span slot="label">
                                <a href="/condicions" target="_blank"
                                >Accepteu els termes i condicións d'ús del lloc web</a>
                            </span>
                        </v-checkbox>
                    </v-form>
                    <v-btn href="/auth/facebook" style="background-color: #3b5998;" class="white--text">
                        <v-icon class="mr-2">fab fa-facebook</v-icon>
                        <span class="ml-1">Entra amb Facebook</span>
                    </v-btn>
                    <a href="/login" color="primary darken-2">
                        Ja tinc un usuari
                    </a>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary darken-1" flat @click.native="show = false">Tancar</v-btn>
                    <v-btn :loading="loading" :disabled="!valid" color="primary darken-1" class="white--text" @click.native="register">Registra'm</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-btn v-else href="/home">
            <v-icon>home</v-icon>
            Home
        </v-btn>
    </span>
</template>

<script>
import { mapGetters } from 'vuex'
import * as actions from '../store/action-types'

export default {
  name: 'RegisterDialog',
  data () {
    return {
      loading: false,
      internalAction: this.action,
      valid: false,
      name: '',
      nameRules: [
        (v) => !!v || 'El nom d\'usuari és un camp obligatori',
        (v) => v.length <= 255 || 'El nom d\'usuari ha de tenir com a màxim 255 caracters'
      ],
      email: '',
      emailRules: [
        (v) => !!v || 'El email és obligatori',
        (v) => /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'S\'ha d\'indicar un email vàlid'
      ],
      errors: [],
      password: '',
      passwordRules: [
        (v) => !!v || 'La paraula de pas és obligatòria',
        (v) => v.length >= 8 || 'La paraula de pas ha de tenir com a mínim 8 caràcters'
      ],
      passwordConfirmation: '',
      passwordConfirmationRules: [
        (v) => !!v || 'La paraula de pas és obligatòria',
        (v) => v.length >= 8 || 'La paraula de pas ha de tenir com a mínim 8 caràcters'
      ],
      givenName: '',
      givenNameRules: [
        (v) => !!v || 'El nom és obligatori'
      ],
      sn1: '',
      sn1Rules: [
        (v) => !!v || 'El segon cognom és obligatori'
      ],
      sn2: '',
      accept: false,
      acceptRules: [
        (v) => !!v || "És obligatori acceptar els termes i condicions d'ús del lloc web"
      ],
    }
  },
  props: {
    color: {
      type: String,
      default: ''
    },
    large: {
      type: Boolean,
      default: false
    },
    dark: {
      type: Boolean,
      default: false
    },
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
        if (this.internalAction && this.internalAction === 'register') return true
        return false
      },
      set (value) {
        if (value) this.internalAction = 'register'
        else this.internalAction = null
      }
    }
  },
  methods: {
    register () {
      if (this.$refs.registrationForm.validate()) {
        this.loading = true
        const user = {
          'name': this.name,
          'email': this.email,
          'password': this.password,
          'password_confirmation': this.passwordConfirmation,
          'givenName': this.givenName,
          'sn1': this.sn1,
          'sn2': this.sn2
        }
        this.$store.dispatch(actions.REGISTER, user).then(response => {
          this.loading = false
          this.show = false
          window.location = '/home'
        }).catch(() => {
          this.loading = false
          this.errors = error.response.data.errors
        })
      }
    },
  }
}
</script>

<style scoped>
    .facebook {
        width: 20px;
    }
</style>
