<template>
    <span>
        <v-dialog v-model="dialog" :fullscreen="$vuetify.breakpoint.smAndDown" transition="dialog-bottom-transition"
                  @keydown.esc="dialog=false" max-width="600px">
            <v-toolbar color="primary" class="white--text">
                <v-icon>edit</v-icon>
                <v-card-title class="headline">Editar esdeveniment</v-card-title>
            </v-toolbar>
            <v-card>
                <v-card-text>
                    <event-update-form :event="event" @close="dialog=false" @updated="updated"></event-update-form>
                </v-card-text>
            </v-card>
        </v-dialog>

        <v-btn icon color="accent" flat title="Actualitzar l'event" @click="dialog=true">
            <v-icon>edit</v-icon>
        </v-btn>

    </span>
</template>

<script>
import EventUpdateForm from './EventUpdateForm'
export default {
  'name': 'EventUpdate',
  components: {
    'event-update-form': EventUpdateForm
  },
  data () {
    return {
      dialog: false
    }
  },
  props: {
    event: {
      type: Object,
      required: true
    }
  },
  methods: {
    updated (event) {
      this.$emit('updated', event)
    }
  }
}
</script>
