<template>
    <span>
        <v-flex xs12 justify-center>
                <v-card>
                    <v-toolbar  dark color="primary">
                        <v-icon style="margin-right: 1%">card_giftcard</v-icon>
                        <v-icon>sentiment_satisfied_alt</v-icon>
                        <v-toolbar-title>Premis</v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-flex lg3 style="margin-top: 1%;">
                            <v-text-field
                                    append-icon="search"
                                    v-model="search"
                                    label="Buscar"
                                    color="white"

                            ></v-text-field>
                        </v-flex>
                        <v-btn icon class="white--text" @click="refresh" :loading="loading" :disabled="loading">
                            <v-icon>refresh</v-icon>
                        </v-btn>
                    </v-toolbar>

                    <v-card-text class="px-0">
                        <v-data-table
                                :headers="headers"
                                :search="search"
                                :items="dataPrizes"
                                no-results-text="No s'ha trobat cap registre"
                                no-data-text="No hiha dades disponibles"
                                rows-per-page-text="prizes per pagina"
                                :rows-per-page-items="[5,10,25,50,100,200,{'text':'tots','value':-1}]"
                                :loading="loading"
                                :pagination.sync="pagination"
                                class="hidden-md-and-down"
                        >
                            <v-progress-linear slot="progress" color="pink" indeterminate></v-progress-linear>
                            <template slot="items" slot-scope="{item: prize}">
                            <tr>

                                <td>{{ prize.id}}</td>
                                <td class="text-xs-left" :title="prize.description" >{{ prize.name}}</td>
                                <td class="text-xs-left">{{ prize.notes}}</td>
                                <td class="text-xs-left">{{ prize.value}}</td>
                                <td class="text-xs-left">{{ prize.partner_name}}</td>
                                <td class="text-xs-left">{{ prize.user_name}}</td>
                                <td class="text-xs-left">{{ prize.number_id}}</td>
                                <td class="text-xs-left">{{prize.session}}</td>
                                <td  class="text-xs-center" v-if="prize.multiple == '1'">Si</td>
                                <td   class="text-xs-center" v-else>No</td>
                                <td class="d-flex">
                                    <prizes-show :partners="partners" :users="users" :prize="prize"></prizes-show>
                                    <prizes-update :partners="partners" :uri="uri" :users="users" @updated="updatePrize" :prize="prize"></prizes-update>
                                    <prizes-delete :uri="uri" :prize="prize" @deleted="removePrize"></prizes-delete>
                                 </td>
                                </tr>
                            </template>
                        </v-data-table>
                    </v-card-text>
                </v-card>
            </v-flex>
        </span>
</template>


<script>
  import PrizesDelete from "./PrizesDelete"
  import PrizesUpdate from "./PrizesUpdate"
  import PrizesShow from "./PrizesShow"

  export default {
    name: 'PrizesManage',
    components: {
      'prizes-delete': PrizesDelete,
      'prizes-update': PrizesUpdate,
      'prizes-show': PrizesShow
    },
    data() {
      return {
        search: '',
        pagination: {
          rowsPerPage: 6
        },
        createDialog: false,
        dataPrizes: this.prizes,
        loading: false,
        creating: false,
        editing: false,
        removing: false,
        headers: [
          {text: 'Id', value: 'id', align: 'left', sortable: true},
          {text: 'Nom', value: 'name', align: 'left', sortable: true},
          // {text: 'Description', value: 'description', align: 'left', sortable: true},
          {text: 'Notes', value: 'notes', align: 'left', sortable: true},
          {text: 'Valor', value: 'value', align: 'left', sortable: true},
          {text: 'Patrocinador', value: 'partner_id', align: 'left', sortable: true},
          {text: 'Usuari', value: 'user_id', align: 'left', sortable: true},
          {text: 'Numero', value: 'number_id', align: 'left', sortable: true},
          { text: 'SESSION', value: 'session' },
          {text: 'Multiple', value: 'multiple', align: 'left', sortable: true},
          {text: 'Actions', align: 'left', sortable: false}
        ]
      }
    },
    computed: {
      total() {
      },
    },
    props: {
      prizes: {
        type: Array,
        required: true
      },
      uri: {
        type: String,
        required: true
      },
      partners: {
        type: Array,
        required: true
      },
      users: {
        type: Array,
        required: true
      }
    },
    methods: {
      removePrize (prize) {
        this.dataPrizes.splice(this.dataPrizes.indexOf(prize), 1)
      },
      updatePrize (task) {
        this.refresh()
      },
      refresh() {
        this.loading = true
        window.axios.get('/api/v1/prizes').then(response => {
          this.dataPrizes = response.data
          this.loading = false
          this.$snackbar.showMessage('Premis actualitzats correctament')
        }).catch(error => {
          this.$snackbar.showError(error)
          this.loading = false
        })
      }
    }

  }
</script>

<style scoped>

</style>
