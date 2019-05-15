<template>
  <span>
    <v-dialog v-model="dialog" :fullscreen="$vuetify.breakpoint.smAndDown" @keydown.esc.stop.prevent="dialog=false">
      <v-toolbar color="primary" class="white--text">
      <v-btn flat icon class="white--text" @click="dialog=false">
        <v-icon>close</v-icon>
      </v-btn>
      <v-toolbar-title class="white--text">Crear col·laborador</v-toolbar-title>
      <v-spacer></v-spacer>
      </v-toolbar>
      <v-card>
        <v-card-text>
          <partner-create-form :uri="uri" @close="dialog =false" @created="created"></partner-create-form>
        </v-card-text>
      </v-card>
    </v-dialog>
    <v-btn
      v-can="'partners.store'"
      @click="dialog = true"
      fab
      bottom
      right
      fixed
      color="pink"
      class="white--text"
    >
      <v-icon>add</v-icon>
    </v-btn>
  </span>

</template>

<script>
import PartnerCreateForm from './PartnerCreateForm'

export default {
  name: 'PartnerCreate',
  components: {
    'partner-create-form': PartnerCreateForm
  },
  data () {
    return {
      dialog: false
    }
  },
  props: {
    uri: {
      type: String,
      required: true
    }
  },
  methods: {
    created (partner) {
      this.$emit('created', partner)
    }
  }
}
</script>

<style scoped>

</style>
