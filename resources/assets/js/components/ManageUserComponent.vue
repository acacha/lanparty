<template>
    <v-container fluid grid-list-md class="grey lighten-4" v-show="show">
        <v-layout row wrap>
            <v-flex xs12 md4>
                <v-card>
                    <v-card-title class="blue darken-1 white--text"><h4>User</h4></v-card-title>
                    <v-container fluid grid-list-md class="grey lighten-4" v-show="show">
                        <v-layout row wrap>
                            <v-flex xs12 md4>
                                <gravatar :user="selectedUser" size="100px"></gravatar>
                            </v-flex>
                            <v-flex xs12 md8>
                                <h3>{{ selectedUser.name }}</h3>
                                <v-switch label="Pagat" v-model="payed"></v-switch>
                            </v-flex>
                        </v-layout>
                    </v-container>
                    <v-card-text class="px-0 grey lighten-3">
                        <v-form class="pl-3 pr-1 ma-0">
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
                    <v-card-actions>
                        <v-btn flat color="orange">Modificar</v-btn>
                        <v-btn flat color="orange">Esborrar</v-btn>
                    </v-card-actions>
                </v-card>
            </v-flex>
            <v-flex xs12 md8>
                <v-card class="mb-2">
                    <v-card-title class="blue darken-1 white--text"><h4>Numbers</h4></v-card-title>
                        <v-list>
                            <v-list-tile v-for="numbers in selectedUser.numbers" v-bind:key="numbers.title" @click="">
                                <v-list-tile-content>
                                    <v-chip color="orange" text-color="white" >
                                        {{ numbers.value }}
                                        <v-icon right>star</v-icon>
                                    </v-chip>
                                </v-list-tile-content>
                                <v-list-tile-content>
                                    <v-list-tile-title> Motiu </v-list-tile-title>
                                </v-list-tile-content>
                                <v-list-tile-content>
                                    <v-list-tile-title> Data assignació</v-list-tile-title>
                                </v-list-tile-content>
                                <v-list-tile-action>
                                    <v-icon right>delete</v-icon>
                                </v-list-tile-action>
                            </v-list-tile>
                        </v-list>

                    <v-card-actions class="white">
                        <v-spacer></v-spacer>
                        <v-btn icon>
                            <v-icon>add_circle</v-icon>
                        </v-btn>
                        <v-btn icon>
                            <v-icon>remove_circle</v-icon>
                        </v-btn>
                    </v-card-actions>
                </v-card>
                <v-card>
                    <v-card-title class="blue darken-1 white--text"><h4>Inscripcions</h4></v-card-title>
                    <v-list>
                        <v-list-tile avatar v-for="numbers in selectedUser.numbers" v-bind:key="numbers.title" @click="">
                            <v-list-tile-avatar>
                                <img src="/img/CounterStrike.png">
                            </v-list-tile-avatar>
                            <v-list-tile-content>
                                <v-list-tile-title> Counter Strike </v-list-tile-title>
                            </v-list-tile-content>
                            <v-list-tile-content>
                                <v-list-tile-title> Data inscripció</v-list-tile-title>
                            </v-list-tile-content>
                            <v-list-tile-action>
                                <v-icon right>delete</v-icon>
                            </v-list-tile-action>
                        </v-list-tile>
                    </v-list>
                    <v-card-actions class="white">
                        <v-spacer></v-spacer>
                        <v-btn icon>
                            <v-icon>add_circle</v-icon>
                        </v-btn>
                        <v-btn icon>
                            <v-icon>remove_circle</v-icon>
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-flex>
        </v-layout>

    </v-container>

</template>

<style>

</style>

<script>
  import { mapGetters } from 'vuex'
  import _ from 'lodash'
  import interactsWithGravatar from './mixins/interactsWithGravatar'
  import Gravatar from './GravatarComponent.vue'

  export default {
    name: 'ManageUser',
    mixins: [ interactsWithGravatar ],
    components: { Gravatar },
    data () {
      return {
        payed: 'false'
      }
    },
    computed: {
      ...mapGetters(['selectedUser']),
      show () {
        return !_.isEmpty(this.selectedUser)
      }
    }
  }
</script>
