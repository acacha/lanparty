<template>
    <span>
        <v-dialog v-model="createDialog" max-width="600px">
                    <v-card>
                        <v-toolbar dark color="pink">
                            <v-icon>card_giftcard</v-icon>
                            <v-toolbar-title>NOU PREMI</v-toolbar-title>

                        </v-toolbar>
                        <v-spacer></v-spacer>

                        <v-card-text>
                            <v-container grid-list-md>
                                <v-layout wrap>
                                    <v-flex xs12>
                                        <v-text-field prepend-icon="videogame_asset" v-model="selectedPrize.name" label="Nom"></v-text-field>
                                    </v-flex>
                                    <v-flex xs12>
                                        <v-text-field prepend-icon="description" v-model="selectedPrize.description" label="Descripcio"></v-text-field>
                                    </v-flex>
                                    <v-flex xs12>
                                        <v-text-field prepend-icon="event_note" v-model="selectedPrize.notes" label="Notes"></v-text-field>
                                    </v-flex>
                                    <v-flex xs12>
                                        <v-text-field prepend-icon="poll" v-model="selectedPrize.valor" label="Valor"></v-text-field>
                                    </v-flex>
                                     <v-flex xs12>
                                        <v-text-field prepend-icon="devices_other" v-model="selectedPrize.patrocinador" label="patrocinador"></v-text-field>
                                    </v-flex>
                                    <v-flex xs12>
                                        <v-text-field prepend-icon="account_circle" v-model="selectedPrize.usuari" label="Usuari"></v-text-field>
                                    </v-flex>
                                    <v-flex xs12>
                                        <v-text-field prepend-icon="filter_9_plus" v-model="selectedPrize.numero" label="Numero"></v-text-field>
                                    </v-flex>
                                    <v-flex xs12>
                                        <v-checkbox v-model="selectedPrize.multiple" label="Multiple"></v-checkbox>
                                    </v-flex>
                                </v-layout>
                            </v-container>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="primary" flat @click="createDialog=false">
                                <v-icon class="mr-2">exit_to_app</v-icon>
                                Close</v-btn>
                            <v-btn @click="add" dark color="green dark" flat >
                                <v-icon class="mr-2">save</v-icon>
                                Save</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
           <v-btn
                  @click="showCreate"
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
    </span>
</template>

<script>
  export default {
    name: 'PrizessCreate',
    data () {
      return {
        dialog: false,
        createDialog: false,
        selectedPrize: {
          name: '',
          description: '',
          notes: '',
          valor:'',
          patrocinador:'',
          usuari:'',
          numero:'',
          multiple: false
        }
      }
    },
    props: {
      // users: {
      //   type: Array,
      //   required: true
      // },
      uri: {
        type: String,
        default: '/api/v1/prizes'
      }
    },
    methods: {
      showCreate () {
        this.createDialog = true
      },
      reset () {
        this.name = ''
        this.description = ''
        this.notes = ''
        this.valor = ''
        this.patrocinador = null
        this.user = null
        this.numero = ''
        this.multiple = false
      },
      add () {
        this.loading = true
        const prize = {
          'name': this.name,
          'description': this.description,
          'notes': this.notes,
          'valor': this.valor,
          'patrocinador': this.patrocinador.id,
          'usuari': this.user.id,
          'numero': this.numero,
          'multiple': this.multiple
        }
        window.axios.post(this.uri + '/', prize).then((response) => {
          this.$snackbar.showMessage("S'ha creat correctament el premi")
          this.reset()
        }).catch((error) => {
          this.loading = false
        }).finally(() => {
          this.loading = false
        })
      }
    }
  }
</script>
