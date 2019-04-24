<template>
    <span>
        <v-dialog
                v-if="!logged"
                @keydown.esc="show=false"
                fullscreen
                v-model="show"
                persistent>
            <template v-if="registrationsEnabled">
                <v-btn slot="activator">Registra't</v-btn>
            </template>
            <v-card>
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
                                hint="Com a mínim 6 caràcters"
                                min="6"
                                type="password"
                                required
                        ></v-text-field>
                        <v-text-field
                                name="password"
                                label="Confirmació paraula de pas"
                                v-model="passwordConfirmation"
                                :rules="passwordConfirmationRules"
                                hint="Com a mínim 6 caràcters"
                                min="6"
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
                    </v-form>
                    <v-btn href="/auth/facebook" style="background-color: #3b5998;" class="white--text">
                        <svg class="facebook" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             width="266.893px" height="266.895px" viewBox="0 0 266.893 266.895" enable-background="new 0 0 266.893 266.895"
                             xml:space="preserve">
                                <path id="Blue_1_" fill="#3C5A99" d="M248.082,262.307c7.854,0,14.223-6.369,14.223-14.225V18.812
                                    c0-7.857-6.368-14.224-14.223-14.224H18.812c-7.857,0-14.224,6.367-14.224,14.224v229.27c0,7.855,6.366,14.225,14.224,14.225
                                    H248.082z"/>
                            <path id="f" fill="#FFFFFF" d="M182.409,262.307v-99.803h33.499l5.016-38.895h-38.515V98.777c0-11.261,3.127-18.935,19.275-18.935
                                    l20.596-0.009V45.045c-3.562-0.474-15.788-1.533-30.012-1.533c-29.695,0-50.025,18.126-50.025,51.413v28.684h-33.585v38.895h33.585
                                    v99.803H182.409z"/>
                                </svg>
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
        (v) => v.length >= 6 || 'La paraula de pas ha de tenir com a mínim 6 caràcters'
      ],
      passwordConfirmation: '',
      passwordConfirmationRules: [
        (v) => !!v || 'La paraula de pas és obligatòria',
        (v) => v.length >= 6 || 'La paraula de pas ha de tenir com a mínim 6 caràcters'
      ],
      givenName: '',
      givenNameRules: [
        (v) => !!v || 'El nom és obligatori'
      ],
      sn1: '',
      sn1Rules: [
        (v) => !!v || 'El segon cognom és obligatori'
      ],
      sn2: ''
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
