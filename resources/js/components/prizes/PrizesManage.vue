<template>
    <span>
        <v-flex xs12 justify-center>
                <v-card>
                    <v-toolbar  dark color="green light">
                        <v-icon>thumb_up</v-icon>
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
                                <td>{{ prize.id}}</td>
                                <td class="text-xs-left">{{ prize.name}}</td>
                                <td class="text-xs-left">{{ prize.description}}</td>
                                <td class="text-xs-center">{{ prize.notes}}</td>
                                <td class="text-xs-center">{{ prize.value}}</td>
                                <td class="text-xs-center">{{ prize.partner_id}}</td>
                                <td class="text-xs-center">{{ prize.user_id}}</td>
                                <td class="text-xs-center">{{ prize.number_id}}</td>
                                <td class="text-xs-center">{{ prize.multiple}}</td>
                                <td class="text-xs-center">
                                        <v-btn icon flat title="Mostrar la tag"
                                               >
                                            <v-icon color="green">visibility</v-icon>
                                        </v-btn>
                                        <v-btn  icon flat title="Editar la tag"
                                               >
                                            <v-icon color="primary">edit</v-icon>
                                        </v-btn>
                                        <v-btn  icon flat title="Eliminar la tag"
                                               >
                                            <v-icon title="Delete tag" color="red">delete</v-icon>
                                        </v-btn>
                                    </td>
                            </template>
                        </v-data-table>
                    </v-card-text>
                </v-card>
                <v-btn
                        fab
                        bottom
                        right
                        fixed
                        large
                        color="pink accent-3"
                        class="white--text "
                >
                    <v-icon>add</v-icon>
                </v-btn>
            </v-flex>
        </span>
</template>


<script>
  export default {
    name: 'PrizesManage',
    data() {
      return {
        search: '',
        pagination: {
          rowsPerPage: 10
        },
        dataPrizes: this.prizes,
        loading: false,
        creating: false,
        editing: false,
        removing: false,
        headers: [
          {text: 'Id', value: 'id', align: 'left', sortable: true},
          {text: 'Nom', value: 'name', align: 'left', sortable: true},
          {text: 'Description', value: 'description', align: 'left', sortable: true},
          {text: 'Notes', value: 'notes', align: 'left', sortable: true},
          {text: 'Valor', value: 'value', align: 'left', sortable: true},
          {text: 'Patrocinador', value: 'partner_id', align: 'left', sortable: true},
          {text: 'Usuari', value: 'user_id', align: 'left', sortable: true},
          {text: 'Numero', value: 'number_id', align: 'left', sortable: true},
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
      }
    },
      methods: {
        refresh() {
          this.loading = true
          window.axios.get('/api/v1/prizes').then(response => {
            this.dataTags = response.data
            this.loading = false
            this.$snackbar.showMessage("S'han actualitzat correctament els tags ")
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
