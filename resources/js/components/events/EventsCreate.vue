<template>
    <span>
        <v-dialog v-model="dialog" hide-overlay transition="dialog-bottom-transition"
                  @keydown.esc.stop.prevent="dialog=false">
            <v-toolbar color="primary" class="white--text">
                <v-btn flat icon class="white--text" @click="dialog=false">
                    <v-icon class="mr-2">close</v-icon>
                </v-btn>
                <v-card-title class="headline">Crear event</v-card-title>
                <v-spacer></v-spacer>
                <v-btn flat class="white--text" @click="dialog=false">
                    <v-icon class="mr-2">exit_to_app</v-icon>
                    Sortir
                </v-btn>
                <v-btn flat class="white--text">
                    <v-icon class="mr-2">save</v-icon>
                    Guardar
                </v-btn>
            </v-toolbar>
            <v-card>
                <v-card-text>
                    <event-form @close="dialog=false" @created="created"></event-form>
                </v-card-text>
            </v-card>
        </v-dialog>
        <v-btn fab bottom right color="primary" fixed class="white--text"
               @click="dialog = true">
            <v-icon>add</v-icon>
        </v-btn>
    </span>
</template>

<script>
import EventForm from './EventForm'
export default {
  name: 'EventsCreate',
  components: {
    'event-form': EventForm
  },
  data () {
    return {
      dialog: false
    }
  },
  methods: {
    created (event) {
      this.$emit('created', event)
    }
  }
}
</script>
