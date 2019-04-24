<template>
    <v-app light>
        <snackbar></snackbar>
        <v-toolbar class="white">
            <v-toolbar-title class="hidden-xs-only">Institut de l'Ebre LAN PARTY</v-toolbar-title>
            <v-spacer></v-spacer>

            <login-dialog></login-dialog>

            <v-dialog fullscreen v-if="!logged" v-model="showRegister" persistent>
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
                                    v-model="registerEmail"
                                    :rules="emailRules"
                                    :error="registerErrors['email']"
                                    :error-messages="registerErrors['email']"
                                    required
                            ></v-text-field>
                            <v-text-field
                                    name="password"
                                    label="Paraula de pas"
                                    v-model="registerPassword"
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
                                    :error="registerErrors['password']"
                                    :error-messages="registerErrors['password']"
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
                        <v-btn color="primary darken-1" flat @click.native="showRegister = false">Tancar</v-btn>
                        <v-btn :loading="registerLoading" color="primary darken-1" class="white--text" @click.native="register">Registra'm</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
            <v-btn v-else href="/home">
                <v-icon>home</v-icon>
                Home
            </v-btn>
            <v-dialog v-model="showRememberPassword" persistent max-width="500px">
                <v-card>
                    <v-card-title>
                        <span class="headline">Recordeu-me la paraula de pas</span>
                    </v-card-title>
                    <v-card-text>
                        <v-alert v-if="rememberErrorMessage" color="error" icon="warning" value="true" dismissible>
                            <h3>{{rememberErrorMessage}}</h3>
                            <p v-for="(error, errorKey) in rememberErrors">{{errorKey}} : {{ error[0] }}</p>
                        </v-alert>
                        <v-form v-model="valid">
                            <v-text-field
                                    label="Correu electrònic"
                                    v-model="emailRememberPassword"
                                    :rules="emailRules"
                                    :error="loginErrors['email']"
                                    :error-messages="loginErrors['email']"
                                    required
                            ></v-text-field>
                        </v-form>
                        <a href="/login" color="primary darken-2">
                            Entrar
                        </a> &nbsp; |
                        <a href="/register" color="primary darken-2">
                            Registra't
                        </a>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="primary darken-1" flat @click.native="showRememberPassword = false">Tancar</v-btn>
                        <v-btn
                                :loading="rememberPasswordLoading"
                                flat
                                :color="rememberPasswordLoadingDone ? 'green' : 'blue'"
                                @click.native="rememberPassword"
                        >
                            <v-icon v-if="!rememberPasswordLoadingDone">mail_outline</v-icon>
                            <v-icon v-else>done</v-icon>
                            &nbsp;
                            <template v-if="!rememberPasswordLoadingDone">Enviar</template>
                            <template v-else>Fet</template>
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
            <v-dialog v-model="showResetPassword" persistent max-width="500px">
                <v-card>
                    <v-card-title>
                        <span class="headline">Restaureu la paraula de pas</span>
                    </v-card-title>
                    <v-card-text>
                        <v-alert v-if="resetErrorMessage" color="error" icon="warning" value="true" dismissible>
                            <h3>{{resetErrorMessage}}</h3>
                            <p v-for="(error, errorKey) in resetErrors">{{errorKey}} : {{ error[0] }}</p>
                        </v-alert>
                        <v-form v-model="valid">
                            <v-text-field
                                    label="Correu electrònic"
                                    v-model="internalResetPasswordEmail"
                                    :rules="emailRules"
                                    required
                            ></v-text-field>
                            <v-text-field
                                    name="resetPassword"
                                    label="Paraula de pas"
                                    v-model="resetPassword"
                                    :rules="passwordRules"
                                    hint="Com a mínim 6 caràcters"
                                    min="6"
                                    type="password"
                                    required
                            ></v-text-field>
                            <v-text-field
                                    name="resetPasswordConfirmation"
                                    label="Confirmació paraula de pas"
                                    v-model="resetPasswordConfirmation"
                                    :rules="passwordConfirmationRules"
                                    hint="Com a mínim 6 caràcters"
                                    min="6"
                                    type="password"
                                    required
                            ></v-text-field>
                        </v-form>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="primary darken-1" flat @click.native="showResetPassword = false">Tancar</v-btn>
                        <v-btn
                                :loading="resetPasswordLoading"
                                flat
                                :color="resetPasswordLoadingDone ? 'green' : 'blue'"
                                @click.native="reset"
                        >
                            <v-icon v-if="resetPasswordLoadingDone">done</v-icon>
                            &nbsp;
                            <template v-if="!resetPasswordLoadingDone">Restaurar</template>
                            <template v-else>Fet</template>
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-toolbar>
        <v-content>
            <section>
                <v-parallax src="/img/LanpartyLanding.jpg" height="600">
                    <v-layout
                            column
                            align-center
                            justify-center
                            class="white--text"
                    >
                        <img src="/img/logo.png" alt="Vuetify.js" height="200">

                        <template v-if="!logged">
                            <template v-if="registrationsEnabled">
                                <v-btn
                                        class="orange darken-3 mt-2"
                                        dark
                                        large
                                        @click.native="showRegister = true"
                                >
                                    Registra't
                                </v-btn>
                            </template>
                            <template v-else>
                                <v-card class="elevation-0 text-xs-center" style="width: 400px;">
                                    <v-card-title style="align-items: center;justify-content: center;">
                                        <span class="title">Llista de correu electrònic</span>
                                        <em class="subheading">Apunta't i sigues el primer en rebre tota la informació de la LAN Party!</em>
                                    </v-card-title>
                                    <v-card-text>
                                        <v-form v-model="valid">
                                            <v-text-field
                                                    name="email"
                                                    label="E-mail"
                                                    v-model="emailMailingList"
                                                    :rules="emailRules"
                                                    required
                                                    box
                                                    autofocus
                                                    auto-grow
                                            ></v-text-field>
                                        </v-form>
                                        <template v-if="newsletterSubscriptionDone">Comproveu el vostre email i seguiu les passes indicades!</template>
                                        <v-btn
                                                :loading="newsLetterLoading"
                                                class="darken-3 mt-2"
                                                :class="{ green: newsletterSubscriptionDone, orange: !newsletterSubscriptionDone }"
                                                dark
                                                large
                                                @click.native="addEmailToMailingList"
                                        >
                                            <v-icon v-if="!newsletterSubscriptionDone">mail_outline</v-icon>
                                            <v-icon v-else>done</v-icon>
                                            &nbsp;
                                            <template v-if="!newsletterSubscriptionDone">Apunta'm</template>
                                            <template v-else>Fet</template>
                                        </v-btn>
                                    </v-card-text>
                                </v-card>
                            </template>
                        </template>
                    </v-layout>
                </v-parallax>
            </section>

            <section style="background-color: white">
                <v-layout
                        column
                        wrap
                        class="my-5"
                        align-center
                >
                    <v-flex xs12 sm4 class="my-3">
                        <div class="text-xs-center">
                            <h2 class="display-1">Competicions</h2>
                            <span class="subheading">
                              Posa a prova les teves habilitats!
                            </span>
                        </div>
                    </v-flex>
                    <v-flex xs12>
                        <v-container grid-list-xl>
                            <v-layout row wrap align-center>
                                <v-flex xs12 md3>
                                    <v-card class="elevation-0 transparent">
                                        <v-card-text class="text-xs-center">
                                            <img src="/img/LeagueofLegends.png" alt="League of Legends" width="200px;">
                                        </v-card-text>
                                        <v-card-title primary-title class="layout justify-center">
                                            <div class="headline text-xs-center">League of Legends</div>
                                        </v-card-title>
                                        <v-card-text>
                                            Els jugadors s’enfronten entre ells dividint-se en 2 equips de 3 o 5 jugadores cadascun, depenent de si el mode de joc és 3 vs. 3 a l’escenari «El Bosque Retorcido» o 5 vs. 5 als escenaris «El Abismo de los Lamentos» i «La Grieta del Invocador», sent aquest últim mapa el més famós i considerat l’estàndard en el joc competitiu.
                                            Més informació a la <a href="https://euw.leagueoflegends.com/es/">pàgina oficial</a>
                                        </v-card-text>
                                    </v-card>
                                </v-flex>
                                <v-flex xs12 md3>
                                    <v-card class="elevation-0 transparent">
                                        <v-card-text class="text-xs-center">
                                            <img src="/img/Overwatch.jpeg" alt="Overwatch" width="200px;">
                                        </v-card-text>
                                        <v-card-title primary-title class="layout justify-center">
                                            <div class="headline">Overwatch</div>
                                        </v-card-title>
                                        <v-card-text>
                                            En una partida d'Overwatch hi ha dos equips de 6 persones cadascun. Cada jugador ha d'escollir un dels personatges (anomenats herois dins del videojoc) amb habilitats i moviments únics. Els herois estan dividits en quatre classes segons el seu estil de joc: atac, defensa, tanc i suport.
                                            Més informació a la <a href="https://playoverwatch.com/es-es/">pàgina oficial</a>
                                        </v-card-text>
                                    </v-card>
                                </v-flex>
                                <v-flex xs12 md3>
                                    <v-card class="elevation-0 transparent">
                                        <v-card-text class="text-xs-center">
                                            <img src="/img/AgeOfEmpires2.png" alt="Age of Empires2" width="200px;">
                                        </v-card-text>
                                        <v-card-title primary-title class="layout justify-center">
                                            <div class="headline text-xs-center">Age of Empires 2</div>
                                        </v-card-title>
                                        <v-card-text>
                                            Joc ambientat en la Edat Mitja, just després de la caiguda de l'Imperi romà i la presa de Roma pels Visigots. El jugador pot escollir entre 13 civilitzacions que van existir en aquell període històric, i ha d'encaminar-les per a formar un gran imperi i guanyar als seus enemics.
                                            Més informació a la <a href="http://www.ensemblestudios.com/">pàgina oficial</a>
                                        </v-card-text>
                                    </v-card>
                                </v-flex>
                                <v-flex xs12 md3>
                                    <v-card class="elevation-0 transparent">
                                        <v-card-text class="text-xs-center">
                                            <img src="/img/CounterStrike.jpeg" alt="Counter Strike" width="200px;">
                                        </v-card-text>
                                        <v-card-title primary-title class="layout justify-center">
                                            <div class="headline text-xs-center">Counter Strike</div>
                                        </v-card-title>
                                        <v-card-text>
                                            L'acció de Counter-Strike es desenvolupa en rondes d'una durada màxima de 9 minuts, en les quals un equip de terroristes s'enfronta a un equip d'antiterroristes. L'equip guanyador és el que compleixi tots els seus objectius, destrucció de material o l'eliminació de tots els jugadors de l'altre equip.
                                            Més informació a la <a href="http://www.counter-strike.net/">pàgina oficial</a>.
                                        </v-card-text>
                                    </v-card>
                                </v-flex>
                            </v-layout>
                        </v-container>
                    </v-flex>
                </v-layout>
            </section>

            <section>
                <v-parallax src="/img/LanpartyLanding2.jpg" height="380">
                    <v-layout column align-center justify-center>
                        <template v-if="registrationsEnabled">
                            <v-card class="elevation-0 text-xs-center" style="width: 400px;">
                                <v-card-title style="align-items: center;justify-content: center;">
                                    <span class="title">Llista de correu electrònic</span>
                                    <em class="subheading mt-3">Apunta't i sigues el primer en rebre tota la informació de la LAN party!</em>
                                </v-card-title>
                                <v-card-text>
                                    <v-form v-model="valid">
                                        <v-text-field
                                                name="email"
                                                label="E-mail"
                                                v-model="emailMailingList"
                                                :rules="emailRules"
                                                required
                                                box
                                                auto-grow
                                        ></v-text-field>
                                    </v-form>
                                    <template v-if="newsletterSubscriptionDone">Comproveu el vostre email i seguiu les passes indicades!</template>
                                    <v-btn
                                            :loading="newsLetterLoading"
                                            class="darken-3 mt-2"
                                            :class="{ green: newsletterSubscriptionDone, orange: !newsletterSubscriptionDone }"
                                            dark
                                            large
                                            @click.native="addEmailToMailingList"
                                    >
                                        <v-icon v-if="!newsletterSubscriptionDone">mail_outline</v-icon>
                                        <v-icon v-else>done</v-icon>
                                        &nbsp;
                                        <template v-if="!newsletterSubscriptionDone">Apunta'm</template>
                                        <template v-else>Fet</template>
                                    </v-btn>
                                </v-card-text>
                            </v-card>
                        </template>
                    </v-layout>
                </v-parallax>
            </section>

            <section>
                <v-container>
                    <div id="googleMap" style="width:100%;height:400px;"></div>
                </v-container>
            </section>

            <v-footer class="primary darken-3">
                <v-layout row wrap align-center>
                    <v-flex xs12>
                        <div class="white--text ml-3">
                            Fet amb
                            <v-icon class="red--text">favorite</v-icon>
                            per <a class="white--text" href="https://github.com/acacha">Sergi Tur</a> utilitzant
                            <a class="white--text" href="https://github.com/laravel-frontend-presets/laravel-vuetify">Laravel Frontend Preset</a> per a <a class="white--text" href="https://vuetifyjs.com" target="_blank">Vuetify</a>.
                            Vegeu la <a class="white--text" href="https://laravel-vuetify.acacha.org/">demo</a>.
                        </div>
                    </v-flex>
                </v-layout>
            </v-footer>
        </v-content>
    </v-app>
</template>

<style scoped>
.facebook {
    width: 20px;
}
</style>

<script>
import { mapGetters } from 'vuex'
import * as actions from '../store/action-types'
import sleep from '../utils/sleep'
import LoginDialog from '../auth/LoginDialog'

export default {
  name: 'LandingPage',
  components: {
    'login-dialog': LoginDialog
  },
  data () {
      return {
        internalAction: this.action,
        loginLoading: false,
        loginErrors: [],
        registerLoading: false,
        registerErrors: [],
        valid: false,
        name: '',
        nameRules: [
          (v) => !!v || 'El nom d\'usuari és un camp obligatori',
          (v) => v.length <= 255 || 'El nom d\'usuari ha de tenir com a màxim 255 caracters'
        ],
        newsLetterLoading: false,
        newsletterSubscriptionDone: false,
        emailMailingList: '',
        emailRememberPassword: '',
        rememberPasswordLoading: false,
        rememberPasswordLoadingDone: false,
        rememberErrorMessage: '',
        rememberErrors: [],
        resetPasswordLoading: false,
        resetPasswordLoadingDone: false,
        resetErrorMessage: '',
        resetErrors: [],
        internalResetPasswordEmail: this.resetPasswordEmail,
        resetPassword: '',
        resetPasswordConfirmation: '',
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
        passwordConfirmation: '',
        passwordConfirmationRules: [
          (v) => !!v || 'La paraula de pas és obligatòria',
          (v) => v.length >= 6 || 'La paraula de pas ha de tenir com a mínim 6 caràcters'
        ],
        registerEmail: '',
        registerPassword: '',
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
      },
      resetPasswordToken: {
        type: String,
        default: null
      },
      resetPasswordEmail: {
        type: String,
        default: null
      }
    },
  computed: {
      ...mapGetters([
        'logged'
      ]),
      showResetPassword: {
        get () {
          if (this.internalAction && this.internalAction === 'reset_password') return true
          return false
        },
        set (value) {
          if (value) this.internalAction = 'reset_password'
          else this.internalAction = null
        }
      },
      showRememberPassword: {
        get () {
          if (this.internalAction && this.internalAction === 'request_new_password') return true
          return false
        },
        set (value) {
          if (value) this.internalAction = 'request_new_password'
          else this.internalAction = null
        }
      },
      showRegister: {
        get () {
          if (this.internalAction && this.internalAction === 'register') return true
          return false
        },
        set (value) {
          if (value) this.internalAction = 'register'
          else this.internalAction = null
        }
      },
      showLogin: {
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
      addEmailToMailingList () {
        this.newsLetterLoading = true
        this.$store.dispatch(actions.SUBSCRIBE_TO_NEWSLETTER, this.emailMailingList).then(response => {
          this.newsletterSubscriptionDone = true
        }).catch(error => {
          console.log(error)
          if (error.response.status !== 422) {
            this.newsletterSubscriptionDone = true
          }
        }).then(() => {
          this.newsLetterLoading = false
        })
      },
      register () {
        if (this.$refs.registrationForm.validate()) {
          this.registerLoading = true
          const user = {
            'name': this.name,
            'email': this.registerEmail,
            'password': this.registerPassword,
            'password_confirmation': this.passwordConfirmation,
            'givenName': this.givenName,
            'sn1': this.sn1,
            'sn2': this.sn2
          }
          this.$store.dispatch(actions.REGISTER, user).then(response => {
            this.registerLoading = false
            this.showRegister = false
            window.location = '/home'
          }).catch(() => {
            this.registerLoading = false
            this.registerErrors = error.response.data.errors
          })
        }
      },
      login () {
        if (this.$refs.loginForm.validate()) {
          this.loginLoading = true
          const credentials = {
            'email': this.email,
            'password': this.password
          }
          this.$store.dispatch(actions.LOGIN, credentials).then(response => {
            this.loginLoading = false
            this.showLogin = false
            window.location = '/home'
          }).catch(() => {
            this.loginLoading = false
          })
        }
      },
      rememberPassword () {
        this.rememberPasswordLoading = true
        this.$store.dispatch(actions.REMEMBER_PASSWORD, this.emailRememberPassword).then(response => {
          this.rememberPasswordLoading = false
          this.rememberPasswordLoadingDone = true
          sleep(4000).then(() => { this.showRememberPassword = false })
        }).catch(error => {
          this.rememberErrorMessage = error.response.data.message
          this.rememberErrors = error.response.data.errors
          console.log(error)
        }).then(() => {
          this.rememberPasswordLoading = false
        })
      },
      reset () {
        const user = {
          'email': this.internalResetPasswordEmail,
          'password': this.resetPassword,
          'password_confirmation': this.resetPasswordConfirmation,
          'token': this.resetPasswordToken
        }
        this.resetPasswordLoading = true
        this.$store.dispatch(actions.RESET_PASSWORD, user).then(response => {
          this.resetPasswordLoading = false
          this.resetPasswordLoadingDone = true
          sleep(4000).then(() => {
            this.showResetPassword = false
            window.location = '/home'
          })
        }).catch(() => {
          this.resetPasswordLoading = false
        })
      }
    }
}
</script>
