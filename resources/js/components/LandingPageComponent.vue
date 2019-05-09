<template>
    <v-app light>
        <snackbar></snackbar>
        <v-toolbar class="white">
            <v-toolbar-title class="hidden-xs-only">Institut de l'Ebre LAN PARTY</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn href="/programa" target="_blank" flat>
                Programa
            </v-btn>
            <v-btn class="hidden-xs-only" @click="$vuetify.goTo('#competicions')" flat>
                Competicions
            </v-btn>
            <v-btn class="hidden-xs-only" href="#premis" flat>
                Premis
            </v-btn>
            <v-btn class="hidden-xs-only" href="#colaboradors" flat>
                Col·laboradors
            </v-btn>
            <v-btn href="https://www.facebook.com/LanPartyIesEbre" target="_blank" flat icon color="primary">
                <v-icon>fab fa-facebook</v-icon>
            </v-btn>
            <v-btn class="hidden-xs-only" @click="$vuetify.goTo('#contacte')" flat>
                <v-icon class="mr-2">email</v-icon> Contacte
            </v-btn>
            <v-btn class="hidden-xs-only" @click="$vuetify.goTo('#onsom')" flat>
                <v-icon class="mr-2" >place</v-icon> On som?
            </v-btn>
            <v-spacer></v-spacer>
            <login-dialog :action="action" :registrations-enabled="registrationsEnabled"></login-dialog>
            <register-dialog :action="action" :registrations-enabled="registrationsEnabled"></register-dialog>
            <remember-password-dialog :action="action"></remember-password-dialog>
            <reset-password-dialog :action="action" :email="resetPasswordEmail" :reset-password-token="resetPasswordToken"></reset-password-dialog>
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
                                <register-dialog :action="action" :registrations-enabled="registrationsEnabled" color="orange darken-3 mt-2" :large="true" :dark="true"></register-dialog>
                            </template>
                            <template v-else>
                                <mailing-list-card></mailing-list-card>
                            </template>
                        </template>
                    </v-layout>
                </v-parallax>
            </section>

            <section id="competicions" style="background-color: white">
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
                            </span><br>
                            <v-btn
                                    href="/programa"
                                    target="_blank"
                                    color="accent"
                            >Programació de tots els esdeveniments</v-btn>
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
                                            <img src="/img/Fifa19a.webp" alt="Fifa 19" width="200px;">
                                        </v-card-text>
                                        <v-card-title primary-title class="layout justify-center">
                                            <div class="headline text-xs-center">Fifa 19</div>
                                        </v-card-title>
                                        <v-card-text>
                                            Saga de videojocs de futbol, iniciada per la companyia EA, que va portar com a novetat la llicència de la FIFA per utilitzar jugadors i lligues amb noms reals.
                                            Més informació a la <a href="https://www.easports.com/es/fifa/">pàgina oficial</a>
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
                            <mailing-list-card></mailing-list-card>
                        </template>
                    </v-layout>
                </v-parallax>
            </section>

            <section id="contacte">
                <v-container>
                <v-flex
                            xs8
                            offset-xs2
                    >
                        <v-card>
                            <v-card-title primary-title>
                                <div>
                                    <h3 class="headline mb-0">Contacte</h3>
                                </div>
                            </v-card-title>

                            <v-card-text>
                                <v-list>
                                    <v-list-tile>
                                        <v-list-tile-avatar
                                                color="accent"
                                        >
                                            <v-icon
                                                    class="elevation-4"
                                                    dark
                                            >
                                                email
                                            </v-icon>
                                        </v-list-tile-avatar>
                                        <v-list-tile-title>CORREU</v-list-tile-title>
                                        <v-list-tile-sub-title>
                                            INFORMATICA@IESEBRE.COM
                                        </v-list-tile-sub-title>
                                    </v-list-tile>
                                    <v-list-tile>
                                        <v-list-tile-avatar
                                                color="accent"
                                        >
                                            <v-icon
                                                    class="elevation-4"
                                                    dark
                                            >
                                                place
                                            </v-icon>
                                        </v-list-tile-avatar>
                                        <v-list-tile-title>ADREÇA</v-list-tile-title>
                                        <v-list-tile-sub-title>
                                            AV. COLOM 34-42 43500 TORTOSA
                                        </v-list-tile-sub-title>
                                    </v-list-tile>
                                    <v-list-tile>
                                        <v-list-tile-avatar
                                                color="accent"
                                        >
                                            <v-icon
                                                    class="elevation-4"
                                                    dark
                                            >
                                                phone
                                            </v-icon>
                                        </v-list-tile-avatar>
                                        <v-list-tile-title>TELÈFON</v-list-tile-title>
                                        <v-list-tile-sub-title>
                                            977500949 Fax: 977503064
                                        </v-list-tile-sub-title>
                                    </v-list-tile>
                                </v-list>

                            </v-card-text>
                        </v-card>
                    </v-flex>
                </v-container>
            </section>

            <section id="onsom">
                <v-container>
                    <div id="googleMap" style="width:100%;height:400px;"></div>
                </v-container>
            </section>

            <section id="premis">
                <v-container>
                    <v-card>
                        <prizes :prizes="internalPrizes"></prizes>
                    </v-card>
                </v-container>
            </section>


            <section id="colaboradors">
                <v-container>
                    <v-container>
                        <v-card>
                            <partners :partners="internalPartners"></partners>
                        </v-card>
                    </v-container>
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
import LoginDialog from '../auth/LoginDialog'
import RegisterDialog from '../auth/RegisterDialog'
import RememberPasswordDialog from '../auth/RememberPasswordDialog'
import ResetPasswordDialog from '../auth/ResetPasswordDialog'
import MailingListCard from '../mailing/MailingListCard'
import prizes from './PrizesComponent'
import partners from './PartnersComponent'

export default {
  data () {
    return {
      internalPrizes: this.prizes,
      internalPartners: this.partners
    }
  },
  name: 'LandingPage',
  components: {
    'login-dialog': LoginDialog,
    'register-dialog': RegisterDialog,
    'remember-password-dialog': RememberPasswordDialog,
    'reset-password-dialog': ResetPasswordDialog,
    'mailing-list-card': MailingListCard,
    'prizes': prizes,
    'partners': partners
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
      },
      prizes: {
        type: Array,
        default: null
      },
      partners: {
        type: Array,
        default: null
      }
    },
  computed: {
    ...mapGetters([
      'logged'
    ])
  }
}
</script>
