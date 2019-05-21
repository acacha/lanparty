<template>
  <span>
    <v-dialog v-model="dialog" @keydown.esc="dialog=false" :fullscreen="$vuetify.breakpoint.smAndDown">
      <v-toolbar color="primary" class="white--text">
        <v-btn flat icon class="white--text" @click="dialog=false">
          <v-icon>close</v-icon>
        </v-btn>
        <v-toolbar-title class="white--text">Premis</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-btn flat class="white--text" @click="dialog=false">
          <v-icon class="mr-1">exit_to_app</v-icon>
          Sortir
        </v-btn>
      </v-toolbar>
      <v-card>
        <v-card-text>
          <prize-show-form :prize="prize" :users="users" :partners="partners"></prize-show-form>
        </v-card-text>
      </v-card>
    </v-dialog>
    <v-btn icon color="blue" flat title="Mostrar premi" @click="dialog=true">
      <v-icon>visibility</v-icon>
    </v-btn>
  </span>
</template>

<script>
import PrizesShowForm from './PrizesShowForm'

export default {
  name: 'PartnerShow',
  components: {
    'prize-show-form': PrizesShowForm
  },
  data () {
    return {
      dialog: false
    }
  },
  props: {
    prize: {
      type: Object,
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
  }
}
</script>

<style scoped>

</style>
