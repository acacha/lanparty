<template>
  <span>
    <v-dialog v-model="dialog" @keydown.esc="dialog=false" :fullscreen="$vuetify.breakpoint.smAndDown">
      <v-toolbar color="primary" class="white--text">
        <v-btn flat icon class="white--text" @click="dialog=false">
          <v-icon>close</v-icon>
        </v-btn>
        <v-toolbar-title class="white--text">Col·laborador</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-btn flat class="white--text" @click="dialog=false">
          <v-icon class="mr-1">exit_to_app</v-icon>
          SORTIR
        </v-btn>
      </v-toolbar>
      <v-card>
        <v-card-text>
          <partner-show-form :partner="partner"></partner-show-form>
        </v-card-text>
      </v-card>
    </v-dialog>
    <v-btn icon color="blue" flat title="Mostrar col·laborador" @click="dialog=true">
      <v-icon>visibility</v-icon>
    </v-btn>
  </span>
</template>

<script>
import PartnerShowForm from './PartnerShowForm'

export default {
  name: 'PartnerShow',
  components: {
    'partner-show-form': PartnerShowForm
  },
  data () {
    return {
      dialog: false
    }
  },
  props: {
    partner: {
      type: Object,
      required: true
    }
  }
}
</script>

<style scoped>

</style>
