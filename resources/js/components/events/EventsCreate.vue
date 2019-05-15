<template>
    <span>
        <v-dialog v-model="createDialog" max-width="600px">
            <v-toolbar color="primary" class="white--text">
                <v-icon>card_giftcard</v-icon>
                <v-card-title class="headline">Crear esdeveniment</v-card-title>
            </v-toolbar>
            <v-card>
                  <v-card-text>
                      <v-container grid-list-md>
                          <v-layout wrap>
                              <v-flex xs12>
                                  <v-text-field v-model="name" label="Nom"></v-text-field>
                              </v-flex>
                              <v-flex xs12>
                                  <v-text-field v-model="inscription_type_id" label="Tipo Instripció"></v-text-field>
                              </v-flex>
                              <v-flex xs12>
                                  <v-text-field v-model="participants_number" label="Participants"></v-text-field>
                              </v-flex>
                               <v-flex xs12>
                                  <v-text-field v-model="regulation" label="Regulació"></v-text-field>
                              </v-flex>
                              <v-flex xs12>
                                  <session-select v-model="session"></session-select>
                              </v-flex>
                          </v-layout>
                      </v-container>
                  </v-card-text>
                  <v-card-actions>
                      <v-spacer></v-spacer>
                      <v-btn color="primary" flat @click="createDialog=false">
                          <v-icon class="mr-2">exit_to_app</v-icon>
                          Close</v-btn>
                      <v-btn @click="add" dark color="success dark" >
                          <v-icon class="mr-2">save</v-icon>
                          Save</v-btn>
                  </v-card-actions>

            </v-card>
        </v-dialog>
        <v-btn fab bottom right color="primary" fixed class="white--text"
               @click="showCreate">
            <v-icon>add</v-icon>
        </v-btn>
    </span>
</template>

<script>
import SessionSelect from '../SessionSelect.vue'
export default {

  name: 'EventsCreate',
  components: {
    'SessionSelect': SessionSelect
  },
  data () {
    return {
      dialog: false,
      createDialog: false,
      name: '',
      inscription_type_id: '',
      participants_number: '',
      regulation: '',
      session: ''
    }
  },
  methods: {
    showCreate () {
      this.createDialog = true
    },
    created (event) {
      this.$emit('created', event)
    },
    reset () {
      this.name = ''
      this.image = ''
      this.inscription_type_id = ''
      this.participants_number = null
      this.regulation = ''
      this.session = null
    },
    add () {
      this.loading = true
      window.axios.post('/api/v1/events/', {
        'name': this.name,
        'inscription_type_id': this.inscription_type_id,
        'participants_number': this.participants_number,
        'regulation': this.regulation,
        'session': this.session
      }).then((response) => {
        this.$snackbar.showMessage("S'ha creat l'esdeveniment")
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
