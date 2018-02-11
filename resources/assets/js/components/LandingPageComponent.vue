<template>
    <v-app light>
        <v-toolbar class="white">
            <v-toolbar-title>Institut de l'Ebre LAN PARTY</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-dialog v-show="!logged" v-model="loginDialog" persistent max-width="500px">
                <v-btn color="primary" dark slot="activator">Entrar</v-btn>
                <v-card>
                    <v-card-title>
                        <span class="headline">Login</span>
                    </v-card-title>
                    <v-card-text>
                        <v-alert v-if="loginErrorMessage" color="error" icon="warning" value="true" class="">
                            <h3>{{loginErrorMessage}}</h3>
                            <p v-for="(error, errorKey) in loginErrors">{{errorKey}} : {{ error[0] }}</p>
                        </v-alert>
                        <v-form v-model="valid">
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
                                    hint="At least 6 characters"
                                    min="6"
                                    type="password"
                                    required
                            ></v-text-field>
                        </v-form>
                        <v-btn color="blue darken-2" class="white--text">
                            Entra amb Facebook
                        </v-btn>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue darken-1" flat @click.native="loginDialog = false">Tancar</v-btn>
                        <v-btn color="blue darken-1" flat @click.native="login" :loading="loginLoading">Entrar</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
            <v-dialog v-if="!logged" v-model="registerDialog" persistent max-width="500px">
                <v-btn slot="activator">Registra't</v-btn>
                <v-card>
                    <v-card-title>
                        <span class="headline">Alta d'usuari</span>
                    </v-card-title>
                    <v-card-text>
                        <v-form v-model="valid">
                            <v-text-field
                                    label="Name"
                                    v-model="name"
                                    :rules="nameRules"
                                    :counter="10"
                                    required
                            ></v-text-field>
                            <v-text-field
                                    label="E-mail"
                                    v-model="email"
                                    :rules="emailRules"
                                    required
                            ></v-text-field>
                            <v-text-field
                                    label="Nom"
                                    v-model="givenName"
                                    required
                            ></v-text-field>
                            <v-text-field
                                    label="Cognom"
                                    v-model="sn1"
                                    required
                            ></v-text-field>
                            <v-text-field
                                    label="2n Cognom"
                                    v-model="sn2"
                                    required
                            ></v-text-field>
                        </v-form>
                        <v-btn color="blue darken-2" class="white--text">
                            Entra amb Facebook
                        </v-btn>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue darken-1" flat @click.native="registerDialog = false">Tancar</v-btn>
                        <v-btn color="blue darken-1" flat @click.native="registerDialog = false">Registrar-se</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
            <v-btn v-else href="/home">Home</v-btn>
        </v-toolbar>
        <v-content>
            <section>
                <v-parallax src="img/LanpartyLanding.jpg" height="600">
                    <v-layout
                            column
                            align-center
                            justify-center
                            class="white--text"
                    >
                        <img src="img/logo.png" alt="Vuetify.js" height="200">
                        <div class="subheading mb-3 text-xs-center">
                            Departament d'Informàtica</div>
                        <v-btn
                                class="orange darken-3 mt-2"
                                dark
                                large
                                @click.native="registerDialog = true"
                        >
                            Registra't
                        </v-btn>
                    </v-layout>
                </v-parallax>
            </section>

            <section>
                <v-layout
                        column
                        wrap
                        class="my-5"
                        align-center
                >
                    <v-flex xs12 sm4 class="my-3">
                        <div class="text-xs-center">
                            <h2 class="headline">The best way to start developing</h2>
                            <span class="subheading">
                Cras facilisis mi vitae nunc
              </span>
                        </div>
                    </v-flex>
                    <v-flex xs12>
                        <v-container grid-list-xl>
                            <v-layout row wrap align-center>
                                <v-flex xs12 md4>
                                    <v-card class="elevation-0 transparent">
                                        <v-card-text class="text-xs-center">
                                            <v-icon x-large class="blue--text text--lighten-2">color_lens</v-icon>
                                        </v-card-text>
                                        <v-card-title primary-title class="layout justify-center">
                                            <div class="headline text-xs-center">Material Design</div>
                                        </v-card-title>
                                        <v-card-text>
                                            Cras facilisis mi vitae nunc lobortis pharetra. Nulla volutpat tincidunt ornare.
                                            Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.
                                            Nullam in aliquet odio. Aliquam eu est vitae tellus bibendum tincidunt. Suspendisse potenti.
                                        </v-card-text>
                                    </v-card>
                                </v-flex>
                                <v-flex xs12 md4>
                                    <v-card class="elevation-0 transparent">
                                        <v-card-text class="text-xs-center">
                                            <v-icon x-large class="blue--text text--lighten-2">flash_on</v-icon>
                                        </v-card-text>
                                        <v-card-title primary-title class="layout justify-center">
                                            <div class="headline">Fast development</div>
                                        </v-card-title>
                                        <v-card-text>
                                            Cras facilisis mi vitae nunc lobortis pharetra. Nulla volutpat tincidunt ornare.
                                            Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.
                                            Nullam in aliquet odio. Aliquam eu est vitae tellus bibendum tincidunt. Suspendisse potenti.
                                        </v-card-text>
                                    </v-card>
                                </v-flex>
                                <v-flex xs12 md4>
                                    <v-card class="elevation-0 transparent">
                                        <v-card-text class="text-xs-center">
                                            <v-icon x-large class="blue--text text--lighten-2">build</v-icon>
                                        </v-card-text>
                                        <v-card-title primary-title class="layout justify-center">
                                            <div class="headline text-xs-center">Completely Open Sourced</div>
                                        </v-card-title>
                                        <v-card-text>
                                            Cras facilisis mi vitae nunc lobortis pharetra. Nulla volutpat tincidunt ornare.
                                            Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.
                                            Nullam in aliquet odio. Aliquam eu est vitae tellus bibendum tincidunt. Suspendisse potenti.
                                        </v-card-text>
                                    </v-card>
                                </v-flex>
                            </v-layout>
                        </v-container>
                    </v-flex>
                </v-layout>
            </section>

            <section>
                <v-parallax src="img/LanpartyLanding2.jpg" height="380">
                    <v-layout column align-center justify-center>
                        <div class="headline white--text mb-3 text-xs-center">Web development has never been easier</div>
                        <em>Kick-start your application today</em>
                        <v-btn
                                class="blue lighten-2 mt-5"
                                dark
                                large
                                href="/pre-made-themes"
                        >
                            Get Started
                        </v-btn>
                    </v-layout>
                </v-parallax>
            </section>

            <section>
                <v-container grid-list-xl>
                    <v-layout row wrap justify-center class="my-5">
                        <v-flex xs12 sm4>
                            <v-card class="elevation-0 transparent">
                                <v-card-title primary-title class="layout justify-center">
                                    <div class="headline">Company info</div>
                                </v-card-title>
                                <v-card-text>
                                    Cras facilisis mi vitae nunc lobortis pharetra. Nulla volutpat tincidunt ornare.
                                    Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.
                                    Nullam in aliquet odio. Aliquam eu est vitae tellus bibendum tincidunt. Suspendisse potenti.
                                </v-card-text>
                            </v-card>
                        </v-flex>
                        <v-flex xs12 sm4 offset-sm1>
                            <v-card class="elevation-0 transparent">
                                <v-card-title primary-title class="layout justify-center">
                                    <div class="headline">Contact us</div>
                                </v-card-title>
                                <v-card-text>
                                    Cras facilisis mi vitae nunc lobortis pharetra. Nulla volutpat tincidunt ornare.
                                </v-card-text>
                                <v-list class="transparent">
                                    <v-list-tile>
                                        <v-list-tile-action>
                                            <v-icon class="blue--text text--lighten-2">phone</v-icon>
                                        </v-list-tile-action>
                                        <v-list-tile-content>
                                            <v-list-tile-title>777-867-5309</v-list-tile-title>
                                        </v-list-tile-content>
                                    </v-list-tile>
                                    <v-list-tile>
                                        <v-list-tile-action>
                                            <v-icon class="blue--text text--lighten-2">place</v-icon>
                                        </v-list-tile-action>
                                        <v-list-tile-content>
                                            <v-list-tile-title>Chicago, US</v-list-tile-title>
                                        </v-list-tile-content>
                                    </v-list-tile>
                                    <v-list-tile>
                                        <v-list-tile-action>
                                            <v-icon class="blue--text text--lighten-2">email</v-icon>
                                        </v-list-tile-action>
                                        <v-list-tile-content>
                                            <v-list-tile-title>john@vuetifyjs.com</v-list-tile-title>
                                        </v-list-tile-content>
                                    </v-list-tile>
                                </v-list>
                            </v-card>
                        </v-flex>
                    </v-layout>
                </v-container>
            </section>

            <v-footer class="blue darken-3">
                <v-layout row wrap align-center>
                    <v-flex xs12>
                        <div class="white--text ml-3">
                            Made with
                            <v-icon class="red--text">favorite</v-icon>
                            by <a class="white--text" href="https://vuetifyjs.com" target="_blank">Vuetify</a>
                            and <a class="white--text" href="https://github.com/acacha">Sergi Tur</a>
                        </div>
                    </v-flex>
                </v-layout>
            </v-footer>
        </v-content>
    </v-app>
</template>

<style>

</style>

<script>
  import * as actions from '../store/action-types'
  import * as mutations from '../store/mutation-types'

  import { mapGetters } from 'vuex'
  export default {
    name: 'LandingPage',
    data () {
      return {
        loginDialog: false,
        loginLoading: false,
        loginErrorMessage: '',
        loginErrors: [],
        registerDialog: false,
        valid: false,
        name: '',
        nameRules: [
          (v) => !!v || 'Name is required',
          (v) => v.length <= 10 || 'Name must be less than 10 characters'
        ],
        email: '',
        emailRules: [
          (v) => !!v || 'E-mail is required',
          (v) => /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'E-mail must be valid'
        ],
        password: '',
        passwordRules: [
          (v) => !!v || 'Password is required',
          (v) => v.length >= 6 || 'Password must be greater than 6 characters'
        ],
        givenName: '',
        sn1: '',
        sn2: ''
      }
    },
    props: {
      user: {
        required: true
      },
      showLogin: {
        type: Boolean,
        default: false
      },
      showRegister: {
        type: Boolean,
        default: false
      }
    },
    computed: {
      ...mapGetters([
        'logged'
      ])
    },
    methods: {
      login () {
        this.loginLoading = true
        const credentials = {
          'email': this.email,
          'password': this.password
        }
        this.$store.dispatch(actions.LOGIN, credentials).then(response => {
          console.log(response)
          this.loginLoading = false
          this.loginDialog = false
          window.location = '/home'
        }).catch(error => {
          this.loginErrorMessage = error.response.data.message
          this.loginErrors = error.response.data.errors
          console.log(error)
        }).then(() => {
          this.loginLoading = false
        })
      }
    },
    mounted () {
      if (this.user) this.$store.commit(mutations.LOGGED, true)
      else this.$store.commit(mutations.LOGGED, false)
      console.log('Show Login:')
      console.log(this.showLogin)
      console.log('Register:')
      console.log(this.showRegister)
      console.log('User:')
      console.log(this.user)
    }
  }
</script>
