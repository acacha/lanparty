<template>
    <div>
        <v-container fluid grid-list-md v-show="showSelectedUser">
            <v-layout row wrap>
                <v-flex xs12 md4>
                    <v-card flat class="elevation-5">
                        <v-card-title class="primary darken-3 white--text"><h4>User</h4></v-card-title>
                        <v-container fluid grid-list-md>
                            <v-layout row wrap>
                                <v-flex xs12 md4>
                                    <gravatar :user="selectedUser" size="100px"></gravatar>
                                </v-flex>
                                <v-flex xs12 md8 >
                                    <h3>{{ selectedUser.name }}</h3>
                                    <p class="text-xs-center">
                                        <payments-switch :session="session"></payments-switch>
                                    </p>
                                </v-flex>
                            </v-layout>
                        </v-container>
                        <v-card-text class="px-0">
                            <v-form class="pl-3 pr-1 ma-0">
                                <v-text-field readonly
                                              label="Id"
                                              :value="selectedUser.id"
                                              readonly
                                ></v-text-field>
                                <v-text-field readonly
                                              label="Email"
                                              :value="selectedUser.email"
                                              readonly
                                ></v-text-field>
                                <v-text-field readonly
                                              label="Nom usuari"
                                              :value="selectedUser.name"
                                              readonly
                                ></v-text-field>
                                <v-text-field readonly
                                              label="Nom"
                                              :value="selectedUser.givenName"
                                              readonly
                                ></v-text-field>
                                <v-text-field readonly
                                              label="1r cognom"
                                              :value="selectedUser.sn1"
                                              readonly
                                ></v-text-field>
                                <v-text-field readonly
                                              label="2n cognom"
                                              :value="selectedUser.sn2"
                                              readonly
                                ></v-text-field>
                                <v-text-field
                                        label="Data creació"
                                        :value="selectedUser.formatted_created_at_date"
                                        readonly
                                ></v-text-field>
                            </v-form>
                        </v-card-text>
<!--                        TODO-->
<!--                        <v-card-actions>-->
<!--                            <v-btn flat color="orange">Modificar</v-btn>-->
<!--                            <v-btn flat color="orange">Esborrar</v-btn>-->
<!--                        </v-card-actions>-->
                    </v-card>
                </v-flex>
                <v-flex xs12 md8>
                    <numbers-manage :session="session"></numbers-manage>
                    <user-inscriptions :events="events" :session="session"></user-inscriptions>
                </v-flex>
            </v-layout>

        </v-container>
    </div>
</template>

<style>

</style>

<script>
  import { mapGetters } from 'vuex'
  import _ from 'lodash'
  import interactsWithGravatar from './mixins/interactsWithGravatar'
  import Gravatar from './GravatarComponent.vue'
  import PaymentsSwitch from './payments/PaymentsSwitch'
  import UserInscriptions from './users/UserInscriptions'
  import NumbersManage from './numbers/NumbersManage'
  export default {
    name: 'ManageUser',
    mixins: [ interactsWithGravatar ],
    components: {
      Gravatar,
      'payments-switch': PaymentsSwitch,
      'user-inscriptions': UserInscriptions,
      'numbers-manage': NumbersManage
    },
    props: {
      session: {
        type: String,
        required: true
      },
      events: {
        type: Array,
        required: true
      }
    },
    computed: {
      ...mapGetters(['selectedUser']),
      showSelectedUser () {
        return !_.isEmpty(this.selectedUser)
      }
    }
}
</script>
