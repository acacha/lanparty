<template>
  <span>
      <v-dialog v-model="createDialog" max-width="600px">
                  <v-card>
                      <v-toolbar dark color="pink">
                          <v-icon>card_giftcard</v-icon>
                          <v-toolbar-title>Nou Esdeveniment</v-toolbar-title>
                      </v-toolbar>
                      <v-spacer></v-spacer>
                      <v-card-text>
                          <v-container grid-list-md>
                              <v-layout wrap>
                                  <v-flex xs12>
                                      <v-text-field v-model="selectedEvent.name" label="Nom"></v-text-field>
                                  </v-flex>
                                  <v-flex xs12>
                                      <v-text-field v-model="selectedEvent.image" label="Descripcio"></v-text-field>
                                  </v-flex>
                                  <v-flex xs12>
                                      <v-text-field v-model="selectedEvent.inscription_type_id" label="Tipo Instripció"></v-text-field>
                                  </v-flex>
                                  <v-flex xs12>
                                      <v-text-field v-model="selectedEvent.participants_number" label="Participants"></v-text-field>
                                  </v-flex>
                                   <v-flex xs12>
                                      <v-text-field v-model="selectedEvent.regulation" label="Regulació"></v-text-field>
                                  </v-flex>
                                  <v-flex xs12>
                                      <v-text-field v-model="selectedEvent.session" label="Sessió"></v-text-field>
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
  name: 'EventForm',
  data () {
    return {
      dialog: false,
      createDialog: false,
      selectedEvent: {
        name: '',
        image: '',
        inscription_type_id: '',
        participants_number:'',
        regulation:'',
        session:''
      }
    }
  },
  methods: {
    showCreate () {
      this.createDialog = true
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
      const event = {
        'name': this.name,
        'image': this.image,
        'inscription_type_id': this.inscription_type_id,
        'participants_number': this.participants_number,
        'regulation': this.regulation,
        'session': this.session
      }
      window.axios.post('/api/v1/events/', event).then((response) => {
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
