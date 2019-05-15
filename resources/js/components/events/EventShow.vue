<template>
    <span>
        <v-dialog v-model="dialog" :fullscreen="$vuetify.breakpoint.smAndDown" transition="dialog-bottom-transition"
                  @keydown.esc="dialog=false" max-width="600px">
            <v-toolbar color="primary" class="white--text">
                <v-icon>visibility</v-icon>
                <v-card-title class="headline">Mostrar esdeveniment</v-card-title>
            </v-toolbar>
            <v-card>
                <v-card-text>
                    <event-show-form :event="event" @close="dialog=false"></event-show-form>
                </v-card-text>
            </v-card>
        </v-dialog>
        <v-btn icon color="success" flat title="Mostrar l'esdeveniment" @click="dialog=true">
            <v-icon>visibility</v-icon>
        </v-btn>
    </span>
</template>

<script>
import EventShowForm from './EventShowForm'

export default {
  'name': 'EventShow',
  components: {
    'event-show-form': EventShowForm
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
    show (event) {
      this.$emit('show', event)
    }
  }
}
</script>
