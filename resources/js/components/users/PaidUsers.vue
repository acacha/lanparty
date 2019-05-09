<template>
    <span>
        <v-tooltip bottom>
            <v-chip label slot="activator" color="success darken-3" text-color="white" @click="dialog = true" style="height: 40px;">
                <v-icon left>group</v-icon>Pagats: {{ this.paidInternalusers.length }}
            </v-chip>
            <span>Usuaris que han realitzat el pagament per a la sessió: {{ session }}</span>
        </v-tooltip>
        <v-dialog
                v-model="dialog"
                fullscreen
        >
          <v-card>
            <v-card-title
                    class="title primary darken-3 white--text"
                    primary-title
            >
              Llista d'usuaris pagats. Sessió: {{ session }}
            </v-card-title>

            <v-card-text>
                <v-layout>
                    <v-flex xs6 offset-xs3>
                        <v-text-field
                                append-icon="search"
                                label="Buscar"
                                single-line
                                hide-details
                                v-model="search"
                        ></v-text-field>
                    </v-flex>
                </v-layout>

                <v-data-table
                        :items="paidInternalusers"
                        :headers="headers"
                        :search="search"
                        no-results-text="No s'ha trobat cap registre coincident"
                        no-data-text="No hi han dades disponibles"
                        rows-per-page-text="Usuaris per pàgina"
                        :rows-per-page-items="[5,10,25,50,100,{'text':'Tots','value':-1}]"
                        :pagination.sync="pagination">
                    <v-progress-linear slot="progress" color="primary" indeterminate></v-progress-linear>
                    <template slot="items" slot-scope="{item:user}">
                      <tr>
                        <td>
                          {{user.id}}
                        </td>
                        <td>
                          <v-avatar>
                            <img :src="gravatarURL(user.email)">
                        </v-avatar>
                        </td>
                        <td>
                          {{user.name}}
                        </td>
                        <td>
                          {{ user.givenName }}
                        </td>
                        <td>
                          {{ user.sn1 }}
                        </td>
                        <td>
                          {{ user.sn2 }}
                        </td>
                        <td>
                          {{ user.email }}
                        </td>
                        <td>
                          {{ priceInEuros(user.total_to_pay) }}
                        </td>
                        <td class="text-xs-left cell" :title="user.formatted_created_at">
                            <v-tooltip bottom>
                                <span slot="activator">{{ user.formatted_created_at_diff }}</span>
                                <span>{{ user.formatted_created_at }}</span>
                            </v-tooltip>
                        </td>
                        <td class="text-xs-left cell" :title="user.formatted_updated_at">
                            <v-tooltip bottom>
                                <span slot="activator">{{ user.formatted_updated_at_diff }}</span>
                                <span>{{ user.formatted_updated_at }}</span>
                            </v-tooltip>
                        </td>
                      </tr>
                    </template>
                </v-data-table>
            </v-card-text>

            <v-divider></v-divider>

            <v-card-actions>
              <v-container grid-list-md text-xs-center>
                <v-layout>
                    <v-flex xs6 offset-xs3 alig>
                        <v-btn
                                color="primary"
                                @click="dialog = false"
                        >
                        Tancar
                      </v-btn>
                    </v-flex>
                </v-layout>
              </v-container>
            </v-card-actions>
          </v-card>
        </v-dialog>
    </span>
</template>

<script>
import interactsWithGravatar from '../mixins/interactsWithGravatar'
import helpers from '../../utils/helpers'
export default {
  name: 'PaidUsers',
  mixins: [ interactsWithGravatar ],
  data () {
    return {
      dialog: false,
      search: '',
      pagination: {
        rowsPerPage: 25
      },
      headers: [
        { text: 'Id', value: 'id' },
        { text: 'Avatar', value: 'avatar' },
        { text: "Nom d'usuari", value: 'name' },
        { text: 'Nom', value: 'givenName' },
        { text: 'Cognom 1', value: 'sn1' },
        { text: 'Cognom 2', value: 'sn2' },
        { text: 'Correu electrònic', value: 'email' },
        { text: 'Total a pagar', value: 'total_to_pay' },
        { text: 'Creat', value: 'created_at' },
        { text: 'Modificat', value: 'updated_at' }
      ]
    }
  },
  props: {
    session: {
      type: String,
      required: true
    }
  },
  computed: {
    paidInternalusers() {
      return this.$store.getters.users.filter((user) => {
        return user.inscription_paid.includes(this.session)
      })
    }
  },
  methods: {
    priceInEuros(price) {
      return helpers.priceInEuros(price)
    }
  }
}
</script>
