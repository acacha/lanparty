<template>
  <span>
    <v-dialog v-model="dialog"
              :fullscreen="$vuetify.breakpoint.smAndDown"
              @keydown.esc="dialog=false">
      <v-toolbar color="primary" class="white--text">
        <v-btn flat icon class="white--text" @click="dialog=false">
          <v-icon class="mr-1">close</v-icon>
        </v-btn>
        <v-toolbar-title class="white--text">Modificar col·laborador</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-btn flat class="white--text" @click="dialog=false">
          <v-icon class="mr-1">exit_to_app</v-icon>
          SALIR
        </v-btn>
      </v-toolbar>
      <v-card>
        <v-card-text>
          <partner-update-form :partner="partner" :uri="uri" @close="dialog = false" @updated="updated"></partner-update-form>
        </v-card-text>
      </v-card>
    </v-dialog>
    <!--v-if="$can('partners.update',partner)"-->
    <v-btn
      icon
      color="pink"
      flat
      title="Editar col·laborador"
      @click="dialog=true"
    ><v-icon>edit</v-icon></v-btn>
  </span>
</template>

<script>
import PartnerUpdateForm from './PartnerUpdateForm'

export default {
  name: 'PartnerUpdate',
  components: {
    'partner-update-form': PartnerUpdateForm
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
    },
    uri: {
      type: String,
      required: true
    }
  },
  methods: {
    updated (partner) {
      this.$emit('updated', partner)
    }
  }
}
</script>

<style scoped>

</style>
